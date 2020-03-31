<?php
    session_start();
    $prevPage = $_SERVER['HTTP_REFERER'];
    session_destroy();
    echo "<script>alert(\"로그아웃 되었습니다.(You have been signed out.)\");</script>";
    echo "<script>location.href='/'</script>";
?>
