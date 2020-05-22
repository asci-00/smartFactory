<?php
    session_start();
    include_once ("./dbinfo.php");
    $member_db = dbopen('user');
    $id = $_POST['id'];
    $pw = $_POST['pw'];

    $sql= "select * from memberinfo where memberID='{$id}' and memberPW='{$pw}'";
    $result = mysqli_query($member_db,$sql);
    $count=mysqli_num_rows($result);

    if($count==1) {
        $_SESSION['login'] = $id; //토큰으로 변경
        mysqli_close($member_db);
        echo("<script>location.href='/';</script>");
    }
    else {
        mysqli_close($member_db);
        echo ("<script>
                alert('아이디 또는 비밀번호가 다릅니다.');
                location.href='/src/login.php';
            </script>");
    }
?>  