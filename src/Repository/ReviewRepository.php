<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\Review;
use SkillShare\Mapper\IMapper;
use SkillShare\Mapper\ReviewMapper;
use SkillShare\QueryObject\ReviewQuery;
use Tracy\Logger;

final class ReviewRepository
{
    private \WeakMap $simpleCache;

    private IMapper $reviewMapper;

    private Logger $logger;

    public function __construct(
        IMapper $reviewMapper,
        Logger $logger
    ) {
        $this->simpleCache = new \WeakMap();
        $this->reviewMapper = $reviewMapper;
        $this->logger = $logger;
    }
    
    public function find(ReviewQuery $reviewQuery): ?Review
    {    
        $project = $this->findAll($reviewQuery)[0] ?? null;
        return $project;
    }

    public function findAll(ReviewQuery $reviewQuery): array
    {
        try {
            return $this->simpleCache[$reviewQuery] ?? ($this->simpleCache[$reviewQuery] = $this->reviewMapper->findAll($reviewQuery));
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }

    public function save(Review $review): bool
    {
        try {
            return $this->reviewMapper->save($review);
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
    }
}