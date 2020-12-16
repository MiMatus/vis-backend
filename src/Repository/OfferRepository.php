<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\Offer;
use SkillShare\Mapper\IMapper;
use SkillShare\Mapper\OfferMapper;
use SkillShare\QueryObject\OfferQuery;
use Tracy\Logger;

final class OfferRepository
{
    private \WeakMap $simpleCache;

    private IMapper $offerMapper;

    private Logger $logger;

    public function __construct(
        IMapper $offerMapper,
        Logger $logger
    ) {
        $this->simpleCache = new \WeakMap();
        $this->offerMapper = $offerMapper;
        $this->logger = $logger;
    }
    
    public function find(OfferQuery $offerQuery): ?Offer
    {    
        $project = $this->findAll($offerQuery)[0] ?? null;
        return $project;
    }

    public function findAll(OfferQuery $offerQuery): array
    {
        try {
            return $this->simpleCache[$offerQuery] ?? ($this->simpleCache[$offerQuery] = $this->offerMapper->findAll($offerQuery));
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }

    public function save(Offer $offer): bool
    {
        try {
            return $this->offerMapper->save($offer);
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
    }
}