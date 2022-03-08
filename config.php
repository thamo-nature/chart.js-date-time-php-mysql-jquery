<?php
ob_start(); //Turns on output buffering 

if(!isset($_SESSION)){
    session_start();
}

$timezone = date_default_timezone_set("Asia/Kolkata");

define('DEVICE_CONSOLE_DOC_ROOT', '/console/');

$con = mysqli_connect("localhost", "root", "", "datetime"); //Connection variable

global $con;

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}


?>
