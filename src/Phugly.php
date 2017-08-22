<?php

/*
 * Copyright (c) 2017 Cully Larson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Phugly;

const dumpM = __NAMESPACE__ . '\dumpM';

/**
 * Dump a variable, with a message.  Will return the variable, so can compose
 * this function.
 *
 * Curried.
 *
 * @param string $msg
 * @param mixed $var
 * @return mixed Will return the provided var.
 */
function dumpM(...$args) {
    $dump = curry(function($msg, $var) {
        echo "<pre>$msg -------\n\n";
        var_dump($var);
        echo "</pre>";

        return $var;
    });

    return call_user_func_array($dump, $args);
}

const dump = __NAMESPACE__ . '\dump';

/**
 * Dump a variable provided.  Will return the variable, so can compose
 * this function.
 *
 * Curried.
 *
 * @param mixed $var
 * @return mixed Will return the provided var.
 */
function dump($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";

    return $var;
}

const map = __NAMESPACE__ . '\map';

/**
 * A curried map function. Works on arrays and any object with a map function.
 *
 * @param callable  $cb
 * @param array|Functor     $arr
 *
 * @return array|Functor|callable If called with both parameters, will just do array_map/Functor::map.  If called
 * just with the callback, will return a function that takes an array|Functor and will return the
 * result of array_map/Functor::map, using the original callback (i.e. it is curried).
 */
function map(...$args) {
    $map = curry(function($f, $x) {
        return is_array($x)
            ? array_map($f, $x)
            : $x->map($f);
    });

    return call_user_func_array($map, $args);
}

const mapKV = __NAMESPACE__ . '\mapKV';

/**
 * Maps over an array, but provides the key and value of each item to the callback function.  E.g. cb($key, $val).
 * This function is curried.
 *
 * @param callable  $f
 * @param array     $arr
 *
 * @return mixed|callable
 */
function mapKV(...$args) {
    $mapKV = curry(function($f, $arr) {
        // in order to preserve the ordering, we need to reverse the array first (because the reduceKV/setAt below will reverse the array)
        $arrReversed = reverse($arr);

        // array_map does not preserve the original array keys, if you pass more than one array, so we need
        // to simulate array_map to preserve them
        return reduceKV(function($acc, $key, $val) use ($f) {
            return setAt($key, $f($key, $val), $acc);
        }, [], $arrReversed);
    });

    return call_user_func_array($mapKV, $args);
}

const filter = __NAMESPACE__ . '\filter';

/**
 * A curried filter function.
 *
 * @param callable  $cb
 * @param array     $arr
 *
 * @return array|callable  If called with both parameters, will just do array_filter.  If called
 * with just the callback, will return a function that takes an array and will return the result
 * of array_filter, using the original callback (i.e. it's curried)
 */
function filter(...$args) {
    return sizeof($args) === 2
        ? call_user_func_array('array_filter', [$args[1], $args[0]])
        : function($arr) use ($args) { return call_user_func_array('array_filter', [$arr, $args[0]]); };
}

const filterK = __NAMESPACE__ . '\filterK';

/**
 * Similar to 'filter', except the callback will filter based on the key of the array, not the value.
 * This is the functionality of array_filter, with the ARRAY_FILTER_USE_KEY flag.
 *
 * @param callable  $cb
 * @param array     $arr
 *
 * @return array|callable  If called with both parameters, will just do array_filter.  If called
 * with just the callback, will return a function that takes an array and will return the result
 * of array_filter, using the original callback (i.e. it's curried)
 */
function filterK(...$args) {
    return sizeof($args) === 2
        ? call_user_func_array('array_filter', [$args[1], $args[0], ARRAY_FILTER_USE_KEY])
        : function($arr) use ($args) { return call_user_func_array('array_filter', [$arr, $args[0], ARRAY_FILTER_USE_KEY]); };
}

const reduce = __NAMESPACE__ . '\reduce';

/**
 * A curried reduce function.
 *
 * @param callable      $cb
 * @param mixed         $initial
 * @param array         $arr
 *
 * @return mixed|callable If called with all three parameters, will just do array_reduce. Otherwise
 * will curry down.
 */
function reduce(...$args) {
    $reduce = curry(function($cb, $initial, $arr) {
        return array_reduce($arr, $cb, $initial);
    });

    return call_user_func_array($reduce, $args);
}

const reduceKV = __NAMESPACE__ . '\reduceKV';


/**
 * Like reduce, except that the key and value are passed to the callback function (i.e. $cb($acc, $key, $val)).
 *
 * @param callable      $cb
 * @param mixed         $initial
 * @param array         $arr
 *
 * @return mixed|callable
 */
function reduceKV(...$args) {
    $reduceKV = curry(function($cb, $initial, $arr) {
        return array_reduce(array_keys($arr), function($acc, $key) use ($cb, $arr) {
            return $cb($acc, $key, $arr[$key]);
        }, $initial);
    });

    return call_user_func_array($reduceKV, $args);
}

const id = __NAMESPACE__ . '\id';

/**
 * Return value itself, without any modifications.
 *
 * @param mixed $x
 * @return mixed
 */
function id($x) {
    return $x;
}

const curry = __NAMESPACE__ . '\curry';

/**
 * Return a curryied version of the given function. You can decide if you also
 * want to curry optional parameters or not.
 *
 * This is copied from:  https://github.com/lstrojny/functional-php
 *
 * @param callable $function the function to curry
 * @param bool $required curry optional parameters ?
 * @return callable a curryied version of the given function
 */
function curry(callable $function, $required = true) {
    if (method_exists('Closure','fromCallable')) {
        $reflection = new \ReflectionFunction(\Closure::fromCallable($function));
    }
    else {
        if(is_string($function) && strpos($function, '::', 1) !== false) {
            $reflection = new \ReflectionMethod($function);
        }
        else if(is_array($function) && count($function) === 2) {
            $reflection = new \ReflectionMethod($function[0], $function[1]);
        }
        else if(is_object($function) && method_exists($function, '__invoke')) {
            $reflection = new \ReflectionMethod($function, '__invoke');
        }
        else {
            $reflection = new \ReflectionFunction($function);
        }
    }

    $count = $required ?
        $reflection->getNumberOfRequiredParameters() :
        $reflection->getNumberOfParameters();

    return curryN($count, $function);
}

const curryN = __NAMESPACE__ . '\curryN';

/**
 * Return a version of the given function where the $count first arguments are curryied.
 *
 * No check is made to verify that the given argument count is either too low or too high.
 * If you give a smaller number you will have an error when calling the given function. If
 * you give a higher number, arguments will simply be ignored.
 *
 * This is copied from:  https://github.com/lstrojny/functional-php
 *
 * @param int $count number of arguments you want to curry
 * @param callable $function the function you want to curry
 * @return callable a curryied version of the given function
 */
function curryN($count, callable $function) {
    $accumulator = function(array $arguments) use ($count, $function, &$accumulator) {
        return function(...$newArguments) use ($count, $function, $arguments, $accumulator) {
            $arguments = array_merge($arguments, $newArguments);
            if($count <= count($arguments)) {
                return call_user_func_array($function, $arguments);
            }
            return $accumulator($arguments);
        };
    };

    return $accumulator([]);
}

const compose = __NAMESPACE__ . '\compose';

/**
 * Return a new function that composes all functions in $functions into a single callable.
 *
 * This function is mostly taken from the https://github.com/lstrojny/functional-php implementation.
 *
 * @param callable[] $functions
 * @return callable
 */
function compose(...$functions) {
    return array_reduce(
        array_reverse($functions), // need to reverse the array so that it's called right to left
        function($carry, $item) {
            return function($x) use ($carry, $item) {
                return call_user_func($item, $carry($x));
            };
        },
        id
    );
}

const pipe = __NAMESPACE__ . '\pipe';

/**
 * Like compose, but executes functions from left to right.
 *
 * This function is mostly taken from the https://github.com/lstrojny/functional-php implementation.
 *
 * @param callable[] $functions
 * @return callable
 */
function pipe(...$functions) {
    return array_reduce(
        $functions,
        function($carry, $item) {
            return function($x) use ($carry, $item) {
                return call_user_func($item, $carry($x));
            };
        },
        id
    );
}

const setAt = __NAMESPACE__ . '\setAt';

/**
 * Sets the value of an array at a defined index.  Does not mutate the original array, returns a
 * copy.  This function is curried.
 *
 * May change the order of the keys (e.g. if you foreach, you might get a different ordering). But
 * the indexes themselves will be maintained
 *
 * If the provided index doesn't exist, it will be created.
 *
 * @param string|int|array  $idx    An index, or an array of indexes (basically a path of indexes
 * into the sub-array you want to target)
 * @param mixed     $val    Will replace the value found at index with this value.
 * @param array     $arr    Look in this array
 *
 * @return array    The provided array, with the set value (doess not mutate $arr)
 */
function setAt(...$args) {
    $setAt = curry(function($idx, $val, $arr) {
        $idxArr = liftArray($idx);

        return empty($idxArr)
            ? $val
            : [first($idxArr) => setAt(tail($idxArr), $val, getAt(first($idxArr), [], $arr))] + $arr;
    });

    return call_user_func_array($setAt, $args);
}

const getAt = __NAMESPACE__ . '\getAt';

/**
 * Gets the value of an array at a defined index.  This function is curried.
 *
 * If the provided index doesn't exist, the provided default value will be returned
 *
 * @param string|int|array  $idx    An index, or an array of indexes (basically a path of indexes
 * into the sub-array you want to target)
 * @param mixed     $default    If the provided index doesn't exist, this value will be returned
 * @param array     $arr    Look in this array
 *
 * @return mixed    The value found, or the default value.
 */
function getAt(...$args) {
    $getAt = curry(function($idx, $default, $arr) {
        $idxArr = liftArray($idx);

        if(empty($idxArr)) {
            return $arr;
        }
        else {
            $firstIdx = first($idxArr);

            return isset($arr[$firstIdx])
                ? getAt(tail($idxArr), $default, $arr[$firstIdx])
                : $default;
        }
    });

    return call_user_func_array($getAt, $args);
}

const getThese = __NAMESPACE__ . '\getThese';

/**
 * Gets values of the provided keys.  If they don't exist, use the provided default value.
 *
 * @param array $indexesAndDefaults  Keys are the keys to look for in the provided array.  Values are default values to fill in if key is not set in provided array.
 * @param array $arr Get values from this array.
 */
function getThese(...$args) {
    $getThese = curry(function($indexesAndDefaults, $arr) {
        return reduceKV(function($acc, $key, $defaultValue) use ($arr) {
            return isset($arr[$key])
                ? setAt($key, $arr[$key], $acc)
                : setAt($key, $defaultValue, $acc);
        }, [], $indexesAndDefaults);
    });

    return call_user_func_array($getThese, $args);
}

const hasAt = __NAMESPACE__ . '\hasAt';

/**
 * Returns true if the provided index path is set. Doesn't look at the value, so it might be empty; just looks
 * to see if the index is set.
 *
 * @param string|int|array  $idx    An index, or an array of indexes (basically a path of indexes
 * into the sub-array you want to target)
 * @param array     $arr    Look in this array
 *
 * @return bool
 */
function hasAt(...$args) {
    $hasAt = curry(function($idx, $arr) {
        $idxArr = liftArray($idx);

        if(empty($idxArr)) {
            return true;
        }
        else {
            $firstIdx = first($idxArr);

            return isset($arr[$firstIdx])
                ? hasAt(tail($idxArr), $arr[$firstIdx])
                : false;
        }
    });

    return call_user_func_array($hasAt, $args);
}

const doAt = __NAMESPACE__ . '\doAt';

/**
 * Applies the function to the value found at the provided index and sets
 * it to the return value.
 *
 * @param string|int|array  $idx    An index, or an array of indexes (basically a path of indexes
 * @param mixed $deafult If there is no value at the provided index, it will be initialized to this (i.e. and then passed to $f).
 * @param callable $f Apply this function to the found value.
 * @param array $arr
 * @return array
 */
function doAt(...$args) {
    $doAt = curry(function($idx, $default, $f, $arr) {
        return setAt($idx, $f(getAt($idx, $default, $arr)), $arr);
    });

    return call_user_func_array($doAt, $args);
}


const getRand = __NAMESPACE__ . '\getRand';

function getRand($arr) {
    $arrVals = array_values($arr);
    return $arrVals[rand(0, count($arrVals) - 1)];
}

const append = __NAMESPACE__ . '\append';

/**
 * Appends a value to an array at a defined index.  Does not mutate the original array, returns a
 * copy.  This function is curried.
 *
 * May change the order of the keys (e.g. if you foreach, you might get a different ordering). But
 * the indexes themselves will be maintained
 *
 * If the provided index doesn't exist, it will be created.
 *
 * If the value at the provided index is not already an array, it will be turned into an array
 * by putting the value at that index into an array, and then appending the provided value.
 *
 * @param string|int|array|null  $idx    An index, or an array of indexes (basically a path of indexes
 * into the sub-array you want to target).  If null, will just append directly to the provided array.
 * @param mixed     $val    Will append this value, at the provided index.
 * @param array     $arr    Look in this array
 *
 * @return array    The provided array, with the appended value (doess not mutate $arr)
 */
function append(...$args) {
    $append = curry(function($idx, $val, $arr) {
        return appendAll($idx, [$val], $arr);
    });

    return call_user_func_array($append, $args);
}

const appendAll = __NAMESPACE__ . '\appendAll';

/**
 * Appends an array of values, to an array, at an index. It doesn't append the $values array itself,
 * but appends all of the values in the array.  Does not mutate the original array, returns a
 * copy.  This function is curried.
 *
 * May change the order of the keys (e.g. if you foreach, you might get a different ordering). But
 * the indexes themselves will be maintained
 *
 * If the provided index doesn't exist, it will be created.
 *
 * If the value at the provided index is not already an array, it will be turned into an array
 * by putting the value at that index into an array, and then appending the provided values.
 *
 * If the provided values are keys, and conflict with a key already in the array, the provided value
 * will override the value already in the array.
 *
 * @param string|int|array|null  $idx    An index, or an array of indexes (basically a path of indexes
 * into the sub-array you want to target).  If null, will just append directly to the provided array.
 * @param array     $val    Will append these values, at the provided index.
 * @param array     $arr    Look in this array
 *
 * @return array    The provided array, with the appended values (doess not mutate $arr)
 */
function appendAll(...$args) {
    $append = curry(function($idx, $values, $arr) {
        $idxArr = liftArray($idx);

        $firstIdx = first($idxArr);

        if($firstIdx === null) {
            return array_merge($arr, $values);
        }
        else if(sizeof($idxArr) > 1) {
            return [$firstIdx => appendAll(tail($idxArr), $values, getAt($firstIdx, [], $arr))] + $arr;
        }
        else {
            $valAtFirstIdx = getAt($firstIdx, [], $arr);

            return is_array($valAtFirstIdx)
                ? [$firstIdx => array_merge($valAtFirstIdx, $values)] + $arr
                : [$firstIdx => array_merge([$valAtFirstIdx], $values)] + $arr;
        }
    });

    return call_user_func_array($append, $args);
}

const appendV = __NAMESPACE__ . '\appendV';

/**
 * Like the append function, except the value is the last parameter.
 *
 * @param string|int|array|null  $idx
 * @param array     $arr
 * @param mixed     $val
 *
 * @return array
 */
function appendV(...$args) {
    $appendV = curry(function($idx, $arr, $val) {
        return append($idx, $val, $arr);
    });

    return call_user_func_array($appendV, $args);
}

const first = __NAMESPACE__ . '\first';

function first(array $arr) {
    return empty($arr)
        ? null
        : array_values($arr)[0];
}

const firstN = __NAMESPACE__ . '\firstN';

/**
 * Gets the first N items of an array. Preserves array keys.
 *
 * If keys are numeric, they will be preserved, but the 'firstness' is determined
 * by array order, not the numeric order of keys.
 *
 * @param int $n
 * @param array $arr
 * @return array
 */
function firstN(...$args) {
    $firstN = curry(function($n, $arr) {
        return array_slice($arr, 0, $n, true); // the last true preserves numeric keys
    });

    return call_user_func_array($firstN, $args);
}

const lastN = __NAMESPACE__ . '\lastN';

/**
 * Gets the last N items of an array. Preserves array keys.
 *
 * If keys are numeric, they will be preserved, but the 'lastness' is determined
 * by array order, not the numeric order of keys.
 *
 * @param int $n
 * @param array $arr
 * @return array
 */
function lastN(...$args) {
    $lastN = curry(function($n, $arr) {
        $diff = count($arr) - $n;
        $offset = $diff < 0
            ? 0
            : $diff;

        return array_slice($arr, $offset, $n, true); // the last true preserves numeric keys
    });

    return call_user_func_array($lastN, $args);
}

const rest = __NAMESPACE__ . '\rest';

/**
 * Gets all items after the first N.
 *
 * If keys are numeric, they will be preserved, but the order is determined
 * by array order, not the numeric order of keys.
 *
 * @param int $n This is not an index, so providing 0 will give you everything.
 * @param array $arr
 * @return array
 */
function rest(...$args) {
    $rest = curry(function($n, $arr) {
        return array_slice($arr, $n, null, true); // the last true preserves numeric keys
    });

    return call_user_func_array($rest, $args);
}

const last = __NAMESPACE__ . '\last';

function last(array $arr) {
    $vals = array_values($arr);

    return empty($vals)
        ? null
        : $vals[count($vals) - 1];
}

const tail = __NAMESPACE__ . '\tail';

/**
 * Returns an array with all but the first item.
 *
 * @param array $arr
 * @return array
 */
function tail(array $arr) {
    return array_slice($arr, 1);
}

const glue = __NAMESPACE__ . '\glue';

/**
 * A curried version of PHP's standard implode/join function.
 *
 * @param string $sep
 * @param array $pieces
 *
 * @return string
 */
function glue(...$args) {
    $glue = curry(function($sep, $pieces) {
        return implode($sep, $pieces);
    });

    return call_user_func_array($glue, $args);
}

const liftArray = __NAMESPACE__ . '\liftArray';

/**
 * Make sure the provided value is an array.  If value is not an array, it will be wrapped
 * in array (i.e. it will be the only value in the array).  If it's already an array, then
 * will just return it.
 *
 * @param mixed $val
 * @return array
 */
function liftArray($val) {
    return is_array($val)
        ? $val
        : [$val];
}

const objProp = __NAMESPACE__ . '\objProp';

/**
 * Gets the requested property from the provided object.  Will return the defaultVal if
 * the property isn't set on the object.
 *
 * @param string $propName
 * @param mixed $defaultVal
 * @param object $obj
 * @return mixed
 */
function objProp(...$args) {
    $objProp = curry(function($propName, $defaultVal, $obj) {
        return isset($obj->$propName)
            ? $obj->$propName
            : $defaultVal;
    });

    return call_user_func_array($objProp, $args);
}

const objProps = __NAMESPACE__ . '\objProps';

/**
 * Grabs multiple property names from an object and returns array where the keys are the
 * property names and the values are the values of the associated proprties.
 *
 * If a property is not set on the object, it will not be included in the result.
 *
 * @param array $propNames
 * @param object $obj
 * @return array
 */
function objProps(...$args) {
    $objProps = curry(function($propNames, $obj) {
        if(sizeof($propNames) === 0) {
            return [];
        }
        else {
            $firstProp = first($propNames);

            $arr = isset($obj->$firstProp)
                ? [$firstProp => $obj->$firstProp]
                : [];

            return array_merge($arr, objProps(tail($propNames), $obj));
        }
    });

    return call_user_func_array($objProps, $args);
}

const notEmpty = __NAMESPACE__ . '\notEmpty';

/**
 * Returns true if value is not empty (uses PHP's standard lib empty function).
 *
 * @param mixed $val
 * @return bool
 */
function notEmpty($val) {
    return !empty($val);
}

const isEmpty = __NAMESPACE__ . '\isEmpty';

/**
 * Returns true if value is empty (uses PHP's standard lib empty function).
 *
 * @param mixed $val
 * @return bool
 */
function isEmpty($val) {
    return empty($val);
}

const toInt = __NAMESPACE__ . '\toInt';

/**
 * Casts the value to an int and returns it.
 *
 * @param mixed $val
 * @return int
 */
function toInt($val) {
    return (int) $val;
}

const always = __NAMESPACE__ . '\always';

/**
 * Returns a function that always returns the provided value.
 *
 * @param mixed $val
 * @return callable
 */
function always($val) {
    return function() use ($val) {
        return $val;
    };
}

const ifElse = __NAMESPACE__ . '\ifElse';

/**
 * Takes a predicate function (that should return a boolean).  If the return of the predicate is true, will execute
 * the doIf function and return the result.  If the return of the predicate is false, will execute the doElse
 * function and return the result.
 *
 * The last paramter (x) will be passed to all of the provided function (predicate, doIf, and doElse) to allow for
 * composition.
 *
 * Note that you must pass the last parameter (x) for the function to execute.  Simply calling the function without
 * a parameter will just return another funciton (it's the way curry works).
 *
 * @param callable $predicate
 * @param callable $doIf
 * @param callable $doElse
 * @param mixed $x
 * @return mixed
 */
function ifElse(...$args) {
    $ifElse = curry(function($predicate, $doIf, $doElse, $x) {
        return call_user_func($predicate, $x)
            ? call_user_func($doIf, $x)
            : call_user_func($doElse, $x);
    });

    return call_user_func_array($ifElse, $args);
}

const call = __NAMESPACE__ . '\call';

function call(...$args) {
    return call_user_func_array(first($args), tail($args));
}

const repeat = __NAMESPACE__ . '\repeat';

/**
 * Calls the provided function $n times.  Each call will have $x passed to it.
 * The results of each call are returned as an array.
 *
 * @param callable $f
 * @param int $n
 * @param mixed $x
 * @return array
 */
function repeat(...$args) {
    $repeat = curry(function($f, $n, $x) {
        $acc = [];
        for($i=0; $i < $n; $i++) $acc []= $f($x);
        return $acc;
    });

    return call_user_func_array($repeat, $args);
}

const fill = __NAMESPACE__ . '\fill';

/**
 * Creates an array with $n elements, filled with the values returned by the $valF
 * function.  Each call to the $valF function will pass the current index number
 * of the array element being filled.
 *
 * @param callabke $valF
 * @param int $n
 * @return array
 */
function fill(...$args) {
    $fill = curry(function($valF, $n) {
        $res = [];
        for($idx=0; $idx < $n; $idx++) $res []= $valF($idx);
        return $res;
    });

    return call_user_func_array($fill, $args);
}

const bookend = __NAMESPACE__ . '\bookend';

/**
 * Wraps a string or an array in the provided before and after strings/values. If
 * an array is provided, the before and after values will be added to the beginning
 * and end of an array, respectively.
 *
 * @param mixed $before
 * @param mixed $after
 * @param string|array $x
 * @return string|array
 */
function bookend(...$args) {
    $bookend = curry(function($before, $after, $x) {
        return is_array($x)
            ? array_merge([$before], $x, [$after])
            : $before . $x . $after;
    });

    return call_user_func_array($bookend, $args);
}

const inArray = __NAMESPACE__ . '\inArray';

/**
 * @param array $arr
 * @param mixed $x
 * @return bool
 */
function inArray(...$args) {
    $inArray = curry(function($arr, $x) {
        return in_array($x, $arr);
    });

    return call_user_func_array($inArray, $args);
}

const reverse = __NAMESPACE__ . '\reverse';

/**
 * Reverses an array.  Works with associative arrays as well (i.e. the foreach ordering of the array will be reversed).
 *
 * @param array $arr
 * @return array
 */
function reverse($arr) {
    return array_reverse($arr, true);
}

const pairs = __NAMESPACE__ . '\pairs';

/**
 * Takes an associative array and converst each key => value into an array of [key, value].
 *
 * @param array $arr
 * @return array
 */
function pairs($arr) {
    return call(compose(
        'array_values',
        mapKV(function($key, $val) { return [$key, $val]; })
    ), $arr);
}

const flip = __NAMESPACE__ . '\flip';

/**
 * Returns a new function much like the supplied one, except that the first two arguments' order is reversed.
 *
 * @param callable $f
 */
function flip($f) {
    return curry(function($x, $y, ...$args) use ($f) {
        return call_user_func_array($f, array_merge([$y, $x], $args));
    });
}

const prefix = __NAMESPACE__ . '\prefix';

/**
 * Prefixes the first argument to the second (e.g. first_argument . second_argument).
 *
 * @param string $thePrefix
 * @param string $str
 * @return string
 */
function prefix(...$args) {
    $prefix = curry(function($thePrefix, $str) {
        return $thePrefix . $str;
    });

    return call_user_func_array($prefix, $args);
}

const suffix = __NAMESPACE__ . '\suffix';

/**
 * Suffixes the first argument to the end of the second (e.g. second_argument . first_argument).
 *
 * @param string $theSuffix
 * @param string $str
 * @return string
 */
function suffix(...$args) {
    return call_user_func_array(flip(prefix), $args);
}

const equal = __NAMESPACE__ . '\equal';

/**
 * Test of two values are equal.  Uses === to test equality.
 *
 * @param mixed $x
 * @param mixed $y
 * @return bool
 */
function equal(...$args) {
    $equal = curry(function($x, $y) {
        return $x === $y;
    });

    return call_user_func_array($equal, $args);
}

const notEqual = __NAMESPACE__ . '\notEqual';

/**
 * Test of two values are not equal.  Uses !== to test inequality.
 *
 * @param mixed $x
 * @param mixed $y
 * @return bool
 */
function notEqual(...$args) {
    $notEqual = curry(function($x, $y) {
        return $x !== $y;
    });

    return call_user_func_array($notEqual, $args);
}

const liftF = __NAMESPACE__ . '\liftF';

/**
 * Lifts the provided function into another function.  Useful for calling a one-parameter function
 * and getting a no-parameter function back, in order to put it into a compose or something.
 *
 * @param callable $f
 * @return callable
 */
function liftF($f) {
    return function(...$args) use ($f) {
        return function() use ($args, $f) {
            return call_user_func_array($f, $args);
        };
    };
}

const rend = __NAMESPACE__ . '\rend';

/**
 * Just a curried version of the native explode function (splits a string into an array).
 *
 * @param string $delimter
 * @param string $str
 * @return array
 */
function rend(...$args) {
    $rend = curry(function($delimter, $str) {
        return explode($delimter, $str);
    });

    return call_user_func_array($rend, $args);
}

const camelKey = __NAMESPACE__ . '\camelKey';

/**
 * Creates an associative array out of an array, by assuming the values of the
 * array are: [key1, value1, key2, value2]
 *
 * @param array $arr
 * @return array
 */
function camelKey($arr) {
    $flat = array_values($arr);

    $keys = filterK(function($i) { return $i % 2 === 0; }, $arr);
    $vals = filterK(function($i) { return $i % 2 !== 0; }, $arr);

    return array_combine($keys, $vals);
}

const also = __NAMESPACE__ . '\also';

/**
 * Calls the two provided functions with the provided value, and 'ands' their return values.
 *
 * This would be called 'and', but it's a reserved word.
 *
 * @param callable $f1
 * @param callable $f2
 * @param mixed $x
 * @return bool
 */
function also(...$args) {
    $and = curry(function($f1, $f2, $x) {
        return $f1($x) && $f2($x);
    });

    return call_user_func_array($and, $args);
}

const not = __NAMESPACE__ . '\not';

/**
 * Returns true if the function called with the value returns false, or returns false
 * if the function returns true.
 *
 * @param callable $f
 * @param mixed $x
 * @return bool
 */
function not(...$args) {
    $not = curry(function($f, $x) {
        return !$f($x);
    });

    return call_user_func_array($not, $args);
}

const either = __NAMESPACE__ . '\either';

/**
 * Returns true if either function returns true, with the provided value, or false
 * if both return false.
 *
 * This would be called 'or', but it's a reserved word.
 *
 * @param callable $f1
 * @param callable $f2
 * @param mixed $x
 * @return bool
 */
function either(...$args) {
    $either = curry(function($f1, $f2, $x) {
        return $f1($x) || $f2($x);
    });

    return call_user_func_array($either, $args);
}

const memoize = __NAMESPACE__ . '\memoize';

/**
 * Returns a memoized version of the provided function.  The return values of the returned function are cached.
 * So the first time the returned function is called with a specific set of input args, the provided function
 * is called and the return value is cached. On subsequent calls, with the same input args, the cached value
 * is returned (and the provided function is not called again).
 *
 * This only works for functions where the input args can be serialized.
 *
 * @param callable $f
 * @return callable
 */
function memoize($f) {
    $cache = [];

    return function(...$args) use ($f, &$cache) {
        $key = serialize($args);

        if(isset($cache[$key])) return $cache[$key];

        $ret = call_user_func_array($f, $args);
        $cache[$key] = $ret;

        return $ret;
    };
}

const concat = __NAMESPACE__ . '\concat';

/**
 * Taktes to strings and concats them together.  The first argument comes first in the string, then the second.
 *
 * @param string $a
 * @param string $b
 * @return string
 */
function concat(...$args) {
    $concat = curry(function($a, $b) {
        return $a . $b;
    });

    return call_user_func_array($concat, $args);
}
