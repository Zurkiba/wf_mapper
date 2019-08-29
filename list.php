<head>
<style>
table, th, td {
    border: 1px solid gray;
    border-spacing: 0px;
    border-collapse: separate;
}
td { 
    padding: 0px;
}
a {
    color: #FFFFFF;
}
body {
    color: white;
    background-color: black;
}
</style>
</head>
<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$order = $_GET['order'];
$organize = $_GET['organize'];
$AO = $_GET['map'];
$sql = "SELECT name,tonnage,size,c0,speed FROM intel WHERE galaxy='".$AO."' ORDER BY(". $organize .") ".$order;
$result = $conn->query($sql);

echo '<center><b>SORT BY:</b><br><a href="list.php?map='.$AO.'&order=DESC&organize=tonnage">HEAVIEST</a> | <a href="list.php?map='.$AO.'&order=DESC&organize=size">LARGEST</a> | <a href="list.php?map='.$AO.'&order=ASC&organize=name">NAME</a></center>';
echo '<table><tr><td width=30%><center><b>Fleet Name</b></center></td><td><center><b>Fleet Tonnage</b></center></td><td><center><b>Fleet Size</b></center></td><td><center><b>Coordinates</b></center></td><td><center><b>km/s</b></center></td></tr>';
if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<tr><td><center>' . $row['name'] . '</center></td>';
            echo '<td><center>' . $row['tonnage'] . '</center></td>';
            echo '<td><center>' . $row['size'] . '</center></td>';
            echo '<td><center>' . $row['c0'] . '</center></td>';
            echo '<td><center>' . $row['speed'] . '</center></td>';
            
            echo '</tr>';
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    echo '</table>';