<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynik</title>
</head>
<body>
    <h2>Wynik kalkulator NASA</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operation = $_POST["operation"];
        
        switch ($operation) {
            case "add":
                $result = $num1 + $num2;
                $operation_name = "Dodawanie";
                break;
            case "subtract":
                $result = $num1 - $num2;
                $operation_name = "Odejmowanie";
                break;
            case "multiply":
                $result = $num1 * $num2;
                $operation_name = "Mnożenie";
                break;
            case "divide":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                    $operation_name = "Dzielenie";
                } else {
                    echo "Nie można dzielić przez zero!";
                    exit;
                }
                break;
            default:
                echo "Niepoprawne działanie!";
                exit;
        }
        
        echo "<p>Wynik działania na podstawie kalkulatora z NASA: {$operation_name} dla liczby {$num1} i {$num2} wynosi: {$result}</p>";
    }
    ?>
</body>
</html>
