<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdzenie czy pole z liczbą zostało przesłane
    if(isset($_POST['number'])) {
        // Pobranie liczby z formularza
        $number = $_POST['number'];

        // Sprawdzenie czy wprowadzona wartość jest liczbą całkowitą dodatnią
        if(is_numeric($number) && $number > 1 && intval($number) == $number) {
            $is_prime = true; // Zmienna przechowująca informację czy liczba jest liczbą pierwszą
            $iterations = 0; // Licznik iteracji

            // Sprawdzenie czy liczba jest liczbą pierwszą
            for ($i = 2; $i <= sqrt($number); $i++) {
                $iterations++; // Zwiększenie licznika iteracji
                if ($number % $i == 0) {
                    $is_prime = false;
                    break; // Jeśli znaleziono dzielnik, liczba nie jest liczbą pierwszą, więc można przerwać pętlę
                }
            }

            // Wyświetlenie wyniku
            if ($is_prime) {
                echo "<p>Liczba $number jest liczbą pierwszą.</p>";
            } else {
                echo "<p>Liczba $number nie jest liczbą pierwszą.</p>";
            }

            // Wyświetlenie liczby iteracji
            echo "<p>Liczba iteracji potrzebna do sprawdzenia: $iterations</p>";
        } else {
            echo "<p>Podana wartość nie jest liczbą całkowitą dodatnią.</p>";
        }
    } else {
        echo "<p>Nie przesłano liczby do sprawdzenia.</p>";
    }
} else {
    echo "<p>Błąd przetwarzania formularza.</p>";
}
?>
