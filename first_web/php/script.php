<?php
@session_start();

if (!isset($_SESSION["table"])) $_SESSION["table"] = array();
date_default_timezone_set($_POST["timezone"]);
$x = (float) $_POST["x"];
$y = (float) $_POST["y"];
$r = (float) $_POST["r"];
if (validate_data($x,$y,$r)){
    doRes($x,$y,$r);
}else{
    http_response_code(400);
    return;
}
function doRes($x,$y,$r){
    $odz = check_odz($x, $y, $r);
    $current_time = date("H : i : s");
    $work_time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    array_push($_SESSION["table"], ($odz=="Да")? "<tr>

    <td>$x</td>
    <td>$y</td>
    <td>$r</td>
    <td><font color='green'>$odz</font></td>
    <td>$current_time</td>
    <td>$work_time</td>
    </tr>":"<tr>
    

    <td>$x</td>
    <td>$y</td>
    <td>$r</td>
    <td><font color='red'>$odz</font></td>
    <td>$current_time</td>
    <td>$work_time</td>
    </tr>");
    echo "<table class='resultTable' id='outputTable'>
        <tr>
            <th>X</th>
            <th>Y</th>
            <th>R</th>
            <th>ODZ</th>
            <th>Текущее время</th>
            <th>Время работы</th>
        </tr>";
    foreach ($_SESSION["table"] as $table) echo $table;
    echo "</table>";
}

function check_triangle($x, $y, $r){
    return ($x>=0) && ($x<=$r) && ($y>=0) && ($y<=$r) && ($y+$x<=$r);
}

function check_rectangle($x, $y, $r){
    return ($x>=-$r)&&($x<=0)&&($y>=0)&&($y<=$r/2);
}

function check_quadrant($x, $y, $r){
    return ($x<=0) && ($y<=0) && ($x**2 + $y**2 <= $r**2);
}

function validate_data($x, $y, $r){
    return in_array($x, array(-3, -2, -1, 0, 1, 2, 3 , 4, 5)) &&
        is_numeric($y) && ($y >= -3 && $y <= 3) &&
        in_array($r, array( 1, 1.5, 2 , 2.5 , 3));
}

function check_odz($x, $y, $r){
    if (check_triangle($x,$y,$r) || (check_rectangle($x,$y,$r)) || (check_quadrant($x,$y,$r)))  return "Да";
    else return "Нет";
}
