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
  
$expiredate = date("Y-m-d");
$notice = listalluudised();

	if (isset($_POST["newsBtn"])){
		if ($_POST["newsEditor"] != "Siia sisesta oma uudis ..." and !empty($_POST["newsTitle"])){
		  $message = test_input($_POST["message"]);
		  $notice = uudistelisamine($title, $content, $expiredate);	
		} else {
		  $notice = "Palun sisesta uudis!";	
		}
	  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	  <?php
	    echo $_SESSION["firstName"];
		echo " ";
		echo $_SESSION["lastName"];
	  ?>
	, õppetöö</title>
	<style>
	  <?php
        echo "body{background-color: " .$_SESSION["bgColor"] ."; \n";
		echo "color: " .$_SESSION["txtColor"] ."} \n";
	  ?>
	</style>
  </head>
  <body>
    <h1>
	  <?php
	    echo $_SESSION["firstName"] ." " .$_SESSION["lastName"];
	  ?>
	</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a>!</li>
	  <li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value=""><br>
	<label>Uudise sisu:</label><br>
	<textarea name="newsEditor" id="newsEditor"></textarea>
	<br>
	<label>Uudis nähtav kuni (kaasaarvatud)</label>
	<input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $expiredate; ?>">
	<input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!">
	</form>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>
		tinymce.init({
			selector:'textarea#newsEditor',
			plugins: "link",
			menubar: 'edit',
		});
	</script>
	<?php
	
	echo $notice;
	
	?>
	
  </body>
</html>