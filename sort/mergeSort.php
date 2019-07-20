<?php
/**
 * 归并排序（正序）（分治法）
 * 
 * 时间复杂度：O(nlgn)
 */

// 分解
function mergeSort(&$A, $p, $r) {
    if ($p < $r) {
        $q = floor(($p + $r) / 2);
        mergeSort($A, $p, $q);
        mergeSort($A, $q + 1, $r);
        merge($A, $p, $q, $r);
    }
}

// 解决 -> 合并
function merge(&$A, $p, $q, $r) {
    $n1 = $q - $p + 1;
    $n2 = $r - $q;

    $L = [];
    $R = [];
    
    for ($i = 0; $i < $n1; $i++) {
        $L[$i] = $A[$p + $i];
    }
    
    for ($j = 0; $j < $n2; $j++) {
        $R[$j] = $A[$q + $j + 1];
    }
    
    $L[$n1] = 10000;
    $R[$n2] = 10000;
    
    $i = 0;
    $j = 0;
    
    for ($k = $p; $k <= $r; $k++) {
        if ($L[$i] <= $R[$j]) {
            $A[$k] = $L[$i];
            $i++;
        } else {
            $A[$k] = $R[$j];
            $j++;
        }
    }
}

// 生成9999个数，打乱
$arr = range(0, 9999);
shuffle($arr);

mergeSort($arr, 0, count($arr) - 1);

print_r($arr);
