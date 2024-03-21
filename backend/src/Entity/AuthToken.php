<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

class AuthToken
{
    public String $value;
    public bool $success;

    /**
     * @param bool $validation
     */
    public function __construct(bool $validation)
    {
        $this->value = uniqid();
        $this->success = $validation;
    }


    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }


}