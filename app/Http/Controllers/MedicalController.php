<?php

namespace App\Http\Controllers;

use App\Models\MedicalProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MedicalController extends Controller
{
    public function medicalRegister(Request $request)
    {
        $support = Str::random(32) . "." . $request->supportMedicalProcedure->getClientOriginalExtension();

        $validator = Validator::make($request->all(), [
            'dateMedicalProcedure' => 'required|date',
            'CostMedicalProcedure' => 'required',
            'commentsMedicalProcedure' => '',
            //'supportMedicalProcedure' => '',
            'cat_id' => 'required',
            'typeMedicalProcedure_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        MedicalProcedure::create(array_merge(
            $validator->validated(),
            ['supportMedicalProcedure' => $support]
        ));

        Storage::disk('public')->put($support, file_get_contents($request->supportMedicalProcedure));

        return response()->json([
            'message' => 'Successfully registered',
            'status' => 201
        ], 201);
    }
}
