<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\Package\StorePackageRequest;
use App\Http\Requests\Package\UpdatePackageRequest;
use OpenApi\Attributes as OA;


class PackageController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */

    #[OA\Get(
        path: '/api/v1/packages',
        security: [['sanctum' => []]],
        summary: 'List packages',
        tags: ['Package'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/PaginationPage'),
            new OA\Parameter(ref: '#/components/parameters/PaginationLimit'),
            new OA\Parameter(ref: '#/components/parameters/SearchQuery')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of packages',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resources retrieved successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                    new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Paket Luxury R1 description'),
                                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                ]
                            )
                        ),
                        new OA\Property(
                            property: 'meta',
                            ref: '#/components/schemas/PaginationMeta'
                        ),
                        new OA\Property(
                            property: 'links',
                            ref: '#/components/schemas/PaginationLinks'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $search = $request->query('search');

        $packages = Package::search($search)
            ->paginate($limit);
        return $this->successPaginate($packages);
    }

    /**
     * Store a newly created resource in storage.
     */

    #[OA\Post(
        path: '/api/v1/packages',
        security: [['sanctum' => []]],
        summary: 'Create a package',
        tags: ['Package'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description', 'is_active'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                    new OA\Property(property: 'description', type: 'string', example: 'Product Luxury R1 description'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Package created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'code', type: 'string', example: 'PRG-00000001'),
                                new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                new OA\Property(property: 'description', type: 'string', example: 'Product Luxury R1 description'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
                    ]
                )
            )
        ]
    )]
    public function store(StorePackageRequest $request)
    {
        $validated = $request->validated();

        $lastPackage = Package::orderBy('code', 'desc')->first();
        $nextCode = $this->incrementCode($lastPackage?->code ?? 'PKG-00000000');

        $package = Package::create(array_merge($validated, [
            'code' => $nextCode
        ]));

        return $this->created($package);
    }

    /**
     * Display the specified resource.
     */

    #[OA\Get(
        path: '/api/v1/packages/{id}',
        security: [['sanctum' => []]],
        summary: 'Get a package by id',
        tags: ['Package'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Package retrieved',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource retrieved successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                new OA\Property(property: 'description', type: 'string', example: 'Paket Luxury R1 description'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Data not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Data not found'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
                    ]
                )
            )
        ]
    )]
    public function show(Package $package)
    {
        return $this->success($package);
    }

    /**
     * Update the specified resource in storage.
     */

    #[OA\Put(
        path: '/api/v1/packages/{id}',
        security: [['sanctum' => []]],
        summary: 'Update a package category',
        tags: ['Package'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description', 'is_active'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                    new OA\Property(property: 'description', type: 'string', example: 'Product Luxury R1 description'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Package updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                new OA\Property(property: 'description', type: 'string', example: 'Product Luxury R1 description'),
                                new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Data not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Data not found'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
                    ]
                )
            ),
        ]
    )]
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $validated = $request->validated();

        $package->update($validated);

        return $this->successUpdated($package);
    }

    /**
     * Remove the specified resource from storage.
     */

    #[OA\Delete(
        path: '/api/v1/packages/{id}',
        security: [['sanctum' => []]],
        summary: 'Delete a package category',
        tags: ['Package'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Package deleted',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource deleted successfully'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Data not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Data not found'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
                    ]
                )
            ),
        ]
    )]
    public function destroy(Package $package)
    {
        $package->delete();
        return $this->successDeleted();
    }

    protected function incrementCode(string $lastCode, string $prefix = 'PKG', int $pad = 8)
    {
        $number = (int) str_replace($prefix . '-', '', $lastCode);

        $nextCode = $number + 1;

        return $prefix . '-' . str_pad($nextCode, $pad, '0', STR_PAD_LEFT);
    }
}
