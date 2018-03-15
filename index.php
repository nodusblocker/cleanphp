<?php
require_once 'vendor/autoload.php';
//Include class ArrayAccessor
use NodusBlocker\CleanPhp\Accessor\ArrayAccessor;
//Initialize an array
$array = [];
//Initialization ArrayAccessor.
//Accept a character used as key separator, default '.'
$accessor = new ArrayAccessor('.');
//Set a array value
$accessor->set($array, 'a', 1);

print_r($accessor->get($array, 'a')); // Output: Array([a] => 1)
$accessor->get($array, 'b'); // Don't throw error, return null
$accessor->has($array, 'a'); // return true
$accessor->has($array, 'b'); // return false
$accessor->set($array, 'b.c', 'abc');
print_r($array);