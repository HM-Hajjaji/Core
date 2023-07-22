<?php

use Core\Component\Kernel\Kernel;
use Core\Component\Validator\Validator;
use Doctrine\ORM\EntityManager;

require_once "http.helper.php";
require_once "path.helper.php";
require_once "engine.helper.php";

//main function
if (!function_exists("kernel"))
{
    /**
     * the function get one instance from object Core
     * @return Kernel
     */
    function core():Kernel
    {
       static $kernel = new Kernel();
       return $kernel;
    }
}

if (!function_exists("entityManager"))
{
    function entityManager():EntityManager
    {
        return core()->getEntityManager();
    }
}

if (!function_exists("validator"))
{
    function validator():Validator
    {
        return core()->getValidator();
    }
}

if (!function_exists("env"))
{
    /**
     * @param string $key key of value in file .env
     * @param string|null $default
     * @return mixed
     */
    function env(string $key, string $default = null):mixed
    {
        return $_ENV[$key] ?? $default;
    }
}