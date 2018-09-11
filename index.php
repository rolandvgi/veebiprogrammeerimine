<?php
	//echo "See on minu esimene PHP!"; != ei ole võrdne
	$firstName = "Roland";
	$lastName = "Vägi";	
	$dateToday = date("d.m.Y");
	$hourNow = date("G");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "varane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "Koolipäev";
		}
	if ($hourNow >= 16){
		$partOfDay = "ilmselt vaba aeg";
	}
		
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
			echo $firstName ." ".$lastName; //. määrab
	?>
	</h1>					<!-- target blank on uus vahekaart!-->
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	<?php												//n= uus rida
	echo "<p>Tänane kuupäev on: " .$dateToday .".</p> \n";
	echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s ") ."käes oli ". $partOfDay . ".</p> \n";
	?>
	<p>Koduseks tööks oli vaja lisada uus rida, mida ma ka tegin.</p>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" 
	alt="TLÜ Terra õppehoone">!-->
	
	<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" 
	alt="TLÜ Terra õppehoone">
	<p>Mul on ka sõber, kes teeb oma <a href="../~urmoros/">veebi</a></p>
	<button a href="http://neti.ee">Vajuta siia, kuigi nupp ei tee midagi</button>
	
	

</body>
</html>