<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 4:03 PM
 */

namespace test\App;

use src\App;
use src\models\EuroMillion;
use src\models\EuroMillionTemplate;
use src\services\ApiService;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class AppTest extends TestCase
{
    private $appObject;

    protected function setUp()
    {
        $this->mysqli = new \mysqlimysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));
        $this->mysqli->query('truncate euromillions_draws');
        $this->appObject = new App;

        $this->redis = new Client();
    }
    protected function tearDown()
    {
        $this->euromillionsObject = null;
        $this->mysqli->query('truncate euromillions_draws');
        $this->mysqli->close();
    }


    public function getLastDrawResultFromAPI()
    {
        $expected = ['status' => 200, 'drawDate' => '2018-09-10', 'results' => [1, 22, 45, 34, 50, 1, 12]];

        $model_map = new EuroMillionTemplate;
        $model_map->result_regular_number_index = 0;
        $model_map->result_regular_number_offset = 4;
        $model_map->result_lucky_number_index = 0;
        $model_map->result_lucky_number_offset = 1;


        $model = new EuroMillion;

        $model->setTable('euromillions_draws');
        $model->setTemplateModel($model_map);

        $this->appObject->setModel($model);
        $this->appObject->setApi(new ApiService);


        $result = $this->appObject->getLastDrawResultApi();
        $this->assertEquals($expected, $result);
        return $result;
    }


    public function saveDraw($draw)
    {
        $result = $this->appObject->saveDraw($draw);
        $this->assertEquals($this->getLastIdDataBase(), $result->getId());
        return $result->getId();
    }

    public function getLastDraw($id)
    {
        $result = $this->appObject->getLastSavedDraw();
        $this->assertEquals($id, $result->getId());
        $this->assertEquals($this->getLastIdCache(), $result->getId());
        return $result->getId();
    }



    private function getLastIdDataBase()
    {
        $result = $this->mysqli->query('SELECT id FROM euromillions_draws ORDED by id DESC LIMIT 1');
        $aux = $result->fetch_assoc();
        return $aux['id'];
    }

    private function getLastIdCache()
    {
        $aux = $this->redis->get('lastDraw');
        $aux = (array)json_decode($aux);
        return $aux['id'];
    }



}