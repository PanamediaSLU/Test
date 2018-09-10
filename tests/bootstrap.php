<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 3:15 PM
 */


require_once __DIR__ . '/../src/interfaces/IResultApi.php';
require_once __DIR__ . '/../src/interfaces/ICache.php';
require_once __DIR__ . '/../src/interfaces/ORMModel.php';
require_once __DIR__ . '/../src/providers/ApiConnector.php';
require_once __DIR__ . '/../src/providers/RedisConnector.php';
require_once __DIR__ . '/../src/providers/PDOConnector.php';
require_once __DIR__ . '/../src/services/ApiService.php';
require_once __DIR__ . '/../src/services/ApiMockService.php';
require_once __DIR__ . '/../src/App.php';
require_once __DIR__ . '/../src/models/EuromillionTemplate.php';
require_once __DIR__ . '/../src/models/Euromillion.php';
require_once __DIR__ . '/../vendor/autoload.php';