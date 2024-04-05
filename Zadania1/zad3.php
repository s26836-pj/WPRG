<?php

function generateOddFibonacci($n) {
    $oddFibonacci = [];  numbers
    $a = 0; 
    $b = 1; 

  
    for ($i = 0; $a <= $n; $i++) {
        if ($a % 2 != 0) {
            $oddFibonacci[] = $a; 
        }
        $c = $a + $b; /
        $a = $b; 
        $b = $c; 
    }

    return $oddFibonacci; 
}

$N = 200;

$oddFibonacci = generateOddFibonacci($N);

echo "Odd elements of the Fibonacci up to N = $N:<br>";

foreach ($oddFibonacci as $index => $value) {
    echo ($index + 1) . ". &nbsp; $value<br>"; 
}

?>
