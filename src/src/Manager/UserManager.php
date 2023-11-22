<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    private $entityManager;
    private $userPasswordHasher;  
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;  
    }

    public function removeUser(User $user): void
    {
        // Remove a user
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function save($entity): void {

        if($entity instanceof User) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void {
        $this->entityManager->flush();
    }
}
