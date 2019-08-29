<style>
    img {
       height:auto;
       width:40%;
    }
    p {
    font-size: 4vw;
    }
    body{
        background-color: #5D5D5D;
    }
    table {
        border: 1px solid black;
        border-spacing: 0px;
    }
    tr {
        border: 1px solid black;
    }
    td {
        border: 1px solid black;
        padding: 0px;
        text-align: center;
    }
    a {
        color: white;
    }
</style>
<?php

$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
$sql = 'SELECT name FROM ao WHERE alert = 1';
$result = $conn->query($sql);

echo "<center><p><b>INTELLIGENCE COMMAND CENTER</b><br></p>";
echo "<center><b><font color='red'>ALERT:</font></b><br>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href='AO.php?map=" . $row['name'] . "'>". $row['name'] . "</a><br>";
    }
} else if ($result->num_rows <= 0){
    echo 'ALL CLEAR<br>';
}
echo '</center><br>';
?>
<a href="map.php"><img src='img/icons-01.png'></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="wormhole.html"><img src='img/icons-02.png'></a><br>
<a href="fleets.php"><img src='img/icons-03.png'></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="lostfleets.php"><img src='img/icons-04.png'></a><br>
<a href="raw.php"><img src='img/icons-05.png'></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="cc.php"><img src='img/icons-06.png'></a><br>

</center>
