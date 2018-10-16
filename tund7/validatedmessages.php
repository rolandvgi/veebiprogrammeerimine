<?php
  require("functions.php");
  
   //kui pole sisse loginud siis logimise lehele
   if(!isset($_SESSION["userid"])){ 
    header("location: index_1.php");
    exit();
  }  else {

    }
  
  //logime välja
if(isset($_GET["logout"])){
    session_destroy();
    header("location: index_1.php");
    exit();
}

$messages = readallvalidatedmessagesbyuser();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>

	<li><a href="main.php">Tagasi</a> pealehele!</li>
  </ul>
  <hr>
  <h2>Valideerimata sõnumid<?php echo $messages; ?> </h2>


</body>
</html>
