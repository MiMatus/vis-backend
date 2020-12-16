<?php declare(strict_types=1);

namespace SkillShare\Service;


final class GeoLocation
{
	private const COORDINATES = [
		'ostrava' => [49.826314, 18.266761],
		'brno' => [49.194368, 16.610175],
		'praha' => [50.075354, 14.436499],
	];

	public function getCoordinates(string $city, string $street, string $postalCode, string $country): array
	{
		return self::COORDINATES[strtolower(trim($city))] ?? [49.706832, 16.054825];
	}
}
