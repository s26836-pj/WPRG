<?php

$fruits = array("apple", "pineapple", "orange", "coconut");

foreach ($fruits as $fruit) {
    $reversedFruit = strrev($fruit);
    $startsWithA = (strtolower($fruit[0]) === 'a') ? "It starts with a" : "It doesn't start with a";
    echo "Reversed fruit: $reversedFruit          $startsWithA <br/>";
}

?>
