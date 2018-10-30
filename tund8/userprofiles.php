<?php
	require("functions.php");
	$notice = "";

	//kui pole sisse loginud siis logimise lehele
	if (!isset($_SESSION["userid"])) {
		header("location: index_1.php");
		exit();
	}
	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("location: index_1.php");
		exit();
	}



	if(isset($_POST["submitProfile"])){
		$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
  } else {
	  $myprofile = showmyprofile();
  }
	
	//lehepäise laadmine
	$pagetitle = "Kasutaja profiili lisamine";
	require("header.php");
?>

	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	<P>Olete sisseloginud kasutajaga:<?php echo $_SESSION["firstName"] . " " .$_SESSION["lastName"];?></p>
	<hr>
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
	<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
		<label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>">
		<input name="submitProfile" type="submit" value="Salvesta profiil">
		<style>
	body{
		background-color: <?php echo $mybgcolor ?>;
		color: <?php echo  $mytxtcolor ?>;
	}
	</style>		
	</form>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
	<hr>
	<?php echo $mybgcolor. "\n". $mytxtcolor; ?>
</body>
</html>