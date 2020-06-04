<?php

$key2 = $_GET['key'];
$value2 = $_GET['value'];


$redis = new Redis();

$redis->connect('redis6', 6379);

$key = "test";
$value = "this is test";

$redis->set($key, $value);
if(!empty($key2) && !empty($value2)){
	$redis->set($key2,$value2);
	echo "<pre>";
	print_r($redis->get($key2));
}

$d = $redis->get($key);
var_dump($d);
