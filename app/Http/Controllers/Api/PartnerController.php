<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Partner;
use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Models\PartnerType;
use OpenApi\Attributes as OA;

class PartnerController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/partners',
        security: [['sanctum' => []]],
        summary: 'List partners',
        tags: ['Partner'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of partners',
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
                                    new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                                    new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                                    new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                                    new OA\Property(property: 'active', type: 'boolean', example: true),
                                    new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(
                                        property: 'partner_type',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'name', type: 'string', example: 'Supplier'),
                                        ]
                                    ),
                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
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
        $partners = Partner::with('partnerType')->get();
        return $this->success($partners);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/api/v1/partners',
        security: [['sanctum' => []]],
        summary: 'Create a partner',
        tags: ['Partner'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                    new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                    new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                    new OA\Property(property: 'active', type: 'boolean', example: true),
                    new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Partner created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                                new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                                new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                                new OA\Property(property: 'active', type: 'boolean', example: true),
                                new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(
                                    property: 'partner_type',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Supplier'),
                                    ]
                                ),
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
    public function store(StorePartnerRequest $request)
    {
        $validated = $request->validated();
        PartnerType::findOrFail($validated['partner_type_id']);

        $partner = Partner::create($validated);
        $partner->load('partnerType');
        return $this->created($partner);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/api/v1/partners/{id}',
        security: [['sanctum' => []]],
        summary: 'Get a partner by id',
        tags: ['Partner'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Partner retrieved',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource retrieved successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                                new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                                new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                                new OA\Property(property: 'active', type: 'boolean', example: true),
                                new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(
                                    property: 'partner_type',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Supplier'),
                                    ]
                                ),
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
    public function show(string $id)
    {
        $partner = Partner::with('partnerType')->findOrFail($id);
        return $this->success($partner);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/api/v1/partners/{id}',
        security: [['sanctum' => []]],
        summary: 'Update a partner',
        tags: ['Partner'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                    new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                    new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                    new OA\Property(property: 'active', type: 'boolean', example: true),
                    new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Partner updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'name', type: 'string', example: 'PT Acme'),
                                new OA\Property(property: 'phone', type: 'string', example: '+628123456789'),
                                new OA\Property(property: 'address', type: 'string', example: 'Jl. Mawar No.1'),
                                new OA\Property(property: 'active', type: 'boolean', example: true),
                                new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(
                                    property: 'partner_type',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Supplier'),
                                    ]
                                ),
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
    public function update(UpdatePartnerRequest $request, string $id)
    {
        $validated = $request->validated();
        $partner = Partner::findOrFail($id);

        $partner->update($validated);
        $partner->load('partnerType');
        return $this->successUpdated($partner);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/api/v1/partners/{id}',
        security: [['sanctum' => []]],
        summary: 'Delete a partner',
        tags: ['Partner'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Partner deleted',
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
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return $this->successDeleted();
    }
}
