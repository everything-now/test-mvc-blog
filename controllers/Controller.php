<?php

Class Controller 
{
	/**
	 * Validate HTTP Method
	 * @param string
	 */
	public function __construct($method)
	{
		if(!$this->validateMethod($method)){
			header('HTTP/1.1 405 Method Not Allowed'); exit;
		}
	}

	/**
	 * [view description]
	 * @param  string $file
	 * @param  array $variables
	 * @return void require view file
	 */
	protected function view($file, $variables = [])
	{
		extract($variables);

		return require_once __DIR__ . '/../views/' . $file . '.php';
	}

	/**
	 * [json description]
	 * @param  array $data
	 * @param  null|int $code
	 * @return void json and exit
	 */
	protected function json($data, $code = null)
	{	
		if($code){
			http_response_code($code);
		}

		exit(json_encode($data));
	}

	/**
	 * [validateMethod description]
	 * @param  string $method
	 * @return boolean
	 */
	protected function validateMethod($method)
	{
		return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
	}
}