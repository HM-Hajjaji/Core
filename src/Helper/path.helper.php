<?php

//function of paths folders
if (!function_exists("basePath"))
{
    /**
     * the function get main folder of project
     * @return string
     */
    function basePath():string
    {
        return core()->getProjectDir();
    }
}

if (!function_exists("viewPath"))
{
    /**
     * the function get main folder of views in project
     * @return string
     */
    function viewPath():string
    {
        return basePath() . "/view/";
    }
}