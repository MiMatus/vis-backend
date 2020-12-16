<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class OfferInsertQuery extends AQueryObject
{

    private array $inserts = [];

    public function getQuery(): string
    {
        return 'INSERT INTO offers';
    }

    public function getParameters(): array
    {
        return [$this->inserts];
    }

    public function withInsert(
        int $projectId,
        int $supplierId,
        int $price,
        ?\DateTime $completionDate,
        bool $accepted = false
    ): self {
        $clone = clone $this;
        $clone->inserts[] = [
            'project_id' => $projectId,
            'supplier_id' => $supplierId,
            'price' => $price,
            'completion_date' => $completionDate,
            'accepted' => $accepted
        ];
        return $clone;
    }


}