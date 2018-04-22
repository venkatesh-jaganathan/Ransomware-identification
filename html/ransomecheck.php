<!--
Created by Venkatesh J
Date:22-09-2017
Details:Malicious file check Module for project phase
-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Encrypted File Analysis</title>
		<!--library for bootstrap-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/script.js"></script>
         <script src='https://www.google.com/recaptcha/api.js'></script>
        <!--Style sheet for the page-->
        <link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="well" id="headercol">
				<div class="row">
					<div class="col-md-2">
						<!--<img class="img-responsive" id="img_logo" src="img/logo_anna.png">-->
					</div>
					<div class="col-md-8">
						<br/><span style="font-size:18px;">Vulnerability Analysis and Penetration Testing (VAPT) of Ransomware using honey pot<br/>
						</span>
					</div>
				</div>
			</div>
			<div class="row">
			    <nav class="navbar navbar-fixed-left navbar-minimal animate" role="navigation">
		<div class="navbar-toggler animate">
			<span class="menu-icon"></span>
		</div>
		<ul class="navbar-menu animate">
			<li>
				<a href="redirection.php" class="animate">
					<span class="desc animate"> Redirection Checker </span>
					<span class="glyphicon glyphicon-retweet"></span>
				</a>
			</li>
			<li>
				<a href="../index.php" class="animate">
					<span class="desc animate"> Phishing Checker </span>
					<span class="glyphicon glyphicon-search"></span>
				</a>
			</li>
			<li>
				<a href="maliciousfilecheck.php" class="animate">
					<span class="desc animate"> Malicious Files Checker </span>
					<span class="glyphicon glyphicon-folder-open"></span>
				</a>
			</li>
			<li>
				<a href="fileanalysis.php" class="animate">
					<span class="desc animate"> File Analysis </span>
					<span class="glyphicon glyphicon-file"></span>
				</a>
			</li>
		</ul>
	</nav>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
		    		<p class="home_title">Encrypted Files Analysis</p>
				</div>
				<div class="col-md-2">
				</div>
			</div>
						<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="well">
					<p style="font-size:23px;color:rgb(6,66,92)"><b>From NoMoreRansomware Repository</b></p>
					<form action="https://www.nomoreransom.org/crypto-sheriff.php?lang=en" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-3">
							<label class="home_label">Upload the File:</label>
						</div>
						<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
<input class="btn btn-default" type="file" value="Browse.." name="file_one" id="fileToUpload">
</div>	<br/>
<div class="fileinput fileinput-new" data-provides="fileinput">
 <input class="btn btn-default" type="file" value="Browse.." name="file_two" id="fileToUpload">
</div>
						</div>
					</div><br/>
					<div class="row">
						<div class="col-md-3">
						</div>
						<div class="col-md-9">
							<input type="submit" name="submit" class="btn btn-default"  value="Perform check">
						</div>
					</div><br/>
					</form>
					</div>
				</div>
				<div class="col-md-2">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="well">
					<p style="font-size:23px;color:rgb(6,66,92)"><b>From system analysis</b></p>
					<div class="alert alert-info alert-dismissible" id="show_alert" role="alert" style="display:none">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span 						aria-hidden="true">&times;</span></button>
  					    <strong>Info!</strong><span>The File <span id="result"></span> has been uploaded.</span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" target="blank" id="ajax_href"><b>Report</b></a>
				    </div>
					<form id="fileUploadForm" method="post">
					<div class="row">
						<div class="col-md-3">
							<label class="home_label">Encrypted Text:</label>
						</div>
						<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <input class="btn btn-default" type="text"  name="textanalysis" id="fileToUpload" required>
</div>
						</div>
					</div><br/>
					<div class="row">
						<div class="col-md-3">
						</div>
						<div class="col-md-9">
							<input type="submit" name="submit" class="btn btn-default"  value="Perform check" id="btnSubmit">
						</div>
					</div><br/>
					</form>
					</div>
				</div>
				<div class="col-md-2">
				</div>
			</div>
<div class="row">
<?php
if(isset($_POST["textanalysis"]))
{
	$data = "Hello World";
	$encrypt_algo = "Not Found";
	$post_val = $_POST["textanalysis"];
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
	else if($encrypt_algo == "SHA-512")
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

?>
	<div class="row" id="ransomware_details">
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
	<div class="well">
	<p style="font-size:23px;color:rgb(6,66,92)"><b>File analysis</b></p>
	<div class="table-responsive">
	 <table class="table">
	 <tr class="info"><td><b>Encrypted Text</b></td><td><?php echo $post_val; ?></td></tr>
	 <tr class="info"><td><b><b>Encoding Standard</b></td><td><?php echo mb_detect_encoding($post_val); ?></td></tr>
	 <tr class="info"><td><b>Encrytion Algorithm</b></td><td><?php echo $encrypt_algo; ?></td></tr>
	 <tr class="info"><td><b>Ransomware</b></td><td><?php echo $ransomware_algo; ?></td></tr>
	 </table>
	 </div>
	 <div><a href="ransomware_report.php?encryp=<?php echo $post_val;?>" target="_blank"><button class="btn btn-primary" style="float:right">Report</button></a></div><br/>
	 </div>
	 </div>
	<div class="col-md-2">
	</div>
	 </div>
<?php
}
?>
</div>

			<div class="row">
			<div class="col-md-8">
				<span id="result"></span>
			</div>
			</div>
			<div class="well" id="footercol">
				<b><p>VAPT of Ransomware using honey pot @ CEG</p></b>
				<p>contact- <span class="glyphicon glyphicon-phone-alt"></span> +918754072937 | <span class="glyphicon glyphicon-envelope"> </span> venkateshj.ceg@gmail.com</p>
			</div>
		</div>
		<script>
		$("#fileUploadForm").submit(function() {
     window.location.hash = "ransomware_details";
});

		</script>
	</body>
</html>
