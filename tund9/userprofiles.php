<?php
require("functions.php");
  //kui pole sisse loginud
if (!isset($_SESSION["userId"])) {
	header("Location: index_1.php");
	exit();
}
  
  //väljalogimine
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: index_1.php");
	exit();
}

$mydescription = "Pole tutvustust lisanud!";
$mybgcolor = "#FFFFFF";
$mytxtcolor = "#000000";

if (isset($_POST["submitProfile"])) {
	$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if (!empty($_POST["description"])) {
		$mydescription = $_POST["description"];
	}
	$mybgcolor = $_POST["bgcolor"];
	$mytxtcolor = $_POST["txtcolor"];
} else {
	$myprofile = showmyprofile();
	if ($myprofile->description != "") {
		$mydescription = $myprofile->description;
	}
	if ($myprofile->bgcolor != "") {
		$mybgcolor = $myprofile->bgcolor;
	}
	if ($myprofile->txtcolor != "") {
		$mytxtcolor = $myprofile->txtcolor;
	}
}

$pageTitle = $_SESSION["firstName"] . " " . $_SESSION["lastName"] . " profiil";
require("header.php");

//piltide laadimis osa
$target_dir = "../vp_profilepics/";
$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submitProfile"])) {
	if(!empty($_FILES["fileToUpload"]["name"])){
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
		//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$timeStamp =microtime(1) *10000;

		$target_file_name =  "vp_user_" .$timeStamp . "." .$imageFileType;
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
			$sizeRatio = $imageWidth / 300;
		} else {
			$sizeRatio = $imageHeight / 300;
		}
		$newWidth = round($imageWidth /  $sizeRatio);
		$newHeight = round($imageHeight / $sizeRatio);

		$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);

		 //faili salvestamine, jälle sõltuvalt faili tüübist
		 if($imageFileType =="jpg" or $imageFileType =="jpeg"){
			 if(imagejpeg($myImage, $target_file, 90)){
				 echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
				 addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
			 } else{
				 echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
			 }
		 }
		 if($imageFileType =="png"){
			 if(imagejpng($myImage, $target_file, 6)){
				 echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
				 addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
			 } else{
				 echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
			 }
		 }
		 if($imageFileType =="gif" ){
			 if(imagegif($myImage, $target_file)){
				 echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti edukalt üles.";
				 addPhotoData($target_file_name, $_POST["alttext"], $_POST["privacy"]);
			 } else{
				 echo "Vabandage,faili üleslaadimisel tekkis tehniline viga.";
			 }
		 }
		 imagedestroy($myTempImage); //kustutab serveri mälust
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

?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<ul>
	  <li><a href="?logout=1">Logi välja</a>!</li>
	  <li><a href="main.php">Tagasi pealehele</a></li>
	</ul>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post" enctype="multipart/form-data">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value=""><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil"><?php echo $notice; ?>
		<label>Lisa profiili pilt:</label>
		<input type="file" name="fileToUpload" id="fileToUpload"><br>

	</form>
	
	
  </body>
</html>