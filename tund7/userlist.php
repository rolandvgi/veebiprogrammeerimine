<?php
  require("functions.php");

  //kui pole sisse loginud siis logimise lehele
  if(!isset($_SESSION["userid"])){ 
    header("location: index_1.php");
    exit();
  }  else {

    }
  
  //logime välja
if(isset($_GET["logout"])){
    session_destroy();
    header("location: index_1.php");
    exit();
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
    <p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]. " " .$_SESSION["lastName"]. ".";?></p>
	<p><?php echo users();?></p>
	
  </body>
</html>