<?php
  require("functions.php");

  //kui pole sisse loginud siis logimise lehele
    if(!isset($_SESSION["userid"])){ 
      header("location: index_1.php");
      exit();
    }
  
  //logime välja
if(isset($_GET["logout"])){
    session_destroy();
    header("location: index_1.php");
    exit();
}
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

      $target_file = $target_dir . "vp_" .$timeStamp . "." .$imageFileType;

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
      //sõltuvalt faili tüübist loon sobiva pildi objekti
      if($imageFileType =="jpg" or $imageFileType =="jpeg"){
        $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
      }
      if($imageFileType =="png" ){
        $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
      }
      if($imageFileType =="gif"){
        $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
      }

      //pildi originaal suurus
      $imageWidth = imagesx($myTempImage);
      $imageHeight = imagesy($myTempImage);
      //leian suuruse muutmise suhtarvu
      if($imageWidth > $imageHeight){
        $sizeRatio = $imageWidth / 600;
      } else {
        $sizeRatio = $imageHeight / 400;
      }
      $newWidth = round($imageWidth /  $sizeRatio);
      $newHeight = round($imageHeight / $sizeRatio);

      $myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
      
      //faili salvestamine, jälle sõltuvalt faili tüübist
      if($imageFileType =="jpg" or $imageFileType =="jpeg"){
        if(imagejpeg($myImage, $target_file, 90)){
          echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
        } else{
          echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
        }
      }
      if($imageFileType =="png"){
        if(imagejpng($myImage, $target_file, 6)){
          echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
        } else{
          echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
        }
      }
      if($imageFileType =="gif" ){
        if(imagegif($myImage, $target_file)){
          echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
        } else{
          echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
        }
      }
      imagedestroy($myTempImage);
      imagedestroy($myImage);

      
    /* if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
    } else {
        echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
    } */
  }

    }//siin lõppeb nupu vajutuse kontroll
  function resizeImage($image, $ow, $oh, $w, $h){
    $newImage = imagecreatetruecolor($w, $h);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
    return $newImage;

  }

//lehepäise laadmine
$pagetitle = "Fotode üleslaadimine";
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
    <input type="submit" value="Lae pilt üles" name="submitImage">
  </form>
	
  </body>
</html>