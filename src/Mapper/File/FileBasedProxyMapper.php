<?php declare(strict_types=1);

namespace SkillShare\Mapper\File;

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use SkillShare\Mapper\IMapper;
use SkillShare\QueryObject\IQueryObject;
use Tracy\Logger;

class FileBasedProxyMapper implements IMapper
{

    private FileStorage $storage;

    private IMapper $realMapper;

    private Logger $logger;

    public function __construct(
        FileStorage $fileStorage,
        IMapper $realMapper,
        Logger $logger
    ){
        $this->storage = $fileStorage;
        $this->realMapper = $realMapper;
        $this->logger = $logger;
    }

    public function find(IQueryObject $query): ?object
    {
        return $this->findAll($query)[0] ?? null;
    }

    public function findAll(IQueryObject $query): iterable
    {
        try{
            $identifier = $query->getIdentifier();
            if(null !== $data = $this->storage->read($identifier)){
                return $data;
            }
            $data = $this->realMapper->findAll($query);
            $this->storage->write($identifier, $data, [Cache::EXPIRATION => 3600/*in seconds*/]);
            return $data;
        } catch (\Exception $exception) {
            $this->logger->log($exception);
            return [];
        }
    }

    public function save(object $object): bool 
    {
        return $this->realMapper->save($object);
    }

}