<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class LoginProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // En la práctica, el firewall de Symfony interceptará la petición 
        // antes de llegar aquí. Este processor es principalmente para 
        // que API Platform valide el recurso en la documentación.
        return $data;
    }
}