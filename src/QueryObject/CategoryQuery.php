<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class CategoryQuery implements IQueryObject
{

    private array $conds = [];


    public function getQuery(): string
    {

        return "
            SELECT 
                id,
                name,
                description
            FROM categories C
            WHERE ?and
        ";
    }

    public function getParameters(): array
    {
        return array_values($this->conds);
    }

    public function withIdCond(int $id): self
    {
        $clone = clone $this;
        $clone->conds['id'] = Connection::literal('C.id = ?', $id);
        return $clone;        
    }

}