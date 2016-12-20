<?php namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class MessageMethod implements MethodInterface
{
	use MethodTrait;

	public function get(string $ids)
	{
		return $this->send(SendTypeEnum::GET, 'messages/:ids', ['params' => ['ids' => $ids]]);
	}

	public static function getMessages(int $userId, int $eventId)
	{
		$findUser = $userId ? app('SocketClient')->users->get($userId) : false;
		$findEvent = $eventId ? app('SocketClient')->eventLink->get($eventId) : false;
		if (!$findUser && !$findEvent)
			return false;

		$ids = join(':', [$userId, $eventId]);

		return app('SocketClient')->messages->get($ids);
	}
}