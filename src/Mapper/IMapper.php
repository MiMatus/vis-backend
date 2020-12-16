<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Enitity\Supplier;
use SkillShare\QueryObject\IQueryObject;
use SkillShare\QueryObject\SupplierQuery;

interface IMapper
{
    public function find(IQueryObject $query): ?object;

    public function findAll(IQueryObject $query): iterable;

    public function save(object $object): bool;

}