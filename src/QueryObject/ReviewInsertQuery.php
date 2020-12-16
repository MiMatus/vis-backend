<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class ReviewInsertQuery implements IQueryObject
{

    private Connection $connection;

    private array $inserts = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getQuery(): string
    {
       return 'INSERT INTO reviews';
    }

    public function getParameters(): array
    {
        return $this->inserts;
    }

    public function withInsert(
        int $userId,
        int $projectId,
        bool $positive,
        string $content
    ): self {
        $clone = clone $this;
        $clone->inserts[] = [
            'user_id' => $userId,
            'project_id' => $projectId,
            'positive' => $positive,
            'content' => $content
        ];
        return $clone;
    }


}