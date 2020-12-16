<?php declare(strict_types=1);

namespace SkillShare\Entity;

final class Review
{
    private ?int $id;

    private int $userId;

    private int $projectId;

    private bool $isPositive;

    private string $content;

    public function __construct(
        int $userId,
        int $projectId,
        bool $isPositive,
        string $content,
        ?int $id = null
    ) {
        $this->userId = $userId;
        $this->projectId = $projectId;
        $this->isPositive = $isPositive;
        $this->content = $content;
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

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function isPositive(): bool
    {
        return $this->isPositive;
    }

    public function getContent(): string
    {
        return $this->content;
    }

}