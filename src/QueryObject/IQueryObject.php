<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

interface IQueryObject
{
    public function getQuery(): string;

    public function getParameters(): array;
}