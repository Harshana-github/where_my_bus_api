<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\UserDataLayer;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

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
}
