<?php 
require_once('dbactions.php');

//instatiate database class to onvoke constructor function which returns the connection

$db= new Database();


// echo $db->fetchAllPhones();

$jsonData=trim(file_get_contents('data.txt'));

//create an array from the json data

$dataArray=json_decode($jsonData,true);

$db->fetchedData($dataArray);


?>
