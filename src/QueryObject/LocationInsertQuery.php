<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class LocationInsertQuery extends AQueryObject
{

    private array $inserts = [];

    public function getQuery(): string
    {
        return  'INSERT INTO locations';
    }

    public function getParameters(): array
    {
        return [$this->inserts];
    }

    public function withInsert(
        string $city, 
        string $street, 
        string $postalCode, 
        string $country, 
        float $lat, 
        float $lng
    ): self {
        $clone = clone $this;
        $clone->inserts = [
            'city' => $city,
            'street' => $street,
            'postal_code' => $postalCode,
            'country' => $country,
            'lat' => $lat,
            'lng' => $lng
        ];
        return $clone;
    }


}