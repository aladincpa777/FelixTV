<?php
require __DIR__.'/webshare_class.php';
// USE WEBSHARE.CZ
$link = $_GET["link"]; //<---- FILE.LINK
$webshare = new FelixFileHostingWebshare($link,"Aladin237","xxx"); 
echo "http://89.203.248.119/player/index.php?q=".urlencode($webshare->GetDownloadInfo());

// ============================================
// ==============Verify Premium================
//if ($webshare->Verify() == USER_IS_PREMIUM){
//	echo "USER_IS_PREMIUM";
//} else {
//	echo "Hmm.. :(";
//}

//Functions Created By Alter Alpha {en/decryption}
function Descramble($msg_text){
        $msg_text = openssl_decrypt($msg_text, 'aes-256-cbc', 'FelixTV_is_Best_Service_Ever', 0, '1234567890123456');
        return $msg_text;
}
////////////////////////////////////////////////////////
?>