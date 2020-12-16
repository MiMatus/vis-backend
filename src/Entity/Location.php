<?php declare(strict_types=1);

namespace SkillShare\Entity;

final class Location
{
    private ?int $id;

    private string $city;

    private string $street;

    private string $postalCode;

    private string $country;

    private float $lat;

    private float $lng;


    public function __construct(
        string $city, 
        string $street, 
        string $postalCode, 
        string $country, 
        float $lat, 
        float $lng,
        ?int $id = null
    ) {
        $this->city = $city;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->country = $country;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    } 

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function __toString()
    {
        return "{$this->street}, {$this->postalCode} {$this->city}";
    }
}