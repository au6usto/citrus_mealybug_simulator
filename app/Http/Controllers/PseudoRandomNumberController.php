<?php

namespace App\Http\Controllers;

use App\PseudoRandomNumber;
use App\ProbabilityNumber;

class PseudoRandomNumberController extends Controller
{
    public function getNumbers()
    {
        $rn = new PseudoRandomNumber();
        $rn->generate();
        $rn->testNumber(43);

        $prob = new ProbabilityNumber();

        $randomNumber = [
            'normal(100, 20)' => $prob->getNormal(100, 20),
            'binomial(100, 0.3)' => $prob->getBinomial(100, 0.7),
            'uniforme(100, 200)' => $prob->getUniform(100, 200),
            'numeros' => $rn->getList(),
        ];
        return $randomNumber;
    }
}
