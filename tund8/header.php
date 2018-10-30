<?php
if (isset($_SESSION["userid"])) {
  $profile = showmyprofile();
  $mybgcolor = $profile->bgcolor;
  $mytxtcolor = $profile->txtcolor;
  $mydescription = $profile->description;
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php echo $pagetitle; ?></title>
    <?php 
        echo "<style>" .
            "body{background-color:" . $mybgcolor . "; \n" .
            "color: ".$mytxtcolor ."} /n" .
            "</style>";
    ?>
  </head>
  <body>
  <div>
      <a href="main.php">
        <img src="../vp_picfiles/vp_logo_w135_h90.png" alt="VP_logo">
      </a> 
      <img src="../vp_picfiles/vp_banner.png" alt="VP 2018 bänner">
  </div>
    <h1>Pealeht</h1>
