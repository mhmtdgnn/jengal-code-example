<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getTowns(Request $request)
    {
        $towns = Town::select('id', 'name AS text')
            ->where('city_id', $request->city_id)
            ->get();

        return $towns;
    }
}
