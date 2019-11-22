<?php
// ========================================
// ||  S T R E A M  C O N T R O L L E R  ||
// ========================================

$streamuj_url = $_GET['q']."?remote=1&affid=0&width=960&height=525";
$contents = file_get_contents($streamuj_url);

//if (getUserIP() == "89.203.249.223"){
//    die("Sorry, Your IP has been BANNED");
//}
// ----------------------------------
//    LANGUAGE CONTROLLER/POINTER
// ----------------------------------
if (isset($_GET['LANG'])){
    $language = $_GET['LANG'];
}
else {
    $language = "CZ";
}
//$language = "EN";
if (strpos($contents, 'langs: "en>English",') !== false) {
    $ONLY_ENGLISH = "1";
} else {
    $ONLY_ENGLISH = "0";
}
// ===================================
if (empty($_GET['SOS'])){
    $SOS = "0";
} else {
    $SOS = "1";
}
if (empty($_GET['s'])) {
    $searchfor = 'res1:'; // ENGLISH
    $searchfor2 = 'res0:'; // CZECH
} elseif (!empty($_GET['hd'])) { 
    $searchfor = '?streamuj=hd';
    $searchfor2 = '?streamuj=hd';
} else {
    $searchfor = 'sub1:';
    $searchfor2 = 'sub0:';
}
header('Content-Type: text/plain');

$pattern = preg_quote($searchfor, '/'); // ENGLISH
$pattern2 = preg_quote($searchfor2, '/'); // CZECH

$pattern = "/^.*$pattern.*\$/m";
$pattern2 = "/^.*$pattern2.*\$/m";


// =========================================================== QUERY ONE ==============================================================================
if(preg_match_all($pattern, $contents, $matches)){ // << ENGLISH<>CZECH? >>
       preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', implode("\n", $matches[0]), $match);

            if ($match[0][1] == ''){
                $video_url = file_get_contents($match[0][0]);
            } else {
                $video_url = file_get_contents($match[0][1]);
            }
        
        if (empty($_GET['s'])) {
            if ($language == "EN"){
               if (strpos($contents, 'en>English') !== false) {
                    echo urlencode(Scramble($video_url));
                } else { echo "Server side error (Code: 99)"; }
            }
        } else { echo $video_url; }
    }
 // ==============================================================================================================================================       
    if (preg_match_all($pattern2, $contents, $matches)){ // << CZECH >>
       preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', implode("\n", $matches[0]), $match);

            if ($match[0][1] == ''){
                $video_url = file_get_contents($match[0][0]);
            } else {
                $video_url = file_get_contents($match[0][1]);
            }
        
         if (empty($_GET['s'])) {
            if ($SOS == "1"){
                die(urlencode(Scramble($video_url)));
            }
             if ($language == "CZ"){
                if ($ONLY_ENGLISH = "1"){
                        echo urlencode(Scramble($video_url));
                       //echo "CZECH: ".urlencode(Scramble($video_url));
                } else {
                     if (strpos($contents, 'cs>čeština') !== false) { 
                        echo urlencode(Scramble($video_url));
                       //echo "CZECH: ".urlencode(Scramble($video_url));
                    } else { echo "Server side error (Code: 99)"; }
                }
             }
        } else {
            echo $video_url;
        }
    }
    // ============================================================================================================================================


function Scramble($string) {
    // you may change these values to your own
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );

    return $output;
}

?>
