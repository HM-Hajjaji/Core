<?php

namespace Core\Component\Validator;

class Validator extends CoreValidation
{
    public function setData(array $data):static
    {
        $this->dataHandling = $data;
        return $this;
    }
}