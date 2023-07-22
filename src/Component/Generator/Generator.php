<?php

namespace Core\Component\Generator;

class Generator
{
    public static function generate(string $path,array $data):string
    {
        extract($data);
        ob_start();
        include_once sprintf(viewPath()."%s.php",$path);
        $content = ob_get_clean();

        preg_match("/@inheritance\((.+)\)@/",$content,$parentalBlocks);

        ob_start();
        require_once sprintf("%s%s.php",viewPath(),end($parentalBlocks));
        $contentInheritance = ob_get_clean();


        return preg_replace_callback("/@block\((\w+)\)@/",function ($block) use($content){
            preg_match("/@block\($block[1]\)@([^.]+)@endBlock\($block[1]\)@/",$content,$mt);
            return $mt[1];
        },$contentInheritance);
    }
}