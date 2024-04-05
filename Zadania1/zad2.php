<?php

function isPrimeNumber($number) {
    if ($number < 2) {
        return false; 
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false; 
        }
    }
    return true; 
}

function printPrimeNumbers($start, $end) {
    $primeNumbers = [];
    foreach (range($start, $end) as $number) {
        if (isPrimeNumber($number)) {
            $primeNumbers[] = $number;
        }
    }
    echo implode(", ", $primeNumbers);
}

$start = 0;
$end = 50;


echo "Prime numbers in the range from $start to $end are: ";
printPrimeNumbers($start, $end);

?>
