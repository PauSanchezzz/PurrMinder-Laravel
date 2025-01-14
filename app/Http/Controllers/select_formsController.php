<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Cat;
use App\Models\CatHealth;
use App\Models\city;
use App\Models\Occupation;
use App\Models\Personality;
use App\Models\ReasonOfDeath;
use App\Models\Sex;
use App\Models\specialCondition;
use App\Models\TypeDocument;
use App\Models\TypeMedicalProcedure;
use Illuminate\Http\Request;

class select_formsController extends Controller
{
    public function select_typeDocument()
    {
        $typeDocument = TypeDocument::all();
        return response()->json(['data' => $typeDocument], 200);
    }

    public function select_city()
    {
        $city = City::all();
        return response()->json(['data' => $city], 200);
    }

    public function select_occupation()
    {
        $occupation = Occupation::all();
        return response()->json(['data' => $occupation], 200);
    }

    public function select_calendar()
    {
        $calendar = Calendar::all();
        return response()->json(['data' => $calendar], 200);
    }

    public function select_sex()
    {
        $sex = Sex::all();
        return response()->json(['data' => $sex], 200);
    }

    public function select_personality()
    {
        $personality = Personality::all();
        return response()->json(['data' => $personality], 200);
    }

    public function select_catHealth()
    {
        $catHealth = CatHealth::all();
        return response()->json(['data' => $catHealth], 200);
    }

    public function select_specialCondition()
    {
        $specialCondition = SpecialCondition::all();
        return response()->json(['data' => $specialCondition], 200);
    }

    public function select_typeMedicalProcedure()
    {
        $typeMedicalProcedure = TypeMedicalProcedure::all();
        return response()->json(['data' => $typeMedicalProcedure], 200);
    }

    public function select_cat()
    {
        $cats = Cat::where('adoptedCat', true)
            ->select('id','nameCat', 'imageCat')
            ->get();
        return response()->json(['data' => $cats], 200);
    }

    public function select_reasonOfDeath()
    {
        $reasonOfDeath = ReasonOfDeath::all();
        return response()->json(['data' => $reasonOfDeath], 200);
    }

    public function select_adoptedCats()
    {
        $cats = Cat::where('adoptedCat', false)
            ->select('id','nameCat', 'imageCat')
            ->get();
        return response()->json(['data' => $cats], 200);
    }

}
