<?php
	//laen andmebaasi info
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_Roland_va_1";
	
	//võtan kasutusele sessiooni
	session_start();

	//loen sõnumi valideerimiseks
	// UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?
	function readmsgforvalidation($editId){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($msg);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $msg;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	  }

	//valideerimata sõnumite lugemine
	function readallunvalidatedmessages(){
		$notice = "<ul> \n"; //ul on täpploend
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); //päärdub andmebaasi polle
		$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_result($id, $msg);
		$stmt->execute();
		
		while($stmt->fetch()){
			$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
		}
		$notice .="</ul> \n";
		$stmt->close();
		$mysqli->close();
		return $notice;
	  }

	//sisse logimine
	function signin($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
		$mysqli->error; //error ainult meile
		$stmt->bind_param("s", $email); //seome mingi parameetri saadab
		$stmt->bind_result($idFromdb, $firtnameFromdb, $lastnameFromdb, $passwordFromdb);// kui midagi andmebaasist tulema peab peal olema alati result
		if($stmt->execute()){//kui õnnestus andmebaasist lugemine
			if($stmt->fetch()){
				//leiti selline kasutaja
			 	if(password_verify($password, $passwordFromdb)){ //kontrollib kas antud paroolid lähevad kokku
					//parool õige
					$notice = "Logisite õnnelikult sisse";
					$_SESSION["userid"] =$idFromdb;
					$_SESSION["firstName"] = $lastnameFromdb;
					$_SESSION["lastName"] = $lastnameFromdb;
					$stmt->close();
					$mysqli->close();
					header("location: main.php"); // läheb teisele lehele kui on koos locationiga
				} else {
					$notice = "Sisestasite vale salasõna";
												
				}
			} else {
				 $notice = "Sellist kasutajat ei leitud(".$email .") ei leitud";
			}
		} else {
			$notice = "Sisselogimisel tekkis tehniline viga". $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signup($firstName, $lastName, $birthdate, $gender, $email, $password){
		$notice ="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//valmistame parooli ette salvestamiseks -krüpteerime,teeme räsi(hash)
		$options = [
			"cost" => 12,
			"salt"=> substr(sha1(rand()), 0, 22),];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		$stmt->bind_param("sssiss", $firstName, $lastName, $birthdate, $gender, $email, $pwdhash);
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