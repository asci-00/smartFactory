<!doctype html>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> WorkPage </title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            
            include_once ("./nav.php");
            include_once ("./func/dbinfo.php");
            include_once ("./func/getWorkList.php");
            include_once ("./func/checksession.php");

            $userID = $_SESSION['login'];
            $work_db = dbopen("worklist");
            $workData = getWorkList($work_db, $userID);
            mysqli_close($work_db);
        ?>
        <div class="container" align="center">
            <h3>Your Work</h3>
            <p><h5>check your work information</h5></p>
            <div style="float: right">
                
                <a type="button" class="btn btn-info" href="/src/newWork.php">
                    New Work
                </a>
            </div>
        </div>
        <div><br>
        <div class="container">
            <div class="row service wp1">
                <?php
                    $count = count($workData);
                    if($count == 0) echo ("
                        <div style='width:100%' align='center'>
                            <h3>No work is shared...</h3>;
                        </div>");
                    else for($idx = 0; $idx < $count; $idx++) setWorkBox($workData[$idx]);
                ?>
            </div>
        </div>
        <?php include("./footer.php");?>
    </body>
</html>
