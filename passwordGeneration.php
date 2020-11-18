<?php

function generatePasswordFromSeed($seed) {

    srand($seed);

    $output = "";

    for ($i = 0; $i < 8; $i++) {

        $output .= chr(rand(65,122));

    }

    return $output;

}

?>