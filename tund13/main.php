<?php
  require("functions.php");
  
  //kui pole sisseloginud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	header("Location: index.php");
	exit();  
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	session_destroy();
    header("Location: index.php");
	exit();
  }
  
	$pageTitle = "Pealeht";
	$scripts = '<script type="text/javascript" src="javascript/setrandompic.js" defer></script>' ."\n";
  require("header.php");
  
?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"] ."."; ?></p>
	<ul>
      <li><a href="?logout=1">Logi välja</a>!</li>
	  <li>Minu <a href="userprofiles.php">kasutajaprofiil</a>.</li>
	  <li>Süsteemi <a href="userlist.php">kasutajad</a>.</li>
	  <li>Valideeri anonüümseid <a href="validatemsg.php">sõnumeid</a>!</li>
	  <li>Näita valideeritud <a href="validatedmessages.php">sõnumeid</a> valideerijate kaupa!</li>
	  <li>Fotode <a href="photoupload.php">üleslaadimine</a>.</li>
	  <li>Avalike fotode <a href="pubgallery.php">galerii</a>.</li>
	  <li>Privaatsete fotode <a href="privgallery.php">galerii</a>.</li>
	  <li>Uudised <a href="vpnews.php"></a>.</li>
	</ul>
	<hr>
	<div id="pic">
	</div>
  </body>
</html>