<?php

namespace App\Http\DataLayer;

use App\Models\User;

class UserDataLayer
{
    public function getAll()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::with('driver.buses.route')->findOrFail($id);
    }

    public function insert($data)
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update($id, $data)
    {
        $user = User::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return true;
    }

}
