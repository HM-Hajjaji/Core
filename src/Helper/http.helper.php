<?php

use Core\Component\Http\Request;
use Core\Component\Http\Response;
use Route\Http\HttpRoute;

if (!function_exists("request"))
{
    function request():Request
    {
        return core()->getRequest();
    }
}

if (!function_exists("response"))
{
    function response():Response
    {
        return core()->getResponse();
    }
}

//function access to url
if (!function_exists("urlBase"))
{
    /**
     * the function get base url of project
     * @return string
     */
    function urlBase():string
    {
       return request()->getBaseUri();
    }
}

if (!function_exists("path"))
{
    /**
     * @throws Exception
     */
    function path(string $name, array $params = []):string
    {
        return HttpRoute::path($name,$params);
    }
}