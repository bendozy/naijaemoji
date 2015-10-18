<?php

namespace Bendozy\NaijaEmoji\Auth;

use Slim\Slim;

/**
 * Class Auth
 * @package Bendozy\NaijaEmoji\Auth
 */
class Auth {

	/**
	 * Deny Access
	 *
	 * @param $message string Error Message
	 *
	 * @return \Slim\Http\Response
	 */
	public static function deny_access($message)
	{
		$app = Slim::getInstance();
		$response = $app->response();
		$response->status(401);
		$responseArray['error'] = $message;
		$response->body(json_encode($responseArray));
		$app->stop();

		return $response;
	}
} 