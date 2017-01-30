<?php

require_once __DIR__ . '/Model.php';

Class Comment extends Model
{
	/**
	 * [get description]
	 * @return object
	 */
	static public function get()
	{
		$query = self::connection()->prepare('SELECT 
				C.id, 
				C.body, 
				C.created_at, 
				C.deleted_at, 
				C.parent_id, 
				C.user_id, 
				C.votes, 
				U.name as user_name  
				FROM comments C 
				LEFT JOIN users U ON C.user_id = U.id
				ORDER BY C.created_at DESC'
			);

		$query->execute();

		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * [create description]
	 * @param  object $comment
	 * @return int
	 */
	static public function create($comment)
	{
		self::connection()->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);

		$query = self::connection()->prepare('INSERT INTO comments (body, parent_id, user_id) VALUES (?, ?, ?)');

		$query->execute([
			$comment->body, 
			$comment->parent_id, 
			$comment->user_id, 
		]);

		return self::connection()->lastInsertId();
	}

	/**
	 * [update description]
	 * @param  object $comment
	 * @return boolean
	 */
	static public function update($comment)
	{
		$query = self::connection()->prepare('UPDATE comments SET body=? WHERE id=?');

		return $query->execute([
			$comment->body, 
			$comment->id, 
		]);
	}

	/**
	 * [delete description]
	 * @param  object $comment
	 * @return boolean
	 */
	static public function delete($comment)
	{
		$query = self::connection()->prepare('UPDATE comments SET deleted_at=? WHERE id=?');
		
		return $query->execute([
			date('Y-m-d H:i:s'), 
			$comment->id, 
		]);
	}

	/**
	 * [count description]
	 * @return int
	 */
	static public function count()
	{
		$query = self::connection()->query('SELECT COUNT(*) FROM comments WHERE deleted_at IS NULL');

		return $query->fetchColumn();
	}

	/**
	 * [checkUser description]
	 * @param  int $id      
	 * @param  int $user_id
	 * @return boolean
	 */
	static public function checkUser($id, $user_id)
	{
		$query = self::connection()->prepare('SELECT id FROM comments WHERE id=? AND user_id=? AND deleted_at IS NULL');

		$query->execute([
			$id, 
			$user_id
		]);

		return $query->fetch();
	}

	/**
	 * [vote description]
	 * @param  object $comment
	 * @return boolean
	 */
	static public function vote($comment)
	{
		if($comment->value == '+')
			$query = self::connection()->prepare('UPDATE comments SET votes = votes + 1  WHERE id=?');
		else {
			$query = self::connection()->prepare('UPDATE comments SET votes = votes - 1  WHERE id=?');
		}

		return $query->execute([
			$comment->id
		]);
	}
}