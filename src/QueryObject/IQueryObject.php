<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Serializable;

interface IQueryObject
{
    public function getQuery(): string;

    public function getParameters(): array;

    public function getIdentifier(): string;
}