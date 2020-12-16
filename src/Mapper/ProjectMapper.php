<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\Location;
use SkillShare\Entity\Project;
use SkillShare\QueryObject\LocationInsertQuery;
use SkillShare\QueryObject\ProjectInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class ProjectMapper extends AMapper
{

    private ProjectInsertQuery $projectInsertQuery;

    private LocationInsertQuery $locationInsertQuery;


    public function __construct(
        ProjectInsertQuery $projectInsertQuery,
        LocationInsertQuery $locationInsertQuery,
        Connection $connection,
        Logger $logger
    ) {
        parent::__construct($connection, $logger);
        $this->projectInsertQuery = $projectInsertQuery;
        $this->locationInsertQuery = $locationInsertQuery;
    }

    public function save(object $project): bool
    {
        try{
            $locationQuery = $this->locationInsertQuery->withInsert(
                $project->getLocation()->getCity(), 
                $project->getLocation()->getStreet(), 
                $project->getLocation()->getPostalCode(), 
                $project->getLocation()->getCountry(), 
                $project->getLocation()->getLat(), 
                $project->getLocation()->getLng()
            );
            $this->connection->query($locationQuery->getQuery(), ...$locationQuery->getParameters());  
            $locationId = (int)$this->connection->getInsertId();
            $project->getLocation()->setId($locationId);

            $projectInsertQuery = $this->projectInsertQuery->withInsert(
                $project->getName(), 
                $project->getDescription(),
                $project->getExpectedPrice(),
                $project->getAllowedArea(),
                $project->getCategoryId(),
                $locationId,
                $project->getUserId()
            );
            $this->connection->query($projectInsertQuery->getQuery(), ...$projectInsertQuery->getParameters());
            $projectId = (int)$this->connection->getInsertId(); 
            $project->setId($projectId);
            return true;
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }

    }


    protected function mapRows(array $rows): array
    {
        $projects = [];
        foreach($rows as $row){
            $projects[] = new Project(
                $row->name,
                $row->description,
                new Location(
                    $row->location_city, 
                    $row->location_street, 
                    $row->location_postal_code, 
                    $row->location_country, 
                    $row->location_lat, 
                    $row->location_lng,
                    $row->location_id
                ),
                $row->expected_price,
                $row->allowed_area,
                $row->category_id,
                $row->user_id,
                $row->id  
            );
        }
        return $projects;
    }
}