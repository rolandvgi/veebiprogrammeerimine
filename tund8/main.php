<?php
  require("functions.php");

  //kui pole sisse loginud siis logimise lehele
  if(!isset($_SESSION["userid"])){ 
    header("location: index_1.php");
    exit();
  }  else {
    $mybgcolor = $_SESSION["bgcolor"];
		$mytxtcolor = $_SESSION["txtcolor"];
		$mydescription = $_SESSION["description"];
    }
  
  //logime välja
if(isset($_GET["logout"])){
    session_destroy();
    header("location: index_1.php");
    exit();
}
$pagetitle = "Pealeht";
require("header.php");

if (!isset($_POST["bgcolor"])){
  $notice = "error";
}
else if (!isset($_POST["txtcolor"])){
  $notice = "error";
} else {
  $mybgcolor = $_POST["bgcolor"];
  $mytxtcolor = $_POST["txtcolor"];
  $mydescription = $_POST["description"];
  userprofiles($_SESSION["userid"], $mybgcolor, $mytxtcolor, $mydescription);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>pealeht</title>  
     <?php 
        echo "<style>" .
            "body{background-color:" . $_SESSION["bgcolor"] . " \n" .
            "color: ".$_SESSION["txtcolor"] ."} /n" .
            "</style>";
    ?>
  </head>
  <body>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
    <p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]. " " .$_SESSION["lastName"]. ".";?></p>
	<ul>
      <li><a href="?logout=1">Logi välja!</a></li>
      <li> <a href="validatemsg.php">Valideeri anonüümseid sõnumeid!</a></li>
      <li> Näita valideeritud<a href="validatedmessages.php">sõnumeid</a>valideerijate kaupa!</li>
      <li>Fotode <a href="photoupload.php">üleslaadimine </li>
      <li><a href ="userprofiles.php">Kasutaja profiili täitmine</li>
  
	</ul>
	
  </body>
</html>