<?php
    function dbopen($name) {
        $mysql_hostname = "localhost";
        $mysql_user = "root";
        $mysql_password = "3qufvv";
        $db = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $name) or die("db connect error");
        return $db;
    }
?>