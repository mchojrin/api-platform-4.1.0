<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\State\LoginProcessor;
use ApiPlatform\Metadata\ApiProperty;

#[ApiResource(
    shortName: 'Auth',
    operations: [
        new Post(
            uriTemplate: '/auth',
            openapi: new \ApiPlatform\OpenApi\Model\Operation(
                summary: 'Get a JWT token',
                requestBody: new \ApiPlatform\OpenApi\Model\RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'email' => ['type' => 'string', 'example' => 'admin@example.com'],
                                    'password' => ['type' => 'string', 'example' => 'password']
                                ]
                            ]
                        ]
                    ])
                )
            ),
            processor: LoginProcessor::class
        )
    ]
)]
class Credentials
{
    #[ApiProperty(identifier: true)]
    public string $email;

    public string $password;

    public ?string $token = null;
}
