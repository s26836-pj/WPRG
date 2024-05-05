<!DOCTYPE html>
<html>
<head>
    <title>Lista odnośników</title>
</head>
<body>

<h2>Lista odnośników</h2>

<ul>
<?php
$file_path = "lista_odnosnikow.txt";

if (!file_exists($file_path)) {
    $default_content = "http://example.com/;Przykładowy odnośnik\n";
    file_put_contents($file_path, $default_content);
}

$lines = file($file_path, FILE_IGNORE_NEW_LINES);

foreach ($lines as $line) {
    list($address, $description) = explode(";", $line);
    echo "<li><a href=\"$address\">$description</a></li>";
}
?>
</ul>

</body>
</html>
