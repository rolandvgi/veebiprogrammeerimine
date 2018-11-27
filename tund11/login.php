<?php
  require("functions.php");
  $notice = "";
  $email = "";
  $emailError = "";
  $passwordError = "";
  
  if(isset($_POST["submit"])){
	if (isset($_POST["email"]) and !empty($_POST["email"])){
	  $email = test_input($_POST["email"]);
    } else {
	  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
    }
  
    if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
	  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
    }
  
  if(empty($emailError) and empty($passwordError)){
	 $notice = signin($email, $_POST["password"]);
	 } else {
	  $notice = "Ei saa sisse logida!";
  }
  
  }


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Katseline veeb</title>
	<link rel="stylesheet" href="css.css">
  </head>
  <body>
	<div id="container">
		<div id="content">
			<form class="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST">
				<h1 class="login-title">Kasutaja Sisselogimine</h1>
				<input type="email" class="login-input" placeholder="Sisesta email" name="email" autofocus required><span><?php echo $emailError; ?></span>
				<input type="password" class="login-input" placeholder="Password" name="password" required><span><?php echo $passwordError; ?></span>
				<input type="submit" name="submit" value="Logi sisse" class="login-button"><span><?php echo $notice; ?></span>
				<a href="newuser.php" class="button">Registreeri kasutaja</a> 
			</form>
		</div>
	</div>
  </body>
</html>