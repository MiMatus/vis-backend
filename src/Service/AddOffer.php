<?php declare(strict_types=1);

namespace SkillShare\Service;

use SkillShare\Entity\Offer;
use SkillShare\QueryObject\OfferQuery;
use SkillShare\QueryObject\ProjectQuery;
use SkillShare\QueryObject\SupplierQuery;
use SkillShare\Repository\OfferRepository;
use SkillShare\Repository\ProjectRepository;
use SkillShare\Repository\SupplierRepository;
use DateTime;

final class AddOffer
{

	private ProjectRepository $projectRepository;

	private ProjectQuery $projectQuery;

	private SupplierRepository $supplierRepository;

	private SupplierQuery $supplierQuery;

	private OfferQuery $offerQuery;

	private OfferRepository $offerRepository;

	public function __construct(
		ProjectRepository $projectRepository,
		ProjectQuery $projectQuery,
		SupplierRepository $supplierRepository,
		SupplierQuery $supplierQuery,
		OfferQuery $offerQuery,
		OfferRepository $offerRepository
	){
		$this->projectRepository = $projectRepository;
		$this->projectQuery = $projectQuery;
		$this->supplierRepository = $supplierRepository;
		$this->supplierQuery = $supplierQuery;
		$this->offerQuery = $offerQuery;
		$this->offerRepository = $offerRepository;	
    }
    

    public function addOffer(string $token, int $projectId, int $price, DateTime $completionDate)
    {
		if($token === null){
			return IAddOfferResult::UNAUTHORIZED;
		}
		$supplier = $this->supplierRepository->find($this->supplierQuery->withTokenCond($token));
		if($supplier === null){
			return IAddOfferResult::UNAUTHORIZED;
		}
		$project = $this->projectRepository->find($this->projectQuery->withIdCond($projectId));
		if($project === null){
			return IAddOfferResult::ERROR;
		}
		$acceptedOffer = $this->offerRepository->find($this->offerQuery->withAcceptedCond()->withProjectIdCond($project->getId()));
		if($acceptedOffer !== null){
			return IAddOfferResult::HAS_ACCEPTED_OFFER;
		}
		return $this->offerRepository->save(
			new Offer($project->getId(), $supplier->getId(), $price, $completionDate)
		) ? IAddOfferResult::SUCCESS : IAddOfferResult::ERROR;
    }
}    
