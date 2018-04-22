<!--
Created by Venkatesh J
Date:22-09-2017
Details:Malicious file check Module for project phase
-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Malicious File Analysis</title>
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
		    		<p class="home_title">Malicious Files Analysis</p>
				</div>
				<div class="col-md-2">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="well">
					<div class="alert alert-info alert-dismissible" id="show_alert" role="alert" style="display:none">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span 						aria-hidden="true">&times;</span></button>
  					    <strong>Info!</strong><span>The File <span id="result"></span> has been uploaded.</span><br/>
  					<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Analysis</button>
  					  <div id="demo" class="collapse">
  					  <div class="well">
  					  	<a href="#" target="blank" id="ajax_href"><button class="btn btn-default">File Analysis</button></a>
  					  	<a href="ransomecheck.php"><button class="btn btn-default">Encrypted File Analysis</button></a>
  					  </div>
  					  </div>
				    </div>
					<form id="fileUploadForm" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-3">
							<label class="home_label">Upload the File:</label>
						</div>
						<div class="col-md-9">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <input class="btn btn-default" type="file" value="Browse.." name="fileToUpload" id="fileToUpload">
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
			<div class="col-md-8">
				<span id="result"></span>
			</div>
			</div>
			<div class="well" id="footercol">
				<b><p>VAPT of Ransomware using honey pot @ CEG</p></b>

			</div>
		</div>
		<script>
$(document).ready(function () {

    $("#btnSubmit").click(function (event) {

        //stop submit the form, we will post it manually.
        event.preventDefault();

        // Get form
        var form = $('#fileUploadForm')[0];

		// Create an FormData object
        var data = new FormData(form);

		// If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");

		// disabled the submit button
        $("#btnSubmit").prop("disabled", true);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "fileupload.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
            	$("#show_alert").css("display", "block");
                $("#result").text(data);
                var ajax_url = "virustotal_api.php?file_url=C:/xampp/htdocs/ransomware/uploads/";
                new_url = ajax_url + data;
                $("#ajax_href").attr("href", new_url);
                console.log("SUCCESS : ", data);
                $("#btnSubmit").prop("disabled", false);

            },
            error: function (e) {
            	$("#show_alert").css("display", "block");
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
        });

    });

});
</script>
	</body>
</html>
