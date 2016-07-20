<?php

namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class TokenMethod implements MethodInterface
{
	use MethodTrait;

	public function create(array $arguments = [])
	{
		return $this->send(SendTypeEnum::POST, 'token', $arguments);
	}

	public function get($token)
	{
		return $this->send(SendTypeEnum::GET, 'token/:token', ['params' => ['token' => $token]]);
	}

	public function update($token, array $params = [])
	{
		return $this->send(SendTypeEnum::PUT, 'token/:token', ['params' => ['token' => $token], 'body' => $params]);
	}

	public function delete($token, array $params = [])
	{
		return $this->send(SendTypeEnum::DELETE, 'token/:token', ['params' => ['token' => $token], 'body' => $params]);
	}

	public static function checkAndUpdate($token)
	{
		$findToken = app('SocketClient')->token->get($token->token);
		if ($findToken) {
			$attributes = [
				'api_user_id' => $token->user_id,
				'device_type' => $token->device_type,
				'device_push' => $token->device_push,
				'updated_at' => (string) $token->updated_at,
			];

			if ($findToken->code == 404) {
				$attributes = array_merge($attributes, [
					'token' => $token->getAttributes()['token'],
					'created_at' => (string) $token->created_at,
					'device_key' => $token->device_key,
				]);
				app('SocketClient')->token->create($attributes);
			} else if ($findToken->code == 200) {
				$attributes = array_merge($attributes, [
					'user_id' => $findToken->body->user_id,
				]);

				app('SocketClient')->token->update($token->token, $attributes);
			}
		}
	}

	public static function checkAndDelete($token)
	{
		$findToken = app('SocketClient')->token->get($token->getAttributes()['token']);
		if ($findToken && $findToken->code == 200)
			app('SocketClient')->token->delete($token->getAttributes()['token']);
	}
}