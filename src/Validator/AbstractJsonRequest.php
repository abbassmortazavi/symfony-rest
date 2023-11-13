<?php

namespace App\Validator;


use Jawira\CaseConverter\Convert;
use ReflectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractJsonRequest
{
    /**
     * @throws ReflectionException
     */
    public function __construct(protected ValidatorInterface $validator, protected RequestStack $requestStack)
    {
        $this->populate();
        $this->validate();
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @throws ReflectionException
     */
    public function populate(): void
    {
        $request = $this->getRequest();

        $reflection = new \ReflectionClass($this);

        foreach ($request->request as $key => $value) {
            $attribute = self::camelcase($key);
            if (property_exists($this, $attribute)) {
                $reflectionProperty = $reflection->getProperty($attribute);
                $reflectionProperty->setValue($this, $value);
            }
        }
    }

    /**
     * @return void
     */
    protected function validate(): void
    {
        $validations = $this->validator->validate($this);

        if (count($validations) < 1) {
            return;
        }

        $errors = [];
        /** @var ConstraintViolation $attribute */
        foreach ($validations as $validation) {
            $attribute = self::snackCase($validation->getPropertyPath());
            $errors[] = [
                'property' => $attribute,
                'value' => $validation->getInvalidValue(),
                'message' => $validation->getMessage()
            ];
        }
        $response = new JsonResponse(['errors' => $errors], 422);
        $response->send();
        exit();
    }

    /**
     * @param string $attribute
     * @return string
     */
    private static function camelcase(string $attribute): string
    {
        return (new Convert($attribute))->toCamel();
    }

    /**
     * @param string $attribute
     * @return string
     */
    private static function snackCase(string $attribute): string
    {
        return (new Convert($attribute))->toSnake();
    }

}