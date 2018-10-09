<?php
		//kutsume välja funktsioonide faili
	require ("functions.php");
	$notice = "";
	$firstName = "";
	$lastName = "";
	$birthday = null;
	$birthyear = null;
	$birthmonth = null;
	$birthdate = null;
	$gender = null;
	$email = "";
	$password = null;
	$confirmpassword = null;
	
	
	$firstNameError = "";
	$lastNameError = "";
	$birthdayError = "";
	$birthyearError = "";
	$birthmonthError = "";
	$birthdateError = "";
	$genderError = "";
	$emailError = "";
	$passwordError = "";
	$confirmpasswordError = "";
	
	$monthNames = [
		'jaanuar',
		'veebruar',
		'märts',
		'aprill',
		'mail',
		'juuni',
		'juuli',
		'august',
		'september',
		'oktoober',
		'november',
		'detsember'
	];
	
	//kontrollime, kas kasutaja on nuppu vajutanud
	if (isset($_POST["submitUserData"])){
		
	//var_dump($_POST);
	if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		//$firstName = $_POST["firstName"];
		$firstName = test_input($_POST["firstName"]);
	}	else {
		$firstNameError = " Palun sisesta oma eesnimi!";
		
	}
	if (isset($_POST["lastName"]) and !empty($_POST["lastName"])){
		//$lastName = $_POST["lastName"];
		$lastName = test_input($_POST["lastName"]);
	}	else {
		$lastNameError =" Palun sisesta oma perekonnanimi!";
	}
	if (isset($_POST["gender"])	and !empty($_POST["gender"])){
		$gender = intval($_POST["gender"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
			$genderError = "Palun määra sugu!";
	}	
	if (isset($_POST["email"])	and !empty($_POST["email"])){
		$email = test_input($_POST["email"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
			$emailError = "Palun sisesta oma email!";
	}
	if (isset($_POST["password"]) and !empty($_POST["password"]) and strlen($_POST["password"]) >=8) {
		$password = test_input($_POST["password"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
		$passwordError = "Palun sisesta oma parool!(min 8 märki)";         
	}
	if ($_POST["password"] == $_POST["confirmpassword"]) {
		$confirmpassword = test_input($_POST["confirmpassword"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
			$confirmpasswordError = "Teie sisestatud paroolid on erinevad!";   
	}
	if (isset($_POST["birthday"])	and !empty($_POST["birthday"])){
		$birthday = test_input($_POST["birthday"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
			$birthdayError = "Palun sisesta oma email!";
	}
	if (isset($_POST["birthyear"])	and !empty($_POST["birthyear"])){
		$birthyear = test_input($_POST["birthyear"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
			$birthyearError = "Palun sisesta oma email!";
	}
	if (isset($_POST["birthmonth"])	and !empty($_POST["birthmonth"])){
		$birthmonth = test_input($_POST["birthmonth"]); //saadaks andmebaasi numbri 1 või 2, et errorit ei tuleks
	} else {
		$birthmonthError = "Palun sisesta oma email!";
	}
	if(checkdate(intval($_POST["birthday"]), intval($_POST["birthmonth"]), intval(["birthyear"]))){
		$birthdate = date_create($_POST["birthday"]. "/" .$_POST["birthmonth"] ."/" .$_POST["birthyear"]);
		$birthdate = date_format($birthdate, "Y-m-d");
		echo $birthdate;
	} else {
		$birthdayError = "Palun sisesta oma email!";
	}
	//kui kõik on korras siis salvetan kasutaja
	if(empty($firstNameError) and empty($lastNameError) and empty($birthyearError) and empty($birthmonthError) and empty($birthdateError) and empty($genderError) and empty($emailError) and empty($passwordError) and empty($confirmpasswordError)
		and empty($birthdayError) and empty ($birthmonthError) and empty($birthyearError)){ 
		echo "tegutsen";
		echo $firstNameError .$lastNameError . $birthyearError. $birthmonthError .$birthdateError .$genderError. $emailError .$passwordError;
		$notice = signup($firstName, $lastName, $birthdate, $gender, $email, $_POST["password"]);	
	}
	
	}//kas vajutati nuppu -lõpp
	
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Uue kasutaja loomine</title>
</head>
<body style="background:moccasin">
	<h1>Loo kasutaja</h1>

	<hr>
	
	<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Eesnimi:</label><br>
		<input type = "text" name="firstName" value = "<?php echo $firstName; ?>"><span><?php echo $firstNameError; ?></span><br>
		<label>Perekonnanimi:</label><br>
		<input type = "text" name="lastName" value = "<?php echo $lastName; ?>"><span><?php echo $lastNameError; ?></span><br>
		<label>Sünnipäev: </label>
		<?php
	    echo '<select name="birthday">' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthday){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  
	  <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonth">' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthNames[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  
		<!--<label> Sünnikuu: </label> 
		<select name="birthMonth">
		<option value="1" <?php if ($birthmonth == 1) echo 'selected';?> >jaanuar</option>
		<option value="2" <?php if ($birthmonth == 2) echo 'selected';?>> veebruar</option>
		<option value="3" <?php if ($birthmonth ==3) echo 'selected';?> >märts</option>
		<option value="4" <?php if ($birthmonth == 4)echo 'selected';?> >aprill</option>
		<option value="5" <?php if ($birthmonth == 5) echo 'selected';?> >mai</option>
		<option value="6" <?php if ($birthmonth == 6) echo 'selected';?> >juuni</option>
		<option value="7" <?php if ($birthmonth == 7) echo 'selected';?> >juuli</option>
		<option value="8" <?php if ($birthmonth == 8) echo 'selected';?> >august</option>
		<option value="9" <?php if ($birthmonth == 9) echo ' selected';?>>september</option> 
		<option value="10" <?php if ($birthmonth == 10) echo 'selected';?> >oktoober</option>
		<option value="11" <?php if ($birthmonth == 11) echo 'selected';?> >november</option>
		<option value="12" <?php if ($birthmonth == 12) echo 'selected';?> >detsember</option>
		</select>-->
		<!--<label>Sünniaasta: </label>
		<input type ="number" min="1914" max="2000" value="1999" name="birthYear">-->
		 <label>Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyear">' ."\n";		// -- tsükkel läheb alla poole 2018-15=2003 2002 2001
		for ($i = date("Y")- 15; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
		<br>
		<input type = "radio" name= "gender" value = "2" <?php if($gender ==2) {echo "checked";}?>> <label>Naine</label><br>
		<input type = "radio" name= "gender" value = "1" <?php if($gender ==1) {echo "checked";}?>> <label>Mees</label><br>
		<span> <?php echo $genderError; ?></span>
		<br>
		<label>E-postiaadress(kasutajatunnuseks):</label>
		<input name="email" type="email"> 	<span> <?php echo $emailError; ?></span>
		<!-- /span on lihtsalt element mille vahele saab asju kirjutada-->
		<br>
		<label>Salasõna (min 8 märki):</label>
		<input type = "password" name= "password"> <span> <?php echo $passwordError;?> </span>
		<label> Korrake salasõna:</label>
		<input type="password" name="confirmpassword"> <span> <?php echo $confirmpasswordError;?> </span>
		<input type = "submit" name="submitUserData" value="Loo kasutaja">
	</form>
	<hr>
	<p><?php echo $notice;?></p>
</body>
</html>