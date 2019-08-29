<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$t = explode(",",$_GET['target']);
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * from strikers WHERE active=1";
$result = $conn->query($sql);
$name = array();
$travelTime = array();
$TZ = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $loc = explode(",",$row['coords']);
        $dist = (sqrt(
                     pow($t[0]-$loc[0],2) +
                     pow($t[1]-$loc[1],2) +
                     pow($t[2]-$loc[2],2)) *
                    4000);
        $kmHour = ($row['speed']/1000)*3600;
        $time = ($dist / $kmHour)*60;
        array_push($depart,$travelTime); //This compiles all the travel times
        array_push($name, $row['name']); //This compiles the names
        array_push($TZ, $row['tz']); //Compiles the timezones
    }
}
$conn->close();

$slowest = max($travelTime);
echo '<table><tr>';
for ($i=0;$i < count($travelTime); $i++){
    echo '<td>';
    if ($travelTime[$i] == $slowest){
        echo '<i><center>SLOWEST FLEET</center></i>';
    }
    echo '<b>' . $name[$i] . '</b><br>';
    $launchTime = time()+$slowest-$travelTime[$i];
    $depart = new DateTime("now", new DateTimeZone($tz[$i]));
    $depart->setTimestamp($leaveTime);
    echo '<br><br><center><b>LEAVE AT</b><br>' . $depart->format('jS \of F, H:i') . ' ' .$TZ[$i] . '<br>' . '</center>'; 
}
echo '</tr></table>';
$arrivalTime = time()+$slowest;
$arrival = new DateTime("now", new DateTimeZone('America/New_York'));
$arrival->setTimeStamp($arrivalTime);
echo '<center><b>ARRIVAL: </b>' . $arrival->format('jS \of F, H:i') . ' EASTERN -5 GMT</center>';
$arrival = new DateTime("now", new DateTimeZone('America/Denver'));
$arrival->setTimeStamp($arrivalTime);
echo '<center><b>ARRIVAL: </b>' . $arrival->format('jS \of F, H:i') . ' MOUNTAIN -7 GMT</center>';
$arrival = new DateTime("now", new DateTimeZone('Europe/Berlin'));
$arrival->setTimeStamp($arrivalTime);
echo '<center><b>ARRIVAL: </b>' . $arrival->format('jS \of F, H:i') . ' BERLIN +2 GMT</center><br>';

?>