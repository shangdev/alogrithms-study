<?php

function insertionSort(&$arr) {
    $len = count($arr);

    for ($j = 1; $j < $len; $j++) {
        $p = $arr[$j]; // $p表示指针
        $i = $j - 1;
        
        while ($i >= 0 && $arr[$i] > $p) {
            $arr[$i + 1] = $arr[$i];
            $i--;
        }
        
        $arr[$i + 1] = $p;
    }
    
    return $arr;
}

$arr = [2, 66, 32, 1, 45, 12];

insertionSort($arr);
print_r($arr);
