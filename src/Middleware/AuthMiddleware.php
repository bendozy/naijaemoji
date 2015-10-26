<?php

namespace Bendozy\NaijaEmoji\Middleware;

use Slim\Slim;
use Bendozy\NaijaEmoji\Auth\Auth;
use Bendozy\NaijaEmoji\Model\User;
use Bendozy\ORM\Exceptions\ModelNotFoundException;

class AuthMiddleware
{
	private $auth;

	/**
	 * Authenticate Routes
	 *
	 */
	public function authenticate()
	{
		$app = Slim::getInstance();
		$token = $app->request->headers->get('Authorization');
		$response = $app->response();
		$response->header("Content-Type", "application/json");

		if(! isset($token)) {
			return Auth::deny_access("Authorization Token is not set. Please login");
		}

		//Get user by token;
		try {
			$token = htmlentities(trim($token));
			$user = User::findByToken($token);

			if($user->token_expire < date('Y-m-d H:i:s')) {
				return Auth::deny_access("Authorization Token has expired. Please login again.");
			}

			$user->token_expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
			$user->save();

		} catch(ModelNotFoundException $e) {
			return Auth::deny_access("Authorization Token is invalid.");
		}
	}
}