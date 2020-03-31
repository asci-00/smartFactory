<?php
    $mysql_hostname = "localhost";
    $mysql_user = "root";
    $mysql_password = "3qufvv";
    function dbopen($name) {
        return mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$name) or die("db connect error");
    }
?>