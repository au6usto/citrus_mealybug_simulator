<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PseudoRandomNumber;

class PseudoRandomNumberController extends Controller
{
    public function getNumbers($amount, $seed) {
        $rn = new PseudoRandomNumber($amount, $seed);
        $rn->generate();
        $rn->testNumber(43);

        return $rn->getList();
    }
}
