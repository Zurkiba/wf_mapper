<?php

$enemy = $_GET['enemy'];
$friend = $_GET['friend'];

$enemy = explode(',',$enemy); //0 x1; 1 y1; 2 z1; 3 x2; 4 y2; 5 z2; 6 speed
$friendly = explode(',',$friend); // 0 x; 1 y; 2 z; 3 speed
$deltaX = $enemy[3] - $enemy[0];
$deltaY = $enemy[4] - $enemy[1];
$deltaZ = $enemy[5] - $enemy[2];
$enemyDist = sqrt(
                  pow($deltaX,2) +
                  pow($deltaY,2) +
                  pow($deltaZ,2) 
                  );
//Each RL minute the fleet moves speed*0.9 units on enemyDist
$unitsPerMin = (($enemy[6]/1000)*3600/4000);
$travelTime = $enemyDist / $unitsPerMin;


for ($i = 0; $i < $travelTime/10; $i++){ 
    $lerpX = $enemy[0] + $i * $deltaX;
    echo $lerpX . '<br>';
}



?>