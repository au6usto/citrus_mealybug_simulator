<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PseudoRandomNumber;

class PseudoRandomNumberController extends Controller
{
    public function getNumbers($seed, $amount) {
        $rn = new PseudoRandomNumber($seed, $amount);
        $rn->generate();
        $rn->testNumber(43);

        return $rn->getList();
    }
}
