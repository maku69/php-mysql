<?php
class Auto {
    var $varv;
    var $tootja;
    var $kiirus;

    function __construct($varv, $tootja) {
        $this->varv = $varv;
        $this->tootja = $tootja;
        $this->kiirus = 0;
    }

    function kiirendus() {
        while ($this->kiirus < 100) {
            $this->kiirus += 10;
            echo "Kiirus: " . $this->kiirus . "<br>";
        }
    }
}

// Create a new car instance
$minuAuto = new Auto("punane", "Audi");
echo "Minu uus " . $minuAuto->tootja . " on " . $minuAuto->varv . ".<br>";

// Accelerate the car
$minuAuto->kiirendus();
?>
