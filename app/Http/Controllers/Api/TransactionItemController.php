<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionItem;
use App\Models\Transaction;
use App\Traits\ApiResponse;
use App\Http\Requests\TransactionItem\StoreTransactionItemRequest;
use App\Http\Requests\TransactionItem\UpdateTransactionItemRequest;
use App\Enums\TransactionStatus;
use App\Models\Product;
use OpenApi\Attributes as OA;


class TransactionItemController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/transactions/{id}/items',
        security: [['sanctum' => []]],
        summary: 'List transaction items',
        tags: ['Transaction Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of transaction items',
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
                                    new OA\Property(property: 'product_id', type: 'string', example: '850941977284448529'),
                                    new OA\Property(property: 'tranction_id', type: 'string', example: '850942152736382104'),
                                    new OA\Property(property: 'quantity', type: 'integer', example: 3),
                                    new OA\Property(property: 'source_type', type: 'string', example: null),
                                    new OA\Property(property: 'source_id', type: 'string', example: null),
                                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
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
    public function index(Transaction $transaction)
    {
        $trxItem =  $transaction->items()->with('product')->get();
        return $this->success($trxItem);
    }

    /**
     * Store a newly created resource in storage.
     */

    #[OA\Post(
        path: '/api/v1/transactions/{id}/items',
        security: [['sanctum' => []]],
        summary: 'Create a transaction items',
        tags: ['Transaction Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['product_id', 'quantity'],
                properties: [
                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'quantity', type: 'integer', example: 8),
                    new OA\Property(property: 'source_type', type: 'string', example: 'single'),
                    new OA\Property(property: 'source_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'transaction item created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'product_id', type: 'string', example: '850941977284448529'),
                                new OA\Property(property: 'tranction_id', type: 'string', example: '850942152736382104'),
                                new OA\Property(property: 'quantity', type: 'integer', example: 3),
                                new OA\Property(property: 'source_type', type: 'string', example: null),
                                new OA\Property(property: 'source_id', type: 'string', example: null),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
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
    public function store(StoreTransactionItemRequest $request, Transaction $transaction)
    {
        if ($transaction->status !== TransactionStatus::DRAFT) {
            return $this->conflict('Transaction already finished and cannot be updated');
        }
        Product::findOrFail($request['product_id']);

        $transactionItem = $transaction->items()->create($request->validated());
        $transactionItem->load(['product']);
        return $this->created($transactionItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/api/v1/transactions/{id}/items/{itemId}',
        security: [['sanctum' => []]],
        summary: 'Update a transaction item',
        tags: ['Transaction Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182'),
            new OA\Parameter(name: 'itemId', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['product_id', 'quantity'],
                properties: [
                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'quantity', type: 'integer', example: 8),
                    new OA\Property(property: 'source_type', type: 'string', example: 'single'),
                    new OA\Property(property: 'source_id', type: 'string', example: '845852226109969182'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Transaction item updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'product_id', type: 'string', example: '850941977284448529'),
                                new OA\Property(property: 'tranction_id', type: 'string', example: '850942152736382104'),
                                new OA\Property(property: 'quantity', type: 'integer', example: 3),
                                new OA\Property(property: 'source_type', type: 'string', example: null),
                                new OA\Property(property: 'source_id', type: 'string', example: null),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
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
    public function update(UpdateTransactionItemRequest $request, Transaction $transaction, TransactionItem $item)
    {
        if ($transaction->status !== TransactionStatus::DRAFT) {
            return $this->conflict('Transaction already finished and cannot be updated');
        }
        if ($transaction->id !== $item->transaction_id) {
            return $this->validationError('Item does not belong to this transaction');
        }
        Product::findOrFail($request['product_id']);
        $item->update($request->validated());
        $item->load('product');
        return $this->successUpdated($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/api/v1/transactions/{id}/items/{itemId}',
        security: [['sanctum' => []]],
        summary: 'Delete a product',
        tags: ['Transaction Item'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182'),
            new OA\Parameter(name: 'itemId', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Transaction Item deleted',
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
    public function destroy(Transaction $transaction, TransactionItem $item)
    {
        if ($transaction->status !== TransactionStatus::DRAFT) {
            return $this->conflict('Transaction already finished and cannot be updated');
        }
        if ($transaction->id !== $item->transaction_id) {
            return $this->validationError('Item does not belong to this transaction');
        }
        $item->delete();
        return $this->successDeleted();
    }
}
