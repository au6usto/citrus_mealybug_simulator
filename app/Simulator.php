<?php

namespace App;

use App\ProbabilityNumber;
use App\Charts\MaleFlight;

class Simulator
{
    public function simulate12months()
    {
    }

    public function createChart() : MaleFlight
    {
        $chart = new MaleFlight;
        $chart->labels(['One', 'Two', 'Three']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);
        return $chart;
    }
}
