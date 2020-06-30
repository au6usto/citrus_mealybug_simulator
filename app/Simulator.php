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

    private $occupiedFruitPercentage;

    private $plots;

    private $plantsAmount;

    public function __construct($plantsAmount, $plots)
    {
        $this->probability = new ProbabilityNumber();
        $this->Gu = new PseudoRandomNumber(1);

        $this->plantsAmount = $plantsAmount;
        $this->plots = $plots;

        $this->periods = collect([
            11 => ['name' => 'Primer Vuelo', 'month' => 'Noviembre'],
            12 => ['name' => 'Segundo Vuelo', 'month' => 'Diciembre/Enero'],
            1 => ['name' => 'Segundo Vuelo', 'month' => 'Diciembre/Enero'],
            2 => ['name' => 'Tercer Vuelo', 'month' => 'Febrero'],
            3 => ['name' => 'Cuarto Vuelo', 'month' => 'Marzo'],
            4 => ['name' => 'Reducción de Población', 'month' => 'Abril'],
            5 => ['name' => 'Deceso', 'month' => 'Mayo'],
            6 => ['name' => 'Deceso', 'month' => 'Junio'],
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
            1 => ['a' => 13.47, 'b' => 3.9795], //enero => ln  ----> vuelo noviembre
            2 => ['a' => 5.5655, 'b' => -22.545], // 1° quincena de febrero => ln  ----> vuelo diciembre enero
            3 => ['a' => 0.008, 'b' => 8.5797], // 2° quincena de febrero  ----> vuelo febrero
            4 => ['a' => 0.008, 'b' => 13.806], // 1° quincena marzo  ----> vuelo febrero
            5 => ['a' => 0.0189, 'b' => 14.498], // 2° quincena marzo  ----> vuelo marzo
            6 => ['a' => 0.0114, 'b' => 10.27], // 1° quincena junio  ----> vuelo marzo
            7 => ['a' => 0.0114, 'b' => 10.27], // 1° quincena junio ----> vuelo marzo
        ]);

        //Insectos en cáliz por mes
        $this->insectsInCalyxPerMonth = collect([
            1 => ['a' => 0.0215, 'b' => 0.9913], //enero   ----> vuelo noviembre
            2 => ['a' => 0.00002, 'b' => 0.0892], // 1° quincena de febrero  ----> vuelo diciembre enero
            3 => ['a' => 0.0005, 'b' => 0.0894], // 2° quincena de febrero  ----> vuelo febrero
            4 => ['a' => 0.0005, 'b' => 0.215], // 1° quincena marzo  ----> vuelo febrero
            5 => ['a' => 0.0009, 'b' => 0.3163], // 2° quincena marzo  ----> vuelo marzo
            6 => ['a' => 0.0007, 'b' => 0.3281], // 1° abril  ----> vuelo marzo
            7 => ['a' => 0.0002, 'b' => 0.1331], // 1° quincena junio  ----> vuelo marzo
        ]);
    }

    //Simular 4 períodos
    public function simulate()
    {
        $i = 0;
        foreach ($this->periods as $key => $period) {
            $this->month = $key;
            $this->calculateTemperature();
            $this->eggsPerOvisac();
            $this->calculateMaleQty();
            if ($key === 1) {
                $simulation = $this->simulatedPeriodsList->get($i - 1);
            } else {
                $femaleQty = $this->calculateFemaleQty();
                $larvaeQty = $this->calculateLarvaeQty();
                //Cantidad de Larvas Hembra
                $femaleLarvaeQty = $larvaeQty * $this->femaleMaleLarvaeRatio();
                //Cantidad de Larvas Macho
                $maleLarvaeQty = $larvaeQty - $femaleLarvaeQty;
                //Porcentaje ocupado de la planta
                $occupiedPeriod = $this->occupiedFruitPerMonth->get($this->calculateAfflictedMonth());

                //Cantidad de Fruta Ocupada
                if ($this->month === 1) {//lineales
                    //Cantidad de machos del período anterior
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($i - 1)->maleQty;
                    $this->occupiedFruitPercentage = $occupiedPeriod['a'] * log($maleQtyFromLastPeriod) + $occupiedPeriod['b'];
                } elseif (!in_array($this->month, [11, 12])) { //exponenciales
                    //Cantidad de machos del período anterior
                    $maleQtyFromLastPeriod = $this->simulatedPeriodsList->get($i - 1)->maleQty;
                    //Porcentaje de fruto ocupado
                    $this->occupiedFruitPercentage = $occupiedPeriod['a'] * $maleQtyFromLastPeriod + $occupiedPeriod['b'];
                } else {
                    $this->occupiedFruitPercentage = 0;
                }
                
                //Cantidad de Insectos en cáliz
                if (!in_array($this->month, [11, 12])) {//lineales
                    $insectsInCalyx = $occupiedPeriod['a'] * $maleQtyFromLastPeriod + $occupiedPeriod['b'];
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
                    $this->occupiedFruitPercentage,
                    $insectsInCalyx,
                    $eggsTotal,
                    $this->temperature,
                    $this->calculateFruitDamage()
                );
            }
            $this->simulatedPeriodsList->push($simulation);
            $i++;
        }
    }

    private function calculateAfflictedMonth() : int
    {
        switch ($this->month) {
            case 11:
                return 1;
            case 12:
                return 2;
            case 1:
                return 2;
            default:
                return $this->month + 1;
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

    private function calculateFruitDamage()
    {
        $fruitDamaged = (0.7911 * $this->occupiedFruitPercentage - 3.5608) + rand(0, 10);
        return $fruitDamaged > 0 ? $fruitDamaged : 0;
    }

    //Calcular Hembras con Huevos
    private function calculateImpregnatedFemale(int $femaleQty): float
    {
        $this->Gu->generate();
        $Gu = $this->Gu->get(0);

        $probs = collect([0.4, 0.8, 1]);

        $p = $probs->first(function ($value) use ($Gu) {
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
        if ($name === 'eggsTotal') {
            return collect([0, 0])->concat($this->simulatedPeriodsList->pluck($name)->except([6, 7]));
        }
        return $this->simulatedPeriodsList->pluck($name);
    }

    public function getPlantsAffected() : float
    {
        return $this->plantsAmount * $this->plots;
    }

    public function getLowFruitsLossInKg() : float
    {
        return $this->plantsAmount * $this->plots * 17 * ($this->getPropertyPerPeriod('fruitDamaged')[4] / 100);
    }

    public function getHighFruitsLossInKg() : float
    {
        return $this->plantsAmount * $this->plots * 90 * ($this->getPropertyPerPeriod('fruitDamaged')[4] / 100);
    }
}
