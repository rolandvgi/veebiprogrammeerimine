<?php
	require("functions.php");
	$notice = "";

	//kui pole sisse loginud siis logimise lehele
	if (!isset($_SESSION["userid"])) {
		header("location: index_1.php");
		exit();
	} else {
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

	$mydescription = "Pole tutvustust lisanud!";
	$mybgcolor = "#FFFFFF";
	$mytxtcolor = "#000000";

	if(isset($_POST["submitProfile"])){
		$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $mydescription = $_POST["description"];
	}
		$mybgcolor = $_POST["bgcolor"];
		$mytxtcolor = $_POST["txtcolor"];
  } else {
	$myprofile = showmyprofile();
	if($myprofile->description != ""){
	  $mydescription = $myprofile->description;
    }
    if($myprofile->bgcolor != ""){
	  $mybgcolor = $myprofile->bgcolor;
    }
    if($myprofile->txtcolor != ""){
	  $mytxtcolor = $myprofile->txtcolor;
    }
  }
	
	
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Kasutaja profiil</title>
<style>
	 body{background-color: #fcf196; 
	color: #000000} 
</style>
</head>
<body>
	<h1>Kasutaja profiili lisamine</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	<P>Olete sisseloginud kasutajaga:<?php echo $_SESSION["firstName"] . " " .$_SESSION["lastName"];?></p>
	<hr>
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
	<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
		<label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>">
		<style>
	body{
		background-color: <?php echo $mybgcolor ?>;
		color: <?php echo  $mytxtcolor ?>;
	}
	</style>		
		<input type = "submit" name="submitdata" value="Salvesta andmed">
	</form>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
	<hr>
	<?php echo $mybgcolor. "\n". $mytxtcolor; ?>
</body>
</html>