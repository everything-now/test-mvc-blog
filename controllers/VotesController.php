<?php

require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Vote.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/Controller.php';

Class VotesController extends Controller
{
	/**
	 * [vote description]
	 * @return json
	 */
	public function vote()
	{
		$request = $this->validate((object) $_POST);

		Vote::addVote($request);

		return $this->json($request);
	}
	
	/**
	 * [validate description]
	 * @param  object $request
	 * @return json|object
	 */
	private function validate($request)
	{
		if(!isset($request->id) || !isset($request->value)){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(!$user = AuthController::user()){
			return $this->json(['status' => 'ERROR'], 422);
		}

		if(Comment::checkUser($request->id, $user->id)){
			return $this->json(['message' => 'Ви не можете оцінювати свій коментар'], 422);
		}

		if(Vote::find($request->id, $user->id)){
			return $this->json(['message' => 'Ви вже голосували'], 422);
		}

		switch ($request->value) {
			case '+1': $request->value = '+';
				break;
			case '-1': $request->value = '-';
				break;
			default:
				return $this->json(['status' => 'ERROR'], 422);
		}

		$request->user_id = $user->id;

		return $request;
	}

}