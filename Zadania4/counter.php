<?php
$file_path = "licznik.txt";

if (file_exists($file_path)) {
    $visits = (int)file_get_contents($file_path);
    
    $visits++;
    
    file_put_contents($file_path, $visits);
} else {
    $visits = 1;
    file_put_contents($file_path, $visits);
}

echo "Liczba odwiedzin: " . $visits;
?>
