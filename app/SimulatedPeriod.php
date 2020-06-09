<?php

namespace App;

use App\ProbabilityNumber;
use App\PseudoRandomNumber;

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
    
    public function __construct($periodName, $periodMonth, $maleQty, $femaleQty, $totalLarvae, $maleLarvaeQty, $femaleLarvaeQty, $occupiedfruitPercentage, $insectsInCalyx, $eggsTotal, $temperature)
    {
        $this->periodName = $periodName;
        $this->periodMonth = $periodMonth;
        $this->maleQty = $maleQty;
        $this->femaleQty = $femaleQty;
        $this->totalLarvae = $totalLarvae;
        $this->maleLarvaeQty = $maleLarvaeQty;
        $this->femaleLarvaeQty = $femaleLarvaeQty;
        $this->occupiedfruitPercentage = $occupiedfruitPercentage;
        $this->insectsInCalyx = $insectsInCalyx;
        $this->eggsTotal = $eggsTotal;
        $this->temperature = $temperature;
    }
}
