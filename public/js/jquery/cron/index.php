<?php
$crontext = "Cron job Run at ".date("r")." by ".$_SERVER['USER']."\n" ;



$folder = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],"/")+1);



$filename = $folder."cron_test.txt" ;



$fp = fopen($filename,"a") or die("Open error!");



fwrite($fp, $crontext) or die("Write error!");



fclose($fp);



$url = "https://trafficpolice.ajk.gov.pk/UploadExcelSheet/import_excel_file_data.php";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);

echo 1; die;
?>

