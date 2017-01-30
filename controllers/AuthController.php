<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

Class AuthController extends Controller
{
	/**
	 * @var object
	 */
	public $user;

	/**
	 * @return Json response
	 */
	public function login()
	{
		$this->validateLogin((object) $_POST);

		$this->autentificate();

		return $this->json('OK'); 
	}

	/**
	 * @return Json response
	 */
	public function register()
	{
		$request = $this->validateRegister((object) $_POST);

		$this->user = User::create($request);

		$this->autentificate();

		return $this->json(['status' => 'OK']); 
	}

	/**
	 * @return redirect
	 */
	public function logout()
	{
		if(self::user()){
			unset($_SESSION['login']);
		}

		return header('Location: /', true, 302);
	}

	/**
	 * @return void
	 */
	private function autentificate()
	{
		$_SESSION['login'] = $this->user->id;
	}

	/**
	 * @return object|boolean
	 */
	static public function user()
	{
		if(isset($_SESSION['login'])){
			return User::get($_SESSION['login']);
		}

		return false;
	}

	/**
	 * @param  object $request
	 * @return redirect|array
	 */
	private function validateRegister($request)
	{
		if(self::user()){
			return header('Location: /', true, 302); 
		}
		
		$errors = [];

		if(!isset($request->name) || !trim($request->name)){
			$errors['name'] = 'Введіть ім\'я';
		}

		if(!isset($request->email) || !trim($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)){
			$errors['email'] = 'Неправильный формат email';
		}

		if(!isset($request->password) || strlen(trim($request->password)) < 6){
			$errors['password'] = 'Пароль не може бути менше 6 символів';
		}

		if(!isset($request->password) || !isset($request->password_confirmation) || $request->password !== $request->password_confirmation){
			$errors['password_confirmation'] = 'Паролі не співпадають';
		}

		if($errors){
			return $this->json($errors, 422);
		}

		return $request;
	}
	
	/**
	 * @param  object $request
	 * @return redirect|array
	 */
	private function validateLogin($request)
	{
		if(self::user()){
			return header('Location: /', true, 302); 
		}

		$errors = [];

		if(!isset($request->email) || !trim($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)){
			$errors['email'] = 'Неправильный формат email';
		}

		if(!isset($request->password) || strlen(trim($request->password)) < 6){
			$errors['password'] = 'Пароль не може бути менше 6 символів';
		} elseif (isset($request->email)) {
			
			$this->user = User::getByEmail($request->email);

			if(!$this->user || !password_verify(trim($request->password), $this->user->password)){
				$errors['password'] = 'Невірний email або пароль';
			} 

		}

		if($errors){
			return $this->json($errors, 422);
		}

		return $request;
	}
}