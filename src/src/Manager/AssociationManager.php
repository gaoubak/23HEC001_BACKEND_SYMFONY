<?php

namespace App\Manager;

use App\Entity\Association;
use Doctrine\ORM\EntityManagerInterface;

class AssociationManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function removeAssociation(Association $association): void
    {
        // Remove an association
        $this->entityManager->remove($association);
        $this->entityManager->flush();
    }

    public function save($entity): void
    {
        if ($entity instanceof Association) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
