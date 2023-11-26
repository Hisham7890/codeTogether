<?php
$servername = "localhost";
$dbusrname = "root";
$dbpswrd = "";
$dbname = "codetogether_db";

$db = mysqli_connect($servername, $dbusrname, $dbpswrd, $dbname);
if(!$db){
    die("connection failed: ".mysqli_connect_error());
}
?>