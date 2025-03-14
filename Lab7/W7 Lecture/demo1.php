<?php
$x = 2;
$power = pow($x, 3.3);
echo "pow(2, 3.3): $power <br/>";

$x = 16;
$squareRoot = sqrt($x);
echo "sqrt(16): $squareRoot <br/>";

$minValue = min(2, 3, 1, 6, 7);
$maxValue = max(2, 3, 1, 6, 7);
echo "min(2, 3, 1, 6, 7): $minValue <br/>";
echo "max(2, 3, 1, 6, 7): $maxValue <br/>";

$x = -15;
$absoluteValue = abs($x);
echo "abs(-15): $absoluteValue <br/>";

$angle = pi(); // π radians
$sinValue = sin($angle); // Sine of π radians
$cosValue = cos($angle); // Cosine of π radians
$tanValue = tan($angle / 4); // Tangent of π/4 radians
echo "sin(π): $sinValue <br/>";
echo "cos(π): $cosValue <br/>";
echo "tan(π/4): $tanValue <br/>";

$x = 10;
$logValue = log($x); // Natural logarithm of 10
$log10Value = log10($x); // Base-10 logarithm of 10
echo "log(10): $logValue <br/>";
echo "log10(10): $log10Value <br/>";

$x = 2;
$expValue = exp($x); // e^2
echo "exp(2): $expValue <br/>";

$start = 1;
$finish = 100;
$randomNumber = rand($start, $finish); // Generates a random number between 1 and 100
echo "rand(1, 100): $randomNumber <br/>";
?>
