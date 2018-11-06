<?php
namespace App\Interfaces;
  
interface IResultRepo
{
	public function create($data);

    public function find($date);

    public function exists($date);
}