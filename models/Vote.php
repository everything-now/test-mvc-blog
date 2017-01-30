<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Comment.php';

Class Vote extends Model
{
	/**
	 * [find description]
	 * @param  int $comment_id
	 * @param  int $user_id   
	 * @return object             
	 */
	static public function find($comment_id, $user_id)
	{
		$query = self::connection()->prepare('SELECT * FROM votes WHERE comment_id = ? AND user_id = ?');

		$query->execute([$comment_id, $user_id]);

		return $query->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * [addVote description]
	 * @param object $comment
	 * @return boolean 
	 */
	static public function addVote($comment)
	{
		$query = self::connection()->prepare('INSERT INTO votes (comment_id, user_id) VALUES (?, ?)');

		$query->execute([$comment->id, $comment->user_id]);
		
		if($query){
			Comment::vote($comment);
		}

		return $query;
	}
}