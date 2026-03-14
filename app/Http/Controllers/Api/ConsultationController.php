<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultationRequest;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;

class ConsultationController extends Controller
{
    public function store(StoreConsultationRequest $request): JsonResponse
    {
        try {
            $consultation = ConsultationRequest::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب الاستشارة بنجاح',
                'data' => $consultation
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إرسال الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}