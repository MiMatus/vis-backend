<?php declare(strict_types=1);

namespace SkillShare\Factory;

use SkillShare\Collection\LazyCollection;
use SkillShare\Enitity\Location;
use SkillShare\Enitity\Supplier;
use SkillShare\Mapper\IMapper;
use SkillShare\QueryObject\IQueryObject;

final class SupplierFactory
{

    private IQueryObject $reviewsQuery;

    private IMapper $reviewsMapper;

    public function createSupplierFromData(
        int $id,
        string $email,
        string $token,
        string $name,
        string $city,
        string $street,
        string $country,
        string $postalCode,
        float $lat,
        float $lng
    ): Supplier {
       $lazyReviews = $this->getReviewsColletion($id);
       return new Supplier(
        $email, 
        $token, 
        new Location(
            $city,
            $street,
            $postalCode,
            $country,
            $lat,
            $lng     
        ), 
        $name,
        $lazyReviews          
       );
    }

    private function getReviewsColletion(int $supplierId): LazyCollection
    {
        return new LazyCollection(  
            $this->reviewsMapper,
            $this->reviewsQuery
        );
    }
}