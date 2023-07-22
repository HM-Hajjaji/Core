<?php
namespace Core\Component\Validator;
abstract class CoreValidation
{
    protected const DEFAULT_VALIDATION_ERRORS = [
        'required' => 'The %s is required',
        'email' => 'The %s is not a valid email address',
        'min' => 'The %s must have at least %d characters',
        'max' => 'The %s must have at most %d characters',
        'between' => 'The %s must have between %d and %d characters',
        'same' => 'The %s must match with %s',
        'alphanumeric' => 'The %s should have only letters and numbers',
        'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
        'unique' => 'The %s already exists',
    ];
    protected array $dataHandling = [];
    protected array $cleanData = [];
    protected array $errors = [];

    protected function getValueOfDateHandling(string $key): mixed
    {
        return trim($this->dataHandling[$key])??null;
    }

    public function getErrors():array
    {
        return $this->errors;
    }

    public function getCleanData():array
    {
        return $this->cleanData;
    }

    protected function setError(string $key ,string $message):void
    {
        if (!array_key_exists($key,$this->errors))
        {
            $this->errors[$key] = $message;
        }
    }

    protected function setCleanData(string $key,mixed $value): void
    {
        $this->cleanData[$key] = $this->sanitizeValue($value);
    }
    protected function sanitizeValue(mixed $value): string
    {
        $sanitizedValue = trim($value);
        $sanitizedValue = stripslashes($sanitizedValue);
        $sanitizedValue = htmlspecialchars($sanitizedValue);
        return $sanitizedValue;
    }

    public function isValid():bool
    {
        return empty($this->errors);
    }


    //---------------------------functions of validate items------------------------------------

    public function required(array $keys):static
    {
        foreach ($keys as $key) {
            $value = $this->getValueOfDateHandling($key);
            if (empty($value) && !ctype_alnum($value)) {
                $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['required'],$key));
            }else{
                $this->setCleanData($key,$value);
            }
        }
        return $this;
    }

    public function email(string $key):static
    {
        $value = filter_var($this->getValueOfDateHandling($key),FILTER_SANITIZE_EMAIL);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['email'],$key));
        }else{
            $this->setCleanData($key,$value);
        }
        return $this;
    }

    public function alphanumeric(string $key):static
    {
        $value = $this->getValueOfDateHandling($key);
        if (!is_numeric($value)) {
            $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['alphanumeric'],$key));
        }else{
            $this->setCleanData($key,$value);
        }
        return $this;
    }

    public function min(string $key,int $min):static
    {
        $value = $this->getValueOfDateHandling($key);
        if (strlen($value) < $min)
        {
            $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['min'],$key,$min));
        }else{
            $this->setCleanData($key,$value);
        }
        return $this;
    }

    public function max(string $key,int $max):static
    {
        $value = $this->getValueOfDateHandling($key);
        if (strlen($value) > $max)
        {
            $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['max'],$key,$max));
        }else{
            $this->setCleanData($key,$value);
        }
        return $this;
    }

    public function between(string $key,int $min,int $max):static
    {
        $value = $this->getValueOfDateHandling($key);
        if (strlen($value) < $min || strlen($value) > $max)
        {
            $this->setError($key,sprintf(self::DEFAULT_VALIDATION_ERRORS['between'],$key,$min,$max));
        }else{
            $this->setCleanData($key,$value);
        }
        return $this;
    }
}