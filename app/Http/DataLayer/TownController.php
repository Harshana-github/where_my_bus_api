<?php

namespace App\Http\DataLayer;

use App\Models\Town;

class TownDataLayer
{
    public function getAll()
    {
        return Town::with('routes')->orderBy('id')->get();
    }

    public function insert(array $data)
    {
        return Town::create($data);
    }

    public function find($id)
    {
        return Town::with('routes')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $town = Town::findOrFail($id);
        $town->update($data);
        return $town;
    }

    public function delete($id)
    {
        return Town::destroy($id);
    }
}
