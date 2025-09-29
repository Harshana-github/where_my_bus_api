<?php

namespace App\Http\DataLayer;

use App\Models\Feedback;

class FeedbackDataLayer
{
    public function insert(array $data): Feedback
    {
        return Feedback::create($data);
    }

    // (Optional) list feedback, for admin dashboards
    public function getAll()
    {
        return Feedback::with('user')->orderByDesc('id')->get();
    }
}
