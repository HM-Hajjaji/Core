<?php

namespace Core\Component\Http;

class Request
{
    private array $query;
    private array $server;
    private array $files;
    private array $cookies;
    public function __construct()
    {
        $this->query = $_REQUEST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
        $this->cookies = $_COOKIE;
    }
    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getMethod():string
    {
        return strtoupper($this->server['REQUEST_METHOD']);
    }

    public function setMethod(string $method = "GET"|"POST"):void
    {
        $this->server['REQUEST_METHOD'] = strtoupper($method);
    }

    public function getPathInfo():string
    {
        return $this->server['PATH_INFO']??"/";
    }

    public function getRequestUri()
    {
        return $this->server['REQUEST_URI'];
    }

    public function getReferer():string|false
    {
        return$this->server["HTTP_REFERER"]??false;
    }

    public function getBaseUri():string
    {
        return sprintf("%s://%s/",$this->getProtocol(),$this->getHttpHost());
    }

    public function getHttpHost():string
    {
        return $this->server['HTTP_HOST'];
    }

    public function getProtocol():string
    {
        $protocol = "http";
        if (isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on') {
            $protocol = "https";
        }
        return $protocol;
    }

}