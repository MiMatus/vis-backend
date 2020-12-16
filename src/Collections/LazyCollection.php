<?php declare(strict_types=1);

namespace SkillShare\Collection;

use SkillShare\Mapper\IMapper;
use SkillShare\QueryObject\IQueryObject;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class LazyCollection implements Countable, IteratorAggregate
{
    
    protected iterable $data;

    protected bool $isInitialized;

    protected IMapper $mapper;

    protected IQueryObject $query;

    public function __construct(IMapper $mapper, IQueryObject $query)
    {
        $this->mapper = $mapper;
        $this->query = $query;
    }

    public function count(): int
    {
        $this->initialize();
        return count($this->data);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    private function initialize(): void
    {
        if(!$this->isInitialized){
            $this->data = $this->mapper->findAll($this->query);
            $this->isInitialized = true;
        }
    }




}