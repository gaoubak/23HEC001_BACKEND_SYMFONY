<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, Security $security, AuthenticationUtils $authenticationUtils): JsonResponse
    {
        // Check if the user is already authenticated
        if ($security->getUser()) {
            return new JsonResponse(['message' => 'User is already authenticated.'], 200);
        }

        // Retrieve login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            return new JsonResponse(['message' => 'Authentication failed.'], 401);
        }

        // Success: return a JSON response
        return new JsonResponse(['message' => 'Authentication successful.'], 200);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
