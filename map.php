<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo '
<style>
    p {
        font-size: 4vw;
    }
    a {
        color: white;
    }
    body{
        background-color: #000000;
        margin:0;
    }
</style>
<center><a href="index.php">GO BACK</a></center>
<img src="img/tacMap.jpg" width="1080" height="1269" usemap="#tacmap">
<map name="tacmap">
    <area shape="rect" coords="797,319,1073,573" href="AO.php?map=Home">
    <area shape="rect" coords="367,689,425,932" href="AO.php?map=Ironclad">
    <area shape="rect" coords="509,658,729,716" href="AO.php?map=Keystone">
    <area shape="rect" coords="453,350,519,572" href="AO.php?map=Bronco">
    <area shape="rect" coords="328,66,544,290" href="AO.php?map=Torchlight">
    <area shape="rect" coords="621,87,884,313" href="AO.php?map=Corkscrew">
    <area shape="rect" coords="507,975,802,1269" href="AO.php?map=Snowfall">  
</map>';
echo '<br><form name="form" action="AO.php" method="get">';
echo '<select name="map">';
$sql = "SELECT name FROM ao";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='".$row['name']."'>".$row['name']."</option>";
    }
} else {
    echo '<center><b>NO RESULTS</b></center>';
}
echo '<input type="submit" id="submit"></form>';

echo '<center><a href="index.php">GO BACK</a></center>';
?>
HELLO