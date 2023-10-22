<?php 

namespace App\Manager;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;

class MessageManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function removeMessage(Message $message): void
    {
        // Remove a message
        $this->entityManager->remove($message);
        $this->entityManager->flush();
    }

    public function save($entity): void
    {
        if ($entity instanceof Message) {
            $this->entityManager->persist($entity);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
