<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;

class RequestController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $requests = ConsultationRequest::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $requests
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $request = ConsultationRequest::findOrFail($id);
            $request->delete();

            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}