<?php

namespace App\DTO;

use Carbon\Carbon;
use App\Entities\Result;

class ResultDTO
{
	protected $draw_date;

	protected $result_regular_number_one;

	protected $result_regular_number_two;

	protected $result_regular_number_three;

	protected $result_regular_number_four;

	protected $result_regular_number_five;

	protected $result_lucky_number_one; 

	protected $result_lucky_number_two;

	public function __construct($result = null)
	{
		if (is_array($result)) {
			$this->setResultFromArray($result);
		}

		if (is_string($result)) {
			$this->setResultFromApi($result);
		}

		if ($result instanceof Result) {
			$this->setResult($result);
		}

	}

	public function getDrawDate($format = 'Y-m-d')
	{
		return (new Carbon($this->draw_date))->format($format);
	}

	public function getResultRegularNumberOne()
	{
		return $this->result_lucky_number_one;
	}

	public function getResultRegularNumberTwo()
	{
		return $this->result_regular_number_two;
	}

	public function getResultRegularNumberThree()
	{
		return $this->result_regular_number_three;
	}

	public function getResultRegularNumberFour()
	{
		return $this->result_regular_number_four;
	}

	public function getResultRegularNumberFive()
	{
		return $this->result_regular_number_five;
	}

	public function getResultLuckyNumberOne()
	{
		return $this->result_lucky_number_one;
	}

	public function getResultLuckyNumberTwo()
	{
		return $this->result_lucky_number_two;
	}

	public function setResult(Result $result)
	{
		$this->draw_date = $result->getDrawDate();

		$this->result_regular_number_one = $result->getResultRegularNumberOne();

		$this->result_regular_number_two = $result->getResultRegularNumberTwo();

		$this->result_regular_number_three = $result->getResultRegularNumberThree();

		$this->result_regular_number_four = $result->getResultRegularNumberFour();

		$this->result_regular_number_five = $result->getResultRegularNumberFive();

		$this->result_lucky_number_one = $result->getResultLuckyNumberOne();

		$this->result_lucky_number_two = $result->getResultLuckyNumberTwo();

		return $this;
	}

	public function setResultFromApi(string $result)
	{
		$result = json_decode($result);

		$numbers = explode(',', $result->results);

		$this->draw_date = $result->draw;

		$this->result_regular_number_one = $numbers[0];

		$this->result_regular_number_two = $numbers[1];

		$this->result_regular_number_three = $numbers[2];

		$this->result_regular_number_four = $numbers[3];

		$this->result_regular_number_five = $numbers[4];

		$this->result_lucky_number_one = $numbers[5];

		$this->result_lucky_number_two = $numbers[6];

		return $this;
	}

	public function setResultFromArray(array $result)
	{
		$this->draw_date = $result['draw_date'];
		$this->result_regular_number_one = $result['result_regular_number_one'];
		$this->result_regular_number_two = $result['result_regular_number_two'];
		$this->result_regular_number_three = $result['result_regular_number_three'];
		$this->result_regular_number_four = $result['result_regular_number_four'];
		$this->result_regular_number_five = $result['result_regular_number_five'];
		$this->result_lucky_number_one = $result['result_lucky_number_one'];
		$this->result_lucky_number_two = $result['result_lucky_number_two'];

		return $this;
	}

	public function setResultFromJson(string $result)
	{
		$result = json_decode($result);

		$this->draw_date = $result->draw_date;
		$this->result_regular_number_one = $result->result_regular_number_one;
		$this->result_regular_number_two = $result->result_regular_number_two;
		$this->result_regular_number_three = $result->result_regular_number_three;
		$this->result_regular_number_four = $result->result_regular_number_four;
		$this->result_regular_number_five = $result->result_regular_number_five;
		$this->result_lucky_number_one = $result->result_lucky_number_one;
		$this->result_lucky_number_two = $result->result_lucky_number_two;

		return $this;
	}

	public function toString() : string
	{
		return serialize($this->toArray());
	}

	public function toJson() : string
	{
		return json_encode($this->toArray());
	}

	public function toArray() : array
	{
		return [
			'draw_date' => $this->draw_date,
			'result_regular_number_one' => $this->result_regular_number_one,
			'result_regular_number_two' => $this->result_regular_number_two,
			'result_regular_number_three' => $this->result_regular_number_three,
			'result_regular_number_four' => $this->result_regular_number_four,
			'result_regular_number_five' => $this->result_regular_number_five,
			'result_lucky_number_one' => $this->result_lucky_number_one,
			'result_lucky_number_two' => $this->result_lucky_number_two,
		];	
	}

	public function toObject() : object
	{
		return json_decode($this->toJson());
	}

	public function getResult() : Result
	{
		return new Result($this->toArray());
	}
}
