<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\User;
use SkillShare\Mapper\IMapper;
use SkillShare\Mapper\UserMapper;
use SkillShare\QueryObject\UserQuery;
use Tracy\Logger;

final class UserRepository
{
    private \WeakMap $simpleCache;

    private IMapper $userMapper;

    private Logger $logger;

    public function __construct(
        IMapper $userMapper,
        Logger $logger
    ) {
        $this->simpleCache = new \WeakMap();
        $this->userMapper = $userMapper;
        $this->logger = $logger;
    }
    
    public function find(UserQuery $userQuery): ?User
    {    
        $project = $this->findAll($userQuery)[0] ?? null;
        return $project;
    }

    public function findAll(UserQuery $userQuery): array
    {
        try {
            return $this->simpleCache[$userQuery] ?? ($this->simpleCache[$userQuery] = $this->userMapper->findAll($userQuery));
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }

    public function save(User $user): bool
    {
        try {
            $this->userMapper->save($user);
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
        return true;
    }
}