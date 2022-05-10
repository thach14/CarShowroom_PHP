<?php
//rootpass
$db = new PDO("mysql:host=localhost;dbname=carshowroom", 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>