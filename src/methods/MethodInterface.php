<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 08.07.16
 * Time: 16:22
 */

namespace LeMaX10\MeetingatSocketClient\methods;


interface MethodInterface
{
    public function send(string $url, array $arguments = []);
}