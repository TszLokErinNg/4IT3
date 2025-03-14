<?php
$firstName = "John";
$lastName = "Doe";
$fullName = $firstName . " " . $lastName; // Concatenates with a space in between

echo "$fullName <br/>"; // Outputs: John Doe

$day = 12;
$dateString = "Today is February " . $day;

echo "$dateString <br/>"; // Outputs: Today is February 12


$y = 12 . "12"; // Both operands are treated as strings during concatenation

echo "$y <br/>"; // Outputs: "1212"

$x = "Hello, World!";
echo "$x[7] <br/>"; // Outputs: W

$text = "I love ";
$text .= "PHP."; // Appends "PHP." to the existing string

echo "$text <br/>"; // Outputs: I love PHP