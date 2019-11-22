<?php
function my_simple_crypt($string) {
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    return $output;
}
echo my_simple_crypt($_GET['q'], 'd' );
?>