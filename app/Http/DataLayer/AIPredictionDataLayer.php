<?php

namespace App\Http\DataLayer;

use App\Models\AIPrediction;

class AIPredictionDataLayer
{
    public function getAll()
    {
        return AIPrediction::with('bus')->get();
    }

    public function find($id)
    {
        return AIPrediction::with('bus')->findOrFail($id);
    }

    public function insert($data)
    {
        return AIPrediction::create($data);
    }

    public function update($id, $data)
    {
        $prediction = AIPrediction::findOrFail($id);
        $prediction->update($data);
        return $prediction;
    }

    public function delete($id)
    {
        AIPrediction::destroy($id);
    }
}
