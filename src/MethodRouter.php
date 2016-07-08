<?php
namespace LeMaX10\MeetingatSocketClient;


class MethodRouter
{
    private $config = [];
    private $methods = [];
    private $instances = [];

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
        $this->initMethods();
    }

    public function setConfig(array $config = []) : MethodRouter
    {
        $this->config = $config;
        return $this;
    }

    protected function initMethods() : MethodRouter
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(__DIR__ . '/methods/'),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $this->methods[$file->getBasename('Method.php')] = "LeMaX10\\MeetingatSocketClient\\Methods\\" . $file->getBasename('.php');
        }

        return $this;
    }


    public function __get($method)
    {
        if(in_array($method, array_keys($this->methods)))
            throw new \RuntimeException('Method ' . $method .' not found method');

        if(isset($this->instances[$method]))
            $this->instances[$method] = (new $this->methods[$method])->setConfig($this->config);


        return $this->instances[$method];
    }
}