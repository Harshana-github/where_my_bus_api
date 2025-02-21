<?php

namespace App\Http\DataLayer;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthDataLayer
{
    public function insert($request)
    {
        try {
            $dataObj = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            return $dataObj;
        } catch (QueryException $ex) {
            Log::error('Error creating user: ' . $ex->getMessage());
            throw $ex;
        }
    }
}
