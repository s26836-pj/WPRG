<!DOCTYPE html>
<html>
<head>
    <title>Reverse Order of Lines in a Text File</title>
</head>
<body>

<h2>Choose a file to reverse the order of lines:</h2>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToReverse">
    <input type="submit" name="submit" value="Reverse Order">
</form>

<?php
if(isset($_POST['submit'])){
    $file_name = $_FILES['fileToReverse']['name'];
    $file_tmp = $_FILES['fileToReverse']['tmp_name'];
    
    if($file_name){
        $lines = file($file_tmp);
        echo "Original content:<br>";
        echo "<pre>";
        print_r($lines);
        echo "</pre>";

        $lines = array_reverse($lines);
        echo "Reversed content:<br>";
        echo "<pre>";
        print_r($lines);
        echo "</pre>";
        
        $destination = 'reversed_' . $file_name; 
        if(move_uploaded_file($file_tmp, $destination)){ 
            if(file_put_contents($destination, implode("", $lines))){ 
                echo "Successfully reversed the order of lines in file: " . $file_name;
            } else {
                echo "There was a problem while saving the file.";
            }
        } else {
            echo "There was a problem while moving the file.";
        }
    } else {
        echo "Please choose a file to process.";
    }
}
?>


</body>
</html>
