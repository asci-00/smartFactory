<?php
    session_start();
    include_once ("{$_SERVER["DOCUMENT_ROOT"]}/src/func/dbinfo.php");
    include_once ("{$_SERVER["DOCUMENT_ROOT"]}/src/func/fileRead.php");
    $db = dbopen('worklist');
    $unit_data = file_to_json("usercustomize/unit_info.json");
    $user = $_SESSION['login'];

    function setData($type, $value) {
        if(empty($value)) {

        }
        return $value;
    }
    function sharedData($id, $db) {
        $query = "UPDATE work SET shared='1' WHERE id='{$id}'";
        mysqli_query($db, $query);
        mysqli_close($db);
        echo("<script>alert('sharing success!');</script>");
    }

    function applyData($data, $db) {
        global $user, $db;
        $trigger = $data['trigger'];
        if(isset($data['operator'])) $operator = $data['operator'];
        else $operator = null;
        $value = $data['value'];
        $actuator = $data['actuator'];
        $action = $data['action'];

        if(!isset($data['id']) || $data['id'] == '')
            $query = "INSERT INTO `work` (`user`, `trigger`, `operator`, `value`, `actuator`, `action`) VALUES('{$user}', '{$trigger}', '{$operator}', '{$value}', '{$actuator}', '{$action}');";
        else
            $query = "UPDATE `work` SET `trigger`='{$trigger}', `operator`='{$operator}', `value`='{$value}', `actuator`='{$actuator}', `action`='{$action}' WHERE `id`='{$data['id']}'";
        mysqli_query($db, $query);

        $query = "SELECT id FROM `work` order by id desc limit 1;";

        $res = mysqli_query($db, $query);
        $data = mysqli_fetch_array($res);

        mysqli_close($db);
        $exe = "cd /home/pi/www/Factory/py && python3 server_client.py {$user} {$data['id']} add";
        $return = exec($exe);
        if($return == '' || $return == 'x')
            echo("<script>alert('your factory is offline');</script>");
    }

    function deleteData($id, $db) {
        $query = "DELETE FROM work WHERE id='{$id}'";
        mysqli_query($db, $query);
        mysqli_close($db);

        $exe = "cd /home/pi/www/Factory/py && python3 server_client.py {$user} {$data['id']} del";
        $return = exec($exe);
        if($return == '' || $return == 'x')
            echo("<script>alert('your factory is offline');</script>");
    }
    $case = $_GET['type'];

    switch($case) {
        case 'apply':
            applyData($_POST, $db);
        break;
        case 'share':
            sharedData($_GET['id'], $db);
        break;
        case 'delete':
            deleteData($_GET['id'], $db);
        break;
    }
    echo("<script>location.href='/src/userWork.php';</script>");
?>