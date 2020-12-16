<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\Category;
use SkillShare\Mapper\CategoryMapper;
use SkillShare\Mapper\IMapper;
use SkillShare\QueryObject\CategoryQuery;
use Tracy\Logger;

final class CategoryRepository
{
    private \WeakMap $simpleCache;

    private IMapper $categoryMapper;

    private Logger $logger;

    public function __construct(
        IMapper $categoryMapper,
        Logger $logger
    ) {
        $this->simpleCache = new \WeakMap();
        $this->categoryMapper = $categoryMapper;
        $this->logger = $logger;
    }
    
    public function find(CategoryQuery $categoryQuery): ?Category
    {    
        $project = $this->findAll($categoryQuery)[0] ?? null;
        return $project;
    }

    public function findAll(CategoryQuery $categoryQuery): array
    {
        try {
            return $this->simpleCache[$categoryQuery] ?? ($this->simpleCache[$categoryQuery] = $this->categoryMapper->findAll($categoryQuery));
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }
}