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
echo '<p>LOST FLEETS</p><i>might indicate colony locations</i><br>';
$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = 'SELECT name, tonnage, size, c0, owner FROM intel WHERE tonnage > 2 AND c1 = c0';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['nInput'] != 'null'){
             echo $row['name'] . ' - ' . $row['owner'] . ' - ' . $row['size'] . 'size - ' . $row['tonnage'] . 'tons - ' . $row['c0'] . '<br>';
        }
    }
} else if ($result->num_rows <= 0){
    echo 'NO LOST FLEETS<br>';
}
echo '<br><a href="index.php">GO BACK</a></center><br>';
?>