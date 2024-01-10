<?php 

namespace App\Service;

use App\Entity\Follower;
use App\Entity\Chanel;
use App\Entity\User;
use App\Entity\Association;
use Doctrine\ORM\EntityManagerInterface;

class FollowerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createFollowerWithChanel(Follower $follower): Follower
    {
        $chanel = $this->createChanel();
        
        $follower->setChannel($chanel);

        $this->entityManager->persist($chanel);
        $this->entityManager->persist($follower);
        $this->entityManager->flush();

        $this->createAssociationsForChannelMembers($follower, $chanel);

        return $follower;
    }

    public function createFollowerWithoutChanel($users,Chanel $chanel)
    {        
        $this->createAssociationsForAddChannelMembers($chanel, $users);

    }


    private function createChanel(): Chanel
    {
        $chanel = new Chanel();
        $chanel->setNom("Follower");
        $this->entityManager->persist($chanel);

        return $chanel;
    }

    private function createAssociationsForAddChannelMembers(Chanel $chanel, array $users): void
    {
        foreach ($users as $user) {
            // Ensure that $user is not null
            if ($user instanceof User) {
                // Create associations for the user
                $userAssociation = new Association();
                $userAssociation->setUser($user);
                $userAssociation->setChanel($chanel);
                $this->entityManager->persist($userAssociation);
            }
        }

        // Flush the associations
        $this->entityManager->flush();
    }


    private function createAssociationsForChannelMembers(Follower $follower, Chanel $chanel): void
    {
        $user = $follower->getUser();
        $followerUser = $follower->getFollower();

        // Ensure that $user and $followerUser are not null
        if ($user && $followerUser) {
            // Create associations for the user
            $userAssociation = new Association();
            $userAssociation->setUser($user);
            $userAssociation->setChanel($chanel);
            $this->entityManager->persist($userAssociation);

            // Create associations for the follower user
            $followerAssociation = new Association();
            $followerAssociation->setUser($followerUser);
            $followerAssociation->setChanel($chanel);
            $this->entityManager->persist($followerAssociation);

            // Flush the associations
            $this->entityManager->flush();
        }
    }

    
}
