<?php declare(strict_types=1);

namespace SkillShare\Entity;


final class Offer
{
    private ?int $id;

    private int $price;

    private ?\Datetime $completionDate;

    private int $projectId;

    private int $supplierId;

    public function __construct(
        int $projectId,
        int $supplierId,
        int $price,
        ?\Datetime $completionDate,
        ?int $id = null
    ) {
        $this->projectId = $projectId;
        $this->supplierId = $supplierId;
        $this->price = $price;
        $this->completionDate = $completionDate;
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    public function getCompletionDate(): ?\Datetime
    {
        return $this->completionDate;
    }
}