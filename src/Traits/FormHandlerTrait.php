<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait FormHandlerTrait {

    private function handleForm(Request $request, FormInterface $form, ?array $removableTranslations = []): void {
    	
        $data = json_decode($request->getContent(), true);
        $clearMissing = 'PATCH' !== $request->getMethod();

        $form->submit($data, $clearMissing);
    }
}