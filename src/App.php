<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 2:44 PM
 */

namespace src;

use src\interfaces\IResultApi;
use src\interfaces\ORMModel;

class App
{
    private $api;
    private $model;


    public function setApi(IResultApi $api)
    {
        $this->api = $api;
    }

    public function setModel(ORMModel $model)
    {
        $this->model = $model;
    }

    public function getLastDrawResultApi()
    {
        return $this->api->fetch();
    }

    public function saveDraw($result)
    {
        $this->model->setDrawDate($result['draw_date']);
        $this->model->setArrayVars($result['results']);

        $this->model->save();

        return $this->model;
    }

    public function getLastSavedDraw(IResultApi $api = null)
    {

        if(!is_null($api))
        {
            $this->setApi($api);
        }

        $result = $this->model->getLastDraw();
        if($result==false)
        {
            $draw = $this->getLastDrawResultApi();
            $this->saveDraw($draw);
        }
        return $this->model;
    }

}