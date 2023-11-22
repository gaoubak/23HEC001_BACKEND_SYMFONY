<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    /**
     * @param string|array $data
     */
    private function createApiResponse($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view((array) $data, $statusCode));
    }

    public function renderCreatedResponse(string $message = 'Resource created successfully', $statusCode = Response::HTTP_CREATED): Response
    {
        return $this->createApiResponse($message, $statusCode);
    }

    public function renderUpdatedResponse(string $message = 'Resource updated successfully', $statusCode = Response::HTTP_OK): Response
    {
        return $this->createApiResponse($message, $statusCode);
    }

    public function renderDeletedResponse(string $message = 'Resource deleted successfully', $statusCode = Response::HTTP_OK): Response
    {
        return $this->createApiResponse($message, $statusCode);
    }
}