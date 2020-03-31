<?php
    session_start();
    include_once ("{$_SESSION['root']}/src/checksession.php");

    $userID = $_SESSION['login'];
    // get pinmap from json
    $path = "{$_SESSION['root']}/data/usercustomize/{$userID}/pinmap.json";

    $json_string = file_get_contents($path);
    $json_data = json_decode($json_string, true);
    foreach($json_data as $key => $val){
        foreach($json_data[$key] as $key2 => $value){
            $updatedPinmapArr[$key][$key2] = $_POST[$key.'-'.$key2];
        }
    }
    $json_update = json_encode($updatedPinmapArr);
    $fp = fopen($path, 'w');
    fwrite($fp, $json_update);
    fclose($fp);

    echo (" <script>
                alert('핀 맵이 업데이트 되었습니다.(Your pinmap is updated.)');
                window.history.back()
            </script>");
?>