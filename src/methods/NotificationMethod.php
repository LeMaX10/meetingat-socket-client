<?php

namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class NotificationMethod implements MethodInterface
{
	use MethodTrait;

	public function create(array $arguments = [])
	{
		return $this->send(SendTypeEnum::POST, 'notification', $arguments);
	}

	public static function push($arguments)
	{
		app('SocketClient')->token->create($arguments);
	}
}