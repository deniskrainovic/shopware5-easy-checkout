<?php

namespace NetsCheckoutPayment\Components\Api;

use NetsCheckoutPayment\Components\Api\Exception\EasyApiException;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var array
     */
    private $headers = [];

    public function __construct() {
        $this->init();
    }

    protected function init() {
        $params = ['headers' =>
            ['Content-Type' => 'text/json',
                'Accept' => 'text/json']];
        $this->client = new \GuzzleHttp\Client($params);

        $this->setHeader('Content-Type','text/json');
        $this->setHeader('Accept','text/json');
    }

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws EasyApiException
     */
    public function post($url, $data = array()) {
        try {
            $params = ['headers' => $this->headers,
                'body' => $data];
            return $this->client->post($url, $params);
        }catch(\Exception $ex) {
            throw new EasyApiException($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    public function isSuccess() {
        return $this->client->isSuccess();
    }

    public function getResponse() {
        return $this->client->getResponse();
    }

    /**
     * @param string $url
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     * @throws EasyApiException
     */
    public function get($url, $data = array()) {
        try {
            $params = ['headers' => $this->headers];
            return $this->client->get($url, $params);
        }catch(\Exception $ex) {
            throw new EasyApiException($ex->getMessage(), $ex->getCode());
        }
    }

    public function put($url, $data = array(), $payload = false) {
        try {
            $params = ['headers' => $this->headers,
                'body' => $data];
            return $this->client->put($url, $params);
        }catch(\Exception $ex) {
            throw new EasyApiException($ex->getMessage(), $ex->getCode());
        }
    }

    public function getHttpStatus() {
        return $this->client->getHttpStatus();
    }

    public function getErrorCode()
    {
        return $this->client->getErrorCode();
    }

    public function getErrorMessage()
    {
        return $this->client->getErrorMessage();
    }
}