<?php

namespace App;

use App\ProbabilityNumber;
use App\PseudoRandomNumber;
use App\SimulatedPeriod;

class Simulator
{
    private $probability;

    private $Gu;

    private $month;

    private $temperaturePerMonth;

    private $maleFlightPerMonth;

    private $simulatedPeriodsList;
    
    public function __construct()
    {
        $this->probability = new ProbabilityNumber();
        $this->Gu = new PseudoRandomNumber(1);

        $this->periods = [10, 11, 12, 1, 2, 3, 4, 5];

        $this->simulatedPeriodsList = collect([]);

        //Temperaturas por mes
        $this->temperaturePerMonth = collect([
            10 => [15, 29],
            11 => [18, 31],
            12 => [20, 32],
            1 => [22,32],
            2 => [21, 30],
            3 => [18, 29],
            4 => [14, 26],
            5 => [10, 23],
        ]);

        //Vuelo de Machos por mes
        $this->maleFlightPerMonth = collect([
            10 => [237.6, 84.1],
            11 => [1529.2, 384.2],
            12 => [1529.2, 384.2],
            1 => [1251.6, 213.4],
            2 => [404.4, 77.5],
            3 => [228.04, 60.5]
        ]);

        //Frutos ocupados por mes
        $this->occupiedFruitPerMonth = collect([
            11 => [13.14, 3.9795],
            12 => [13.14, 3.9795],
            1 => [5.635, 22.545],
            2 => [0.0005, 0.215]
        ]);

        //Insectos en cáliz por mes
        $this->insectsInCalyxPerMonth = collect([
            11 => [0.0215, 0.9913],
            12 => [0.0215, 0.9913],
            1 => [0.0002, 0.0892],
            2 => [0.008, 13.806]
        ]);
    }

    //Simular 12 meses
    public function simulate()
    {
        foreach ($this->periods as $key => $period) {
            $this->month = $period;
            if ($period === 12) {
                $simulation = $this->simulatedPeriodsList->get($key - 1);
            } else {
                $maleQtyFromPeriod = $this->maleFlightPerMonth->get($this->month) ?? [0, 0];
                $femaleMaleRatio = $this->femaleMaleRatio();

                $maleQty = $this->probability->getNormal($maleQtyFromPeriod[0], $maleQtyFromPeriod[1]);
                $femaleQty = $this->calculateFemaleQty();
                $larvaeQty = $this->calculateLarvaeQty();
                //Cantidad de Larvas Hembra
                $femaleLarvaeQty = $larvaeQty * $femaleMaleRatio;
                //Cantidad de Larvas Macho
                $maleLarvaeQty = $larvaeQty - $femaleLarvaeQty;

                //Cantidad de Fruta Ocupada
                if ($this->month === 2) {//lineales
                    $occupiedPeriod = $this->occupiedFruitPerMonth->get($this->month);
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($key - 1)->maleQty;
                    $occupiedFruitPercentage = $occupiedPeriod[0] * $maleQtyFromLastPeriod + $occupiedPeriod[1];
                } elseif ($this->month !== 10 && $this->occupiedFruitPerMonth->get($this->month) !== null) { //exponenciales
                    $occupiedPeriod = $this->occupiedFruitPerMonth->get($this->month);
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($key - 1)->maleQty;
                    $occupiedFruitPercentage = $occupiedPeriod[0] * log($maleQtyFromLastPeriod) + $occupiedPeriod[1];
                } else {
                    $occupiedFruitPercentage = 0;
                }

                //Cantidad de Insectos en cáliz
                if ($this->month === 2) {//lineales
                    $occupiedPeriod = $this->insectsInCalyxPerMonth->get($this->month);
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($key - 1)->maleQty;
                    $insectsInCalyx = $occupiedPeriod[0] * $maleQtyFromLastPeriod + $occupiedPeriod[1];
                } else {
                    $insectsInCalyx = 0;
                }
            
                $simulation = new SimulatedPeriod(
                    $maleQty,
                    $femaleQty,
                    $larvaeQty,
                    $maleLarvaeQty,
                    $femaleLarvaeQty,
                    $occupiedFruitPercentage,
                    $insectsInCalyx
                );
            }
            $this->simulatedPeriodsList->push($simulation);
        }
    }

    //Calcular cantidad de Larvas
    private function calculateLarvaeQty()
    {
        $temperature = $this->probability->getNormal(
            $this->temperaturePerMonth->get($this->month)[0],
            $this->temperaturePerMonth->get($this->month)[1]
        );

        if ($temperature >= 17 && $temperature <= 33) {
            return $this->eggsPerOvisac() * 0.9;
        }
        return $this->eggsPerOvisac() * $this->probability->getUniform(0.5, 0.9);
    }

    //Calcular cantidad de hembras
    private function calculateFemaleQty() : float
    {
        $maleQtyFromPeriod = $this->maleFlightPerMonth->get($this->month) ?? [0, 0];
        return $this->probability->getNormal($maleQtyFromPeriod[0], $maleQtyFromPeriod[1]) * $this->FemaleMaleRatio();
    }

    //Calcular Hembras con Huevos
    private function calculateImpregnatedFemale(float $femaleQty): float
    {
        $this->Gu->generate();
        $Gu = $this->Gu->get(0);
        
        if ($Gu < 0.8) {
            $impregnatedFemale = $femaleQty * $Gu;
        }
        return $impregnatedFemale;
    }

    //Cantidad de días en que las larvas nacerán
    private function daysTillLarvaeBorn() : float
    {
        return $this->probability->getNormal(49.5, 2.05);
    }

    //Huevo por ovísaco
    private function eggsPerOvisac() : float
    {
        $ovisac = $this->probability->getUniform(3, 5);

        $eggs = 0;
        for ($i=0; $i < $ovisac; $i++) {
            $eggs += $this->probability->getUniform(100, 150);
        }

        return $eggs;
    }

    //Proporción Hembra-Macho
    private function femaleMaleRatio() : float
    {
        return 100 / $this->probability->getNormal(101.72, 10.2);
    }

    public function getPropertyPerPeriod($name)
    {
        return $this->simulatedPeriodsList->pluck($name);
    }
}
