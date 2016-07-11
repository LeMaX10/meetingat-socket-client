<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 11.07.16
 * Time: 13:35
 */

namespace LeMaX10\MeetingatSocketClient\Enums;


use CommerceGuys\Enum\AbstractEnum;

final class SendTypeEnum extends AbstractEnum
{
    const POST = 'post';
    const GET  = 'get';
    const PUT  = 'put';
    const DELETE = 'delete';
}