<?php

namespace App;

use App\ProbabilityNumber;
use App\PseudoRandomNumber;

class SimulatedPeriod
{
    public $maleQty;
    public $femaleQty;
    public $totalLarvae;
    public $maleLarvaeQty;
    public $femaleLarvaeQty;
    public $occupiedfruitPercentage;
    public $insectsInCalyx;
    
    public function __construct($maleQty, $femaleQty, $totalLarvae, $maleLarvaeQty, $femaleLarvaeQty, $occupiedfruitPercentage, $insectsInCalyx)
    {
        $this->maleQty = $maleQty;
        $this->femaleQty = $femaleQty;
        $this->totalLarvae = $totalLarvae;
        $this->maleLarvaeQty = $maleLarvaeQty;
        $this->femaleLarvaeQty = $femaleLarvaeQty;
        $this->occupiedfruitPercentage = $occupiedfruitPercentage;
        $this->insectsInCalyx = $insectsInCalyx;
    }
}
