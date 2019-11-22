<?php
ini_set('session.use_cookies',1);
session_start();
$_GET["a"];
$ogv=uniqid(); 
$_SESSION[$ogv]=$_GET["a"];
echo '<video autoplay="autoplay">'
    .'<source src="video.php?video='.$ogv.' type="video/mp4">'
    .'</video>';

?>