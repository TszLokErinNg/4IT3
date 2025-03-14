<?php
$x = true;
$y = false;

if ($x && $y) {
    echo "Both are true <br/>";
} else {
    echo "At least one is false <br/>";
}

if ($x || $y) {
    echo "At least one is true <br/>";
} else {
    echo "Both are false <br/>";
}

if ($x xor $y) {
    echo "One is true and one is false <br/>";
} else {
    echo "Both are true or both are false <br/>";
}

if (!$y) {
    echo "y is false";
}
?>