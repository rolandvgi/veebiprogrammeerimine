<?php
  require("functions.php");
  $notice = "";
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
if(isset($_GET["id"])){
	$msgid = $_GET["id"];
    $msg = readmsgforvalidation($_GET["id"]);
}
if (isset($_POST["submitValidation"]) and isset($_POST["id"])){
	$msgid = readmsgforvalidation($_GET["id"]);
	$msg = readmsgforvalidation($_GET["id"]);
	$notice = validatemsg($_POST["id"], $_POST["validation"], $_SESSION["userid"]);
	}
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
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="validatemsg.php">Tagasi</a> sõnumite lehele!</li>
  </ul>
  <hr>
  <h2>Valideeri see sõnum:</h2>
  <form method="POST">
    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
    <p><?php echo $msg; ?></p>
    <input type="radio" name="validation" value="0" checked><label>Keela näitamine</label><br>
    <input type="radio" name="validation" value="1"><label>Luba näitamine</label><br>
    <input type="submit" value="Kinnita" name="submitValidation">
	<span><?php echo $notice;?></span>
  </form>
  <hr>
  
  

</body>
</html>