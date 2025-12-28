<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Respon sukses standar (200)
     */
    public function success($data = null, string $message = 'Resource retrieved successfully', int $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Respon sukses untuk pembuatan data (201)
     */
    public function created($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Respon sukses dengan paginasi
     */
    public function paginate(LengthAwarePaginator $paginator, string $message = 'Resources retrieved successfully'): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $paginator->items(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ], 200);
    }

    /**
     * Respon error umum
     */
    public function error(string $message = 'An error occurred', int $code = 400, $errors = null): JsonResponse
    {
        $response = [
            'status'  => 'error',
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Respon error validasi (422)
     * Biasanya digunakan saat $request->validate() gagal
     */
    public function validationError($errors, string $message = 'Validation errors'): JsonResponse
    {
        return $this->error($message, 422, $errors);
    }

    /**
     * Respon Not Found (404)
     */
    public function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->error($message, 404);
    }

    /**
     * Respon Unauthorized (401)
     */
    public function unauthorized(string $message = 'Unauthorized access'): JsonResponse
    {
        return $this->error($message, 401);
    }

    /**
     * Respon Forbidden (403)
     */
    public function forbidden(string $message = 'Forbidden access'): JsonResponse
    {
        return $this->error($message, 403);
    }
}