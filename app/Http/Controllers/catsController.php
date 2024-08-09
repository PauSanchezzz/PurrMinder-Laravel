<?php

namespace App\Http\Controllers;

use App\Models\Cat;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\support\Str;

class catsController extends Controller
{

    public function catsAdoption()
    {
        $cats = Cat::where('availabilityCat', true)->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function catsAdopted()
    {
        $cats = Cat::where('availabilityCat', false)->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function catRegister(Request $request)
    {
      //  dd($request);
        $imgName = Str::random(32) . "." . $request->imageCat->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [
            'nameCat' => 'required',
            //'imageCat' => 'image',
            'descriptionCat' => 'required',
            'ageCat' => 'required',
            'calendar_id' => 'required',
            'weightCat' => 'required',
            'sexCat_id' => 'required',
            'specialCondition' => 'required',
            'specialCondition_id' => '',
            'catHealth_id' => 'required',
            'personality_id' => 'required',
            'availabilityCat' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Cat::create(array_merge(
            $validator->validated(),
            ['imageCat' => $imgName]
        ));

        Storage::disk('public')->put($imgName,file_get_contents($request->imageCat));

        return response()->json([
            'message' => 'Cat successfully registered',
            'status' => 201], 201);
    }

}
