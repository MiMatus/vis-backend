<?php declare(strict_types=1);

namespace SkillShare\Entity;

class User
{
    private string $email;

    private string $token;

    private ?int $id;

    public function __construct(string $email, string $token, ?int $id = null)
    {
        $this->email = $email;
        $this->token = $token;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }

}