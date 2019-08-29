<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$user = $_GET['user'];
$pass = $_GET['pass'];
$new = $_GET['new'];
$delete = $_GET['delete'];

$base_encryption_array = array(
    '0'=>'b76','1'=>'d75','2'=>'f74','3'=>'h73','4'=>'j72','5'=>'l71','6'=>'n70','7'=>'p69','8'=>'r68','9'=>'t67',
    'a'=>'v66','A'=>'v87','b'=>'x65','B'=>'x86','c'=>'z64','C'=>'z85','d'=>'a63','D'=>'a84','e'=>'d62','E'=>'d83',
    'f'=>'e61','F'=>'e82','g'=>'h60','G'=>'h81','h'=>'i59','H'=>'i80','i'=>'j58','I'=>'j79','j'=>'g57','J'=>'g78',
    'k'=>'f56','K'=>'f77','l'=>'c55','L'=>'c76','m'=>'b54','M'=>'b75','n'=>'y53','N'=>'y74','o'=>'w52','O'=>'w73',
    'p'=>'u51','P'=>'u72','q'=>'s50','Q'=>'s71','r'=>'q49','R'=>'q70','s'=>'o48','S'=>'o69','t'=>'m47','T'=>'m68',
    'u'=>'k46','U'=>'k67','v'=>'i45','V'=>'i66','w'=>'g44','W'=>'g65','x'=>'e43','X'=>'e64','y'=>'c42','Y'=>'c63',
    'z'=>'a41','Z'=>'a62','!'=>'o36','@'=>'j11');
# strtr($user, array_flip($base_encryption_array))
# strtr($user, $base_encryption_array)

#Username: <input type="text" name="user" id="user" value="'.strtr($user, $base_encryption_array).'"><br>
#Password: <input type="text" name="pass" id="pass" value="'.strtr($pass, $base_encryption_array).'"><br>

echo '<b>ADD YOUR ACCOUNT:<br></b>
<form name="form" action="account.php" method="get">
  Username: <input type="text" name="user" id="user" value=""><br>
  Password: <input type="text" name="pass" id="pass" value=""><br>
  <input type="checkbox" name="new" value="1">
  <i>My username/password will be stored<br>
  on a relatively insecure server. My password will be<br>
  stored with a weak encryption which is easy to decrypt<br>
  but can not be identified at first glance<br>
  The password will be encrypted with a custom<br>
  encryption key which will turn the password<br>
  "password" into "u51v66o48o48g44w52q49a63".<br>
  Automated systems will log into your war-facts<br>
  account every hour and access one page.<br>
  The code is open source at <a href="https://github.com/Zurkiba/wf">this git</a><br>
  <b>CHECK BOX TO INDICATE YOU UNDERSTAND</b></i>
  <br><br><input type="submit" id="submit">
</form><br><br>';
echo '<b>DELETE YOUR ACCOUNT:<br></b>
<form name="form" action="account.php" method="get">
    Username: <input type="text" name="user" id="user" value="'.strtr($user, $base_encryption_array).'"><br>
    Password: <input type="text" name="pass" id="pass" value="'.strtr($pass, $base_encryption_array).'"><br>
    <input type="checkbox" name="delete" value="1"> <i>Remove my account/password<br>
    from the database</i>
    <br><br><input type="submit" id="submit">';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if ($new == 1){
    $sql = "INSERT INTO accounts (user,pass) VALUES('".strtr($user, $base_encryption_array)."','".strtr($pass, $base_encryption_array)."')";
    if ($conn->multi_query($sql) === TRUE) {
        echo '<br>NEW ACCOUNT ADDED';
        $add = "INSERT INTO input (name) VALUES ('$user')";
        if ($conn->multi_query($add) === TRUE) {
        } else{
        echo $conn->error;
        }
    } else{
        echo $conn->error;
        }
}

if ($delete == 1){
    $sql = 'DELETE FROM accounts WHERE pass='.strtr($pass, array_flip($base_encryption_array)).' AND user='.strtr($user, array_flip($base_encryption_array));
    if ($conn->multi_query($sql) === TRUE) {
        echo '<br>ACCOUNT DELETED';
    } else{
        echo $conn->error;
        }
}

?>