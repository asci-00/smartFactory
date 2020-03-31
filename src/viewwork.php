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
    </head>
    <body>
        <?php
            session_start();
            $_SESSION['root'] = $_SERVER['DOCUMENT_ROOT'];
            include_once ("{$_SESSION['root']}/src/nav.php");
            include_once ("{$_SESSION['root']}/dbinfo.php");
            include_once ("{$_SESSION['root']}/src/getWorkList.php");
            $work_db = dbopen("worklist");
            $data = getWork($work_db, $_GET['workID']);
            mysqli_close($work_db);
        ?>
        <?=setViewBox($data)?>
        <?php include("{$_SESSION['root']}/src/footer.php");?>
    </body>
</html>