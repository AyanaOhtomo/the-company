<?php 
include "../classes/User.php";

//Create an obj
$user = new User();

//Useing the method
$user->store($_POST);


?>