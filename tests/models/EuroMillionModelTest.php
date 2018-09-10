<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 3:18 PM
 */

namespace test\models;

use src\models\Euromillion;
use src\models\EuroMillionTemplate;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class EuroMillionModelTest extends TestCase
{
    protected function setUp()
    {
        $this->mysqli = new \mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));
        $this->mysqli->query('truncate euromillions_draws');
        $this->euromillionsObject = new EuromillionsRepository(true);
        $this->redis = new Client();
    }
    protected function tearDown()
    {
        $this->euromillionsObject = null;
        $this->mysqli->query('truncate euromillions_draws');
        $this->mysqli->close();
    }

    public function save()
    {
        //Maping the model
        $model_map = new EuroMillionTemplate;
        $model_map->result_regular_number_index = 0;
        $model_map->result_regular_number_offset = 4;
        $model_map->result_lucky_number_index = 0;
        $model_map->result_lucky_number_offset = 1;


        $model = new EuroMillion;

        $model->setTable('euromillions_draws');
        $model->setTemplateModel($model_map);

        $model->setDrawDate(date("Y-m-d", mt_rand(1, time())));

        $array_result = [];

        for($i = 0; $i < 5; $i++)
        {
            do
            {
                $result = rand(1,50);

            }while(in_array($result, $array_result));

            $array_result[] = $result;


        }

        $array_result = [];
        for($i = 0; $i < 1; $i++)
        {
            do
            {
                $result = rand(1,12);

            }while(in_array($result, $array_result));

            $array_result[] = $result;


        }

        $model->setArrayVars($array_result);

        $model->save();

        $this->assertEquals($this->getLastId(), $model->getId());
    }

    public function testGetLastDraw($id)
    {
        $model = new Euromillions;
        $model->getLastDraw('last_draw');
        $this->assertEquals($id, $model->getId());
        $this->assertEquals($this->getLastIdCache(), $model->getId());
    }



    private function getLastId()
    {
        $result=$this->mysqli->query('SELECT id FROM euromillions_draws ORDER BY id DESC LIMIT 1');
        $aux= $result->fetch_assoc();
        return $aux['id'];
    }
    private function getLastIdCache()
    {
        $aux=$this->redis->get('last_draw');
        $aux=(array)json_decode($aux);
        return $aux['id'];
    }
}