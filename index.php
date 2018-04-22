<!--
Created by Venkatesh J
Date:18-07-2017
Details:Home Page for project phase
-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Phishing Checker</title>
		<!--library for bootstrap-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
         <script src='https://www.google.com/recaptcha/api.js'></script>
        <!--Style sheet for the page-->
        <link rel="stylesheet" href="css/style.css">
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
				<a href="html/redirection.php" class="animate">
					<span class="desc animate"> Redirection Checker </span>
					<span class="glyphicon glyphicon-retweet"></span>
				</a>
			</li>
			<li>
				<a href="index.php" class="animate">
					<span class="desc animate"> Phishing Checker </span>
					<span class="glyphicon glyphicon-search"></span>
				</a>
			</li>
			<li>
				<a href="html/maliciousfilecheck.php" class="animate">
					<span class="desc animate"> Malicious Files Checker </span>
					<span class="glyphicon glyphicon-folder-open"></span>
				</a>
			</li>
			<li>
				<a href="html/fileanalysis.php" class="animate">
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
		    		<p class="home_title">Phishing Website Checker</p>
				</div>
				<div class="col-md-2">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="well">
					<form>
					<div class="row">
						<div class="col-md-3">
							<label class="home_label">Enter website URL:</label>
						</div>
						<div class="col-md-9">
							<div class="input-group input-group-lg">
  							<span class="input-group-addon" id="sizing-addon1"><span class="glyphicon glyphicon-link"></span></span>
  							<input type="text" class="form-control" id="url" placeholder="http://www.domain.com" aria-describedby="sizing-addon1"
  							value="<?php if(isset($_GET['url'])) { echo $_GET['url'];} ?>" required>
							</div>
						</div>
					</div><br/>
					</form>
					<div class="row">
						<div class="col-md-3">
						</div>
						<div class="col-md-9">
							<button class="btn btn-default" id="check_submit"><span class="glyphicon glyphicon-triangle-right"></span> Perform check</button>
						</div>
					</div><br/>
					<div class="row">
					<div id="div1"></div>
					</div>
					</div>
				</div>
				<div class="col-md-2">
				</div>
			</div>
			<div class="well" id="footercol">
				<b><p>VAPT of Ransomware using honey pot @ CEG</p></b>
				
			</div>
		</div>
	</body>
</html>
