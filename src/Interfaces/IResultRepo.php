<?php
namespace App\Interfaces;

use App\Entities\Result;

interface IResultRepo
{
	public function create(Result $result);

    public function find($value);

    public function exists($value);

    public function doesNotexists($value);
}