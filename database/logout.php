<?php
session_start();

if(isset($_SESSION['activeuser'])){
    unset($_SESSION["activeuser"]);
}

if(isset($_SESSION["activestaff"])){
    unset($_SESSION["activestaff"]);
}

if(isset($_SESSION["activeadmin"])){
    unset($_SESSION["activeadmin"]);
}

header("location: ../index.php");
die();

?>