<?php
    $unit_file = file_get_contents("{$_SESSION['root']}/unit.json");
    $unit_data = json_decode($unit_file, true);

    function getWorkList($db, $user = 'shared') {
        $query = ($user == 'shared') ? 
            "SELECT * FROM work WHERE shared is true  order by id":
            "SELECT * FROM work WHERE user='{$user}' OR shareUsers LIKE '%;{$user};%' order by id";            
        $res = mysqli_query($db, $query);
        $data = array();

        while($row = mysqli_fetch_array($res))
            array_push($data, $row);
        return $data;
    }
    function getWork($db, $id) {
        $query = "SELECT * FROM work WHERE id = '{$id}'";
        $res = mysqli_query($db, $query);
        $data = mysqli_fetch_array($res);
        return $data;
    }
    
    function setWorkBox($data, $link = '/src/viewwork.php') {
        if(isset($unit_data[$data['trigger']])) $unit = isset($unit_data[$data['tirrger']]);
        else $unit = '';
        $operator = $data['operator'] === '=' ? 'is' : $data['operator'];

        echo("
        <div class='col-xs-6 col-md-3 square-box' >
            <a href='{$link}?workID={$data['id']}'>
                <div class='panel panel-success square-content'>
                    <div class='panel-body'><h4>
                        if <font color='#22741C'>{$data['trigger']} {$operator} {$data['value']} {$unit}</font>, 
                        then <font color='#CC3D3D'>set {$data['actuator']} to {$data['action']}</font>
                    </h4></div>
                </div>
            </a>
        </div>");
    }

    function setViewBox($data) {
        if(isset($unit_data[$data['trigger']])) $unit = isset($unit_data[$data['tirrger']]);
        else $unit = '';
        $operator = $data['operator'] === '=' ? 'is' : $data['operator'];

        return ("
        <div class='container main-box' align='center'>
            <div>
                <div class='head-1 side-border'>Configure</div>
                <div id='applied-unit-box' class='box-border info-box' >
                    <div class='wt-box'><span>IF</span></div>
                    <div class='wt-box unit-box'>
                        <img src='/imgs/{$data['trigger']}.gif' class='unit-img'/>
                    </div>
                    <div class='wt-box'><span>SET</span></div>
                    <div class='wt-box unit-box'>
                        <img src='/imgs/{$data['actuator']}.gif' class='unit-img'/>
                    </div>
                </div>
                <div class='info-box'>
                    <div style='width:110px;height:1px;'></div>
                    <div style='width:110px;'><font color='#22741C'>{$operator} {$data['value']} {$unit}</font></div>
                    <div style='width:110px;height:1px;'></div>
                    <div style='width:110px;'><font color='#CC3D3D'>to {$data['action']}</font></div>
                </div>
                <br>
                <div class='btn-group' role='group'>
                    <button type='button' name='add' onclick='sharing()' class='btn btn-info  btn-sm'>share</button>
                    <button type='button' name='add' onclick='edit()' class='btn btn-success  btn-sm'>edit</button>
                    <button class='btn btn-danger  btn-sm' onclick='delete()'>delete</button>
                </div>
            </div>
        </div>");
    }
?>