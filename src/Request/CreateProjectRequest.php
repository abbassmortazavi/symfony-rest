<?php

namespace App\Request;

use App\Validator\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateProjectRequest extends AbstractJsonRequest
{
    #[NotBlank(message: 'I dont like this field empty')]
    #[Type('string')]
    public readonly string $name;

    #[NotBlank(message: 'I dont like this field description')]
    #[Type('string')]
    public readonly string $description;
}