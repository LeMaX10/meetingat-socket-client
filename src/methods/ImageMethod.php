<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 20.07.16
 * Time: 10:00
 */

namespace LeMaX10\MeetingatSocketClient\methods;


use Unirest\Method;
use Unirest\Request;

class ImageMethod implements MethodInterface
{
    use MethodTrait;
    
    public function get(int $userId)
    {
        return $this->send(Method::GET, 'images/:userId', ['params' => ['userId' => $userId]]);
    }
    
    public function create(array $arguments = []) 
    {
        return $this->send(Method::PUT, 'images', $arguments);
    }
    
    public function delete(int $userId)
    {
        return $this->send(Method::DELETE, 'images/:userId', ['params' => ['userId' => $userId]]);
    }
    
    public static function checkAndUpdateOrDelete($userModel)
    {
        $findImage = app('SocketClient')->images->get($userModel->id);
        if($findImage) {
            if($userModel->avatar) {
                $attributes = [
                    'user_id' => $userModel->id,
                    'image_id' => $userModel->avatar->id,
                    'link' => $userModel->avatar->link
                ];

                if($findImage->code == 404) {
                    app('SocketClient')->images->create($attributes);
                }
            }
        } else {
            if($findImage->code == 200) {
                app('SocketClient')->images->delete($userModel->id);
            }
        }
    }
}