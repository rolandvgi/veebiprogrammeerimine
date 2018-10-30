<?php
	//laen andmebaasi info
	require("../../../config.php");
	//echo $GLOBALS["serverUsername"];
	$database = "if18_Roland_va_1";
	
	//võtan kasutusele sessiooni
	session_start();
	 //kasutajaprofiili salvestamine
	 function storeuserprofile($desc, $bgcol, $txtcol){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($description, $bgcol, $txtcol);
		$stmt->execute();
		if($stmt->fetch()){
			//profiil juba olemas, uuendame
			$stmt->close();
			$stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, bgcolor=?, txtcolor=? WHERE id=?");
			echo $mysqli->error;
			$stmt->bind_param("sssi", $desc, $bgcol, $txtcol, $_SESSION["userid"]);
			if($stmt->execute()){
				$notice = "Profiil edukalt uuendatud!";
			} else {
				$notice = "Profiili uuendamisel tekkis tõrge! " .$stmt->error;
			}
		} else {
			//profiili pole, salvestame
			$stmt->close();
			//INSERT INTO vpusers3 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)"
			$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $mysqli->error;
			$stmt->bind_param("isss", $_SESSION["userid"], $desc, $bgcol, $txtcol);
			if($stmt->execute()){
				$notice = "Profiil edukalt salvestatud!";
				$_SESSION["bgColor"] = $bgcol;
				$_SESSION["txtColor"] = $txtcol;
			} else {
				$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
			}
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	  }
	  function showmyprofile(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($description, $bgcolor, $txtcolor);
		$stmt->execute();
		$profile = new Stdclass();
		if($stmt->fetch()){
			$profile->description = $description;
			$profile->bgcolor = $bgcolor;
			$profile->txtcolor = $txtcolor;
		} else {
			$profile->description = "Pole tutvustust lisanud!";
			$profile->bgcolor = "#FFFFFF";
			$profile->txtcolor = "#000000";
		}
		$stmt->close();
		$mysqli->close();
		return $profile;
	  }
	function userprofiles($userid, $mybgcolor, $mytxtcolor, $mydescription){
		$totalhtml = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("isss", $userid , $mydescription, $mybgcolor, $mytxtcolor);
		if($stmt->execute()){
			$notice = "Kasutaja profiili lisamine õnnestus";
		} else{
			$notice = "Kasutaja profiili lisamisel tekkis viga" .$stmt->error;
		}			
		$stmt->close();
		$mysqli->close();
		return $notice;

	}


	function getuserprofiles($userid){
		$totalhtml = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, userid, description, bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");// andmete küsimine andmebaasist = select
		echo $mysqli->error;
		$stmt->bind_param("i",$userid);
		$stmt->bind_result($id, $userid, $description, $bgcolor ,$txtcolor);
		if($stmt->fetch()){
			$data = ["bgcolor" =>$bgcolor, "txtcolor"=>$txtcolor, "description"=>$description];//kui kasutaja on varem sättinud ss tuleb tema valik
		} else {
			$data = ["bgcolor" =>"#FFFFFF", "txtcolor"=>"#000000", "description" => "Pole iseloomustust lisanud."];// ehks siis kui kasutaja on esimest korda siis default on see
		}
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		return $data;
	}
	

	//kõige valideeritud sõnumite lugemine kasutajate kaupa
	function readallvalidatedmessagesbyuser(){
		$msghtml = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");// andmete küsimine andmebaasist = select
		echo $mysqli->error;
		$stmt ->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);//suvalised muutujad mis tulevad preparest,muutujanimed on suvalsed aga järjekord on oluline

		$stmt2= $mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
		echo $mysqli->error;
		$stmt2->bind_param("i", $idfromdb);
		$stmt2->bind_result($msgfromdb, $acceptedfromdb);
		
		$stmt->execute();
		//et hoida andmebaasist loetud andmeid pisut kauem mälus hoida, et saaks edasi kasutada
		$stmt->store_result();
		while ($stmt->fetch()){
			$msghtml.= "<h3>" .$firstnamefromdb. " " . $lastnamefromdb . " ". "</h3> \n";
			$stmt2->execute();
			while($stmt2->fetch()){
				$msghtml .="<p><b>";
				if($acceptedfromdb ==1){
					$msghtml .= "Lubatud: ";
				} else{
					$msghtml .= "Keelatud:";
				}
				$msghtml .="</b>" .$msgfromdb ."</p> \n";
			}
		}
		$stmt2->close(); 
		$stmt->close();
		$mysqli->close();
		return $msghtml;
	}

	// UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?
	function users (){
		$notice = "<ul>";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id != ?");
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($firstName, $lastName, $email);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= "<li>" . $firstName . " ". $lastName . " " .$email . "</li>";
		}
		$notice .="</ul>";
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	function listallmessages(){
		$notice = "<ul> \n"; //ul on täpploend
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]); //päärdub andmebaasi polle
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=1");
		echo $mysqli->error;
		$stmt->bind_result($msg);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= "<li>" . $msg . "</li>";
		}
		$notice .= "</ul>";
		$stmt->close();
		$mysqli->close();
		return $notice;
	  }
	  //loen sõnumi valideerimiseks
	function validatemsg ($messageId, $accepted, $userid){
		$notice = "sõnum valideeritud";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?");
		$stmt->bind_param("iii", $userid, $accepted, $messageId);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
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
					$profile = getuserprofiles($idFromdb);

					$_SESSION["description"] = $profile["description"];
					$_SESSION["bgcolor"] = $profile["bgcolor"];
					$_SESSION["txtcolor"] = $profile["txtcolor"];
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
	function saveamsg($msg){
		$notice = "";
		//serveri ühendus (server, kasutaja, parool, andmebaas)
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistan ette SQL käsu
		$stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES (?)");
		echo $mysqli->error;
		//asendame SQL käsus küsimärgi päris infoga (andmetüüp,andmed ise)
		//s - string; i- integer; d -decimal e murdarv;
		$stmt->bind_param("s", $msg);
		if ($stmt->execute()){
			$notice = 'sõnum: "' .$msg .'" on salvestatud."';
		}	else {
				$notice = "sõnum salvestamisel tekkis tõrge: " .$stmt->error;
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