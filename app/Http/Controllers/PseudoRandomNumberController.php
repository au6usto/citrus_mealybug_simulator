<?php

namespace App\Http\Controllers;

use App\PseudoRandomNumber;

class PseudoRandomNumberController extends Controller
{
    public function getNumbers()
    {
        $rn = new PseudoRandomNumber();
        $rn->generate();
        $rn->testNumber(43);

        return $rn->getList();
    }
}
