<?php

/**
 * 插入排序（正序）
 * 
 * 时间复杂度：O(n^2)
 */
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

// 生成100个数，打乱
$arr = range(1, 100);
shuffle($arr);

insertionSort($arr);
print_r($arr);
