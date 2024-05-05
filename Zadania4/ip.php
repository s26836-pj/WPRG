<?php
// Pobranie adresu IP użytkownika
$user_ip = $_SERVER['REMOTE_ADDR'];

// Plik z listą dozwolonych adresów IP
$allowed_ips_file = 'allowed_ips.txt';

// Odczytanie adresów IP z pliku
$allowed_ips = file($allowed_ips_file, FILE_IGNORE_NEW_LINES);

// Sprawdzenie, czy adres IP użytkownika jest na liście dozwolonych
if (in_array($user_ip, $allowed_ips)) {
    // Adres IP jest na liście dozwolonych, wyświetlenie specjalnej strony dla tych użytkowników
    include 'allowed_page.php'; // Załóżmy, że to jest nazwa pliku specjalnej strony
} else {
    // Adres IP nie jest na liście dozwolonych, wyświetlenie standardowej strony
    include 'normal_page.php'; // Załóżmy, że to jest nazwa pliku standardowej strony
}
?>
