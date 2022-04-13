<?php

session_start();
$_SESSION["username"] = null;
$_SESSION["password"] = null;
$_SESSION["user_id"] = null;
$_SESSION["image_name"] = null;
header("location: index.php");

?>