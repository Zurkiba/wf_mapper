<?php
$num = $_GET['n'];
$data = array();
$numForm = $_GET['f'];
for ($i = 0; $i < $num; $i++){
    $grab = (string)$i;
    array_push($data,$_GET[$grab]);
}
if ($numForm == null && data[0] != null){
    echo '<form name="form" action="strike.php" method="get">';
    echo "<input type='text' name='f' id='f' value='How many fleets?'><br><br>";
    echo '<input type="submit" id="submit"></form>';
}
if ($numForm > 0){
    echo '<form name="form" action="strike.php" method="get">';
    for ($i = 0; $i < $numForm; $i++){
        echo "<input type='text' name='$i' id='$i' value='Name,x,y,z,speed'><br>";
    }
    echo "<br><input type='text' name='target' id='t' value='target x,y,z'><br>";
    echo "<input type='text' name='number' id='n' value=$numForm readonly><br>";
    echo '<br><input type="submit" id="submit"></form>';
}
if ($data[0] != null){
    echo 'Test';
}


?>