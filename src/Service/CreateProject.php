<?php declare(strict_types=1);

namespace SkillShare\Service;

use SkillShare\Entity\Location;
use SkillShare\Entity\Project;
use SkillShare\QueryObject\SupplierQuery;
use SkillShare\QueryObject\UserQuery;
use SkillShare\Repository\ProjectRepository;
use SkillShare\Repository\SupplierRepository;
use SkillShare\Repository\UserRepository;

final class CreateProject
{

	private ProjectRepository $projectRepository;

	private UserRepository $userRepository;

	private SupplierRepository $supplierRepository;

	private SupplierQuery $supplierQuery;

	private UserQuery $userQuery;

	private GeoLocation $geoLocation;

	public function __construct(
		ProjectRepository $projectRepository,
		UserRepository $userRepository,
		SupplierRepository $supplierRepository,
		SupplierQuery $supplierQuery,
		UserQuery $userQuery,
		GeoLocation $geoLocation
	){
		$this->projectRepository = $projectRepository;
		$this->userQuery = $userQuery;
		$this->userRepository = $userRepository;
		$this->supplierRepository = $supplierRepository;
		$this->supplierQuery = $supplierQuery;
		$this->geoLocation = $geoLocation;
	}
    

    public function createProject(
		string $token,
		string $name,
		string  $description,
		int $expectedPrice,
		int $categoryId,
		string $streetName,
		string $cityName,
		string $countryName,
		string $postalCode,
		int $allowedArea
	){
		if($token === null){
			return ICreateProjectResult::UNAUTHORIZED;
		}		
		$user = $this->userRepository->find($this->userQuery->withTokenCond($token));
		if($user === null){
			return ICreateProjectResult::UNAUTHORIZED;
		}

		$location = $this->createLocationFromData(
			$streetName,
			$cityName,
			$countryName,
			$postalCode
		);
		$supplierQuery = $this->supplierQuery->withPointAreaCond($location->getLat(), $location->getLng(), $allowedArea);

		if(!$this->supplierRepository->find($supplierQuery)){
			return ICreateProjectResult::UNAVAILABLE_SUPPLIER;
		}

		return $this->projectRepository->save(
			new Project(
				$name, 
				$description, 
				$this->createLocationFromData(
					$streetName,
					$cityName,
					$countryName,
					$postalCode
				),
				$expectedPrice,
				$allowedArea,
				$categoryId,
				$user->getId()
			)
		) ? ICreateProjectResult::SUCCESS : ICreateProjectResult::ERROR;
	}
	
	private function createLocationFromData(
		string $streetName,
		string $cityName,
		string $countryName,
		string $postalCode
	): Location {
		[$lat, $lng] = $this->geoLocation->getCoordinates(
			$cityName, 
			$streetName, 
			$postalCode, 
			$countryName,
		);

		return new Location(
			$cityName, 
			$streetName, 
			$postalCode, 
			$countryName,
			$lat, 
			$lng
		);
	}	
}    
