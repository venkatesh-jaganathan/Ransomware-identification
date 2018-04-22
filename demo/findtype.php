<?php
$word = "aword";
$hash_type = "md5";
$email = "demo@gmail.com";
$code = "e5f2165cab336b51";
$response = file_get_contents("http://md5decrypt.net/Api/api.php?word=".$word."&hash_type=".$hash_type."&email=".$email."&code=".$code);
echo $response;
?>
