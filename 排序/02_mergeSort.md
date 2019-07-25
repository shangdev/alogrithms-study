# 归并排序

---

## 分治求解法

正序：

```php
// 分解
function mergeSort(&$A, $p, $r) {
    if ($p < $r) {
        $q = floor(($p + $r) / 2); // 向下取整（ceil：向上取整)
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
    
    // 设置哨兵
    $L[$n1] = PHP_INT_MAX;
    $R[$n2] = PHP_INT_MAX;
    
    // 重置$i和$j的值
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
```

逆序：哨兵设置最小值，如1；元素比较修改为 $L[$i] >= $R[$j]

测试：

```php
// 生成10个数，打乱
$arr = range(1, 10);
shuffle($arr);

mergeSort($arr, 0, count($arr) - 1);
print_r($arr);
```

算法复杂度：O(nlgn)
