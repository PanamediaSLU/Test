<?php 

	require __DIR__ . '/../vendor/autoload.php';

	use App\Services\CacheService;
	use App\Services\ResultService;

	$container = (new \App\Containers\AppContainer)->getContainer();

	if (is_cache_enabled()) {

		$cache = $container->get(CacheService::class);

		if ($cache->isCached()) {
			$res = $cache->getResult();

			return format_result($res);
		}
	}

	$resultService = $container->get(ResultService::class);;

	$result = $resultService->getFromApi();

	if (!$resultService->isInDB($result->draw)) {
		$resultService->saveResult($result);
	}

	$res = $resultService->getFromDB($result->draw);

	if (is_cache_enabled()) {
		$cache->saveResult($res);
	}

	return format_result($res);