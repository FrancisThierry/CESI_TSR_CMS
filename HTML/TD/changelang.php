<?php

session_start();
$_SESSION["lang"] = $_GET["lang"];
$lang = $_SESSION["lang"];
$flower = $_GET["flower"];
$color = $_GET["color"];
header("Location: ./index.php?flower=$flower&color=$color&lang=$lang");
?>  