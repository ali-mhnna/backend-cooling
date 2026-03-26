<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    // عرض كل الطلبات
    public function index(): JsonResponse
    {
        $requests = ConsultationRequest::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $requests,
            'total' => $requests->count()
        ]);
    }

    // عرض طلب واحد
    public function show($id): JsonResponse
    {
        $request = ConsultationRequest::find($id);

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $request
        ]);
    }

    // حذف طلب
    public function destroy($id): JsonResponse
    {
        $request = ConsultationRequest::find($id);

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $request->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطلب بنجاح'
        ]);
    }
}