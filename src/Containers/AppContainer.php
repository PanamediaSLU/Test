<?php

namespace App\Containers;

use App\Services\CacheService;
use App\Services\ResultService;
use App\Repositories\ResultApi;
use App\Repositories\ResultRepository;
use Zend\ServiceManager\ServiceManager;
use App\Repositories\FileCacheRepository;
use Zend\ServiceManager\Factory\InvokableFactory;

class AppContainer
{
    protected $container;

    public function __construct()
    {
        $this->container = new ServiceManager;
        $this->invokableFactory = new InvokableFactory();

        $this->makeContainer();
    }

    public function makeContainer()
    {
        $this->container->setFactory(
            CacheService::class,
            function() {
                return new CacheService(
                    new FileCacheRepository()
                );
            }
        );

        $this->container->setFactory(
            ResultService::class,
            function() {
                return new ResultService(
                    new ResultApi(), new ResultRepository()
                );
            }
        );

        return $this;
    }

    public function getContainer()
    {
        return $this->container;
    }
}