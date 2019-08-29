<head>
<style>
table {
    border: 3px solid white;
}
a {
    color: white;
}
body{
    background-color: #000000;
    color: white;
}
p {
    font-size: 2vw;
}
</style>
</head>

<?php
echo '<center><a href="index.php">GO BACK</a><br>';
echo '<p>KNOWN FLEETS</p>';
$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);

$focusMaps = array('397892,576958,76870,299062', 
             '-69511,-16253,-281088,-59895', 
             '20514,74056,97106,282725', 
             '79818,283630,-71552,-18174', 
             '-91470,93481,376021,539031',
             '43530,83530,439031,489030',
             '195020,436878,273884,531579'
             ); # 0 - Iota; 1 - Ironclad, 2 - Bronco, 3 - Keystone, 4 - Torchlight, 5 - Khan's Landing, 6 - Corkscrew
                #xLeft,xRight,yBot,yTop
                
$map = $_GET['map'];
echo '<table><tr><td>DEFINED AO';
echo '<form name="form" action="fleets.php" method="get">';
echo '<select name="map">';
echo '<option value="0" selected>Home</option>';
echo '<option value="1">Ironclad</option>';
echo '<option value="2">Bronco</option>';
echo '<option value="3">Keystone</option>';
echo '<option value="4">Torchlight</option>';
echo "<option value='5'>Khan's Landing</option>";
echo '<option value="6">Corkscrew</option>';
echo '<input type="submit" id="submit"></form>';
echo '</td><td>';
echo 'CUSTOM:';
echo '<form name="form" action="fleets.php" method="get">';
echo '<input type="text" name="xMIN" id="xMIN" value="xMIN"><input type="text" name="xMAX" id="xMAX" value="xMAX"><br>';
echo '<input type="text" name="yMIN" id="yMIN" value="yMIN"><input type="text" name="yMAX" id="yMAX" value="yMAX">';
echo '<br><input type="submit" id="submit"></form>';
echo '</td></tr></table><br>';

$xMIN = $_GET['xMIN'];
$xMAX = $_GET['xMAX'];
$yMIN = $_GET['yMIN'];
$yMAX = $_GET['yMAX'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$coords = array();
if ($map == null){
    $sql = "SELECT name, tonnage, size, c0, owner FROM intel WHERE x > $xMIN AND x < $xMAX AND y > $yMIN AND y < $yMAX"; 
} else if ($map != null){
    $coords = explode(",",$focusMaps[$map]);
    $sql = "SELECT name, tonnage, size, c0, owner FROM intel WHERE x > ".$coords[0]." AND x < ".$coords[1]." AND y > ".$coords[2]." AND y < ".$coords[3];
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['nInput'] != 'null'){
             echo $row['name'] . ' - ' . $row['owner'] . ' - ' . $row['size'] . 'size - ' . $row['tonnage'] . 'tons - ' . $row['c0'] . '<br>';
        }
    }
} else if ($result->num_rows <= 0){
    echo 'NO FLEETS<br>';
}
echo '<br><a href="index.php">GO BACK</a></center><br>';
?>