<?php session_start(); ?>

<?php

function quickSort(array $array)
{
    echo '<pre>';
    if (count($array) < 2) {
        return $array;
    } else {
        $pivot = $array[0];
        $less = [];

        foreach ($array as $num) {
            if ($num < $pivot) {
                $less[] = $num;
            }
        }

        $greater = [];

        foreach ($array as $num) {
            if ($num > $pivot) {
                $greater[] = $num;
            }
        }

        return array_merge(quickSort($less), [$pivot], quickSort($greater));
    }
}
