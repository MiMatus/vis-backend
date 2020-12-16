<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class SupplierInsertQuery implements IQueryObject
{

    private array $inserts = [];

    public function getQuery(): string
    {
        return 'INSERT INTO suppliers';
    }

    public function getParameters(): array
    {
        return $this->inserts;
    }

    public function withInsert(
        int $userId,
        int $locationId,
        string $name
    ): self {
        $clone = clone $this;
        $clone->inserts[] = [
            'user_id' => $userId,
            'location_id' => $locationId,
            'name' => $name
        ];
        return $clone;
    }


}