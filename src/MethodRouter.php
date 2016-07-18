<?php
namespace LeMaX10\MeetingatSocketClient;


use LeMaX10\MeetingatSocketClient\methods\EventLinkMethod;
use LeMaX10\MeetingatSocketClient\methods\TokenMethod;
use LeMaX10\MeetingatSocketClient\methods\UsersMethod;

class MethodRouter
{
    private $config = [];
    private $methods = [
        'users' => UsersMethod::class,
		'eventLink' => EventLinkMethod::class,
		'token' => TokenMethod::class,
    ];
    private $instances = [];

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config = []) : MethodRouter
    {
        $this->config = $config;
        return $this;
    }

    public function __get($method)
    {
        if(!in_array($method, array_keys($this->methods)))
            throw new \RuntimeException('Method ' . $method .' not found method');

        if(!array_key_exists($method, $this->instances))
            $this->instances[$method] = (new $this->methods[$method])->setConfig($this->config);


        return $this->instances[$method];
    }
}