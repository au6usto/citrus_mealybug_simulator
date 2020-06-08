<?php

namespace App;

use App\PseudoRandomNumber;

class ProbabilityNumber
{
    //Distribuciones Probabilísticas

    public function getNormal(float $mean, float $deviation) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber(12);
        $pseudoRandomNumber->generate();
        $uList = $pseudoRandomNumber->getList();
        $sum = 0;
        for ($i=0; $i < 12; $i++) {
            $sum += $uList[$i];
        }

        $result = $deviation * ($sum - 6) + $mean;
        return $result;
    }

    public function getBinomial(int $nSamples, float $probabilityOfSuccess) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber($nSamples);
        $pseudoRandomNumber->generate();
        $uList = $pseudoRandomNumber->getList();
        $result = 0;
        for ($i=0; $i < $nSamples; $i++) {
            if ($uList[$i] <= $probabilityOfSuccess) {
                $result++;
            }
        }

        return $result;
    }

    public function getUniform(float $a, float $b) : float
    {
        $pseudoRandomNumber = new PseudoRandomNumber(1);
        $pseudoRandomNumber->generate();
        $Gu = $pseudoRandomNumber->get(0);
        $result = $a + (($b - $a) * $Gu);

        return $result;
    }
}
