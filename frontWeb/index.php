<!doctype html>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Main </title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
        <link href="/src/css/form.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            include_once ("src/nav.php");
            include_once ("src/func/dbinfo.php");
            include_once ("src/func/getWorkList.php");
            $work_db = dbopen("worklist");
            $workData = getWorkList($work_db);
            mysqli_close($work_db);
        ?>
        <div class="container" align="center">
            <h3>Recommended for you !</h3>
            <p><h5>Make your own applet..</h5></p>
            <div style="float: right">
                <form class="search-container">
                    <input type="text" id="search-bar" placeholder="Search">
                    <a href="#"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>
                </form>
            </div>
        </div><br>
        <div class="container">
            <div class="row service wp1">
                <?php
                    $count = count($workData);
                    if($count == 0) echo ("
                        <div style='width:100%' align='center'>
                            <h3>No work is shared...</h3>;
                        </div>");
                    else for($idx = 0; $idx < $count; $idx++) {
                        setWorkBox($workData[$idx], '/src/getshare.php');
                        if ( $idx > 7 ) {
                            echo ("
                            <div class='col-xs-6 col-md-3 square-box'>
                                <a type='button'  href='Allwork.php'>
                                    <div class='panel square-content'>
                                        <div class='panel-body'><h2>more >></h2></div>
                                    </div>
                                </a>
                            </div>
                            ");
                            break;
                        }
                    }
                ?>
            </div>
        </div>
        <?php include("./src/footer.php");?>
    </body>
</html>

