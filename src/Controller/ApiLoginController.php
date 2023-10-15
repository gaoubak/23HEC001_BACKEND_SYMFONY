<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;



class ApiLoginController extends AbstractController
{
    private $tokenGenerator;
    private $entityManager;

    public function __construct(TokenGenerator $tokenGenerator, EntityManagerInterface $entityManager)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/login', name: 'app_api_login')]
    public function apiLogin(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return new JsonResponse(['message' => 'Missing credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = $this->tokenGenerator->generateToken($user);

        return new JsonResponse([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

    #[Route('/api/logout', name: 'app_api_logout')]
    public function apiLogout(): void
    {
        throw new \Exception('Should not be reached');
    }

    #[Route('/inscription', name: 'app_registration', methods: ['POST'])]
    public function registration(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPassword($data['password']);
   

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return new JsonResponse(['message' => 'User registered successfully'], JsonResponse::HTTP_CREATED);
        
    }
}
