<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obsługa katalogów</title>
</head>
<body>
    <h2>Obsługa katalogów</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="path">Ścieżka:</label>
        <input type="text" id="path" name="path" required>
        <br><br>
        <label for="directory">Nazwa katalogu:</label>
        <input type="text" id="directory" name="directory" required>
        <br><br>
        <label for="operation">Operacja:</label>
        <select id="operation" name="operation">
            <option value="read">Odczytanie elementów</option>
            <option value="delete">Usunięcie katalogu</option>
            <option value="create">Stworzenie katalogu</option>
        </select>
        <br><br>
        <button type="submit">Wykonaj operację</button>
    </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = $_POST['path'];
    $directory = $_POST['directory'];
    $operation = $_POST['operation'];

    // Wywołanie odpowiedniej funkcji w zależności od wybranej operacji
    if ($operation == 'read') {
        echo "<h3>Lista elementów w katalogu:</h3>";
        readDirectory($path, $directory);
    } elseif ($operation == 'delete') {
        echo "<h3>Usunięto katalog:</h3>";
        deleteDirectory($path, $directory);
    } elseif ($operation == 'create') {
        echo "<h3>Stworzono katalog:</h3>";
        createDirectory($path, $directory);
    }
}
?>

<?php
function readDirectory($path, $directory) {
    $fullPath = $path . '/' . $directory;
    
    if(is_dir($fullPath)) {
        $elements = scandir($fullPath);
        foreach($elements as $element) {
            if($element != '.' && $element != '..') {
                echo $element . "<br>";
            }
        }
    } else {
        echo "Katalog nie istnieje.";
    }
}

function deleteDirectory($path, $directory) {
    $fullPath = $path . '/' . $directory;
    
    if(is_dir($fullPath)) {
        if(count(scandir($fullPath)) == 2) {
            rmdir($fullPath);
            echo "Katalog został usunięty.";
        } else {
            echo "Katalog nie jest pusty.";
        }
    } else {
        echo "Katalog nie istnieje.";
    }
}

function createDirectory($path, $directory) {
    $fullPath = $path . '/' . $directory;
    
    if(!is_dir($fullPath)) {
        mkdir($fullPath);
        echo "Katalog został stworzony.";
    } else {
        echo "Katalog już istnieje.";
    }
}
?>
</body>
</html>
