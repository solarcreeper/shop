<?php
	$array1 = array();
	$array1['name'] = "yehongjiang";
	$json = json_encode($array1);
	$array2 = array();
	$array2 = json_decode($json, true);
	var_dump($array2);
	echo $array2['name'];
?>