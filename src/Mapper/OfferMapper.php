<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\Offer;
use SkillShare\QueryObject\OfferInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class OfferMapper extends AMapper
{

    private OfferInsertQuery $offerInsertQuery;

    public function __construct(
        OfferInsertQuery $offerInsertQuery,
        Logger $logger,
        Connection $connection
    ){
        parent::__construct($connection, $logger);
        $this->offerInsertQuery = $offerInsertQuery;
    }


    public function save(object $offer): bool
    {
        try{
            $offerInsertQuery = $this->offerInsertQuery->withInsert(
                $offer->getProjectId(), 
                $offer->getSupplierId(), 
                $offer->getPrice(), 
                $offer->getCompletionDate()
            );
            $this->connection->query($offerInsertQuery->getQuery(), ...$offerInsertQuery->getParameters());
            $offerId = (int)$this->connection->getInsertId();
            $offer->setId($offerId);
            return true;
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
        
    }


    protected function mapRows(array $rows): array
    {
        $offers = [];
        foreach($rows as $row)
        {
            $offers[] = new Offer(
                $row->project_id,
                $row->supplier_id,
                $row->price,
                $row->completion_date,
                $row->id
            );
        }
        return $offers;
    }
}