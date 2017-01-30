<?php

require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/Controller.php';

Class CommentsController extends Controller
{
	/**
	 * 
	 * @return view
	 */
	public function getList()
	{
		$user = AuthController::user();

		$comments = Comment::get();
		$count = Comment::count();

		return $this->view('home', [
				'user'	   => $user,
				'count'    => $count,
				'comments' => $comments,
			]);
	}

	/**
	 * 
	 * @return json
	 */
	public function create()
	{	
		$request = $this->validateCreate((object) $_POST);
		
		$request->id = Comment::create($request);

		return $this->json($request);
	}

	/**
	 * 
	 * @return json
	 */
	public function update()
	{
		$request = $this->validateUpdate((object) $_POST);

		Comment::update($request);

		return $this->json($request);
	}

	/**
	 * 
	 * @return json
	 */
	public function delete()
	{
		$request = $this->validateDelete((object) $_POST);

		Comment::delete($request);

		return $this->json(['message' => 'Коментар було видалено']);
	}

	/**
	 * [validateCreate description]
	 * @param  object $request
	 * @return json|object
	 */
	private function validateCreate($request)
	{
		if(!$user = AuthController::user()){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!isset($request->body) || !trim($request->body) || strlen($request->body) > 1000){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!isset($request->parent_id)){
			$request->parent_id = null;
		}

		$request->created_at = date('d.m.y H:i');
		$request->user_name = $user->name;
		$request->user_id = $user->id;

		return $request;
	}

	/**
	 * [validateUpdate description]
	 * @param  object $request
	 * @return json|object
	 */
	private function validateUpdate($request)
	{
		if(!$user = AuthController::user()){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!Comment::checkUser($request->id, $user->id)){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!isset($request->body) || !trim($request->body) || strlen($request->body) > 1000){
			return $this->json(['status' => 'ERROR'], 422);
		}

		return $request;
	}

	/**
	 * [validateDelete description]
	 * @param  object $request
	 * @return json|object
	 */
	private function validateDelete($request)
	{
		if(!$user = AuthController::user()){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!Comment::checkUser($request->id, $user->id)){
			return $this->json(['status' => 'ERROR'], 422);
		}

		return $request;
	}
}