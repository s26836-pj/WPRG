<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podsumowanie rezerwacji</title>
</head>
<body>
    <h2>Podsumowanie rezerwacji</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p>Liczba osób: {$_POST['number_of_guests']}</p>";
        echo "<p>Imię: {$_POST['first_name']}</p>";
        echo "<p>Nazwisko: {$_POST['last_name']}</p>";
        echo "<p>Adres: {$_POST['address']}</p>";
        echo "<p>Numer karty kredytowej: {$_POST['credit_card']}</p>";
        echo "<p>E-mail: {$_POST['email']}</p>";
        echo "<p>Data pobytu: {$_POST['stay_date']}</p>";
        echo "<p>Godzina przyjazdu: {$_POST['arrival_time']}</p>";
        echo "<p>Dodatkowe łóżko dla dziecka: " . ($_POST['extra_bed'] ? 'Tak' : 'Nie') . "</p>";
        echo "<p>Udogodnienia: ";
        if(isset($_POST['amenities'])) {
            echo implode(", ", $_POST['amenities']);
        } else {
            echo "Brak";
        }
        echo "</p>";

        if ($_POST['number_of_guests'] > 1) {
            echo "<h3>Dane dodatkowych osób:</h3>";
            for ($i = 0; $i < $_POST['number_of_guests'] - 1; $i++) {
                $guest_number = $i + 1;
                echo "<p><strong>Osoba $guest_number:</strong></p>";
                echo "<p>Imię: {$_POST['guest_first_name'][$i]}</p>";
                echo "<p>Nazwisko: {$_POST['guest_last_name'][$i]}</p>";
                echo "<p>Adres: {$_POST['guest_address'][$i]}</p>";
            }
        }
    } else {
        echo "Błąd przetwarzania formularza.";
    }
    ?>
</body>
</html>
