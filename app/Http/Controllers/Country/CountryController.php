<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Models\CountryModel;
use Illuminate\Http\Request;
use Validator;

class CountryController extends Controller
{
    //
    public function country()
    {
        return response()->json(CountryModel::get(), 200);
    }
    public function countryById($id)
    {
        // VALIDATION
        $country = CountryModel::find($id);
        if (is_null($country)) {
            return response()->json(["message" => "Record Not Found"], 404);
        }

        return response()->json(CountryModel::find($id), 200);
    }
    public function countrySave(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'iso' => 'required|min:2|max:2',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $country = CountryModel::create($request->all());
        return response()->json(CountryModel::find($country), 201);
    }
    public function countryUpdate(Request $request, $country)
    {
        $countryM = CountryModel::find($country);
        if (is_null($countryM)) {
            return response()->json(["message" => "Record Not found"], 404);
        }
        $countryM->update($request->all());
        return response()->json($countryM, 200);
    }
    public function countryDelete(Request $request, CountryModel $country)
    {
        $country->delete();
        return response()->json('NOT FOUND', 204);
    }

}
