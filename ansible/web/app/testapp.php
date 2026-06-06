<?php
set_time_limit(0);
ignore_user_abort(true);

$x = 0;
for ($j = 0; $j < 200; $j++) {
    for ($i = 0; $i < 1000000; $i++) {
        $x += sqrt($i);
    }
}
echo $x;
?>