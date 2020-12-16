<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\Location;
use SkillShare\Entity\Review;
use SkillShare\Entity\Supplier;
use SkillShare\QueryObject\LocationInsertQuery;
use SkillShare\QueryObject\ReviewInsertQuery;
use SkillShare\QueryObject\ReviewQuery;
use SkillShare\QueryObject\SupplierInsertQuery;
use SkillShare\QueryObject\UserInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class SupplierMapper extends AMapper
{

    private UserInsertQuery $userInsertQuery;

    private SupplierInsertQuery $supplierInserQuery;

    private LocationInsertQuery $locationInsertQuery;


    public function __construct(
        UserInsertQuery $userInsertQuery,
        SupplierInsertQuery $supplierInserQuery,
        LocationInsertQuery $locationInsertQuery,
        /*ReviewInsertQuery $reviewInsertQuery,
        ReviewQuery $reviewQuery,*/
        Connection $connection,
        Logger $logger
    ){
        parent::__construct($connection, $logger);
        $this->userInsertQuery = $userInsertQuery;
        $this->supplierInserQuery = $supplierInserQuery;
        $this->locationInsertQuery = $locationInsertQuery;
       /* $this->reviewQuery = $reviewQuery;
        $this->reviewInsertQuery = $reviewInsertQuery;*/
    }

    public function save(Supplier $supplier): bool
    {
        try{
            $this->connection->beginTransaction();
            $userQuery = $this->userInsertQuery->withInsert(
                $supplier->getEmail(),
                $supplier->getToken(),
            );            
            $this->connection->query($userQuery->getQuery(), $userQuery->getParameters());
            $userId = (int)$this->connection->getInsertId();

            $locationQuery = $this->locationInsertQuery->withInsert(
                $supplier->getLocation()->getCity(), 
                $supplier->getLocation()->getStreet(), 
                $supplier->getLocation()->getPostalCode(), 
                $supplier->getLocation()->getCountry(), 
                $supplier->getLocation()->getLat(), 
                $supplier->getLocation()->getLng()
            );
            $this->connection->query($locationQuery->getQuery(), $locationQuery->getParameters());  
            $locationId = (int)$this->connection->getInsertId();

            $supplierQuery = $this->supplierInserQuery->withInsert(
                $userId,
                $locationId,
                $supplier->getName()
            );
            $this->connection->query($supplierQuery->getQuery(), $supplierQuery->getParameters());
            $this->connection->commit();
        } catch(\Exception $exception){
            $this->connection->rollBack();
            return false;
        }
        $supplier->setId($userId);
        $supplier->getLocation()->setId($locationId);
        return true;
    }

    protected function mapRows(array $rows): array
    {
        //$reviews = $this->getReviews($rows);
        $suppliers = [];
        foreach($rows as $row){
            $suppliers[] = new Supplier(
                $row->email,
                $row->token,
                new Location(
                    $row->location_city, 
                    $row->location_street, 
                    $row->location_postal_code, 
                    $row->location_country, 
                    $row->location_lat, 
                    $row->location_lng,
                    $row->location_id
                ),
                $row->name,
                $row->id
                //$reviews[$row->id] ?? []
            );
        }
        return $suppliers;
    }

    /*private function getReviewInsertQuery(array $reviews): ReviewInsertQuery
    {
        $query = $this->reviewInsertQuery;
        foreach($reviews as $review){
            $query = $query->withInsert(
                $review->getUserId(),
                $review->getProjectId(),
                $review->isPositive(),
                $review->getContent(),
            );
        }
        return $query;
    }*/

  /*  private function getReviews(array $rows): array
    {
        $ids = array_column($rows, 'id');
        $reviewsData = $this->safelyExecuteQuery($this->reviewQuery->withSupplierIdsCond($ids));
        $reviews = [];
        foreach($reviewsData as $reviewData){
            $reviews[$reviewData->user_id] = new Review(
                $reviewData->user_id, 
                $reviewData->project_id, 
                (bool) $reviewData->positive, 
                $reviewData->content
            );
        }
        return $reviews;
    }*/
}