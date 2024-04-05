<?php

$text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
galley of type and scrambled it to make a type specimen book. It has survived not only five
centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was
popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
and more recently with desktop publishing software like Aldus PageMaker including versions of
Lorem Ipsum.";

$text = preg_replace('/[^\w\s]/', '', $text);

$words = explode(" ", $text);

$assoc_array = [];

foreach ($words as $index => $word) {
    if ($index % 2 === 0) {
        if (isset($words[$index + 1])) {
            $assoc_array[$word] = $words[$index + 1];
        }
    }
}

foreach ($assoc_array as $key => $value) {
    echo $key . " : " . $value . "<br>";
}
?>
