<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\Supplier;
use SkillShare\Mapper\SupplierMapper;
use SkillShare\QueryObject\SupplierQuery;
use Tracy\Logger;

final class SupplierRepository
{
    private \WeakMap $simpleCache;

    private SupplierMapper $supplierMapper;

    private Logger $logger;

    public function __construct(
        SupplierMapper $supplierMapper,
        Logger $logger
    ) {
        $this->queryCache = new \WeakMap();
        $this->supplierMapper = $supplierMapper;
        $this->logger = $logger;
    }
    
    public function find(SupplierQuery $supplierQuery): ?Supplier
    {    
        $project = $this->findAll($supplierQuery)[0] ?? null;
        return $project;
    }

    public function findAll(SupplierQuery $supplierQuery): array
    {
        try {
            if(isset($this->simpleCache[$supplierQuery])){
                return $this->simpleCache[$supplierQuery];
            }
            return $this->supplierMapper->findAll($supplierQuery);
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }

    public function save(Supplier $supplier): bool
    {
        try {
            $this->supplierMapper->save($supplier);
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
        return true;
    }
}