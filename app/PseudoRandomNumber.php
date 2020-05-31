<?php

namespace App;

class PseudoRandomNumber
{
    private $seed;

    private $randomNumber;

    private $u;

    private $multiplier;

    private $aditive;

    private $modulus;

    private $iterations;

    public function __construct($seed, $multiplier, $aditive, $modulus) {
        $this->seed = $seed;
        $this->randomNumber = $seed;
        $this->multiplier = $multiplier;
        $this->aditive = $aditive;
        $this->modulus = $modulus;
    }

    public function generate() {
        for ($i=0; $i <= $iterations ; $i++) {
            $this->randomNumber = ($this->multiplier * $this->randomNumber + $this->aditive) % $this->modulus;
            $this->u = $thi->randomNumber / $this->modulus;
        }
        return $this->randomNumber;
    }
}
