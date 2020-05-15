<?php
declare(strict_types=1);

namespace JeanSouzaK\Duf\Tool;


class ArrayTool
{

    /**
     * Recursive in array
     * @author jwueller <https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array/4128377#4128377>     
     */
    public static function inArrayRecursive($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::inArrayRecursive($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }

}
