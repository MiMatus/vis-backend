<?php declare(strict_types=1);

namespace SkillShare\Entity;

final class Project
{
    private ?int $id;

    private string $name;

    private string $description;

    private Location $location;

    private int $expectedPrice;

    private int $allowedArea;

    private int $categoryId;

    private int $userId;

    public function __construct(
        string $name, 
        string $description,
        Location $location,
        int $expectedPrice,
        int $allowedArea,
        int $categoryId,
        int $userId,
        ?int $id = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
        $this->expectedPrice = $expectedPrice;
        $this->allowedArea = $allowedArea;
        $this->categoryId = $categoryId;
        $this->userId = $userId;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryId(): int 
    {
        return $this->categoryId;
    }

    public function getExpectedPrice(): int
    {
        return $this->expectedPrice;
    }

    public function getAllowedArea(): int
    {
        return $this->allowedArea;
    }
}