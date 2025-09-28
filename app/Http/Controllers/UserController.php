<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\UserDataLayer;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userDL;

    public function __construct(UserDataLayer $userDL)
    {
        $this->userDL = $userDL;
    }
    public function index()
    {
        $users = $this->userDL->getAll();
        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userDL->insert($request->validated());
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = $this->userDL->find($id);
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userDL->update($id, $request->validated());
        return response()->json($user);
    }


    public function destroy($id)
    {
        $this->userDL->delete($id);
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::guard('api')->user();
        if (!$authUser) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // via DataLayer to keep your architecture consistent
            $this->userDL->updateLocationForUserId($authUser->id, [
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            Log::error('Failed to update user location: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update location'], 500);
        }
    }
}
