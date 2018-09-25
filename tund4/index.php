<?php
	//echo "See on minu esimene PHP!"; != ei ole võrdne
	$firstName = "Roland";
	$lastName = "Vägi";	
	$dateToday = date("d.F.Y");
	$weekdayNow = date("N");
	$weekdayNamesET = ["esmaspäev", "teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
	$monthdayET = 
	["jaanuar",
	"veebruar",
	"märts",
	"aprill",
	"mai",
	"juuni",
	"juuli",
	"august",
	"september",
	"oktoober",
	"november",
	"detsember"];
	//echo $weekdayNamesET[1];
	//var_dump($weekdayNamesET);
	//echo $weekdayNow;
	$yearNow = date("Y");
	$dateNow = date("j");
	$monthNow = date("n");
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
	$picNum = mt_rand(2, 43);
	//echo $picNum;		
	$picUrl = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picEXT = ".jpg";
	$picFile = $picUrl .$picNum .$picEXT;
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
	
	<p>Tundides tehtu: <a href="photo.php">photo.php</a></p>
	<?php												// \n= uus rida
	//echo "<p>Tänane kuupäev on: " .$dateToday .".</p> \n";
	//echo  "<p>Täna on ".$weekdayNow .", " .$dateToday .".</p> \n";
	echo  "<p>Täna on ".$weekdayNamesET[$weekdayNow - 1] .", ".$dateNow .". " . $monthdayET[$monthNow - 1] ." ". $yearNow ."".".</p> \n";
	echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s ") ."käes oli ". $partOfDay . ".</p> \n";
	?>
	<p>Koduseks tööks oli vaja lisada uus rida, mida ma ka tegin.</p>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" 
	alt="TLÜ Terra õppehoone">!-->
	
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" 
	alt="TLÜ Terra õppehoone">-->
	<img src ="<?php echo $picFile; ?>" alt="TLÜ Terra õppehoone">
	<p>Mul on ka sõber, kes teeb oma <a href="../../../~urmoros/">veebi</a></p>
	<button formaction="https://www.neti.ee/">"Vajuta siia, kuigi nupp ei tee midagi</button>
	
	

</body>
</html>