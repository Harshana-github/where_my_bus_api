<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\RoleDataLayer;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $roleDL;

    public function __construct(RoleDataLayer $roleDL)
    {
        $this->roleDL = $roleDL;
    }

    public function all()
    {
        try {
            $roleObj = $this->roleDL->getAll();
            return response()->json($roleObj);
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
