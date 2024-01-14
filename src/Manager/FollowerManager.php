<?php 

namespace App\Manager;

use App\Entity\Follower;
use App\Entity\User;
use App\Repository\FollowerRepository;
use Doctrine\ORM\EntityManagerInterface;

class FollowerManager
{
    private $entityManager;
    private $followerRepository;

    public function __construct(EntityManagerInterface $entityManager, FollowerRepository $followerRepository)
    {
        $this->entityManager = $entityManager;
        $this->followerRepository = $followerRepository;
    }

    public function removeFollower(Follower $follower): void
    {
        // Remove a follower
        $this->entityManager->remove($follower);
        $this->entityManager->flush();
    }

    public function save($entity): void
    {
        if ($entity instanceof Follower) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function findFollowerByUserAndFollowerId(User $user, User $followerId): ?Follower
    {
        return $this->followerRepository->findFollowerByUserAndFollowerId($user, $followerId);
    }
}
