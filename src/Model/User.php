<?php

namespace Bendozy\NaijaEmoji\Model;

use Bendozy\ORM\Base\Model;

class User extends Model
{
	protected static $primaryKey = 'id';

	/**
	 * Return User Model where the token is given.
	 *
	 * @param  string $token
	 *
	 * @throws \Bendozy\ORM\Exceptions\ModelNotFoundException
	 *
	 * @return User
	 */
	public static function findByToken($token){

		return User::where('token',$token);
	}
}