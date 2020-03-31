<!doctype html>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Main </title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            $_SESSION['root'] = $_SERVER['DOCUMENT_ROOT'];
            include_once ("{$_SESSION['root']}/src/nav.php");
            include_once ("{$_SESSION['root']}/dbinfo.php");
            include_once ("{$_SESSION['root']}/src/getWorkList.php");
            $work_db = dbopen("worklist");
            $workData = getWorkList($work_db);
            mysqli_close($work_db);
        ?>
        <div class="container" align="center">
            <h3>Recommended for you !</h3>
            <p><h5>Make your own applet..</h5></p>
            <div style="float: right">
                <form action="SearchResult.php" class="search-form" method="post">
                    <div class="form-group has-feedback">
                        <label for="search" class="sr-only">Search</label>
                        <input type="text" class="form-control" name="search" id="search" placeholder="search">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
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
        <?php include("{$_SESSION['root']}/src/footer.php");?>
    </body>
</html>

