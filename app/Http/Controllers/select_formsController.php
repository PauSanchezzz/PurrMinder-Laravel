<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\CatHealth;
use App\Models\city;
use App\Models\Occupation;
use App\Models\Personality;
use App\Models\Sex;
use App\Models\TypeDocument;
use Illuminate\Http\Request;

class select_formsController extends Controller
{
    public function select_typeDocument()
    {
        $typeDocument = TypeDocument::all();
        return response()->json(['data' => $typeDocument], 200);
    }

    public function select_city(){
        $city = City::all();
        return response()->json(['data' => $city], 200);
    }

    public function select_occupation(){
        $occupation = Occupation::all();
        return response()->json(['data' => $occupation], 200);
    }

    public function select_calendar(){
        $calendar = Calendar::all();
        return response()->json(['data' => $calendar], 200);
    }

    public function select_sex(){
        $sex = Sex::all();
        return response()->json(['data' => $sex], 200);
    }

    public function select_personality(){
        $personality = Personality::all();
        return response()->json(['data' => $personality], 200);
    }

    public function select_catHealth(){
        $catHealth = CatHealth::all();
        return response()->json(['data' => $catHealth], 200);
    }

}
