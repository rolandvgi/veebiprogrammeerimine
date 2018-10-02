<?php
	//laen andmebaasi info
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_Roland_va_1";
	
	function signup($firstName, $lastName, $birhtdate, $gender, $email, $password){
		$notice ="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//valmistame parooli ette salvestamiseks -krüpteerime,teeme räsi(hash)
		$options = [
			"cost" => 12,
			"salt"=> substr(sha1(rand()), 0, 22),];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("sssiss", $firstName, $lastName, $birhtdate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice = "Uue kasutaja lisamine õnnestus";
		} else{
			$notice = "Kasutaja lisamisel tekkis viga" .$stmt->error;
		}			
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	//anonüümse sõnumi salvestamine
	function savecats($catname, $catcolor, $cattail){
		$notice = "";
		//serveri ühendus (server, kasutaja, parool, andmebaas)
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistan ette SQL käsu
		$stmt = $mysqli->prepare("INSERT INTO kiisu (nimi, v2rv, saba) VALUES (?, ?, ?)");
		echo $mysqli->error;
		//asendame SQL käsus küsimärgi päris infoga (andmetüüp,andmed ise)
		//s - string; i- integer; d -decimal e murdarv;
		$stmt->bind_param("ssi", $catname, $catcolor, $cattail);
		if ($stmt->execute()){
			$notice = 'andmed: "' .$catname .'" on salvestatud."';
		}	else {
				$notice = "andmete salvestamisel tekkis tõrge: " .$stmt->error;
			}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}	
	
	//tekstsisestuse kontroll
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


?>