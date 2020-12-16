<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class UserInsertQuery extends AQueryObject
{

    private array $inserts = [];

    public function getQuery(): string
    {
        return 'INSERT INTO users VALUES';
    }

    public function getParameters(): array
    {
        return [$this->inserts];
    }

    public function withInsert(
        string $email,
        string $token
    ): self {
        $clone = clone $this;
        $clone->inserts[] = [
            'email' => $email,
            'token' => $token,
        ];
        return $clone;
    }


}