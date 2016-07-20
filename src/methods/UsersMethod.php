<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 08.07.16
 * Time: 16:25
 */

namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

class UsersMethod implements MethodInterface
{
    use MethodTrait;

    public function create(array $arguments = [])
    {
        return $this->send(SendTypeEnum::POST, 'users', $arguments);
    }

    public function get(int $userId)
    {
        return $this->send(SendTypeEnum::GET, 'users/:id', ['params' => ['id' => $userId]]);
    }

    public function update(int $userId, array $params = [])
    {
        return $this->send(SendTypeEnum::PUT, 'users/:id', ['params' => ['id' => $userId], 'body' => $params]);
    }
    
    public static function checkAndUpdate($user)
    {
        $findUser = app('SocketClient')->users->get($user->id);
        if($findUser) {
            $attributes = [
                'lastName' => $user->last_name,
                'firstName'=> $user->first_name,
                'user_id'  => (int) $user->id,
                'created_at' => (string) $user->created_at,
                'updated_at' => (string) $user->updated_at,
                'moderated'  => $user->getIsModeratedOnceAttribute() ? 1 : 0
            ];

            if ($findUser->code == 404) {
                app('SocketClient')->users->create($attributes);
                app('SocketClient')->images->checkAndUpdateOrDelete($user);
            } else if($findUser->code == 200) {
                app('SocketClient')->users->update($user->id, $attributes);
                app('SocketClient')->images->checkAndUpdateOrDelete($user);
            }
        }
    }
}