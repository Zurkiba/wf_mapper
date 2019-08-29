<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$id = $_GET['id'];
$gal = $_GET['galaxy'];
$sys = $_GET['system'];
$x = $_GET['x'];
$y = $_GET['y'];
$z = $_GET['z'];
$key = $_GET['key'];
if ($key == 2348){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "INSERT INTO wormholes (id, galaxy, system, x, y, z) VALUES ('$id', '$gal', '$sys', $x, $y, $z)";
    if ($conn->multi_query($sql) === TRUE) {
        echo 'WORMHOLE UPDATED';
    } else{
        echo $conn->error;
    }
}
?>