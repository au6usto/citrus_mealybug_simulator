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

    private $maleQty;

    private $eggsPerOvisac;

    private $temperature;

    private $simulatedPeriodsList;

    public function __construct()
    {
        $this->probability = new ProbabilityNumber();
        $this->Gu = new PseudoRandomNumber(1);

        $this->periods = collect([
            11 => ['name' => 'Primer Vuelo', 'month' => 'Octubre'],
            12 => ['name' => 'Segundo Vuelo', 'month' => 'Noviembre/Diciembre'],
            1 => ['name' => 'Segundo Vuelo', 'month' => 'Noviembre/Diciembre'],
            2 => ['name' => 'Tercer Vuelo', 'month' => 'Enero'],
            3 => ['name' => 'Cuarto Vuelo', 'month' => 'Febrero'],
            4 => ['name' => 'Reducción de Población', 'month' => 'Marzo'],
            5 => ['name' => 'Deceso', 'month' => 'Abril'],
            6 => ['name' => 'Deceso', 'month' => 'Mayo'],
        ]);

        $this->simulatedPeriodsList = collect([]);

        //Temperaturas por mes
        $this->temperaturePerMonth = collect([
            11 => ['min' => 18, 'max' => 31],
            12 => ['min' => 20, 'max' => 32],
            1 => ['min' => 22,'max' => 32],
            2 => ['min' => 21, 'max' => 30],
            3 => ['min' => 18, 'max' => 29],
            4 => ['min' => 14, 'max' => 26],
            5 => ['min' => 10, 'max' => 23],
            6 => ['min' => 8, 'max' => 32],
        ]);

        //Vuelo de Machos por mes
        $this->maleFlightPerMonth = collect([
            11 => ['mean' => 237.6, 'deviation' => 84.1],
            12 => ['mean' => 1529.2, 'deviation' => 384.2],
            1 => ['mean' => 1529.2, 'deviation' => 384.2],
            2 => ['mean' => 1251.6, 'deviation' => 213.4],
            3 => ['mean' => 404.4, 'deviation' => 77.5],
            4 => ['mean' => 228.04, 'deviation' => 60.5]
        ]);

        //Frutos ocupados por mes
        $this->occupiedFruitPerMonth = collect([
            1 => ['a' => 13.47, 'b' => 3.9795], //enero => ln
            2 => ['a' => 5.5655, 'b' => -22.545], // 1° quincena de febrero => ln
            3 => ['a' => 0.008, 'b' => 8.5797], // 2° quincena de febrero
            4 => ['a' => 0.008, 'b' => 13.806], // 1° quincena marzo
            5 => ['a' => 0.0189, 'b' => 14.498], // 2° quincena marzo
            6 => ['a' => 0.0114, 'b' => 10.27], // 1° quincena junio
        ]);

        //Insectos en cáliz por mes
        $this->insectsInCalyxPerMonth = collect([
            1 => ['a' => 0.0215, 'b' => 0.9913], //enero
            2 => ['a' => 0.00002, 'b' => 0.0892], // 1° quincena de febrero
            3 => ['a' => 0.0005, 'b' => 0.0894], // 2° quincena de febrero
            4 => ['a' => 0.0005, 'b' => 0.215], // 1° quincena marzo
            5 => ['a' => 0.0009, 'b' => 0.3163], // 2° quincena marzo
            6 => ['a' => 0.0007, 'b' => 0.3281], // 1° abril
            7 => ['a' => 0.0002, 'b' => 0.1331], // 1° quincena junio
        ]);

        $this->relationOccupiedDamage = collect([
            'a'=> 0,7911, 'b' => -3,5608
        ]);
    }

    //Simular 4 períodos
    public function simulate()
    {
        $i = 0;
        foreach ($this->periods as $key => $period) {
            $this->month = $key;
            if ($key === 12) {
                $simulation = $this->simulatedPeriodsList->get($i - 1);
            } else {
                $this->calculateTemperature();
                $this->eggsPerOvisac();
                $this->calculateMaleQty();
                $femaleQty = $this->calculateFemaleQty();
                $larvaeQty = $this->calculateLarvaeQty();
                //Cantidad de Larvas Hembra
                $femaleLarvaeQty = $larvaeQty * $this->femaleMaleLarvaeRatio();
                //Cantidad de Larvas Macho
                $maleLarvaeQty = $larvaeQty - $femaleLarvaeQty;

                //Cantidad de Fruta Ocupada
                if ($this->month === 2) {//lineales
                    $occupiedPeriod = $this->occupiedFruitPerMonth->get($this->month);
                    //Cantidad de machos del período anterior
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($i - 2)->maleQty;
                    //Porcentaje de fruto ocupado
                    $occupiedFruitPercentage = $occupiedPeriod['mean'] * $maleQtyFromLastPeriod + $occupiedPeriod['deviation'];
                } elseif ($this->month !== 10 && $this->occupiedFruitPerMonth->get($this->month) !== null) { //exponenciales
                    $occupiedPeriod = $this->occupiedFruitPerMonth->get($this->month);
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($i - 1)->maleQty;
                    $occupiedFruitPercentage = $occupiedPeriod['mean'] * log($maleQtyFromLastPeriod) + $occupiedPeriod['deviation'];
                } else {
                    $occupiedFruitPercentage = 0;
                }

                //Cantidad de Insectos en cáliz
                if ($this->month === 2) {//lineales
                    $occupiedPeriod = $this->insectsInCalyxPerMonth->get($this->month);
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($i - 1)->maleQty;
                    $insectsInCalyx = $occupiedPeriod['mean'] * $maleQtyFromLastPeriod + $occupiedPeriod['deviation'];
                } else {
                    $insectsInCalyx = 0;
                }

                //Calculo total de huevos
                $eggsTotal = $this->calcaultateEggsTotal() * $this->calculateImpregnatedFemale($femaleQty);

                $simulation = new SimulatedPeriod(
                    $period['name'],
                    $period['month'],
                    $this->maleQty,
                    $femaleQty,
                    $larvaeQty,
                    $maleLarvaeQty,
                    $femaleLarvaeQty,
                    $occupiedFruitPercentage,
                    $insectsInCalyx,
                    $eggsTotal,
                    $this->temperature
                );
            }
            $this->simulatedPeriodsList->push($simulation);
            $i++;
        }
    }

    //Calcular cantidad de Larvas
    private function calculateLarvaeQty()
    {
        if ($this->temperature >= 17 && $this->temperature <= 33) {
            return $this->eggsPerOvisac * 0.9;
        }
        return $this->eggsPerOvisac * $this->probability->getUniform(0.5, 0.9);
    }

    private function calculateTemperature() : void
    {
        $this->temperature = $this->probability->getUniform(
            $this->temperaturePerMonth->get($this->month)['min'],
            $this->temperaturePerMonth->get($this->month)['max']
        );
    }

    private function calculateMaleQty() : void
    {
        $maleQtyFromPeriod = $this->maleFlightPerMonth->get($this->month);
        $this->maleQty = isset($maleQtyFromPeriod['mean']) ?
                    $this->probability->getNormal($maleQtyFromPeriod['mean'], $maleQtyFromPeriod['deviation']) :
                    0;
    }

    //Calcular cantidad de hembras
    private function calculateFemaleQty() : float
    {
        return  $this->maleQty * $this->FemaleMaleRatio();
    }

    //Calcular Hembras con Huevos
    private function calculateImpregnatedFemale(int $femaleQty): float
    {
        $this->Gu->generate();
        $Gu = $this->Gu->get(0);

        $probs = collect([0.4, 0.8, 1]);

        $p = $probs->first(function ($value, $key) use ($Gu) {
            return $Gu < $value;
        });

        if ($p) {
            return $femaleQty * $this->probability->getBinomial($probs->count(), $p);
        }

        return $femaleQty;
    }

    //Cantidad de días en que las larvas nacerán
    private function daysTillLarvaeBorn() : float
    {
        return $this->probability->getNormal(49.5, 2.05);
    }

    //Huevos Totales
    private function calcaultateEggsTotal() : float
    {
        $eggs = 0;
        for ($i = 0; $i < $this->eggsPerOvisac; $i++) {
            $eggs += $this->probability->getUniform(100, 150);
        }

        return $eggs;
    }

    //Huevos por ovísaco
    private function eggsPerOvisac() : void
    {
        $this->eggsPerOvisac = $this->probability->getUniform(3, 5);
    }

    //Proporción Hembra-Macho
    private function femaleMaleRatio() : float
    {
        return 100 / $this->probability->getNormal(101.72, 10.2);
    }

    //Proporción Hembra-Macho
    private function femaleMaleLarvaeRatio() : float
    {
        return (100) / ($this->probability->getNormal(101.72, 10.2)+100);
    }

    public function getPropertyPerPeriod($name)
    {
        return $this->simulatedPeriodsList->pluck($name);
    }
}
