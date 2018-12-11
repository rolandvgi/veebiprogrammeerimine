<?php
require("../../../config.php");
$database = "if18_Roland_va_1";
session_start();

//siia saadetud parameetrid
$id = $_GET["id"];
$rating = $_GET["rating"];

$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
$stmt = $mysqli->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES (?, ?, ?)");
echo $mysqli->error;
$stmt->bind_param("iii", $id, $_SESSION["userId"], $rating);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("SELECT AVG(rating) FROM vpphotoratings WHERE photoid = ?");
$stmt->bind_param("i", $id);
$stmt->bind_result($score);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$mysqli->close();
echo "Hinne: ", round($score, 2);
?>