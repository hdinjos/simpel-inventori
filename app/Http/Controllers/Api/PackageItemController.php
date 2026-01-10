<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\PackageItem;
use App\Http\Requests\PackageItem\StorePackageItemRequest;
use App\Http\Requests\PackageItem\UpdatePackageItemRequest;
use OpenApi\Attributes as OA;


class PackageItemController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */


    #[OA\Get(
        path: '/api/v1/package-items',
        security: [['sanctum' => []]],
        summary: 'List package items',
        tags: ['Package Item'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of package items',
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
                                    new OA\Property(property: 'quantity', type: 'boolean', example: 8),
                                    new OA\Property(property: 'package_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(
                                        property: 'package',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                            new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                            new OA\Property(property: 'description', type: 'string', example: 'Paket Luxury R1 description'),
                                            new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'product',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'code', type: 'string', example: 'PRD-00000001'),
                                            new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                                            new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                                            new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        ]
                                    ),
                                ]
                            )
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
    public function index()
    {
        $packageItems = PackageItem::with('package', 'product')->get();
        return $this->success($packageItems);
    }

    /**
     * Store a newly created resource in storage.
     */

    #[OA\Post(
        path: '/api/v1/package-items',
        security: [['sanctum' => []]],
        summary: 'Create a package items',
        tags: ['Package Item'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['quantity', 'package_id', 'product_id'],
                properties: [
                    new OA\Property(property: 'quantity', type: 'integer', example: 5),
                    new OA\Property(property: 'package_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Package Item created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'quantity', type: 'boolean', example: 8),
                                new OA\Property(property: 'package_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(
                                    property: 'package',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                        new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Paket Luxury R1 description'),
                                        new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'product',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'code', type: 'string', example: 'PRD-00000001'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                                        new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
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
    public function store(StorePackageItemRequest $request)
    {
        $validated = $request->validated();
        $packageItem = PackageItem::create($validated);
        $packageItem->load(['package', 'product']);

        return $this->created($packageItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/api/v1/package-items/{id}',
        security: [['sanctum' => []]],
        summary: 'Update a package item',
        tags: ['Package Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['quantity', 'product_id'],
                properties: [
                    new OA\Property(property: 'quantity', type: 'integer', example: 5),
                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Package Item updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'quantity', type: 'boolean', example: 4),
                                new OA\Property(property: 'package_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(
                                    property: 'package',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                        new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Paket Luxury R1 description'),
                                        new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'product',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'code', type: 'string', example: 'PRD-00000001'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                                        new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
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
    public function update(UpdatePackageItemRequest $request, string $id)
    {
        $validated = $request->validated();
        $packageItem =  PackageItem::findOrFail($id);
        $packageItem->update($validated);
        $packageItem->load(['package', 'product']);

        return $this->successUpdated($packageItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/api/v1/package-items/{id}',
        security: [['sanctum' => []]],
        summary: 'Delete a package item',
        tags: ['Package Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'package item deleted',
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
            )
        ]
    )]
    public function destroy(string $id)
    {
        $packageItem = PackageItem::findOrFail($id);

        $packageItem->delete();
        return $this->successDeleted();
    }
}
