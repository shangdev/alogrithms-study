# 最大子数组问题

---

## 暴力求解法

> 从第一个元素向后累加，每次累加后与之前的最大和（$maxSum）比较，保留最大值。
> 再从第二个元素向后累加，以此类推。

代码：

```php
function findMaximumSubarray($A) {
    $maxSum = 0;
    $len = count($A);

    for ($i = 0; $i < $len; $i++) {
        $curSum = 0;
        
        for ($j = $i; $j < $len; $j++) {
            $curSum += $A[$j];
            
            if ($curSum > $maxSum) {
                $maxSum = $curSum;
                $maxLeft = $i;
                $maxRight = $j;
            }
        }
    }
    
    return [
        $maxLeft,
        $maxRight,
        $maxSum
    ];
}
```

测试：

```php
$A = [13,-3,-25,20,-3,-16,-23,18,20,-7,12,-5,-22,15,-4,7];
print_r(findMaximumSubarray($A));
```

算法复杂度：O(n^2)；效率最低。

## 分治求解法

> 假定寻找子数组 A[low, high] 的最大子数组，则根据分治策略，我们将子数组划分为两个规模尽量相等的子数组，即找到子数组的中央位置，记为 mid。则最大子数组必然出现以下三种情况：
>
> 1. 完全位于子数组 A[low, mid] 中；
> 2. 完全位于子数组 A[mid + 1, high] 中；
> 3. 跨越了中点，包含左右子数组中靠近中点的部分。

核心算法：

```php
 // 第三种情况
function findMaxCrossingSubarray(&$A, $low, $mid, $high){
    // 获取左子数组最大值和下标元组
    $leftSum = -PHP_INT_MAX;
    $sum = 0;
    for($i = $mid; $i >= $low; $i--) {
        $sum = $sum + $A[$i];
        if ($sum > $leftSum) {
            $leftSum = $sum;
            $maxLeft = $i;
        }
    }
    
    // 获取右子数组最大值和下标元组
    $rightSum = -PHP_INT_MAX;
    $sum = 0;
    for($j = $mid + 1; $j <= $high; $j++) {
        $sum = $sum + $A[$j];
        if ($sum > $rightSum) {
            $rightSum = $sum;
            $maxRight = $j;
        }
    }
    
    return [
        $maxLeft,
        $maxRight,
        $leftSum + $rightSum,
    ];
}

// 分治思想求解最大子数组
function findMaximumSubarray(&$A, $low, $high) {
    if ($low === $high) {
        // 递归到最后的情况
        return [$low, $high, $A[$low]];
    } else {
        $mid = (int)floor(($low + $high) / 2); // 转为整型，否则递归到最后判断使用 === 时陷入死循环
        
        // 递归获取最大子数组
        list($leftLow, $leftHigh, $leftSum) = findMaximumSubarray($A, $low, $mid);
        list($rightLow, $rightHigh, $rightSum) = findMaximumSubarray($A, $mid + 1, $high);
        list($crossLow, $crossHigh, $crossSum) = findMaxCrossingSubarray($A, $low, $mid, $high);
        
        // 返回最大子数组
        if ($leftSum >= $rightSum && $leftSum >= $crossSum) {
            return [
                $leftLow,
                $leftHigh,
                $leftSum,
            ];
        } else if ($rightSum >= $leftSum && $rightSum >= $crossSum) {
            return [
                $rightLow,
                $rightHigh,
                $rightSum,
            ];
        } else {
            return [
                $crossLow,
                $crossHigh,
                $crossSum,
            ];
        }
    }
}
```

测试：

```php
$A = [13,-3,-25,20,-3,-16,-23,18,20,-7,12,-5,-22,15,-4,7];
print_r(findMaximumSubarray($A, 0, 15));
```

算法复杂度分析：

当 n=1 时，执行时间为 T(1) = O(1);  
当 n>1 时，执行时间为 T(n) = 2T(n/2) + O(n) ;

求解，得出算法复杂度为：O(nlgn)；效率次之。

## 线性时间法求解

> 最大子数组第一个下标元组一定是正数;
>
> 因为元素有正有负，所以最大子数组之和一定大于 0.

代码：

```php
function findMaximumSubarray($A) {
    $maxLeft = 0;
    $maxRight = 0;
    $maxSum = 0;
    $curSum = 0;
    $len = count($A);

    for($i = 0; $i < $len; $i++) {
        $curSum += $A[$i];
        
        if($curSum > $maxSum) {
            $maxSum = $curSum;
            $maxRight = $i;
        }
        
        // 累加之和小于 0，故最大子数组不可能包含前面的元素，所以从下个元素（$maxLeft = $i + 1）重新开始累加
        if ($curSum < 0) {
            $curSum = 0;
            $maxLeft = $i + 1;
        }
    }
    
    return [
        $maxLeft,
        $maxRight,
        $maxSum
    ];
}
```

测试：

```php
$A = [13,-3,-25,20,-3,-16,-23,18,20,-7,12,-5,-22,15,-4,7];
print_r(findMaximumSubarray($A));
```

算法复杂度：O(n)；效率最优。