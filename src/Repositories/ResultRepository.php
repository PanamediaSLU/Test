<?php
namespace App\Repositories;

use App\Entities\Result;
use App\Interfaces\IResultRepo;
  
class ResultRepository extends BaseRepository implements IResultRepo
{
	public function create(Result $result)
    {
        $stmt = $this->db->prepare("INSERT INTO euromillions_draws (draw_date, result_regular_number_one, result_regular_number_two, result_regular_number_three, result_regular_number_four, result_regular_number_five, result_lucky_number_one, result_lucky_number_two) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            'ssssssss',
            $result->getDrawDate(),
            $result->getResultRegularNumberOne(),
            $result->getResultRegularNumberTwo(),
            $result->getResultRegularNumberThree(),
            $result->getResultRegularNumberFour(),
            $result->getResultRegularNumberFive(),
            $result->getResultLuckyNumberOne(),
            $result->getResultLuckyNumberTwo()
        );

		$stmt->execute();
		$stmt->close();
    }

    public function find($value)
    {
        $date = $value instanceof Result ? $value->getDrawDate() : $value;

        $res = $this->db->query("SELECT * FROM euromillions_draws WHERE draw_date = '$date'");

        if ($res->num_rows == 0)  {
            return null;
        }

        return new Result($res->fetch_assoc());
    }

    public function exists($value)
    {
        $date = $value instanceof Result ? $value->getDrawDate() : $value;

        $res = $this->db->query("SELECT * FROM euromillions_draws WHERE draw_date = '$date'");

        return $res->num_rows > 0;
    }

    public function delete($value)
    {
        $date = $value instanceof Result ? $value->getDrawDate() : $value;

        $this->db->query("SELECT FROM euromillions_draws WHERE draw_date = '$date'");
    }

    public function doesNotExists($date)
    {
        return !$this->exists($date);
    } 

    public function getLastResult()
    {
        $res = $this->db->query("SELECT * FROM euromillions_draws ORDER BY draw_date DESC LIMIT 1");

        if ($res->num_rows == 0)  {
            return null;
        }

        return new Result($res->fetch_assoc());
    }
}