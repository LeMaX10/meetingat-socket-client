<?php

namespace LeMaX10\MeetingatSocketClient\methods;

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
}