<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

class JsonReturn
{
    public String $id;
    public bool $validation;

    /**
     * @param bool $validation
     */
    public function __construct(bool $validation)
    {
        $this->id = uniqid();
        $this->validation = $validation;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function isValidation(): bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): void
    {
        $this->validation = $validation;
    }


}