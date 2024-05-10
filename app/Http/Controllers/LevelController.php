<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(MonthlyUsersChart $chart)
{
    return view('chart', ['chart' => $chart->build()]);
}
}
