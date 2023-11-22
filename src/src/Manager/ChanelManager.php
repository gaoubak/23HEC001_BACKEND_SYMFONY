<?php 

namespace App\Manager;

use App\Entity\Chanel;
use Doctrine\ORM\EntityManagerInterface;

class ChanelManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function removeChanel(Chanel $chanel): void
    {
        // Remove a chanel
        $this->entityManager->remove($chanel);
        $this->entityManager->flush();
    }

    public function save($entity): void
    {
        if ($entity instanceof Chanel) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
