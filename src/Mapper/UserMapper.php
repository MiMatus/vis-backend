<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\User;
use SkillShare\QueryObject\UserInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class UserMapper extends AMapper
{

    private UserInsertQuery $userInsertQuery;

    public function __construct(
        UserInsertQuery $userInsertQuery,
        Logger $logger,
        Connection $connection
    ){
        parent::__construct($connection, $logger);
        $this->userInsertQuery = $userInsertQuery;
    }


    public function save(User $user): bool
    {
        try{
            $userInsertQuery = $this->userInsertQuery->withInsert($user->getEmail(), $user->getToken());
            $this->connection->query($userInsertQuery->getQuery(), $userInsertQuery->getParameters());
            $userId = (int)$this->connection->getInsertId();
            $user->setId($userId);
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
            $reviews[] = new User(
                $row->email,
                $row->token,
                $row->id
            );
        }
        return $reviews;
    }
}