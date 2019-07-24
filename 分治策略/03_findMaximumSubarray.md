# 最大子数组问题

---

## 暴力破解法

## 分治法

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
    for($i = $mid; $i >= 0; $i--) {
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
        $mid = floor(($low + $high) / 2);
        
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

算法复杂度：O(nlgn)

## 线性时间算法
