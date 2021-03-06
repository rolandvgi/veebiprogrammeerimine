<?php
  require("functions.php");
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	session_destroy();
	header("Location: index_1.php");
	exit();
  }

  $page = 1;
  $totalImages = findTotalPrivateImages();
  //echo $totalImages;
  $limit = 10;
  if (!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif (round(($_GET["page"] - 1) * $limit) > $totalImages){
	  $page = round($totalImages / $limit) - 1;
  } else {
	  $page = $_GET["page"];
  }
  
  //$thumbslist  = listpublicphotos(3);
  $thumbslist  = listmyprivatephotos($page, $limit);
  $pageTitle = "Privaatsed fotod";
  $scripts = '<link rel="stylesheet" type ="text/css" href="style/modal.css">' ."\n";
  $scripts .= '<script type ="text/javascript" src="javascript/modal.js" defer></script>' ."\n";
  require("header.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a>!</li>
	  <li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
	<hr>
   <!-- The Modal -->
<div id="myModal" class="modal">
   <!-- The Close Button -->
   <span class="close">&times;</span>

   <!-- Modal Content (The Image) -->
    <img class="modal-content" id="modalImg">

   <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>
  <div id ="gallery">
  <?php
    echo "<p>";
		if ($page > 1){
			echo '<a href="?page=' .($page - 1) .'">Eelmised pildid</a> ';
		} else {
			echo "<span>Eelmised pildid</span> ";
		}
		if ($page * $limit < $totalImages){
			echo '| <a href="?page=' .($page + 1) .'">Järgmised pildid</a>';
		} else {
			echo "| <span>Järgmised pildid</span>";
		}
		echo "</p> \n";
		echo $thumbslist;
  ?>
	</div>
	
  </body>
</html>