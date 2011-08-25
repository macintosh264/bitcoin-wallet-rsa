<?php
//Encrypt Bitcoin Wallet
require("rsatools.php");
$rsa = new RSATools();
$bitcoinWallet = fopen($argv[1],"r") or die("Please supply the bitcoin wallet location as the only arguement. Run the script like this. php -f <script location> -- <bitcoin wallet location>");
$wallet = fread($bitcoinWallet, filesize($argv[1]));
$keyPair = $rsa->getRSAKeyPair();
$privKey = $keyPair["private"];
$publicKey = $keyPair["public"];
$fp = fopen("DECRYPT_KEY","w");
fwrite($fp,$privKey);
fclose($fp);
$wallet = str_split($wallet,100);
$finalWallet = array();
echo count($wallet), " Parts To Encrypt\n";
foreach ($wallet as $part) {
$encryptedWallet = openssl_public_encrypt($part,$output,$publicKey);
$finalWallet[] = base64_encode($output);
}
$fp = fopen("WALLET_ENCRYPTED","w");
fwrite($fp, base64_encode(json_encode($finalWallet)));
fclose($fp);
echo "WALLET ENCRYPTED TO ./WALLET_ENCRYPTED\nDECRYPT_KEY FILE IS NEEDED TO DECRYPT. DO NOT LOOSE!!!!";
?>