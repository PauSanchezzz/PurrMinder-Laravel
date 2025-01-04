<?php

namespace App\Http\Controllers;

use App\Models\Death;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DeathController extends Controller
{
    public function deathRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dateOfDeath' => 'required|date',
            'associatedCosts' => 'required',
            'comments' => '',
            'cat_id' => 'required',
            'reasonOfDeath_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        Death::create(array_merge(
            $validator->validated()
        ));

        return response()->json([
            'message' => 'Successfully registered',
            'status' => 201
        ], 201);
    }
}
