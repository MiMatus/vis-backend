<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class ProjectInsertQuery implements IQueryObject
{

    private array $inserts = [];

    public function getQuery(): string
    {
        return 'INSERT INTO projects';
    }

    public function getParameters(): array
    {
        return $this->inserts;
    }

    public function withInsert(
        string $title, 
        string $description,
        int $expectedPrice,
        int $allowedArea,
        int $categoryId,
        int $locationId,
        int $userId
    ): self {
        $clone = clone $this;
        $clone->inserts[] = [
            'name' => $title,
            'description' => $description,
            'expected_price' => $expectedPrice,
            'allowed_area' => $allowedArea,
            'category_id' => $categoryId,
            'location_id' => $locationId,
            'user_id' => $userId,
        ];
        return $clone;
    }


}