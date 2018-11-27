<?php
  require("functions.php");

  //kui pole sisse loginud siis logimise lehele
     if(!isset($_SESSION["userId"])){ 
       header("location: index.php");
       exit();
     }
  
  //logime välja
 if(isset($_GET["logout"])){
     session_destroy();
    header("location: index.php");
     exit();
 }
    require ("classes/Photoupload.class.php");
//  require("classes/Test.class.php");
//  $myTest = new Test(4);
//  $mySecondaryTest = new Test(7);
//  echo $mySecondaryTest->publicNumber;
//  echo "Teine avalik number on: " .$mySecondaryTest->publicNumber ."! ";
//  echo $myTest->publicNumber;
// // echo$myTest->secretNumber;
// $myTest->tellInfo();
// unset($myTest);

//piltide laadimis osa
  $target_dir = "../vp_pic_uploads/";
  $uploadOk = 1;
  // Check if image file is a actual image or fake image
  if(isset($_POST["submitImage"])) {
    if(!empty($_FILES["fileToUpload"]["name"])){
      $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
      //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $timeStamp =microtime(1) *10000;

      $target_file_name =  "vp_" .$timeStamp . "." .$imageFileType;
      $target_file = $target_dir. $target_file_name;

      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "Fail on " . $check["mime"] . "Pilt.";
          //$uploadOk = 1;
      } else {
          echo "Fail ei ole pilt.";
          $uploadOk = 0;
      }
    }
// Check if file already exists
  if (file_exists($target_file)) {
    echo "Vabandage, selle nimega fail on juba olemas.";
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 2500000) {
    echo "Vabandage pilt on liiga suur.";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Vabandage, ainult JPG, JPEG, PNG & GIF failid on lubatud.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Vabandage, valitud faili ei saa üles laadida.";
  // if everything is ok, try to upload file
  } else {

      $myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
      $myPhoto->changePhotosize(600, 400);
      $myPhoto->addWatermark();
      $myPhoto->addTextToImage();
      $notice = $myPhoto->savePhoto($target_file);
      unset($myPhoto);
      
      //kui salvestamine õnnestus
      if ($notice = 1){
        addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
      } else{
        echo "Vabandme, faili üleslaadiimsel tekkis tehniline viga";
      }
    /* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
    } else {
        echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
    } */
  }

    }//siin lõppeb nupu vajutuse kontroll

//lehepäise laadmine
$pageTitle = "Fotode üleslaadimine";
require("header.php");

?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
    <p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"]. " " .$_SESSION["lastName"]. ".";?></p>
	<ul>
      <li><a href="?logout=1">Logi välja!</a></li>
      <li>Tagasi <a href="main.php">Pealehele</a></li> 
  </ul>
  <hr>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    Vali üleslaetav pildifail(soovitavalt mahuga kuni 2,5 MB): </label><br>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <label>Alt tekst: </label>
    <input type="text" name="alttext">
    <br>
    <label>Määra pildi kasutusõigused</label>
    <br>
    <input type="radio" name="privacy" value="1">Avalik pilt</label>
    <input type="radio" name="privacy" value="2">Ainult sisseloginud kasutajatele</label>
    <input type="radio" name="privacy" value="3"checked>Privaatne</label>
    <br>
    <input type="submit" value="Lae pilt üles" name="submitImage">

  </form>
	
  </body>
</html>