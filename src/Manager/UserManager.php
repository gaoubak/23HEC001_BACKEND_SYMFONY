<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\ImageManagerStatic as Image;
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

    public function processAndSaveImages($uploadedImage): array
    {
        // Prepare filenames and paths
        $originalFilename = pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME);
        $webpPath = '/public/upload/' . $originalFilename . '.webp';
        $jpgPath = '/public/upload/' . $originalFilename . '.jpg';

        // Intervention Image conversion to webp
        $image = Image::make($uploadedImage);
        $image->save($webpPath, 75, 'webp');

        // Intervention Image conversion to jpg
        $image->save($jpgPath, 75, 'jpg');

        // Return URLs or paths as an associative array
        return [
            'webp' => $webpPath,
            'jpg' => $jpgPath,
        ];
    }
}
