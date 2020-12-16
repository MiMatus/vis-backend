<?php declare(strict_types=1);


namespace SkillShare\Test\Unit\Mock;

use SkillShare\Enitity\Supplier;
use SkillShare\Mapper\ISupplierMapper;
use SkillShare\QueryObject\SupplierQuery;

final class SupplierMapperMock implements ISupplierMapper
{

	private array $storage;

	public function __construct()
	{
		$this->storage = [];
	}

	public function save(Supplier $supplier): void
	{
		$this->storage[] = $supplier;
	}

	public function find(SupplierQuery $supplierQuery): ?Supplier
	{
		return $this->storage[0] ?? null;
	}

	public function findAll(SupplierQuery $supplierQuery): array
	{
		return $this->storage;
	}

}

