<?php
/**
 * General Function terkait php
 */


/**
 * Uses random_int as core logic and generates a random string
 * random_int is a pseudorandom number generator
 *
 * @param int $length
 * @return string
 */
function getRandomStringRandomInt($length = 8)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pieces = [];
    $max = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++ $i) {
        $pieces[] = $stringSpace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

?>