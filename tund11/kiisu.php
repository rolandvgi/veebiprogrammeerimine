<?php
	require ("functions.php");
$notice = null;
$givecats = savecats();


	if (isset($_POST["catname"]));{
		if (!empty($_POST["catname"])){
			$cats = test_input($_POST["catname"]);
			$notice = savecats($catname, $catcolor, $cattail);
		}	else {
				$notice = "Palun sisesta kiisu nimi";
		}
	}
	if (isset($_POST["catcolor"]));{	
		if (!empty($_POST["catcolor"])){
			$cats = test_input($_POST["catcolor"]);
			$notice = savecats($catname, $catcolor, $cattail);
		}	else {
				$notice = "Palun sisesta kiisu värvus";
		}
	}
	if (isset($_POST["cattail"]));{	
		if (!empty($_POST["cattail"])){
			$cats = test_input($_POST["cattail"]);
			$notice = savecats($catname, $catcolor, $cattail);
		}	else {
				$notice = "Palun sisesta kiisu saba pikkus";
		
		}
	}	




?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Kiisude lisamine</title>
</head>
<body>
	<h1>Kiisu lisamine</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Kiisu nimi:</label>
		<input type = "text" name = "catname">
		<label>Kiisu värvus:</label>
		<input type = "text" name = "catcolor">
		<label>Kiisu saba pikkus:</label>
		<input type = "text" name = "cattail">
		<br>
		<input type = "submit" name="submitdata" value="Salvesta andmed">
	</form>
	<hr>
	<?php echo $givecats ?>
</body>
</html>