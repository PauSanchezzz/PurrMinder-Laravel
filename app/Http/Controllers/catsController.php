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
        $cats = Cat::where('availabilityCat', true)
            ->where('adoptedCat', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function catsNotAvailable()
    {
        $cats = Cat::where('availabilityCat', false)
            ->where('adoptedCat', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function catsAdopted()
    {
        $cats = Cat::where('adoptedCat', false)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function allCats()
    {
        $cats = Cat::orderBy('updated_at', 'desc')
        ->get();

        return response()->json(['cats' => $cats], 200);
    }


    public function findCat(Request $request)
    {
        $nameCat = $request->input('nameCat');

        if (!$nameCat) {
            return response()->json(['cats' => []], 200);
        }

        $cats = Cat::whereRaw('LOWER("nameCat") LIKE ?', ['%' . strtolower($nameCat) . '%'])->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function catById($id)
    {
        $catQuery = Cat::select(
            'cats.id',
            'cats.nameCat',
            'cats.imageCat',
            'cats.descriptionCat',
            'cats.ageCat',
            'cats.calendar_id',
            'calendar.calendar',
            'cats.weightCat',
            'cats.sexCat_id',
            'cats.specialCondition as specialConditionStatus',
            'cats.catHealth_id',
            'catHealth.catHealth',
            'cats.personality_id',
            'personality.personality',
            'cats.availabilityCat',
            'cats.adoptedCat'
        )
            ->join('calendar', 'calendar.idCalendar', '=', 'cats.calendar_id')
            ->join('personality', 'personality.idPersonality', '=', 'cats.personality_id')
            ->join('catHealth', 'catHealth.idCatHealth', '=', 'cats.catHealth_id')
            ->where('cats.id', $id);

        // Verificar si el campo `specialCondition` es verdadero
        if (Cat::where('id', $id)->where('cats.specialCondition', true)->exists()) {
            $catQuery->addSelect('specialCondition.specialCondition', 'cats.specialCondition_id')
                ->join('specialCondition', 'specialCondition.idSpecialCondition', '=', 'cats.specialCondition_id');
        }

        $cat = $catQuery->first();

        return response()->json(['cat' => $cat], 200);
    }

    public function catRegister(Request $request)
    {

        $imgName = Str::random(32) . "." . $request->imageCat->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [
            'nameCat' => 'required',
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

        Storage::disk('public')->put($imgName, file_get_contents($request->imageCat));

        return response()->json([
            'message' => 'Cat successfully registered',
            'status' => 201], 201);
    }

    public function catEdit(Request $request, $id)
    {

        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json(['message' => 'Cat not found'], 404);
        }

        if ($request->hasFile('imageCat')) {
            $imgName = Str::random(32) . "." . $request->imageCat->getClientOriginalExtension();
            Storage::disk('public')->put($imgName, file_get_contents($request->imageCat));
            $cat->imageCat = $imgName;
        }

        $fields = [
            'nameCat', 'descriptionCat', 'ageCat', 'calendar_id',
            'weightCat', 'specialCondition', 'specialCondition_id', 'availabilityCat'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $cat->$field = $request->$field;
            }
        }

        $cat->save();

        return response()->json([
            'cat' => $cat,
            'message' => 'Cat successfully updated',
            'status' => 200
        ], 200);
    }


}
