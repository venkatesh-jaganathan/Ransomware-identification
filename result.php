
<?php 
$GLOBALS['phishing_flag'] = 0;
$GLOBALS['phishing_db'] = 0;
function expand_url($url){
    //Get response headers
    $response = get_headers($url, 1);
    //Get the location property of the response header. If failure, return original url
    if (array_key_exists('Location', $response)) {
        $location = $response["Location"];
        if (is_array($location)) {
            // t.co gives Location as an array
            return expand_url($location[count($location) - 1]);
        } else {
            return expand_url($location);
        }
    }
    return $url;
}

function test_expand_url($short_url, $expected_long_url) {
    $actual_long_url = expand_url($short_url);
    if ($actual_long_url == $expected_long_url) {
    	$GLOBALS['tiny_url'] = 0;
    	$GLOBALS['url_val'] = $short_url;
    } else {
    	$GLOBALS['tiny_url'] = 1;
    	$GLOBALS['url_val'] = $actual_long_url;
    }
}


if(filter_var($_GET["url"], FILTER_VALIDATE_URL) != FALSE){

//for db connectivity
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ransomware";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


//check for the tiny url
test_expand_url($_GET["url"], $_GET["url"]);

//check for phishing website
if (filter_var(parse_url($url_val, PHP_URL_HOST), FILTER_VALIDATE_IP))
{
    $phishing_flag = 1;
}
else if(strlen($url_val) >= 70)
{
    $phishing_flag = 1;
}
else if(strrchr($url_val,'@'))
{
    $phishing_flag = 1;
}
else if(strrchr(parse_url($url_val, PHP_URL_HOST),'-'))
{
    $phishing_flag = 1;
}
else if(substr_count($url_val,".") > 3)
{
    $phishing_flag = 1;
}
else
{
    $phishing_flag = 0;
}

if(parse_url($url_val, PHP_URL_SCHEME) == 'https')
{
    $phishing_flag = 0;
}


//check for the entry of data in db
if($phishing_flag)
{
$sql = "SELECT phish_url FROM phish_table WHERE phish_url= '$url_val'";
//echo $sql;
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
        $phishing_db = 1;
} else {
   $phishing_db = 0;
}
}
?>


<?php if($phishing_flag) { ?>
<div class="well" id="result_url">
<?php if($phishing_db == 1) { ?>
<div class="row">
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Info!</strong> Phishing Website URL present in DB.
</div>
</div>
<?php } ?>
<div class="row">
<h4>&nbsp;&nbsp;<span class="glyphicon glyphicon-remove-circle"></span>  <b>URL</b> <?php echo $url_val; ?>  <span class="label label-warning">Phishing Site</span><?php if($phishing_db == 0){ ?>   <input type="hidden" id="sql_urlval" value="<?php echo $url_val; ?>"><button onclick="sql_url()" class="btn btn-primary" id="btn_sqladd">Add+</button>&nbsp;&nbsp;<a href='html/maliciousfilecheck.php?url=<?php echo $url_val; ?>' title='Check For Malicious Files Present' target='_blank'><button class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-folder-open'></span></button></a><?php } else { ?>
&nbsp;&nbsp;<a href='html/maliciousfilecheck.php?url=<?php echo $url_val; ?>' title='Check For Malicious Files Present' target='_blank'><button class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-folder-open'></span></button></a><?php } ?>
</h4>
</div>
</div>
<?php } else { ?>
<div class="well" id="result_url">
<div class="row">
<h4>&nbsp;&nbsp;<span class="glyphicon glyphicon-ok-circle"></span>  <b>URL</b> <?php echo $url_val; ?>  <span class="label label-primary">Legitimate Site</span></h4>
</div>
</div>
<?php } ?>


<?php
if($tiny_url)
{ ?>
<div class="well"  id="result_url">
<span class="label label-default">Actual URL</span>
<?php echo $url_val; ?>
</div>
<?php } }
else
{
          echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> A valid URL please.
</div>';
}
?>





<?php
if(filter_var($_GET["url"], FILTER_VALIDATE_URL) != FALSE)
{
?>

<div class="well"  id="result_url">
<?php

$strlen = strlen( $url_val );
	?>
	<span class="label label-default">URL Parsing</span>
	<?php
	print_r(parse_url($url_val));
	?>
	<br/><br/>
	<table class="table table-striped">
	<thead>
      <tr>
        <th>URL Length</th>
        <th>'@' Symbol</th>
        <th>'-' Symbol</th>
        <th>'.' count</th>
        <th> '//' Symbol</th>
        <th> host </th>
        <th> Protocol </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo strlen($url_val); ?></td>
        <td><?php if(strrchr($url_val,'@')) { echo 'Yes'; } else { echo 'No'; }  ?></td>
        <td><?php if(strrchr(parse_url($url_val, PHP_URL_HOST),'-')) { echo 'Yes'; } else { echo 'No'; }  ?></td>
        <td><?php echo substr_count($url_val,"."); ?></td>
        <td><?php if(strpos(substr($url_val,7),'//')) { echo 'Yes'; } else { echo 'No'; } ?></td>
        <td><?php echo parse_url($url_val, PHP_URL_HOST); ?></td>
        <td><?php echo parse_url($url_val, PHP_URL_SCHEME); ?></td>
      </tr>
     </tbody>
     </table>
</div>
<div class="well">
<div class="row">
<div class="col-md-10">
</div>
<div class="col-md-2">
							<a href="report.php?url=<?php echo $url_val; ?>&short_url=<?php echo $tiny_url; ?>&tiny_url=<?php echo $_GET["url"];?>" target="blank"><button class="btn btn-primary btn-default" sytle="float:left" id="check_submit"><span class="glyphicon glyphicon-file"></span> Report</button></a>
</div>
</div>

</div>
<?php
}

?>
