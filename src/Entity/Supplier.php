<?php declare(strict_types=1);

namespace SkillShare\Entity;

use LogicException;

final class Supplier extends User
{
   private string $name;

   private Location $location;

   private string $email;

   public function __construct(
       string $email, 
       string $token, 
       Location $location, 
       string $name,
       ?int $id
    ) {
       parent::__construct($email, $token, $id);
       $this->location = $location;
       $this->name = $name;
   }

   public function getName(): string
   {
       return $this->name;
   }

   public function getEmail(): string
   {
       return $this->email;
   }

   public function getLocation(): Location
   {
       return $this->location;
   }
}