<?
//RSA Tools
class RSATools {
public function getRSAKeyPair() {
$res=openssl_pkey_new();
openssl_pkey_export($res, $privatekey);
$publickey=openssl_pkey_get_details($res);
$publickey=$publickey["key"];
$test = rand();
openssl_private_encrypt($test, $testCrypt, $privatekey);
openssl_public_decrypt($testCrypt, $testDecrypted, $publickey);
$verified = $testDecrypted == $test;
return array('private' => $privatekey,'public'=>$publickey,'verified' => $verified);
}
public function encryptString($string,$rsaPublicKey,$base64=true) {
openssl_public_encrypt($string,$crypt,$rsaPublicKey);
$crypt = $base64 ? base64_encode($crypt) : $crypt;
return $crypt;
}
public function decryptString($string,$rsaPrivateKey,$base64=true) {
$string = $base64 ? base64_decode($string) : $string;
openssl_private_decrypt($string,$decrypt,$rsaPrivateKey);
return $decrypt;
}
public function writeRSAKeysToFile($rsaKeyPair,$directory,$prefix=-1) {
if ($prefix == -1) {
$prefix = rand();
}
if ($rsaKeyPair["verified"] == true) {
$fp = fopen($directory . $prefix . "RSAPUBLIC","w") or die('cannot open stream to file' . $directory .  $prefix . 'RSAPUBLIC please try the following command. sudo chmod 777 ' . $_SERVER["DOCUMENT_ROOT"] . ' and this could fix the problem');
fwrite($fp,$rsaKeyPair["public"]);
fclose($fp);
$fp = false;
$fp = fopen($directory . $prefix . "RSAPRIVATE","w") or die('cannot open stream to file' . $directory .  $prefix . 'RSAPRIVATE please try the following command. sudo chmod 777 ' . $_SERVER["DOCUMENT_ROOT"] . ' and this could fix the problem');
fwrite($fp,$rsaKeyPair["private"]);
fclose($fp);
$fp = false;
}
return $rsaKeyPair["verified"];
}
}
