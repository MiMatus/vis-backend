<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\QueryObject\IQueryObject;
use Nette\Database\Connection;
use Tracy\Logger;

abstract class AMapper implements IMapper
{

    protected Connection $connection;

    protected Logger $logger;

    public function __construct(
        Connection $connection,
        Logger $logger
    ){
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function find(IQueryObject $query): ?object
    {
        return $this->mapRows($this->safelyExecuteQuery($query))[0] ?? null;
    }

    public function findAll(IQueryObject $query): array
    {
        return $this->mapRows($this->safelyExecuteQuery($query));  
    }

    private function safelyExecuteQuery(IQueryObject $query): array
    {
        try{
           // $this->connection->query($query->getQuery(), $query->getParameters())->fetchAll();
           // var_dump($this->connection->getLastQueryString());
            return $this->connection->query($query->getQuery(), $query->getParameters())->fetchAll();
        } catch(\Exception $exception) {
            $this->logger->log($exception);
            return [];
        }       
    }

    protected function executeSaveQueries(IQueryObject ...$queries): bool
    {
        try{
            $this->connection->beginTransaction();
            foreach($queries as $query){
                $this->connection->query($query->getQuery(), $query->getParameters());
            }
            $this->connection->commit();
        } catch(\Exception $exception) {
            $this->connection->rollBack();
            return false;
        }
        return true;
    }

    abstract protected function mapRows(array $rows): array;
}