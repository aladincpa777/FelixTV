<?php
ini_set('session.use_cookies',1);
session_start();
$file='http://188981.w81.wedos.ws/Movies_Storage/'.$_SESSION[$_GET['video']].'/movie';
$_SESSION=array();
$params = session_get_cookie_params();
setcookie(session_name(),'', time()-42000,$params["path"],$params["domain"],
                                         $params["secure"], $params["httponly"]);
if(!file_exists($file) or $file==='' or !is_readable($file)){
  header('HTTP/1.1 404 File not found',true);
  exit;
  }
readfile($file);
exit:
?>