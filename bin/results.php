<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	
	require __DIR__ . '/../vendor/autoload.php';

	$container = (new \App\Containers\AppContainer)->getContainer();

	$resultService = $container->get(App\Services\ResultService::class);

	if (is_cache_enabled()) {
		$result = $resultService->getResultFromCache();
		print 'Desde cache: ';
		print $result;
		return; 
	}

	$result = $resultService->getResult();
	print 'Desde api/db: ';
	print $result;