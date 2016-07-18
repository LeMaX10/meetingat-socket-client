<?php

namespace LeMaX10\MeetingatSocketClient\methods;

use App\Models\v1\EventParticipant;
use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class EventLinkMethod implements MethodInterface
{
	use MethodTrait;

	public function create(array $arguments = [])
	{
		return $this->send(SendTypeEnum::POST, 'eventLink', $arguments);
	}

	public function get($ids)
	{
		return $this->send(SendTypeEnum::GET, 'eventLink/:ids', ['params' => ['ids' => $ids]]);
	}

	public function update($ids, array $params = [])
	{
		return $this->send(SendTypeEnum::PUT, 'eventLink/:ids', ['params' => ['ids' => $ids], 'body' => $params]);
	}

	public function delete($ids, array $params = [])
	{
		return $this->send(SendTypeEnum::DELETE, 'eventLink/:ids', ['params' => ['ids' => $ids], 'body' => $params]);
	}

	public static function checkAndUpdate(EventParticipant $ep)
	{
		$findEventLink = app('SocketClient')->eventLink->get($ep->user_id . ':' . $ep->event_id);
		$findUser = app('SocketClient')->users->get($ep->user_id);

		if ($findEventLink) {
			$attributes = [
				'rethink_id' => $findUser->body->user_id,
				'sendPush' => 0,
				'sendToApi' => 1,
				'status' => $ep->status
			];

			if ($findEventLink->code == 404) {
				$attributes = array_merge($attributes, [
					'event_id' => $ep['event_id'],
					'user_id' => $ep['user_id']
				]);
				app('SocketClient')->eventLink->create($attributes);
			} else if ($findEventLink->code == 200) {
				app('SocketClient')->eventLink->update($ep->user_id . ':' . $ep->event_id, $attributes);
			}
		}
	}

	public static function checkAndDelete(EventParticipant $ep)
	{
		$findEvenLink = app('SocketClient')->eventLink->get($ep->user_id . ':' . $ep->event_id);
		if ($findEvenLink->code == 200)
			app('SocketClient')->eventLink->delete($ep->user_id . ':' . $ep->event_id);
	}
}