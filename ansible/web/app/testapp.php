<?php

$x = 0;

for ($j = 0; $j < 50; $j++) {
    for ($i = 0; $i < 1000000; $i++) {
        $x += sqrt($i);
    }
}

echo $x;
?>