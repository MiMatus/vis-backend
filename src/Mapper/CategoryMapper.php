<?php declare(strict_types=1);

namespace SkillShare\Mapper;

use SkillShare\Entity\Category;
use SkillShare\Entity\Offer;
use SkillShare\QueryObject\OfferInsertQuery;
use Nette\Database\Connection;
use Tracy\Logger;

final class CategoryMapper extends AMapper
{

    public function __construct(
        OfferInsertQuery $offerInsertQuery,
        Logger $logger,
        Connection $connection
    ){
        parent::__construct($connection, $logger);
        $this->offerInsertQuery = $offerInsertQuery;
    }

    public function save(Category $object): bool
    {
        return true;
    }

    protected function mapRows(array $rows): array
    {
        $categories = [];
        foreach($rows as $row)
        {
            $categories[] = new Category(
                $row->name,
                $row->description,
                $row->id
            );
        }
        return $categories;
    }
}