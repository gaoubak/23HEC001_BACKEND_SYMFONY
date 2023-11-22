<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait FormHandlerTrait {

    private function handleForm(Request $request, FormInterface $form, ?array $removableTranslations = []): void {
    	
        $data = json_decode($request->getContent(), true);
        if(count($removableTranslations) > 0) { // we need to remove translatable parameters, who will be handled outside of the edit action
            foreach($removableTranslations as $fieldName => $fieldValue) {
                if(gettype($fieldValue) == "string") { // simple case
                    unset($data[$fieldName]);
                } else if(gettype($fieldValue) == "array") { // nested case (2 dimensions max)
                    foreach($fieldValue as $nestedKey => $nestedElement) {
                        foreach($nestedElement as $subFieldName => $subFieldValue) {
                            unset($data[$fieldName][$nestedKey][$subFieldName]);
                        }
                    }
                }
            }
        }
        $clearMissing = 'PATCH' !== $request->getMethod();
        $form->submit($data, $clearMissing);
    }
}