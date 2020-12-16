<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class OfferQuery extends AQueryObject
{

    public function getQuery(): string
    {

        return "
            SELECT 
                id,
                project_id, 
                supplier_id, 
                price, 
                completion_date
            FROM `offers` O
            WHERE ?and
        ";
    }

    public function withSupplierIdsCond(array $supplierIds): self
    {
        $clone = clone $this;
        return $clone;
    }

    public function withProjectIdCond(int $projectId): self
    {
        $clone = clone $this;
        $clone->conds['project_id'] = Connection::literal('O.project_id = ?', $projectId);
        return $clone;           
    }

    public function withAcceptedCond(bool $accepted = true): self
    {
        $clone = clone $this;
        $clone->conds['accepted'] = Connection::literal('O.accepted = ?', $accepted);
        return $clone;           
    }

}