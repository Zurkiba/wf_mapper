<style>
    p {
        font-size: 4vw;
    }
    a {
        color: white;
    }
    body{
        background-color: #000000;
        color: white;
    }
    box{
        float:left;
        margin-right:20px;
    }
    clear{
        clear:both;
    }
</style>
<?php
$AO = $_GET['map'];
echo "<center><a href='index.php'>GO BACK</a></center>";

echo '<form name="form" action="cc.php" method="get">';
echo '<select name="map">';
echo '<option value="Home">Iota</option>';
echo '<option value="Torchlight" selected>Torchlight</option>';
echo '<input type="submit" id="submit"></form><br>';

echo '<center><b>' . $AO . ' Command Center</b></center>';
echo '<iframe src="'.$AO.'.png" width=90% height=600><p>Your browser does not support iframes.</p></iframe>';
echo '<a href="'.$AO.'.png">IMG</a>';
if ($AO == 'Torchlight'){
   echo '<center><b>Khans Landing Sub-AO</b></center>';
    echo '<iframe src="KhansLanding.png" width=90% height=600><p>Your browser does not support iframes.</p></iframe>';
    echo '<a href="KhansLanding.png">IMG</a>';
}
echo '<br><b>FLEET LIST</b><br>';
echo '<iframe src="list.php?map='.$AO.'&order=DESC&organize=tonnage" width=50% height=600><p>Your browser does not support iframes.</p></iframe>';





echo "<center><a href='index.php'>GO BACK</a></center>";
?>