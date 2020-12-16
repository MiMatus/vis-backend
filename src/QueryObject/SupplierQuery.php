<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use Nette\Database\Connection;

final class SupplierQuery extends AQueryObject
{

    private array $conds = [];

    public function getQuery(): string
    {
        return "                
            SELECT
                S.id,
                S.name,
                S.user_id,
                U.email,
                U.token,
                L.city AS `location_city`,
                L.street AS `location_street`,
                L.country AS `location_country`,
                L.postal_code AS `location_postal_code`,
                L.lat AS `location_lat`,
                L.lng AS `location_lng`,
                L.id AS `location_id`
            FROM suppliers S
            JOIN users U ON U.id = S.user_id
            JOIN locations L ON L.id = S.location_id
            WHERE ?and
        ";
    }

    public function withIdCond(int $id): self
    {
        $clone = clone $this;
        $clone->conds['id'] = Connection::literal('S.id = ?', $id);
        return $clone;
    }

    public function withTokenCond(string $token): self
    {
        $clone = clone $this;
        $clone->conds['token'] = Connection::literal('U.token = ?', $token);
        return $clone;
    }
    public function withPointAreaCond(float $lat, float $lng, int $area): self
    {
        $clone = clone $this;
        $clone->conds['pointArea'] = Connection::literal('
            (6371 * acos( 
                cos( radians(?) ) 
            * cos( radians( L.lat ) ) 
            * cos( radians( L.lng ) - radians(L.lng) ) 
            + sin( radians(?) ) 
            * sin( radians( L.lat ) )
                ) ) <= ?
        ', $lat, $lat, $area);
        return $clone;
    }

}