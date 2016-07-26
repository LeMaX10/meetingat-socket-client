<?php

namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class FilterMethod implements MethodInterface
{
	use MethodTrait;

	public function get($table, $query)
	{
		return $this->send(SendTypeEnum::GET, 'filter/:table?:query', ['params' => ['table' => $table, 'query' => $query]]);
	}
}