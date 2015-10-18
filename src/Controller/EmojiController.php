<?php
/**
 * Created by PhpStorm.
 * User: bendozy
 * Date: 10/18/15
 * Time: 12:32 AM
 */

namespace Bendozy\NaijaEmoji\Controller;

use Bendozy\NaijaEmoji\Auth\Auth;
use Bendozy\NaijaEmoji\Model\Emoji;
use Bendozy\NaijaEmoji\Model\User;
use Bendozy\ORM\Exceptions\ModelNotFoundException;
use PDOException;
use Slim\Http\Response;
use Slim\Slim;

class EmojiController
{

	/**
	 * Find an emoji resource
	 *
	 * @param int $id ID of the emoji
	 *
	 * @return Emoji
	 */
	public static function findEmoji($id)
	{
		$app = Slim::getInstance();
		$response = $app->response();
		$response->headers->set('Content-Type', 'application/json');

		try {
			$emoji = Emoji::find($id);
			$response->body(json_encode(['emoji' => self::buildResult($emoji)]));
		} catch(PDOException $e) {
			$response->status(404);
			$response->body(json_encode(['error' => 'Emoji not found for the given id']));
		}
		return $response;
	}

	/**
	 * Delete an emoji resource
	 *
	 * @param int $id ID of the emoji
	 *
	 * @return Emoji
	 */
	public static function deleteEmoji($id)
	{
		$app = Slim::getInstance();
		$response = $app->response();
		$response->headers->set('Content-Type', 'application/json');

		try {
			Emoji::find($id);
			Emoji::destroy($id);
			$response->body(json_encode(['message' => "Emoji with the given id has been deleted"]));
		} catch(ModelNotFoundException $e) {
			$response->status(404);
			$response->body(json_encode(['error' => 'Emoji not found for the given id']));
		}
		return $response;
	}

	/**
	 * Retrieve a collection of emoji resources
	 *
	 * @return Response
	 */
	public static function getAll()
	{
		$app = Slim::getInstance();
		$response = $app->response();
		$response->headers->set('Content-Type', 'application/json');

		try {
			$emojis = Emoji::all();

			$responseBody = [];
			foreach($emojis as $emoji){
				$responseBody[$emoji->id] = self::buildResult($emoji);
			}
			$response->body(json_encode($responseBody));

		} catch(ModelNotFoundException $e) {
			$response->status(200);
			$response->body(json_encode(['message' => 'No Emojis have been added']));
		}
		return $response;
	}

	public function addEmoji()
	{
		$app = Slim::getInstance();

		$request = $app->request();
		$token = $request->headers->get('Authorization');

		$name = $request->params('name');
		$emoji_char = $request->params('char');
		$keywords = $request->params('keywords');
		$category = $request->params('category');

		if(! isset($name)) {
			return Auth::deny_access("Emoji name is null");
		}

		if(! isset($emoji_char)) {
			return Auth::deny_access("Emoji character value is null");
		}

		if(! isset($category)) {
			return Auth::deny_access("Emoji category is null");
		}

		if(! isset($keywords)) {
			return Auth::deny_access("Emoji keywords is null");
		}

		$response = $app->response();
		$response->header("Content-Type", "application/json");

		$emoji = new Emoji();
		$emoji->name = $name;
		$emoji->emoji_char = $emoji_char;
		$emoji->category = $category;
		$emoji->keywords = $keywords;
		$emoji->date_created = date('Y-m-d H:i:s');
		$emoji->date_modified = date('Y-m-d H:i:s');
		$emoji->created_by = User::findByToken($token)->id;
		$emoji->save();

		$responseArray['message'] = "Emoji has been successfully created";
		$response->status(200);
		$response->body(json_encode($responseArray));

		return $response;
	}

	public function updateEmoji($id)
	{
		$app = Slim::getInstance();

		$request = $app->request();
		$response = $app->response();
		$response->header("Content-Type", "application/json");

		$name = $request->params('name');
		$emoji_char = $request->params('char');
		$keywords = $request->params('keywords');
		$category = $request->params('category');

		try {
			$emoji = Emoji::find($id);

			if(isset($name)) {
				$emoji->name = $name;
			}

			if(isset($emoji_char)) {
				$emoji->emoji_char = $emoji_char;
			}

			if(! isset($category)) {
				$emoji->category = $category;
			}

			if(! isset($keywords)) {
				$emoji->keywords = $keywords;
			}

			$emoji->date_modified = date('Y-m-d H:i:s');
			$emoji->save();

			$responseArray['message'] = "Emoji has been successfully updated";
			$response->status(200);
			$response->body(json_encode($responseArray));

		} catch(ModelNotFoundException $e) {
			$response->body(json_encode(['error' => 'Emoji not found for the given id']));
			$response->status(404);
		}

		return $response;
	}

	public static function buildResult(Emoji $emoji)
	{
		return [
			"id" => $emoji->id,
			"name" => $emoji->name,
			"char" => $emoji->emoji_char,
			"category" => $emoji->category,
			"keywords" => explode(",", $emoji->keywords),
			"date_created" => $emoji->date_created,
			"date_modified" => $emoji->date_modified,
			"created_by" => User::find($emoji->created_by)->username
		];
	}

} 