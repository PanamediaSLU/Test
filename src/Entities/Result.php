<?php

namespace App\Entities;

use Carbon\Carbon;

class Result
{
	protected $draw_date;

	protected $result_regular_number_one;

	protected $result_regular_number_two;

	protected $result_regular_number_three;

	protected $result_regular_number_four;

	protected $result_regular_number_five;

	protected $result_lucky_number_one; 

	protected $result_lucky_number_two;

	public function __construct(array $data = [])
	{
		if (!empty($data)) {
			$this->draw_date = $data['draw_date'];
			$this->result_regular_number_one = $data['result_regular_number_one'];
			$this->result_regular_number_two = $data['result_regular_number_two'];
			$this->result_regular_number_three = $data['result_regular_number_three'];
			$this->result_regular_number_four = $data['result_regular_number_four'];
			$this->result_regular_number_five = $data['result_regular_number_five'];
			$this->result_lucky_number_one = $data['result_lucky_number_one'];
			$this->result_lucky_number_two = $data['result_lucky_number_two'];
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

	public function setDrawDate($value)
	{
		$this->draw_date = $value;

		return $this;
	}

	public function setResultRegularNumberOne($value)
	{
		$this->result_lucky_number_one = $value;

		return $this;
	}

	public function setResultRegularNumberTwo($value)
	{
		$this->result_regular_number_two = $value;

		return $this;
	}

	public function setResultRegularNumberThree($value)
	{
		$this->result_regular_number_three = $value;

		return $this;
	}

	public function setResultRegularNumberFour($value)
	{
		$this->result_regular_number_four = $value;

		return $this;
	}

	public function setResultRegularNumberFive($value)
	{
		$this->result_regular_number_five = $value;

		return $this;
	}

	public function setResultLuckyNumberOne($value)
	{
		$this->result_lucky_number_one = $value;

		return $this;
	}

	public function setResultLuckyNumberTwo($value)
	{
		$this->result_lucky_number_two = $value;

		return $this;
	}

	public function __toString()
	{
		return 'SORTEO DEL ' . $this->draw_date . ': '.
			$this->result_regular_number_one . ' ' .
			$this->result_regular_number_two . ' ' .
			$this->result_regular_number_three . ' ' .
			$this->result_regular_number_four . ' ' .
			$this->result_regular_number_five . ' ' .
			$this->result_lucky_number_one . ' ' .
			$this->result_lucky_number_two . "\n"; 
	}
}