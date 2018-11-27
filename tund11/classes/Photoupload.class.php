<?php
	class Photoupload
	{
		private $tempName;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
		//eriline funktsioon ehk constructor on see, mis käivitatakse kohe classi kasutuselevõtmisel ehk objekti loomisel
		function __construct($name,$type){
			$this->tempName = $name;
			$this->imageFileType = $type;
			$this->createImageFromFile();
			
		}
		//eriline funktsioon, mida kasutatakse kui class suletakse/objekt eemaldatakse
		function __destruct(){
			imagedestroy($this->myTempImage); //kustutab serveri mälust
			imagedestroy($this->myImage);
		}
		private function createImageFromFile(){
			 //sõltuvalt faili tüübist loon sobiva pildi objekti
			if($this->imageFileType =="jpg" or $this->imageFileType =="jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempName);
			}
			if($this->imageFileType =="png" ){
				$this->myTempImage = imagecreatefrompng($this->tempName);
			}
			if($this->imageFileType =="gif"){
				$this->myTempImage = imagecreatefromgif($this->tempName);
			}

		}
		
		public function changePhotoSize($width, $height){
			//pildi originaal suurus
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
			//leian suuruse muutmise suhtarvu
		if($imageWidth > $imageHeight){
			$sizeRatio = $imageWidth / $width;
		} else {
		  $sizeRatio = $imageHeight / $height;
		}
		$newWidth = round($imageWidth /  $sizeRatio);
		$newHeight = round($imageHeight / $sizeRatio);
		$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
		}
		
		private function resizeImage($image, $ow, $oh, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
			return $newImage;
		}
		
		public function addWatermark(){
			$watermark = imagecreatefrompng("../vp_picfiles/vp_logo_color_w100_overlay.png");
			$watermarkwidth = imagesx($watermark);
			$watermarkheight = imagesy($watermark);
			$watermarkposx = imagesx($this->myImage) - $watermarkwidth - 10;
			$watermarkposy = imagesy($this->myImage) - $watermarkheight - 10;
			imagecopy($this->myImage, $watermark, $watermarkposx, $watermarkposy, 0, 0, $watermarkwidth, $watermarkheight);

		}
		public function addTextToImage(){
			//teks vesimärgina
			$texttoimage = "Veebiprogrammeerimine";
			$textcolor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 50); //alpha on läbipaistvusega,Mis pilt, R, G, B, Läbipaistvus 0...127
			imagettftext($this->myImage, 20, 0, 10, 30, $textcolor, "../vp_picfiles/ARIALBD.TTF", $texttoimage);

		}
		public function savePhoto($target_file){
			$notice = null;
			//faili salvestamine, jälle sõltuvalt faili tüübist
			if($this->imageFileType =="jpg" or $this->imageFileType =="jpeg"){
				if(imagejpeg($this->myImage, $target_file, 90)){
					$notice = 1;
				}	else{
					$notice = 0;
				}
			}
			if($this->imageFileType =="png"){
				if(imagepng($this->myImage, $target_file, 6)){
					$notice = 1;
					} else{
					$notice = 0;	
						}
				}
			if($this->imageFileType =="gif" ){
				if(imagegif($this->myImage, $target_file)){
					$notice = 1;
				} else{
					$notice = 0;
					}
			}
			return $notice;
		}
		
	}//class lõppeb	



?>