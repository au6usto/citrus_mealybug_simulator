<?php

namespace App;

use \App\PseudoRandomNumber;

class ProbabilityNumber
{
    //Distribuciones Probabilísticas

    public function getNormal($mean, $stdDeviation) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber(12);
        $pseudoRandomNumber->generate();
        $sum = 0;
        for ($i=0; $i < 12; $i++) {
            $sum += $pseudoRandomNumber->getList()[$i];
        }

        return $stdDeviation * ($sum - 6) + $mean;
    }

    public function getBinomial($nSamples, $probabilityOfSuccess) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber($nSamples);
        $pseudoRandomNumber->generate();
        $result = 0;
        for ($i=0; $i < $nSamples; $i++) {
            if ($pseudoRandomNumber->getList()[$i] <= $probabilityOfSuccess) {
                $result++;
            }
        }

        return $result;
    }

    public function getUniform($a, $b) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber(1);
        $pseudoRandomNumber->generate();
        return $a + ($b - $a) * $pseudoRandomNumber->getList()[0];
    }
}
