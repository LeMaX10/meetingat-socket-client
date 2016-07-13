<?php

namespace LeMaX10\MeetingatSocketClient;

use Illuminate\Support\Facades\Facade;

class ClientServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SocketClient';
    }
}
