<!doctype html>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> PinSettingPage </title>

        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
        <style>
            th, td { padding: 5px; text-align:center;}
        </style>
    </head>
    <body>
        <?php
            session_start();
            include_once ("{$_SESSION['root']}/src/nav.php");
            include_once ("{$_SESSION['root']}/src/checksession.php");

            $userID = $_SESSION['login'];
            // get pinmap from json
            $path = "{$_SESSION['root']}/data/usercustomize/{$userID}/pinmap.json";
            $file = file_get_contents($path);
            $data = json_decode($file, true);
        ?>
        <div class="container" align="center">
            <h3>Your Pinmap</h3>
            <p><h5>check & update your setting</h5></p>
            <div align="center">
                <form method="POST" action="updatePin.php">
                    <table  align="center" border=1>
                    <tr><th>module</th><th>pin num</th></tr>
                    <?php
                    foreach($data as $key => $val) {
                        echo "<tr>";
                        echo "<td colspan=2 style=\"background:#BDBDBD\"><b>".$key."</b></td>";
                        echo "</tr>";
                        foreach($data[$key] as $key2 => $value) {
                            echo "<tr>";
                            echo "<td>".$key2."</td>";
                            echo "<td><input type=\"text\" style='border:0px' name=\"$key-$key2\" value=\"$value\"/></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </table>
                    </br>
                    <input type="submit" class="btn btn-lg navbar-dark bg-primary" value="Save pin map"/>
                </form>
            </div>
        </div>
        <?php include("{$_SESSION['root']}/src/footer.php");?>
    </body>
</html>
