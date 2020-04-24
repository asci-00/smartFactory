<?php
    session_start();
    include_once ("./checksession.php");
    include_once ("./fileRead.php");

    $userID = $_SESSION['login'];
    // get pinmap from json
    $path = "usercustomize/{$userID}/pinmap.json";
    $json_data = file_to_json($path);
    foreach($json_data as $key => $val){
        foreach($json_data[$key] as $key2 => $value){
            $updatedPinmapArr[$key][$key2] = $_POST[$key.'-'.$key2];
        }
    }
    $json_update = json_encode($updatedPinmapArr);
    $fp = fopen("{$_SERVER["DOCUMENT_ROOT"]}/data/{$path}", 'w');
    fwrite($fp, $json_update);
    fclose($fp);

    echo (" <script>
                alert('핀 맵이 업데이트 되었습니다.(Your pinmap is updated.)');
                window.history.back()
            </script>");
?>