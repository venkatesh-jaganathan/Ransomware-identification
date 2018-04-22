<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Malicious File Checker</title>
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
<?php


//header("Content-Type: text/plain"); 

// edit the virustotal.com api key, get one from the site
$virustotal_api_key = "0809d3d8724c22cda95a39a28a128c7cdf854335042db6303ef0f24edaadd8ac";

// enter here the path of the file to be scanned
$file_to_scan = $_GET['file_url'];


// get the file size in mb, we will use it to know at what url to send for scanning (it's a different URL for over 30MB)
//$file_size_mb = filesize($file_to_scan)/1024/1024;

// calculate a hash of this file, we will use it as an unique ID when quering about this file
$file_hash = hash('sha256', file_get_contents($file_to_scan));




// [PART 1] hecking if a report for this file already exists (check by providing the file hash (md5/sha1/sha256) 
// or by providing a scan_id that you receive when posting a new file for scanning
// !!! NOTE that scan_id is the only one that indicates file is queued/pending, the others will only report once scan is completed !!!
$report_url = 'https://www.virustotal.com/vtapi/v2/file/report?apikey='.$virustotal_api_key."&resource=".$file_hash;


$api_reply = file_get_contents($report_url);

// convert the json reply to an array of variables
$api_reply_array = json_decode($api_reply, true);



// your resource is queued for analysis
if($api_reply_array['response_code']==-2){
	echo $api_reply_array['verbose_msg'];
}

// reply is OK (it contains an antivirus report)
// use the variables from $api_reply_array to process the antivirus data
if($api_reply_array['response_code']==1){
	//echo "\nWe got an antivirus report, there were ".$api_reply_array['positives']." positives found. Here is the full data: \n\n";
	//print_r($api_reply_array);
	echo '<h4>File Signature Details</h4>';
	echo '<table class="table table-striped"><thead><tr><th>Name</th><th>Details</th></thead><tbody>';
	$malicious_file = 0;
	foreach($api_reply_array as $x=>$x_value)
  {
  	if($x == 'positives')
  	{
  		if($x_value)
  		{
  			$malicious_file = 1;
  		}
  	}
  	if($x != 'scans' && $x != 'verbose_msg' && $x != 'permalink' && $x != 'scan_id')
  	{
  	echo '<tr><td>'.$x.'</td><td>'.$x_value.'</td></tr>';  		
 	}
  }
  echo '</tbody></table>';
  if($malicious_file)
  {
   echo '<button class="btn btn-lg btn-danger">Malicious File</button>'; 	
  }
  else
  {
  	  echo '<button class="btn btn-lg btn-primary">Normal File</button>';
  }

	echo '<h4>File Signature Checks with Other Antivirus Signatures DB</h4>';
	echo '<table class="table table-striped"><thead><tr><th>S.no</th><th>Name</th><th>Version</th><th>Detection</th></thead><tbody>';  
	$count = 1;
 	foreach($api_reply_array as $x=>$x_value)
  {

  	if($x == 'scans')
  	{
  		foreach($x_value as $y=>$y_value)
  		{

  		echo '<tr><td>'.$count.'</td><td>'.$y.'</td>';
  			foreach($y_value as $z=>$z_value)
  			{
  				if($z == 'version')
  				{
  				echo '<td>'.$z_value.'</td>';
  				}
  				if($z == 'result')
  				{
  					if($z_value == NULL)
  					{
  						echo '<td>0</td>'; 
  					}
  					else
  					{
  						echo '<td>'.$z_value.'</td>';
  					}
  				}
  			}
  			echo '</tr>';
  			$count++;
  		}
  	}
  } 
  echo '</tbody></table>';
	exit;
}



// [PART 2] a report for this file was not found, upload file for scanning
if($api_reply_array['response_code']=='0'){

	// default url where to post files
	$post_url = 'https://www.virustotal.com/vtapi/v2/file/scan';

	// get a special URL for uploading files larger than 32MB (up to 200MB)
	if($file_size_mb >= 32){
		$api_reply = @file_get_contents('https://www.virustotal.com/vtapi/v2/file/scan/upload_url?apikey='.$virustotal_api_key);
		$api_reply_array = json_decode($api_reply, true);
		if(isset($api_reply_array['upload_url']) and $api_reply_array['upload_url']!=''){
			$post_url = $api_reply_array['upload_url'];
		}
	}
	
	// send a file for checking

	// curl will accept an array here too:
	$post['apikey'] = $virustotal_api_key;
	$post['file'] = '@'.$file_to_scan;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$post_url);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$api_reply = curl_exec ($ch);
	curl_close ($ch);
	
	$api_reply_array = json_decode($api_reply, true);
	
	if($api_reply_array['response_code']==1){
		echo "\nfile queued OK, you can use this scan_id to check the scan progress:\n".$api_reply_array['scan_id'];
		echo "\nor just keep checking using the file hash, but it will only report once it is completed (no 'PENDING/QUEUED' reply will be given).";
	}

}

?>
</body>
</html>