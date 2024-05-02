<?php
if(isset($_GET['birthdate'])) {
    $birthdate = $_GET['birthdate'];
    
    // Funkcja do sprawdzenia dnia tygodnia
    function dzien_tygodnia($data) {
        $dzien = date('l', strtotime($data));
        return $dzien;
    }
    
    // Funkcja do obliczenia ukończonych lat
    function lata_urodzin($data) {
        $dzis = new DateTime();
        $urodziny = new DateTime($data);
        $roznica = $dzis->diff($urodziny);
        return $roznica->y;
    }
    
 // Funkcja do obliczenia dni do najbliższych przyszłych urodzin
function dni_do_urodzin($data) {
    $dzis = new DateTime();
    $urodziny = new DateTime($data);
    $urodziny->modify('+' . (date('Y') - $urodziny->format('Y')) . ' years');
    if ($urodziny < $dzis) {
        $urodziny->modify('+1 year');
    }
    $roznica = $dzis->diff($urodziny);
    return $roznica->days + 1; // dodajemy jeden dzień, aby uwzględnić również dzień urodzin
}

if(isset($_GET['birthdate']) && isset($_GET['month'])) {
    $birthdate = $_GET['birthdate'];
    $month = $_GET['month'];
    
    // Funkcja do obliczenia znaku zodiaku
    function znak_zodiaku($dzien, $miesiac) {
        if (($miesiac == 3 && $dzien > 20) || ($miesiac == 4 && $dzien < 20)) {
            return 'Baran';
        } elseif (($miesiac == 4 && $dzien > 19) || ($miesiac == 5 && $dzien < 21)) {
            return 'Byk';
        } elseif (($miesiac == 5 && $dzien > 20) || ($miesiac == 6 && $dzien < 21)) {
            return 'Bliźnięta';
        } elseif (($miesiac == 6 && $dzien > 20) || ($miesiac == 7 && $dzien < 23)) {
            return 'Rak';
        } elseif (($miesiac == 7 && $dzien > 22) || ($miesiac == 8 && $dzien < 23)) {
            return 'Lew';
        } elseif (($miesiac == 8 && $dzien > 22) || ($miesiac == 9 && $dzien < 23)) {
            return 'Panna';
        } elseif (($miesiac == 9 && $dzien > 22) || ($miesiac == 10 && $dzien < 23)) {
            return 'Waga';
        } elseif (($miesiac == 10 && $dzien > 22) || ($miesiac == 11 && $dzien < 22)) {
            return 'Skorpion';
        } elseif (($miesiac == 11 && $dzien > 21) || ($miesiac == 12 && $dzien < 22)) {
            return 'Strzelec';
        } elseif (($miesiac == 12 && $dzien > 21) || ($miesiac == 1 && $dzien < 20)) {
            return 'Koziorożec';
        } elseif (($miesiac == 1 && $dzien > 19) || ($miesiac == 2 && $dzien < 19)) {
            return 'Wodnik';
        } else {
            return 'Ryby';
        }
    }

    // Wywołanie funkcji i wyświetlenie wyników
    $dzien_tygodnia = dzien_tygodnia($birthdate);
    $lata_urodzin = lata_urodzin($birthdate);
    $znak_zodiaku = znak_zodiaku(date('d', strtotime($birthdate)), $month);
    $dni_do_urodzin = dni_do_urodzin($birthdate);

    echo "Urodziłeś/aś się w dniu: $dzien_tygodnia <br>";
    echo "Masz $lata_urodzin lat <br>";
    echo "Twój znak zodiaku: $znak_zodiaku <br>";
    echo "Do Twoich najbliższych urodzin pozostało $dni_do_urodzin dni";
}

    
    $dzien_tygodnia = dzien_tygodnia($birthdate);
    $lata_urodzin = lata_urodzin($birthdate);
    $dni_do_urodzin = dni_do_urodzin($birthdate);
    
    echo "Urodziłeś/aś się w dniu: $dzien_tygodnia <br>";
    echo "Masz $lata_urodzin lat <br>";
    echo "Do Twoich najbliższych urodzin pozostało $dni_do_urodzin dni";
}
?>
