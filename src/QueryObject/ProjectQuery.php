<?php declare(strict_types=1);

namespace SkillShare\QueryObject;

use SkillShare\Enitity\Location;
use Nette\Database\Connection;

final class ProjectQuery extends AQueryObject
{

    public function getQuery(): string
    {
        return "
            SELECT 
                P.name,
                P.description,
                P.created_at,
                P.expected_price,
                P.id,
                P.user_id,
                P.allowed_area,
                P.category_id,
                L.city AS `location_city`,
                L.street AS `location_street`,
                L.country AS `location_country`,
                L.postal_code AS `location_postal_code`,
                L.lat AS `location_lat`,
                L.lng AS `location_lng`,
                L.id AS `location_id`
            FROM projects P
            JOIN locations L ON P.location_id = L.id
            WHERE ?and
        ";
    }
    public function withIdCond(int $id): self
    {
        $clone = clone $this;
        $clone->conds['id'] = Connection::literal('P.id = ?', $id);
        return $clone;
    }

    public function withSupplierIdCond(int $supplierId): self
    {
        $clone = clone $this;
        $clone->conds['supplier_id'] = Connection::literal('
            EXISTS (
                SELECT id
                FROM offers O
                WHERE project_id = P.id AND O.accepted = 1 AND O.supplier_id = ?
            )            
        ', $supplierId);
        return $clone;      
    }

    public function withUserIdCond(int $userId): self
    {
        $clone = clone $this;
        $clone->conds['user_id'] = Connection::literal('P.user_id = ?', $userId);
        return $clone;
    }    

}