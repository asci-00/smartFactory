<?php
    session_start();
    include_once ("./func/dbinfo.php");
    $work_db = dbopen("worklist");

    $user = $_SESSION['login'];
    $trigger = $_POST['trigger'];
    $operator = $_POST['operator'];
    $value = $_POST['value'];
    $actuator = $_POST['actuator'];
    $action = $_POST['action'];

    echo ($query);
    mysqli_query($work_db, $query);
    mysqli_close($work_db);
    echo("<script>location.href='/src/userWork.php';</script>");
?>