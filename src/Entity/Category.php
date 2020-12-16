<?php declare(strict_types=1);

namespace SkillShare\Entity;


final class Category
{
    private ?int $id;

    private string $name;

    private string $description;

    public function __construct(
        string $name,
        string $description,
        ?int $id = null
    ) {
        $this->name = $name;
        $this->description = $description;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}