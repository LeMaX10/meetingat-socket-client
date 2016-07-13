<?php namespace LeMaX10\MeetingatSocketClient;

use Illuminate\Support\Facades\Facade;

class SocketClientFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SocketClient';
    }
}
