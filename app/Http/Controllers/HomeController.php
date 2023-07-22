<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('index', compact('countries', 'states', 'cities'));
    }

    public function getStates(Request $request)
    {
        $countryId = $request->input('country_id');
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $stateId = $request->input('state_id');
        $cities = City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }
}
