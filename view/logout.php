<?php  
$user = new User($db);
$user->logout();
header("location :login.php");

?>