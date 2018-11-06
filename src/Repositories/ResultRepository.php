<?php
namespace App\Repositories;

use App\Interfaces\IResultRepo;
  
class ResultRepository extends BaseRepository implements IResultRepo
{
	public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO euromillions_draws (draw_date, result_regular_number_one, result_regular_number_two, result_regular_number_three, result_regular_number_four, result_regular_number_five, result_lucky_number_one, result_lucky_number_two) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param('ssssssss', $data['drawDate'], $data['resultRegularNumberOne'], $data['resultRegularNumberTwo'], $data['resultRegularNumberThree'], $data['resultRegularNumberFour'], $data['resultRegularNumberFive'], $data['resultLuckyNumberOne'], $data['resultLuckyNumberTwo']);

		$stmt->execute();
		$stmt->close();
    }

    public function find($date)
    {
        $res = $this->db->query("SELECT * FROM euromillions_draws WHERE draw_date = '$date'");

        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function exists($date)
    {
        $res = $this->db->query("SELECT * FROM euromillions_draws WHERE draw_date = '$date'");

        return $res->num_rows > 0;
    }

    public function delete($date)
    {
        $this->db->query("SELECT FROM euromillions_draws WHERE draw_date = '$date'");
    }
}