<?php
//Create connection credentials
try{

$con = new PDO('mysql:host=localhost;dbname=xbar;','username','password');

} catch(PDOException $e){
	die("Connection Failed, Check your Code!");
}

?>