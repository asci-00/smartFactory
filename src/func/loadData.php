<?php
    include_once ("{$_SERVER["DOCUMENT_ROOT"]}/src/func/dbinfo.php");
    function getDataByID($id) {
        $work_db = dbopen("worklist");
        $query = "SELECT * FROM `work` WHERE id='${id}'";
        $res = mysqli_query($work_db, $query);
        $data = mysqli_fetch_assoc($res);
        mysqli_close($work_db);
        
        return json_encode($data);
    }
?>