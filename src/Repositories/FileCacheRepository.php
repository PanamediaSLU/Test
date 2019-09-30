<?php

namespace App\Repositories;

use App\Interfaces\ICache;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Cache\Adapter\Filesystem\FilesystemCachePool;

class FileCacheRepository implements ICache
{
	public function __construct()
	{			
		$filesystemAdapter = new Local(__DIR__.'/../../cache');
		$filesystem        = new Filesystem($filesystemAdapter);

		$this->pool = new FilesystemCachePool($filesystem);
	}

    public function has($key)
    {
    	return $this->pool->hasItem($key);
    }

    public function put($key, $json)
    {
    	$item = $this->pool->getItem($key);
		$item->set($json)->setTags([$key]);
		$this->pool->save($item);
    }

    public function get($key)
    {
    	return $this->pool->getItem($key)->get();
    }
}