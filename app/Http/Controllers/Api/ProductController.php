<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;


class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/products',
        security: [['sanctum' => []]],
        summary: 'List products',
        tags: ['Product'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of products',
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
                                    new OA\Property(property: 'code', type: 'string', example: 'PRD-00000001'),
                                    new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                                    new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(
                                        property: 'productCategory',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                                            new OA\Property(property: 'description', type: 'string', example: 'Electronics Category'),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'unit',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'name', type: 'string', example: 'Box'),
                                            new OA\Property(property: 'description', type: 'string', example: 'Box unit 1'),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'stock',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                            new OA\Property(property: 'quantity', type: 'integer', example: 0),
                                            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
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
        $products = Product::with('productCategory', 'unit', 'stock')->get();

        return $this->success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/api/v1/products',
        security: [['sanctum' => []]],
        summary: 'Create a product',
        tags: ['Product'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description', 'product_category_id', 'unit_id'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                    new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                    new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Product created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
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
                                new OA\Property(
                                    property: 'productCategory',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Electronics Category'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'unit',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Box'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Box unit 1'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'stock',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'quantity', type: 'integer', example: 0),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
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
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product =  DB::transaction(function () use ($validated) {
            $lastProduct = Product::orderBy('code', 'desc')
                ->lockForUpdate()
                ->first();
            $lastCode = $lastProduct?->code ?? 'PRD-00000000';
            $nextCode = $this->incrementCode($lastCode);

            $dataReq = array_merge($validated, ['code' => $nextCode]);
            $product = Product::create($dataReq);

            $product->stock()->create(['quantity' => 0]);
            return $product;
        });
        $product->load(['productCategory', 'unit', 'stock']);
        return  $this->created($product);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/api/v1/products/{id}',
        security: [['sanctum' => []]],
        summary: 'Get a product by id',
        tags: ['Product'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Product retrieved',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource retrieved successfully'),
                        new OA\Property(
                            property: 'data',
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
                                new OA\Property(
                                    property: 'productCategory',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Electronics Category'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'unit',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Box'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Box unit 1'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'stock',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'quantity', type: 'integer', example: 0),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
                                    ]
                                )
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
        $product = Product::findOrFail($id);
        $product->load(['productCategory', 'unit', 'stock']);
        return $this->success($product);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/api/v1/products/{id}',
        security: [['sanctum' => []]],
        summary: 'Update a product',
        tags: ['Product'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description', 'product_category_id', 'unit_id'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Product A'),
                    new OA\Property(property: 'description', type: 'string', example: 'Product description'),
                    new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Product updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
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
                                new OA\Property(
                                    property: 'productCategory',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Electronics Category'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'unit',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'name', type: 'string', example: 'Box'),
                                        new OA\Property(property: 'description', type: 'string', example: 'Box unit 1'),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'stock',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                        new OA\Property(property: 'quantity', type: 'integer', example: 0),
                                        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
                                    ]
                                )
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
    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($id);
        $product->update($validated);

        $product->load(['productCategory', 'unit', 'stock']);

        return $this->successUpdated($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/api/v1/products/{id}',
        security: [['sanctum' => []]],
        summary: 'Delete a product',
        tags: ['Product'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Product deleted',
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
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->successDeleted();
    }

    protected function incrementCode(string $lastCode, string $prefix = 'PRD', int $pad = 8): string
    {
        // Ambil angka di belakang
        $number = (int) str_replace($prefix . '-', '', $lastCode);

        // Increment
        $nextNumber = $number + 1;

        // Gabungkan kembali
        return $prefix . '-' . str_pad($nextNumber, $pad, '0', STR_PAD_LEFT);
    }
}
