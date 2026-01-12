<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
  schema: 'PaginationMeta',
  type: 'object',
  properties: [
    new OA\Property(property: 'current_page', type: 'integer', example: 1),
    new OA\Property(property: 'last_page', type: 'integer', example: 3),
    new OA\Property(property: 'per_page', type: 'integer', example: 10),
    new OA\Property(property: 'total', type: 'integer', example: 25),
  ]
)]
#[OA\Schema(
  schema: 'PaginationLinks',
  type: 'object',
  properties: [
    new OA\Property(property: 'first', type: 'string', nullable: true, example: 'http://localhost/api/v1/resources?page=1'),
    new OA\Property(property: 'last', type: 'string', nullable: true, example: 'http://localhost/api/v1/resources?page=10'),
    new OA\Property(property: 'prev', type: 'string', nullable: true, example: null),
    new OA\Property(property: 'next', type: 'string', nullable: true, example: 'http://localhost/api/v1/resources?page=2'),
  ]
)]

class PaginationSchemas
{
  // Class kosong, hanya untuk Swagger scan
}
