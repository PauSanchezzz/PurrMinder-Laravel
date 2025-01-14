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

    public function deathList()
    {

        $deaths = Death::join('cats', 'cats.id', '=', 'death.cat_id')
            ->join('reasonOfDeath', 'reasonOfDeath.idReasonOfDeath', '=', 'death.reasonOfDeath_id')
            ->select(
                'death.id',
                'death.dateOfDeath',
                'death.associatedCosts',
                'death.comments',
                'cats.nameCat',
                'cats.imageCat',
                'reasonOfDeath.reasonOfDeath'
            )
            ->orderBy('death.updated_at', 'desc')
            ->get();

        return response()->json(['data' => $deaths], 200);

    }

    public function updateDeathRegister(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dateOfDeath' => 'sometimes|date',
            'associatedCosts' => 'sometimes',
            'comments' => 'nullable',
            'cat_id' => 'sometimes',
            'reasonOfDeath_id' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $death = Death::find($id);

        if (!$death) {
            return response()->json([
                'message' => 'Death record not found',
                'status' => 404
            ], 404);
        }

        $death->update($validator->validated());

        return response()->json([
            'message' => 'Successfully updated',
            'status' => 200
        ], 200);
    }

    public function deathById($id)
    {
        $death = Death::select(
            'death.id',
            'death.dateOfDeath',
            'death.associatedCosts',
            'death.comments',
            'death.cat_id',
            'cats.nameCat',
            'cats.imageCat',
            'death.reasonOfDeath_id',
            'reasonOfDeath.reasonOfDeath'
        )
            ->join('cats', 'cats.id', '=', 'death.cat_id')
            ->join('reasonOfDeath', 'reasonOfDeath.idReasonOfDeath', '=', 'death.reasonOfDeath_id')
            ->where('death.id', $id)->first();

        return response()->json(['data' => $death], 200);
    }
}
