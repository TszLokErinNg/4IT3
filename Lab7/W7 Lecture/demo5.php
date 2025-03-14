<?php

$age = 20;

if ($age >= 18) {
    echo "You are an adult. <br/>";
} elseif ($age >= 13) {
    echo "You are a teenager. <br/>";
} else {
    echo "You are a child. <br/>";
}

$day = "Mon";

switch ($day) {
    case "Mon":
        echo "Monday <br/>";
        break;
    case "Tue":
        echo "Tuesday <br/>";
        break;
    default:
        echo "Some other day <br/>";
}

for ($i = 0; $i < 5; $i++) {
    echo "The number is: $i<br/>";
}

$i = 0;
while ($i < 5) {
    echo "The number is: $i<br/>";
    $i++;
}

$i = 0;
do {
    echo "The number is: $i<br/>";
    $i++;
} while ($i < 5);

?>