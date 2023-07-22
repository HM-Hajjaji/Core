<?php

namespace Core\Component\Controller;

use Core\Component\Generator\Generator;
use Core\Component\Http\Response;
use JetBrains\PhpStorm\NoReturn;

abstract class CoreController
{
    protected function view(string $view,array $data = []):Response
    {
        return response()->setContent($this->renderView($view,$data))->send();
    }

    private function renderView(string $path, array $data): string
    {
        return Generator::generate($path,$data);
    }

    /**
     * @throws \Exception
     */
    #[NoReturn] public function redirectTo(string $path, array $params=[]):void
    {
        request()->setMethod("GET");
        header("location:".path($path,$params));
        exit();
    }
}