<?php

namespace App;

class PseudoRandomNumber
{
    //Método Congruencial Mixto
    //(a * n_i + c) mod m
    const MULTIPLIER = 5; //a
    const ADITIVE = 7; //c
    const MODULUS = 8; //m

    private $seed;
    private $amount;
    private $randomNumber;
    private $randomNumberList;

    public function __construct($amount, $seed) {
        $this->seed = $seed;
        $this->randomNumber = $seed;
        $this->amount = $amount;
        $this->randomNumberList = collect([]);
    }

    public function generate() : void {
        for ($i=0; $i < $this->amount ; $i++) {
            $this->randomNumber = (self::MULTIPLIER * $this->randomNumber + self::ADITIVE) % self::MODULUS;
            $this->randomNumberList->push([
                'n' => $this->randomNumber,
                'u' => $this->randomNumber / self::MODULUS
            ]);
        }
    }

    public function getList() : array {
        return $this->randomNumberList->toArray();
    }

    public function testNumber($z) : bool {
        $n = $this->randomNumberList->count();
        $mean = $this->randomNumberList->sum('u') / $n;
        $statZ = (($mean - 0.5) * sqrt($n)) / sqrt(1/12);
        return abs($statZ) < $z;
    }
}
