<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class TransactionItemController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/transaction-items',
        security: [['sanctum' => []]],
        summary: 'List transaction items',
        tags: ['Transaction Item'],
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
                                    new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'quantity', type: 'integer', example: 3),
                                    new OA\Property(property: 'source_type', type: 'string', example: null),
                                    new OA\Property(property: 'source_id', type: 'string', example: null),
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
        $transactionItems = TransactionItem::get();
        return $this->success($transactionItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionItem $transactionItem)
    {
        //
    }
}
