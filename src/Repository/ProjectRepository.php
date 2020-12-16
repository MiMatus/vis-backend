<?php declare(strict_types=1);

namespace SkillShare\Repository;

use SkillShare\Entity\Project;
use SkillShare\Mapper\IMapper;
use SkillShare\Mapper\ProjectMapper;
use SkillShare\QueryObject\ProjectQuery;
use Tracy\Logger;

final class ProjectRepository
{
    private \WeakMap $simpleCache;

    private IMapper $projectMapper;

    private Logger $logger;

    public function __construct(
        IMapper $projectMapper,
        Logger $logger
    ) {
        $this->simpleCache = new \WeakMap();
        $this->projectMapper = $projectMapper;
        $this->logger = $logger;
    }
    
    public function find(ProjectQuery $projectQuery): ?Project
    {    
        $project = $this->findAll($projectQuery)[0] ?? null;
        return $project;
    }

    public function findAll(ProjectQuery $projectQuery): array
    {
        try {
            return $this->simpleCache[$projectQuery] ?? ($this->simpleCache[$projectQuery] = $this->projectMapper->findAll($projectQuery));
        } catch(\Exception $exception) {
            $this->logger->log($exception);
        }
        return [];
    }

    public function save(Project $project): bool
    {
        try {
            return $this->projectMapper->save($project);
        } catch(\Exception $exception){
            $this->logger->log($exception);
            return false;
        }
    }
}