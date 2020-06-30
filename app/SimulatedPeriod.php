<?php

namespace App;

class SimulatedPeriod
{
    public $periodName;
    public $maleQty;
    public $femaleQty;
    public $totalLarvae;
    public $maleLarvaeQty;
    public $femaleLarvaeQty;
    public $occupiedfruitPercentage;
    public $insectsInCalyx;
    public $eggsTotal;
    public $temperature;
    public $fruitDamaged;
    
    public function __construct($periodName, $periodMonth, $maleQty, $femaleQty, $totalLarvae, $maleLarvaeQty, $femaleLarvaeQty, $occupiedfruitPercentage, $insectsInCalyx, $eggsTotal, $temperature, $fruitDamaged)
    {
        $this->periodName = $periodName;
        $this->periodMonth = $periodMonth;
        $this->maleQty = abs($maleQty);
        $this->femaleQty = abs($femaleQty);
        $this->totalLarvae = abs($totalLarvae);
        $this->maleLarvaeQty = abs($maleLarvaeQty);
        $this->femaleLarvaeQty = abs($femaleLarvaeQty);
        $this->occupiedfruitPercentage = abs($occupiedfruitPercentage);
        $this->insectsInCalyx = abs($insectsInCalyx);
        $this->eggsTotal = abs($eggsTotal);
        $this->temperature = abs($temperature);
        $this->fruitDamaged = abs($fruitDamaged);
    }
}
