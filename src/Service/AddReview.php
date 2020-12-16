<?php declare(strict_types=1);

namespace SkillShare\Service;

use SkillShare\Entity\Review;
use SkillShare\QueryObject\ProjectQuery;
use SkillShare\QueryObject\ReviewQuery;
use SkillShare\QueryObject\UserQuery;
use SkillShare\Repository\ProjectRepository;
use SkillShare\Repository\ReviewRepository;
use SkillShare\Repository\UserRepository;

final class AddReview
{

	private ProjectRepository $projectRepository;

	private ProjectQuery $projectQuery;

	private UserRepository $userRepository;

	private UserQuery $userQuery;

	private ReviewRepository $reviewRepository;

	private ReviewQuery $reviewQuery;

	public function __construct(
		ProjectRepository $projectRepository,
		ProjectQuery $projectQuery,
		UserRepository $userRepository,
		UserQuery $userQuery,
		ReviewRepository $reviewRepository,
		ReviewQuery $reviewQuery
	){
		$this->projectRepository = $projectRepository;
		$this->projectQuery = $projectQuery;
		$this->userRepository = $userRepository;
		$this->userQuery = $userQuery;
		$this->reviewRepository = $reviewRepository;
		$this->reviewQuery = $reviewQuery;
	}
    

    public function addReview(string $token, int $projectId, bool $positive, string $content): string
    {

		if($token === null){
			return IAddReviewResult::UNAUTHORIZED;
		}
		$user = $this->userRepository->find($this->userQuery->withTokenCond($token));
		if($user === null){
			return IAddReviewResult::UNAUTHORIZED;
		}
		$project = $this->projectRepository->find($this->projectQuery->withIdCond($projectId));
		if($project === null){
			return IAddReviewResult::ERROR;
		}

		$reviewQuery = $this->reviewQuery->withProjectIdCond($project->getId())->withUserIdCond($user->getId());
		if($this->reviewRepository->find($reviewQuery)){
			return IAddReviewResult::DUPLICATE;
		}

		return $this->reviewRepository->save(
			new Review($user->getId(), $project->getId(), $positive, $content)
		) ?  IAddReviewResult::SUCCESS : IAddReviewResult::ERROR;
    }
}    
