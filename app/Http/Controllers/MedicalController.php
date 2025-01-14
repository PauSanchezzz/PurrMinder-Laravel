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
        $support = null;

        if ($request->hasFile('supportMedicalProcedure')) {
            $file = $request->file('supportMedicalProcedure');
            $support = Str::random(32) . "." . $file->getClientOriginalExtension();
        }

        $validator = Validator::make($request->all(), [
            'dateMedicalProcedure' => 'required|date',
            'CostMedicalProcedure' => 'required',
            'commentsMedicalProcedure' => 'nullable|string',
            'cat_id' => 'required|integer',
            'typeMedicalProcedure_id' => 'required|integer',
            'supportMedicalProcedure' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalProcedureData = $validator->validated();

        if ($support) {
            $medicalProcedureData['supportMedicalProcedure'] = $support;

            Storage::disk('public')->put($support, file_get_contents($file));
        }

        MedicalProcedure::create($medicalProcedureData);

        return response()->json([
            'message' => 'Successfully registered',
            'status' => 201,
        ], 201);
    }
    public function medicalList(){

        $medicalProcedures = MedicalProcedure::join('cats', 'cats.id', '=', 'medicalProcedure.cat_id')
            ->join('typeMedicalProcedure', 'typeMedicalProcedure.idTypeMedicalProcedure', '=', 'medicalProcedure.typeMedicalProcedure_id')
            ->select(
                'medicalProcedure.id',
                'medicalProcedure.dateMedicalProcedure',
                'medicalProcedure.CostMedicalProcedure',
                'medicalProcedure.commentsMedicalProcedure',
                'medicalProcedure.supportMedicalProcedure',
                'cats.nameCat',
                'cats.imageCat',
                'typeMedicalProcedure.typeMedicalProcedure'
            )
            ->orderBy('medicalProcedure.updated_at', 'desc')
            ->get();

        return response()->json(['data' => $medicalProcedures], 200);
    }

    public function updateMedicalRegister(Request $request, $id)
    {
        $support = $request->hasFile('supportMedicalProcedure')
            ? Str::random(32) . "." . $request->supportMedicalProcedure->getClientOriginalExtension()
            : null;

        $validator = Validator::make($request->all(), [
            'dateMedicalProcedure' => 'sometimes|date',
            'CostMedicalProcedure' => 'sometimes',
            'commentsMedicalProcedure' => 'nullable',
            'supportMedicalProcedure' => 'nullable|file',
            'cat_id' => 'sometimes',
            'typeMedicalProcedure_id' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $medicalProcedure = MedicalProcedure::find($id);

        if (!$medicalProcedure) {
            return response()->json([
                'message' => 'Medical procedure record not found',
                'status' => 404
            ], 404);
        }

        $updateData = $validator->validated();

        if ($support) {
            Storage::disk('public')->put($support, file_get_contents($request->supportMedicalProcedure));
            $updateData['supportMedicalProcedure'] = $support;
        }

        $medicalProcedure->update($updateData);

        return response()->json([
            'message' => 'Successfully updated',
            'status' => 200
        ], 200);
    }
    public function medicalById($id){

        $medicalProcedures = MedicalProcedure::select(
            'medicalProcedure.id',
            'medicalProcedure.dateMedicalProcedure',
            'medicalProcedure.CostMedicalProcedure',
            'medicalProcedure.commentsMedicalProcedure',
            'medicalProcedure.supportMedicalProcedure',
            'medicalProcedure.cat_id',
            'cats.nameCat',
            'cats.imageCat',
            'medicalProcedure.typeMedicalProcedure_id',
            'typeMedicalProcedure.typeMedicalProcedure'
        )
            ->join('cats', 'cats.id', '=', 'medicalProcedure.cat_id')
            ->join('typeMedicalProcedure', 'typeMedicalProcedure.idTypeMedicalProcedure', '=', 'medicalProcedure.typeMedicalProcedure_id')
            ->where('medicalProcedure.id', $id)->first();

        return response()->json(['data' => $medicalProcedures], 200);
    }
}
