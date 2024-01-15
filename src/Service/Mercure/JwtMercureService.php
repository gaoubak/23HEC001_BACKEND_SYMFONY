<?php

namespace App\Service\Mercure;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class JwtMercureService
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function createJwt(): string
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->secret)
        );

        $token = $configuration->builder()
            ->issuedBy('localhost')
            ->permittedFor('localhost:9090')
            ->identifiedBy(bin2hex(random_bytes(16)), true)
            ->issuedAt(new \DateTimeImmutable())
            ->canOnlyBeUsedAfter(new \DateTimeImmutable())
            ->expiresAt(new \DateTimeImmutable('+24 hour'))
            ->withClaim('mercure', [
                'publish' => ['*'],
                'subscribe' => ['*'],
            ])
            ->getToken($configuration->signer(), $configuration->signingKey());

        return $token->toString();
    }
}