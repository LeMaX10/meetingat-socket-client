<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 08.07.16
 * Time: 16:25
 */

namespace LeMaX10\MeetingatSocketClient\methods;

class UsersMethod implements MethodInterface
{
    use MethodTrait;

    public function create(array $arguments = [])
    {
        return $this->send('POST:users', $arguments);
    }

    public function get(int $userId)
    {
        return $this->send('GET:users/:id', ['params' => ['id' => $userId]]);
    }

    public function update(int $userId, array $params = [])
    {
        return $this->send('PUT:users/:id', ['params' => ['id' => $userId], 'body' => $params]);
    }
}