<?php
    if(isset($_SESSION['login'])) $user_id = $_SESSION['login'];
    else {
        echo 
        ("<script>
            alert('please login')
            window.history.back()
        </script>");
    }
?>