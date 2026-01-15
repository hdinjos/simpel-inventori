<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\ApiResponse;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use Carbon\Carbon;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;


class TransactionController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */

    #[OA\Get(
        path: '/api/v1/transactions',
        security: [['sanctum' => []]],
        summary: 'List Transactions',
        tags: ['Transaction'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of transactions',
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
                                    new OA\Property(property: 'identifier', type: 'string', example: 'TRX202601-00000001'),
                                    new OA\Property(property: 'user_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'partner_id', type: 'string', example: '845852226109969182'),
                                    new OA\Property(property: 'note', type: 'string', example: 'Transaksi product in'),
                                    new OA\Property(property: 'type', type: 'string', example: 'in'),
                                    new OA\Property(property: 'status', type: 'string', example: 'draft'),
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
        $transaction = Transaction::get();
        return $this->success($transaction);
    }

    /**
     * Store a newly created resource in storage.
     */

    #[OA\Post(
        path: '/api/v1/transactions',
        security: [['sanctum' => []]],
        summary: 'Create a transaction',
        tags: ['Transaction'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'partner_id', 'type', 'note'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'partner_id', type: 'string', example: '845852226109969182'),
                    new OA\Property(property: 'type', type: 'string', example: 'in'),
                    new OA\Property(property: 'note', type: 'string', example: 'product in'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'transaction created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource created successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'identifier', type: 'string', example: 'TRX202601-00000001'),
                                new OA\Property(property: 'user_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'partner_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'note', type: 'string', example: 'Transaksi product in'),
                                new OA\Property(property: 'type', type: 'string', example: 'in'),
                                new OA\Property(property: 'status', type: 'string', example: 'draft'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
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
    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        $now = Carbon::now();
        $prefix = 'TRX' . $now->format('Ym');

        $lastTransaction = Transaction::where('identifier', 'LIKE', $prefix . '-%')
            ->orderBy('identifier', 'desc')
            ->first();
        $nextIdentifier = $this->generateTrxCode($lastTransaction, $prefix);

        $trx = Transaction::create(array_merge($validated, [
            'identifier' => $nextIdentifier,
            'status' => TransactionStatus::DRAFT->value
        ]));

        return $this->created($trx);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    #[OA\Put(
        path: '/api/v1/transactions/{id}',
        security: [['sanctum' => []]],
        summary: 'Update a transaction',
        tags: ['Transaction'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: '845852226109969182')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Transaction updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Resource updated successfully'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'identifier', type: 'string', example: 'TRX202601-00000001'),
                                new OA\Property(property: 'user_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'partner_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'note', type: 'string', example: 'Transaksi product in'),
                                new OA\Property(property: 'type', type: 'string', example: 'in'),
                                new OA\Property(property: 'status', type: 'string', example: 'finished'),
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
    public function update(Transaction $transaction)
    {
        if ($transaction->status !== TransactionStatus::DRAFT) {
            return $this->conflict('Only draft transactions can be processed.');
        }

        DB::beginTransaction();

        try {
            $items = $transaction->items;

            if ($transaction->type === TransactionType::IN) {

                foreach ($items as $item) {
                    $stock = $item->product->stock()->lockForUpdate()->first();

                    $stock->update([
                        'quantity' => $stock->quantity + $item->quantity
                    ]);
                }
            } elseif ($transaction->type === TransactionType::OUT) {

                foreach ($items as $item) {
                    $stock = $item->product->stock()->lockForUpdate()->first();

                    $qtyAfter = $stock->quantity - $item->quantity;

                    if ($qtyAfter <= 0) {
                        DB::rollBack();
                        return $this->error(
                            'Stok produk "' . $item->product->name . '" tidak mencukupi',
                            422
                        );
                    }

                    $stock->update([
                        'quantity' => $qtyAfter
                    ]);
                }
            } else {
                DB::rollBack();
                return $this->error('Tipe Transaksi not available', 400);
            }

            $transaction->update([
                'status' => TransactionStatus::FINISHED->value
            ]);

            DB::commit();

            return $this->successUpdated($transaction);
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->error(
                'Terjadi kesalahan saat memproses transaksi',
                500,
                $e->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    protected function generateTrxCode($lastTransaction, string $prefix, int $pad = 8)
    {
        if (!$lastTransaction) {
            $nextNumber = 1;
        } else {
            $lastNumber = explode('-', $lastTransaction->identifier[1]);
            $nextNumber = (int) $lastNumber + 1;
        }

        return $prefix . '-' . str_pad($nextNumber, $pad, '0', STR_PAD_LEFT);
    }
}
