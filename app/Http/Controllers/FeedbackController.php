<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\DataLayer\FeedbackDataLayer;
use App\Http\Requests\StoreFeedbackRequest;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    protected $dl;

    public function __construct(FeedbackDataLayer $dl)
    {
        $this->dl = $dl;
    }

    public function store(StoreFeedbackRequest $request)
    {
        try {
            $payload = $request->validated();

            // Attach user_id if authenticated
            $userId = auth('api')->check() ? auth('api')->id() : null;
            if ($userId) {
                $payload['user_id'] = $userId;
            }

            $record = $this->dl->insert($payload);

            return response()->json([
                'message' => 'Feedback submitted',
                'feedback' => $record,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Feedback store failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to submit feedback'], 500);
        }
    }

    // (Optional) For admins
    public function index()
    {
        try {
            return response()->json($this->dl->getAll());
        } catch (\Throwable $e) {
            Log::error('Feedback index failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch feedback'], 500);
        }
    }
}
