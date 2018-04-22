<?php
require('ransomware_table.php');
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

if(isset($_GET['encryp']))
{
		$data = "Hello World";
	$encrypt_algo = "Not Found";
	$post_val = $_GET['encryp'];
//for hash encoding
foreach (hash_algos() as $v) 
	{
        $r = hash($v, $data, false);
        if($r == $post_val)
        {
        	$encrypt_algo = $v;
        }
	}
//for encryption standards
	if(crypt($data, 'rl') == $post_val)
	{
			$encrypt_algo = "Standard DES";
	}
	else if(crypt($data, '_J9..rasm') == $post_val )
	{
		  $encrypt_algo = "Extended DES";
	}
	else if(crypt($data, '$1$rasmusle$') == $post_val)
	{
		$encrypt_algo = "MD5";
	}
	else if(crypt($data, '$2a$07$usesomesillystringforsalt$') == $post_val)
	{
		$encrypt_algo = "Blowfish";
	}
	else if(crypt($data, '$5$rounds=5000$usesomesillystringforsalt$') == $post_val)
	{
		$encrypt_algo = "SHA-256";
	}
	else if(crypt($data, '$6$rounds=5000$usesomesillystringforsalt$') == $post_val)
	{
		$encrypt_algo = "SHA-512";
	}
	else
	{
		$encrypt_algo = "Not Found";
	}


	if($encrypt_algo == "Blowfish")
	{
		$ransomware_algo = "FLRK Ransomware";
	}
	else if($encrypt_algo == "MD5")
	{
		$ransomware_algo = "CRYPTOWALL 4 Ransomware";
	}
	else if($encrypt_algo == "SHA-256")
	{
		$ransomware_algo = "Apocalypse Ransomware";
	}
	else if($encrypt_algo == "SHA-512")
	{
		$ransomware_algo = "Apocalypse Ransomware";
	}
	else
	{
		$ransomware_algo = "Anonymous Ransomware";
	}



	  $html='
<table border="1">
<tr><p><b>Encrypted Text: </b>'.$post_val.'</p></tr>
<tr><p><b>Encoding Standard:  </b></p>'.mb_detect_encoding($post_val).'</tr>
<tr><p><b>Encrytion Algorithm: </b>'.$encrypt_algo.'</p></tr>
<tr><p><b>Ransomware: </b>'.$ransomware_algo.'</p></tr>
</table>';
}


$pdf->WriteHTML($html);
$pdf->Output();
?>