<?php

Class Model
{
	/**
	 * new connection to DB
	 * @return object
	 */
	static public function connection()
	{
		$config = require 'config/database.php';

		return new PDO("mysql:dbname={$config['database']};host={$config['host']}", 
			$config['username'], 
			$config['password']);
	}
}