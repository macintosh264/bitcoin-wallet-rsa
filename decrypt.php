<?php
//Decrypt.php
$walletLoc = $argv[1];
$keyLoc = $argv[2];
if (!isset($walletLoc) || !isset($keyLoc)) {
die("Provide the files in the following manner. php -f <script location> -- <encrypted wallet> <key file>\n");
}
$fp = fopen($walletLoc,"r");
$wallet = fread($fp,filesize($walletLoc));
fclose($fp);
$fp = fopen($keyLoc,"r") or die("cannot read key");
$key = fread($fp,filesize($keyLoc));
fclose($fp);
$fp = false;
$walletobject = json_decode(base64_decode($wallet));
unset($wallet);
$finalWallet = "";
echo "\nWill decrypt ", count($walletobject), " parts";
foreach ($walletobject as $walletPart) {
$output = false;
openssl_private_decrypt(base64_decode($walletPart),$output,$key);

$finalWallet .= $output;
}
$fp = fopen("WALLET_DECRYPTED.dat","w");
fwrite($fp,$finalWallet);
fclose($fp);
echo "\nWROTE WALLET";
?>