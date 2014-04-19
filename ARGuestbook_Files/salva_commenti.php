<?php

session_start();
$slug=$_SESSION['slug'];
$nomefile=$_SESSION['path'].$slug.".txt";
if(isset($_POST['nick'])) $nick=$_POST['nick'];
if(isset($_POST['commenti'])) $commento=$_POST['commenti'];
if(isset($_POST['code'])) $code = $_POST['code'];

//controllo antispam
$sum = $_SESSION['a']+$_SESSION['b'];
if(isset($code) && ($sum == $code)) scrittura($nomefile,$nick,$commento,$_SESSION['data']);
else{
echo "<SCRIPT>alert('Check that the result entered is correct');";
echo "history.back();</SCRIPT>";
}


 

//scrittura sul file
function scrittura($nomefile,$nick,$commento,$data){
if(($nick!="") && ($nick!=$_SESSION['nicktext'])){
if(($commento!="") && ($commento!=$_SESSION['textarea'])){
if(!is_dir($_SESSION['path'])) mkdir($_SESSION['path']);
if(!file_exists($nomefile)) $p_file=fopen($nomefile, "w+");
else $p_file = fopen($nomefile,"a");
if(!$p_file) die("Please contact the Administrator");
$scrivicommento = fwrite($p_file,$nick."|".$commento."|".$data."|".$_SERVER['REMOTE_ADDR']."\r\n");
//$scrivicommento = fwrite($p_file,"«".$commento."»");
fclose($p_file);
header('Location:'. $_SESSION['pageurl']);
}
else {
echo "<SCRIPT>alert('The typed text is too short or invalid');";
echo "history.back();</SCRIPT>";
}
}
else {
echo"<SCRIPT>alert('You must enter a valid Nickname');";
echo "history.back();</SCRIPT>";
}
}
?>
