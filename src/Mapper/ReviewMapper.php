<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\Review;
use SkillShare\QueryObject\ReviewInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class ReviewMapper extends AMapper
{

    private ReviewInsertQuery $reviewInsertQuery;

    public function __construct(
        ReviewInsertQuery $reviewInsertQuery,
        Logger $logger,
        Connection $connection
    ){
        parent::__construct($connection, $logger);
        $this->reviewInsertQuery = $reviewInsertQuery;
    }


    public function save(object $review): bool
    {

        try{
            $reviewInsertQuery = $this->reviewInsertQuery->withInsert(
                $review->getUserId(), 
                $review->getProjectId(), 
                $review->isPositive(), 
                $review->getContent()
            );
            $this->connection->query($reviewInsertQuery->getQuery(), ...$reviewInsertQuery->getParameters());
            $reviewId = (int)$this->connection->getInsertId();
            $review->setId($reviewId);
            return true;
        } catch(\Exception $exception){
            return false;
        }
        
    }


    protected function mapRows(array $rows): array
    {
        $reviews = [];
        foreach($rows as $row)
        {
            $reviews[] = new Review(
                $row->user_id,
                $row->project_id,
                (bool)$row->positive,
                $row->content,
                $row->id
            );
        }
        return $reviews;
    }
}