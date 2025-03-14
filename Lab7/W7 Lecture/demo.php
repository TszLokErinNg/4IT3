<?php
$x = 10;
$y = 3;

$sum = $x + $y; // 13

$difference = $x - $y; // 7

$product = $x * $y; // 30

$quotient = $x / $y; // 3.33333333333

$modulus = $x % $y; // 1

echo "$x  <br />";
echo "$y <br />";
echo "Sum: $sum <br />";
echo "Difference: $difference<br />";
echo "Product: $product<br />";
echo "Quotient: $quotient<br />";
echo "Modulus: $modulus<br />";

$x++; // 11
echo "Increment: $x <br />";
$x--;  // 10
echo "Decrement: $x <br />";


$x += 5; //15
echo "Addition Assignment: $x<br />";

$x -= 3;  //12
echo "Subtraction Assignment: $x<br />";

$x *= 2;  //24
echo "Multiplication Assignment: $x<br />";

$x /= 4;  //6
echo "Division Assignment: $x<br />";

$y = (5 + 3) * 2;  //16

echo "Changed Order: $y<br />";

?>
