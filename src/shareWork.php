<?php
    session_start();
    include_once ("{$_SESSION['root']}/dbinfo.php");
    $work_db = dbopen("worklist");

    $ID = $_GET['workID'];

    $query = "UPDATE work SET 'shared'='1' WHERE 'id'='{$ID}'";
    echo ($query);
    mysqli_query($work_db, $query);
    mysqli_close($work_db);
    echo("<script>location.href='/src/userWork.php';</script>");
?>