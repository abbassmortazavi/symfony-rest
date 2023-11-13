<?php

namespace App;

trait HandelValidation
{
    public function error($validationErrors)
    {
        if (count($validationErrors) > 0) {
            $errors = [];
            foreach ($validationErrors as $error) {
                $propertyPath = $error->getPropertyPath();
                $message = $error->getMessage();
                $errors[$propertyPath] = $message;
            }
            return $errors;
        }
    }
}