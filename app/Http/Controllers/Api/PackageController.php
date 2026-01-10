<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\Package\StorePackageRequest;
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
                                    new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury 1'),
                                    new OA\Property(property: 'code', type: 'string', example: 'PKG-00000001'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Paket luxury v1'),
                                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                    // new OA\Property(property: 'partner_type_id', type: 'string', example: '845852226109969182'),
                                    // new OA\Property(
                                    //     property: 'partner_type',
                                    //     type: 'object',
                                    //     properties: [
                                    //         new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                    //         new OA\Property(property: 'name', type: 'string', example: 'Supplier'),
                                    //     ]
                                    // ),
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
        $packages = Package::with('packageItems')->get();
        return $this->success($packages);
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
                                new OA\Property(property: 'code', type: 'string', example: 'PRD-00000001'),
                                new OA\Property(property: 'name', type: 'string', example: 'Paket Luxury R1'),
                                new OA\Property(property: 'description', type: 'string', example: 'Product Luxury R1 description'),
                                // new OA\Property(property: 'product_category_id', type: 'string', example: '845852226109969182'),
                                // new OA\Property(property: 'unit_id', type: 'string', example: '845852226109969182'),
                                new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                // new OA\Property(
                                //     property: 'productCategory',
                                //     type: 'object',
                                //     properties: [
                                //         new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                //         new OA\Property(property: 'name', type: 'string', example: 'Electronics'),
                                //         new OA\Property(property: 'description', type: 'string', example: 'Electronics Category'),
                                //         new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                //         new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                //     ]
                                // ),
                                // new OA\Property(
                                //     property: 'unit',
                                //     type: 'object',
                                //     properties: [
                                //         new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                //         new OA\Property(property: 'name', type: 'string', example: 'Box'),
                                //         new OA\Property(property: 'description', type: 'string', example: 'Box unit 1'),
                                //         new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                //         new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                //     ]
                                // ),
                                // new OA\Property(
                                //     property: 'stock',
                                //     type: 'object',
                                //     properties: [
                                //         new OA\Property(property: 'id', type: 'string', example: '845852226109969182'),
                                //         new OA\Property(property: 'product_id', type: 'string', example: '845852226109969182'),
                                //         new OA\Property(property: 'quantity', type: 'integer', example: 0),
                                //         new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z'),
                                //         new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-12-28T10:42:53.000000Z')
                                //     ]
                                // ),

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
    public function show(string $id)
    {
        $package = Package::findOrFail($id);
        $package::load('packageItems');

        return $this->success($package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }

    protected function incrementCode(string $lastCode, string $prefix = 'PKG', int $pad = 8)
    {
        $number = (int) str_replace($prefix . '-', '', $lastCode);

        $nextCode = $number + 1;

        return $prefix . '-' . str_pad($nextCode, $pad, '0', STR_PAD_LEFT);
    }
}
