<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class StockOpnameController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/api/v1/stock-opname',
        security: [['sanctum' => []]],
        summary: 'List stock opname',
        tags: ['Stock Opname'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/PaginationPage'),
            new OA\Parameter(ref: '#/components/parameters/PaginationLimit'),
            // new OA\Parameter(ref: '#/components/parameters/SearchQuery')
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of product categories',
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
                                    new OA\Property(property: 'user_id', type: 'string', example: '850511022740609603'),
                                    new OA\Property(property: 'note', type: 'string', example: 'stock opname for janary'),
                                    new OA\Property(property: 'status', type: 'string', example: 'pending'),
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
            ),
        ]
    )]
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $stockOpnames = StockOpname::paginate($limit);
        return $this->successPaginate($stockOpnames);
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
    public function show(StockOpname $stockOpname)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockOpname $stockOpname)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOpname $stockOpname)
    {
        //
    }
}
