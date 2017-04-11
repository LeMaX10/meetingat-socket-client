<?php namespace LeMaX10\MeetingatSocketClient\methods;
use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;
use Unirest\Response;
class MessageMethod implements MethodInterface
{
	use MethodTrait;
	public function get(string $ids)
	{
		return $this->send(SendTypeEnum::GET, 'messages/:ids', ['params' => ['ids' => $ids]]);
	}
	public function lastMessages(int $userId)
	{
		return $this->send(SendTypeEnum::GET, 'messages/chats/:userId/lastMessages', ['params' => ['userId' => $userId]]);
	}
	/**
	 * @param int $userId
	 * @param int $eventId
	 * @return bool
	 */
	public static function getMessages(int $userId, int $eventId)
	{
		$findUser = $userId ? app('SocketClient')->users->get($userId) : false;
		$findEvent = $eventId ? app('SocketClient')->eventLink->get($eventId) : false;
		if (!$findUser && !$findEvent)
			return false;
		$ids = join(':', [$userId, $eventId]);
		return app('SocketClient')->messages->get($ids);
	}
	/**
	 * @param int $userId
	 * @return Response
	 * @throws \Exception
	 */
	public static function getLastChatMessages(int $userId) : Response
	{
		$findUser = $userId ? app('SocketClient')->users->get($userId) : false;
		if (!$findUser)
			throw new \Exception('Пользователь не найден', 404);
		
		return app('SocketClient')->messages->lastMessages($userId);
	}
}
