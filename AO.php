<style>
    img {
       height:auto;
       width:100%;
    }
    p {
        font-size: 4vw;
    }
    a {
        color: white;
    }
    body{
        background-color: #000000;
    }
</style>
<?php
$AO = $_GET['map'];
echo '<center><a href="map.php">GO BACK</a></center><br>';
if ($AO == 'Torchlight'){
    echo "<center><br><a href='AO.php?map=KhansLanding'>KHAN'S LANDING AO</a></center><br>";
}
echo "<img src='" . $AO . ".png'><br><center><a href='map.php'>GO BACK</a></center>";
?>