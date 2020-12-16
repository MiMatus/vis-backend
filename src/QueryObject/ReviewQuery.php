<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class ReviewQuery extends AQueryObject
{

    public function getQuery(): string
    {

        return "
            SELECT 
                id,
                positive,
                content,
                user_id,
                project_id
            FROM reviews R
            WHERE ?and
        ";
    }

    public function withProjectIdCond(int $projectId): self
    {
        $clone = clone $this;
        $clone->conds['project_id'] = Connection::literal('R.project_id = ?', $projectId);
        return $clone;
    }

    public function withUserIdCond(int $userId): self
    {
        $clone = clone $this;
        $clone->conds['user_id'] = Connection::literal('R.user_id = ?', $userId);
        return $clone;
    }
}