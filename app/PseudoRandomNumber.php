<?php

namespace App;

class PseudoRandomNumber
{
    //Método Congruencial Mixto
    //(a * n_i + c) mod m
    const MULTIPLIER = 281; //a
    const ADITIVE = 11; //c
    const MODULUS = 10000000000; //m

    private $seed;
    private $amount;
    private $randomNumber;
    private $uList;

    public function __construct($amount = null, $seed = null)
    {
        $this->seed = $seed ?? rand();
        $this->randomNumber = $this->seed;
        $this->amount = $amount ?? 10;
        $this->uList = collect([]);
    }

    public function generate() : void
    {
        for ($i=0; $i < $this->amount ; $i++) {
            $this->randomNumber = (self::MULTIPLIER * $this->randomNumber + self::ADITIVE) % self::MODULUS;
            $u = $this->randomNumber / self::MODULUS;
            $this->uList->push($u);
        }
    }

    public function getList() : array
    {
        return $this->uList->toArray();
    }

    public function get($i) : float
    {
        return $this->uList->get($i);
    }

    public function testNumber($z) : bool
    {
        $n = $this->uList->count();
        $mean = $this->uList->sum() / $n;
        $statZ = (($mean - 0.5) * sqrt($n)) / sqrt(1/12);
        return abs($statZ) < $z;
    }
}
