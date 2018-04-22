<html>
<head>
<title>Ransomware Report</title>
<style>
div {
    background-color: lightgrey;
    width: 1000px;
    border: 5px solid black;
    padding: 25px;
    margin: 25px;
}
</style>
</head>
<body>
<?php
function decrypt_file($file,$passphrase) {

	$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
	$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
	md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
	$opts = array('iv'=>$iv, 'key'=>$key);
	$fp = fopen($file, 'rb');
	stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);

	return $fp;
}

?>

<b>Encrypted File Sample</b>
<br/>
<div>
<?php
$decrypted = decrypt_file($_GET['file_url'],'MySuperSecretPassword');

$decrypted_val = fpassthru($decrypted);
?>
</div>
<br/>
<p><b>File Encryption (md5) with Other Virus</b></p>
</body>
</html>
