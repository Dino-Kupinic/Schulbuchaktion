<?php

namespace App\Entity;

use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use JWT\Authentication\JWT;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

class AuthToken
{
    private String $key;
    public String $jwtString;
    public bool $success;

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }


    public function getValue(): string
    {
        return $this->jwtString;
    }

    public function setValue(array $payload): void
    {
        $this->jwtString = $this->encode($payload);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }


    private function encode(array $data): string
    {
        try {
            $data = array_merge($data, ['iat' => (int)date('U')]);
            return JWT::encode($data, $this->key);
        }
        catch (Exception $e) {
            throw new JWTEncodeFailureException(JWTEncodeFailureException::INVALID_CONFIG, 'An error occurred while trying to encode the JWT token.', $e);
        }
    }

    public function decode($token): array
    {
        try {
            return (array) JWT::decode($token, $this->key);
        } catch (Exception $e) {
            throw new JWTDecodeFailureException(JWTDecodeFailureException::INVALID_TOKEN, 'Invalid JWT Token', $e);
        }
    }

    public function __toString(): string
    {
        return $this->jwtString;
    }


}