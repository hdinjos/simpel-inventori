<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(title: "Simple Inventory", version: "1.0.0")]
#[OA\Server(url: 'http://localhost:8000', description: 'Local Server')]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
#[OA\Parameter(
    parameter: 'PaginationPage',
    name: 'page',
    in: 'query',
    description: 'Page number',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        example: 1,
        minimum: 1
    )
)]
#[OA\Parameter(
    parameter: 'PaginationLimit',
    name: 'limit',
    in: 'query',
    description: 'Number of items per page',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        example: 10,
        minimum: 1
    )
)]
#[OA\Parameter(
    parameter: 'SearchQuery',
    name: 'search',
    in: 'query',
    description: 'Search query string',
    required: false,
    schema: new OA\Schema(
        type: 'string',
        example: '',
        minimum: 1
    )
)]
abstract class Controller
{
    //
}
