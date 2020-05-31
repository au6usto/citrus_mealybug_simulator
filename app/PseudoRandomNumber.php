<?php

namespace App;

class PseudoRandomNumber
{
    private $seed;

    private $randomList;

    private $number;

    private $multiplier;

    private $aditive;

    private $modulus;

    private $iterations;

    public function __construct($seed, $multiplier, $aditive, $modulus) {
        $this->seed = $seed;
        $this->number = $number;
        $this->multiplier = $multiplier;
        $this->aditive = $aditive;
        $this->modulus = $modulus;
    }

    public function generate() : array {
        for ($i=0; $i <= $iterations ; $i++) {
            $this->randomNumberList[$i]['n'] = ($this->multiplier * $this->number + $this->aditive) % $this->modulus;
            $this->randomNumberList[$i]['u'] = $thi->number / $this->modulus;
        }
        return $this->randomNumberList;
    }
}
