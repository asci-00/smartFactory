<?php
    session_start();
    include_once ("{$_SESSION['root']}/dbinfo.php");
    include_once ("{$_SESSION['root']}/src/checksession.php");
    $work_db = dbopen("worklist");

    $ID = $_GET['workID'];
    $userID = $_SESSION['login'];
    $query = "SELECT * FROM work WHERE (user='{$userID}' OR shareUsers LIKE '%;{$userID};%') AND id={$ID}";
    $res = mysqli_query($work_db, $query);
    if(mysqli_num_rows($res) != 0)
       echo("<script>alert('This work already exist!');</script>");
    else {
        $query = "UPDATE work SET shareUsers=CONCAT(shareUsers, '{$userID};') WHERE id={$ID};";
        mysqli_query($work_db, $query);
    }
    mysqli_close($work_db);
    echo("<script>location.href='/src/userWork.php';</script>");
?>