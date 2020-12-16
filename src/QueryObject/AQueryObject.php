<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use LogicException;
use Nette\Database\Connection;

abstract class AQueryObject implements IQueryObject
{

    protected array $conds = [];

    protected ?int $limit = null;

    protected ?int $offset = null;


    public function getParameters(): array
    {
        $parameters = [array_values($this->conds)];
        if($this->limit !== null){
            $parameters[] = Connection::literal('LIMIT '. $this->limit);
        }
        if($this->offset !== null){
            $parameters[] = Connection::literal('OFFSET '. $this->offset);
        }
        return $parameters;
    }

    public function withLimit(int $limit): self
    {
        $clone = clone $this;
        $clone->limit = $limit;
        return $clone;
    }

    public function withOffset(int $offset): self
    {
        $clone = clone $this;
        $clone->offset = $offset;
        return $clone;
    }

    public function getIdentifier(): string
    {
        return md5(serialize([
            $this->getQuery(),
            $this->conds,
            $this->limit,
            $this->offset
        ]));
    }

}