<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TestController extends Controller
{
    /**
     * @param $postcodes
     * @return \Illuminate\Http\JsonResponse
     */
    public function carsList()
    {
        $car_make = DB::table('car_make')
            ->select('car_make.name as make', 'car_model.name as model')
            ->join('car_model', 'car_model.id_car_make', 'car_make.id_car_make')
            ->get();
        $cars_array = $this->group_by_key($car_make);
        if ($cars_array) {
            return response()->json($cars_array, 200);
        } else {
            return response()->json('Resource not found', 404);
        }
    }

    private function group_by_key($array)
    {
        $w = array();
        foreach ($array as $y) {
            $maker = $y->make;
            $w[$maker][] = $y->model;
        }
        return $w;
    }
}
