<?php
/**
 * Created by PhpStorm.
 * User: aurelianoa
 * Date: 9/10/18
 * Time: 11:57 AM
 */

namespace src\models;

use Exception;
use src\interfaces\ICache;
use src\interfaces\ORMModel;
use src\providers\RedisConnector;
use src\providers\PDOConnector;
use src\models\EuroMillionTemplate;



class EuroMillion implements ICache, ORMModel
{
    use RedisConnector;
    use PDOConnector;

    private $id;
    private $table;
    private $date;
    private $templatemodel;
    private $arrayVars;


    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setDrawDate($date)
    {
        $this->date = $date;
    }

    public function getDrawDate()
    {
        return $this->date;
    }

    public function setTemplateModel(EuroMillionTemplate $template)
    {
        $this->templatemodel = $template;
    }

    public function getTemplateModel()
    {
        return $this->templatemodel;
    }

    public function setArrayVars($array)
    {
        $this->arrayVars = $array;
    }

    public function getArrayVars()
    {
        return $this->arrayVars;
    }

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->connect();
        $sql = 'INSERT INTO'.$this->getTable();
        $sql .= ' values(NULL, NULL, '.$this->getDrawDate();
        $sql .= ', '.$this->buildSQLVars('regular_number').', '.$this->buildSQLVars('lucky_number').')';

        try{
            $this->pdo->prepare($sql)->execute();
            $this->id = $this->lastInsertId();

        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

        $this->put('last_draw',json_encode(['id' => $this->id, 'draw_date' => $this->getDrawDate(),'vars' => $this->getArrayVars()]));
    }

    public function buildSQLVars($name_var = 'regular_number')
    {
        $index = 'result_'.$name_var.'_index';
        $offset = 'result_'.$name_var.'_offset';



        return implode(', ',array_slice($this->getArrayVars(),$this->templatemodel->$index,$this->templatemodel->$offset));

    }


    public function getLastDraw($key)
    {
        $result_operation = true;
        $cache = $this->get($key);
        if(is_null($cache))
        {
            $this->connect();
            try
            {
                $result = $this->pdo->query('select * from '.$this->getTable().' ORDER BY id DESC LIMIT 1')->fetch();
            }
            catch(Exception $e)
            {
                throw new Exception($e->getMessage());
            }
            if(is_null($result))
            {
                $result_operation = false;
            }
        }
        if($result)
        {
            $this->id = $result['id'];
            $this->draw_date = $result['draw_date'];
            $this->arrayVars = [
                $result['result_regular_number_one'],
                $result['result_regular_number_two'],
                $result['result_regular_number_three'],
                $result['result_regular_number_four'],
                $result['result_regular_number_five'],
                $result['result_lucky_number_one'],
                $result['result_lucky_number_two'],
            ];

        }
        return $result_operation;
    }


}