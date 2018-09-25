<?php
	//echo "See on minu esimene PHP!"; != ei ole võrdne
	$firstName = "Roland";
	$lastName = "Vägi";
	//loeme piltide kataloogi sisu
	$dirToRead = "../../pics/";
	$allFiles = scandir($dirToRead);
	$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	$picNumh = mt_rand(1, 3);		
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>
		<?php
			echo $firstName;
			echo " ";
			echo $lastName;
		?>
	, õppetöö</title>
</head>
<body>
	<h1>
	<?php
			echo $firstName ." ".$lastName; //
	?>
	</h1>					<!-- target blank on uus vahekaart!-->
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	<?php
		if (isset($picFiles) && count($picFiles) > 0) {
			echo '<img src="' . $dirToRead . $picFiles[rand(0, count($picFiles) - 1)] . '" alt="Pilt">';
					} 
	//<img src ="" alt="pilt">
	//for($i = 0; $i< $allFiles = mt_rand(1,3); $i ++){ //$i< count($picFiles)
	//	echo '<img src="' .$dirToRead .$picFiles[$i] .'" alt="pilt"><br>'."\n";
		//echo '<img src ="'. $dirToRead .$picFiles[$i] .'" alt="pilt"><br>'."\n";
		//}
		
	?>
</body>
</html>