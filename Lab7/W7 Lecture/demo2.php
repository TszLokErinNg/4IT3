<?php
$x = 5.4;      // double
$y = "5.4";    // string

// Loose comparison - true because the values are equal when type conversion occurs
if ($x == $y) {
    echo "x == y is true <br/>";
} else {
    echo "x == y is false <br/>";
}

// Strict comparison - false because the types are different
if ($x === $y) {
    echo "x === y is true <br/>";
} else {
    echo "x === y is false <br/>";
}

$str1 = "apple";
$str2 = "banana";

// Lexical string comparison
if ($str1 < $str2) {
    echo "$str1 comes before $str2 <br/>";
} else {
    echo "$str1 comes after $str2 <br/>";
}


?>