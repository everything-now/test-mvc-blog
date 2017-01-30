<?php

/**
 * Application Routes
 * 
 * @return array
 */
return [
	'/' 			  => ['get',  'CommentsController', 'getList'],
	'/auth/register'  => ['post', 'AuthController',     'register'], 
	'/auth/login'     => ['post', 'AuthController',     'login'], 
	'/auth/logout'    => ['get',  'AuthController',     'logout'], 
	'/comment/create' => ['post', 'CommentsController', 'create'],
	'/comment/update' => ['post', 'CommentsController', 'update'],
	'/comment/delete' => ['post', 'CommentsController', 'delete'],
	'/comment/vote'   => ['post', 'VotesController',    'vote'],
];