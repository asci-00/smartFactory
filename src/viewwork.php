<!doctype html>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Main </title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
        <link href="/src/css/viewWork.css" rel="stylesheet">
        <link href="/src/css/newworkPage.css" rel="stylesheet">
        <script>
            <?php
                session_start();
                include_once ("./func/dbinfo.php");
                include_once ("./func/getWorkList.php");
                $work_db = dbopen("worklist");
                $data = getWork($work_db, $_GET['workID']);
                mysqli_close($work_db);
            ?>
            var share = () => 
                window.location.href = '/src/func/data_func.php?type=share&&id=<?=$data['id']?>'
            var edit = () =>
                window.location.href = "/src/newWork.php?id=<?=$data['id']?>"
            var del = () =>
                window.location.href = '/src/func/data_func.php?type=delete&&id=<?=$data['id']?>'
        </script>
    </head>
    <body>
        <? 
            include_once ("./nav.php");
            echo setViewBox($data);
            include("./footer.php");
        ?>
    </body>
</html>