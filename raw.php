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
echo '<center><a href="index.php">GO BACK</a><br><br>';
$servername = "";
$username = "";
$password = "";
$dbname = "";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name = $_GET['name'];
$sql = "SELECT nInput,eInput FROM input WHERE name = '$name'";
echo '<form name="form" action="raw.php" method="get">';
echo '<select name="name">';
echo '<option value="SolarCat" selected>SolarCat</option>';
echo '<option value="Blacktusk">KhaganHrak</option>';
echo '<option value="crabrock">Crabrock</option>';
echo '<option value="cd2767">Frost</option>';
echo '<option value="ichthysghoti">Leif</option>';
echo '<option value="LemoniceX">Lemon</option>';
echo '<input type="submit" id="submit"></form>';

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['nInput'] != 'null'){
            echo '<br><b>NEUTRALS:</b><br>';
            echo '<table><tr>
              <td class="strong light padding5 tbborder">Fleet Name</td>
              <td class="strong light padding5 tbborder">Owner - Relation</td>
              <td class="strong light padding5 tbborder">Number</td>
              <td  class="strong light padding5 tbborder">Tonnage</td>
              <td class="strong light padding5 tbborder">Distance</td>
              <td class="strong light padding5 tbborder">Location</td></tr>';
            echo $row['nInput'];
            echo '<br><br>';
        } else {
            echo '<center><b>NO NEUTRALS</b></center>';
        }
        if ($row['eInput'] != 'null'){
            echo '<b>ENEMIES:</b><br>';
            echo '<table><tr>
              <td class="strong light padding5 tbborder">Fleet Name</td>
              <td class="strong light padding5 tbborder">Owner - Relation</td>
              <td class="strong light padding5 tbborder">Number</td>
              <td  class="strong light padding5 tbborder">Tonnage</td>
              <td class="strong light padding5 tbborder">Distance</td>
              <td class="strong light padding5 tbborder">Location</td></tr>';
            echo $row['eInput'];
            echo '<br><br>';
        } else {
            echo '<center><b>NO ENEMIES</b></center>';
        }
    }
} else {
    echo '<center><b>NO RESULTS</b></center>';
}
echo '<br><a href="index.php">GO BACK</a></center><br>';

?>