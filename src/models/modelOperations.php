<?php

namespace wishlist\models;

interface modelOperations{
	
	public static function getById($id);
	
	public static function getAll();

	public static function create($attributs);

	public function edit($attributs);

	public function delete();

}