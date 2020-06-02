<?php
/*all data json format*/
class dataIO {
	const $DB = 0, $FILE = 1;

	static function setData($data, $type, $dataInfo) {
		switch($type) {
		case $DB:
			break;
		case $FILE:
			break;
		}
	}
	static function getData($type, $dataInfo) {
		switch($type) {
		case $DB:
			break;
		case $FILE:
			break;
		}
	}
}
?>
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
        global $db;
        $query = "UPDATE work SET shared='1' WHERE id='{$id}'";
        mysqli_query($db, $query);
        mysqli_close($db);
        echo("<script>alert('sharing success!');</script>");
    }

    function applyData($data, $db) {
        global $user, $db, $unit_data;
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

        if($value == 'shape-learning' || $value == 'color-learning') {
            $uploads_dir = "{$_SERVER["DOCUMENT_ROOT"]}/data/usercustomize/ajh/imgs/";
            $allowed_ext = array('jpg','jpeg','png','gif');
            // 변수 정리
            echo $uploads_dir.'<br/>';
            foreach($unit_data[$value] as $type => $data) {   
                foreach($data as $idx => $value) {
                    $error = $_FILES[$type]['error'][$idx];
                    $fname = $_FILES[$type]['name'][$idx];
                    if($fname == null || $fname == '') continue;
                    $ext = explode('.', $fname)[1];

                    if(in_array($ext, $allowed_ext) != true) {
                        echo "허용되지 않는 확장자입니다.";
                        continue;
                    }
                    // 파일 이동
                    move_uploaded_file($_FILES[$type]['tmp_name'][$idx], "$uploads_dir/$id$type$idx");
                }
            }
           
            $learn = "cd /home/pi/www/Factory/py && python3 {$value}Learning {$data['id']} pass fail";
            exec($learn);
        }

        $work = "cd /home/pi/www/Factory/py && python3 server_client.py {$user} {$data['id']} add";
        $return = exec($work);
        
        if($return == '' || $return == 'x')
            echo("<script>alert('your factory is offline');</script>");
    }

    function deleteData($id, $db) {
        global $user;
        $query = "DELETE FROM work WHERE id='{$id}'";
        mysqli_query($db, $query);
        mysqli_close($db);

        $exe = "cd /home/pi/www/Factory/py && python3 server_client.py {$user} {id} del";
        $return = exec($exe);
        if($return == '' || $return == 'x')
            echo("<script>alert('your factory is offline');</script>");
    }
    $case = $_GET['type'];

    switch($case) {
        case 'apply':
            applyData($_POST, $db, $_FILES);
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