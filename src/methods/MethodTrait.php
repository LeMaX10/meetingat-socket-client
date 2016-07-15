<?php
/**
 * Created by PhpStorm.
 * User: api
 * Date: 08.07.16
 * Time: 16:24
 */

namespace LeMaX10\MeetingatSocketClient\methods;

use LeMaX10\MeetingatSocketClient\Enums\SendTypeEnum;

trait MethodTrait
{
    protected $config = [];
    protected $headers = [
        'Accept' => 'application/json'
    ];
    protected $timeout = '5';

    public function setConfig(array $config = [])
    {
        $this->config = $config;
        $this->addHeader('SecretKey', $this->config['secret_key'] ?: null);

        return $this;
    }

    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function getHeader($name)
    {
        return array_key_exists($name, $this->headers) ? $this->headers[$name] : false;
    }

    public function getHeaders() : array
    {
        return (array) $this->headers;
    }

    public function getUrlString($url)
    {
        return $this->config['host'] . '/api/' . $url;
    }

    public function send(string $type, string $url, array $arguments = [])
    {
        try {
            SendTypeEnum::assertExists($type);
            if (array_key_exists('params', $arguments) && is_array($arguments['params'])) {
                foreach ($arguments['params'] as $param => $value) {
                    $url = str_replace(':' . $param, $value, $url);
                }

                if (array_key_exists('body', $arguments) && is_array($arguments['body'])) {
                    $arguments = $arguments['body'];
                }
            }

            \Unirest\Request::timeout($this->timeout);

            return \Unirest\Request::$type($this->getUrlString($url), $this->getHeaders(), $arguments);
        } catch(\Exception $e) {

        }
    }
}