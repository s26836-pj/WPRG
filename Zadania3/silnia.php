<?php
    // Funkcja obliczająca silnię rekurencyjnie
    function silnia_rekurencyjnie($n) {
        if ($n <= 1) {
            return 1;
        } else {
            return $n * silnia_rekurencyjnie($n - 1);
        }
    }

    // Funkcja obliczająca silnię iteracyjnie
    function silnia_iteracyjnie($n) {
        $result = 1;
        for ($i = 1; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $number = $_POST["number"];

        // Pomiar czasu wykonania funkcji dla silni rekurencyjnie
        $start_silnia_rekurencyjnie = microtime(true);
        $result_silnia_rekurencyjnie = silnia_rekurencyjnie($number);
        $end_silnia_rekurencyjnie = microtime(true);
        $time_silnia_rekurencyjnie = ($end_silnia_rekurencyjnie - $start_silnia_rekurencyjnie) * 1000;

        // Pomiar czasu wykonania funkcji dla silni iteracyjnie
        $start_silnia_iteracyjnie = microtime(true);
        $result_silnia_iteracyjnie = silnia_iteracyjnie($number);
        $end_silnia_iteracyjnie = microtime(true);
        $time_silnia_iteracyjnie = ($end_silnia_iteracyjnie - $start_silnia_iteracyjnie) * 1000;

        // Wyświetlenie wyników
        echo "Silnia rekurencyjnie dla $number: $result_silnia_rekurencyjnie <br>";
        echo "Czas wykonania silni rekurencyjnie: $time_silnia_rekurencyjnie milisekund <br>";

        echo "Silnia iteracyjnie dla $number: $result_silnia_iteracyjnie <br>";
        echo "Czas wykonania silni iteracyjnie: $time_silnia_iteracyjnie milisekund <br>";
    }
    ?>
</body>
</html>