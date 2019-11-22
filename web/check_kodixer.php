<?php

echo "TRYING!".$_SERVER['REMOTE_ADDR']."<br />";
$static = "89.203.248.119";
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
echo "IP is " . $ip_address . "<br />";
if ($ip_address === $static){
	echo "Pass";
} else {
	echo "Not pass";
}
?>