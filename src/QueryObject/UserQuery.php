<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class UserQuery extends AQueryObject
{

    public function getQuery(): string
    {
        return "
            SELECT
                id,
                email,
                token
            FROM users U
            WHERE ?and
        ";
    }

    public function withIdCond(int $id): self
    {
        $clone = clone $this;
        $clone->conds['id'] = Connection::literal('U.id = ?', $id);
        return $clone;
    }

    public function withTokenCond(string $token): self
    {
        $clone = clone $this;
        $clone->conds['token'] = Connection::literal('U.token = ?', $token);
        return $clone;
    }

}