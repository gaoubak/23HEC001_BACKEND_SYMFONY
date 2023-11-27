<?php 

namespace App\Manager;

use App\Entity\Follower;
use Doctrine\ORM\EntityManagerInterface;

class FollowerManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
}
