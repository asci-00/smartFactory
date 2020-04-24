<!doctype html>
<meta charset="utf-8"/>
<html lang="ko-kr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> NewWork </title>

        <!-- Bootstrap -->
        <link href="/src/css/nomalize.css" rel="stylesheet">
        <link href="/src/css/bootstrap.min.css" rel="stylesheet">
        <link href="/src/css/listPage.css" rel="stylesheet">
        <link href="/src/css/newworkPage.css" rel="stylesheet">
        
        <script src='/src/js/createConfig.js'></script>
        <script src='/src/js/dragUnit.js'></script>
        <script src='/src/js/setDefault.js'></script>
        <script src='/src/js/checkvalue.js'></script>
        <script>
            <?
                session_start();
                include_once ("./func/checksession.php");
                include_once ("./func/loadData.php");
                include_once ("./func/fileRead.php");
                $id = '';
                $data = '0';
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $data = getDataByID($id);
                }
            ?>
            window.onload = () => {
                DragProc.init()
                var data = init(<?=$data?>)
            }
        </script>
    </head>
    <body onselectstart="return false">
        <?php
            include_once ("./nav.php");
            $userID = $_SESSION['login'];
            $unit_data = file_to_json("usercustomize/{$userID}/pinmap.json");
            $userUnitList = array(
                'sensor' => [],
                'actuator' => [],
            );

            foreach($unit_data as $type => $units) {
                foreach($units as $unit => $pin)
                    array_push($userUnitList[$type], $unit);
            }

            $unit_info = file_get_contents("../data/usercustomize/unit_info.json"); //all unit detail information

            function getUnitList($type) {
                global $userUnitList;
                $data = array();
                foreach($userUnitList[$type] as $name) {
                    array_push($data, array(
                        'name' => $name,
                        'img' => "/imgs/{$name}.gif"
                    ));
                }
                return $data;
            }
        ?>
        <script> var unit_info = <?=$unit_info?> </script>
        <div class="head-1">Choose a unit service.</div>
        <div id='setting-container'>
            <div id = 'unit-box' class = 'box'>
                <?php
                    foreach($userUnitList as $type => $units) {
                        $htmlText = '';
                        $htmlText = $htmlText."<div class='{$type} box'>
                                                <div class='head-3 graybgr'>{$type} list</div>
                                                <div class='unit-list'>";
                                                array_map(function($value) {
                                                    global $htmlText, $type;
                                                    $htmlText = $htmlText."<div class='img-box'>
                                                                            <img src='{$value['img']}' 
                                                                                name={$value['name']} 
                                                                                class='unit-img'
                                                                                id='{$type}-{$value['name']}'/>
                                                                            <span class='tooltip'>{$value['name']}</span>
                                                                        </div>";
                                                }, getUnitList($type));
                        $htmlText = $htmlText."</div></div>";
                        echo $htmlText;
                    }
                ?>
            </div>
            
            <form id='work-setting' class='box' action='/src/func/data_func.php?type=apply' method='post'>    <!--if operator is null substitute '='-->
                <input type='hidden' name ='id' value='<?=$id?>'/>
                <input type='hidden' name='trigger' value=''/>
                <input type='hidden' name='actuator' value=''/>
                <div id='applied-unit-box'>
                    <div class='wt-box'><span>IF</span></div>
                    <div id='trigger-box' class='wt-box unit-box'><span >DROP</span></div>
                    <div class='wt-box'><span>SET</span></div>
                    <div id='action-box' class='wt-box unit-box'><span>DROP</span></div>
                </div>

                <div id='unit-config-box'>
                    Unit config setting<hr/>
                    <div id='trigger-config'>
                    </div>
                    <div id='action-config'>
                    </div>
                </div>
            </form>
        </div>
        <button id='submit' type="button" class="btn btn-success" onclick='onClick()'>SUBMIT</button>
        <?php include("./footer.php");?>
    </body>
</html>