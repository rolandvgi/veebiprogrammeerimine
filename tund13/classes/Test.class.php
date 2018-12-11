<?php
	class Test
	{
		//Omadused ehk muutujad
		private $secretNumber;
		public $publicNumber;
		
		//eriline funktsioon ehk constructor on see, mis käivitatakse kohe classi kasutuselevõtmisel ehk objekti loomisel
		function __construct($sentNumber){
			$this->secretNumber = 5;
			$this->publicNumber = $this->secretNumber * $sentNumber;
			$this->tellSecret();
		}
		//eriline funktsioon, mida kasutatakse kui class suletakse/objekt eemaldatakse
		function __destruct(){
			echo"Lõpetame!";
		}
		
		private function tellSecret(){
			echo "Salajane number on: " .$this->secretNumber ." ";
			
		}
		public function tellInfo(){
			echo "\n Saladusi ei paljasta!";
		}
	}//class lõppeb	



?>