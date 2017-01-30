<?php

require_once __DIR__ . '/Model.php';

Class User extends Model
{
	/**
	 * [get description]
	 * @param  int $id
	 * @return object
	 */
	static public function get($id)
	{
		$query = self::connection()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');

		$query->execute([$id]);

		return $query->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * [getByEmail description]
	 * @param  string $email
	 * @return object
	 */
	static public function getByEmail($email)
	{
		$query = self::connection()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');

		$query->execute([$email]);

		return $query->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * [create description]
	 * @param  object $user
	 * @return object
	 */
	static public function create($user)
	{
		$query = self::connection()->prepare('INSERT INTO users(name, email, password) VALUES(?, ?, ?)');

		$query->execute([
			$user->name, 
			$user->email, 
			password_hash($user->password, PASSWORD_BCRYPT)
		]);

		return self::getByEmail($user->email);
	}
}