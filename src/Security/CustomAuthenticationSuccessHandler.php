<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Service\Mercure\JwtMercureService;

class CustomAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $jwtMercureService;
    private $jwtTokenManager;

    public function __construct(JwtMercureService $jwtMercureService, JWTTokenManagerInterface $jwtTokenManager)
    {
        $this->jwtMercureService = $jwtMercureService;
        $this->jwtTokenManager = $jwtTokenManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $symfonyJwt = $this->jwtTokenManager->create($token->getUser());

        $mercureJwt = $this->jwtMercureService->createJwt();

        return new JsonResponse([
            'token' => $symfonyJwt,  // Symfony's generated JWT token
            'mercure_token' => $mercureJwt,  // Your Mercure token
        ]);
    }
}
