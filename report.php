<?php 
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

if($_GET["url"] != "")
{
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

if($phishing_flag == 1)
{
    $phishing_val = 'Phishing';
}
else
{
    $phishing_val = 'Legitimate';
}


if($tiny_url)
{
 ?>
<div class="well"  id="result_url">
<span class="label label-default">Actual URL</span>
<?php echo $url_val; ?>
</div>
<?php }
//for the pdf values
$url_len = strlen($url_val);
if(strrchr($url_val,'@')) {  $url_sym = 'Yes'; } else {  $url_sym = 'No'; }
if(strrchr($url_val,'-')) { $url_under = 'Yes'; } else { $url_under = 'No'; } 
$url_dot = substr_count($url_val,'.');
if(strpos(substr($url_val,7),'//')) { $url_pos = 'Yes'; } else { $url_pos = 'No'; }
$url_host = parse_url($url_val, PHP_URL_HOST);
$url_scheme = parse_url($url_val, PHP_URL_SCHEME);
 }?>
<?php
require('html_table.php');
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

if($_GET['short_url'] == 1)
{
		$html='
<table border="1">
<tr><p><b>URL Report: </b>'.$phishing_val.'</p></tr>
<tr><p><b>Shorten URL:  </b></p>'.$_GET['tiny_url'].'</tr>
<tr><p><b>Actual URL:  </b></p>'.$url_val.'</tr>
<tr></tr>
<tr><b>URL Featuring</b></tr>
<tr>
<td width="100" height="30" bgcolor="#D0D0FF">URL Length</td><td width="100" height="30" bgcolor="#D0D0FF">@ Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">- Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">. Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">// Symbol</td>
<td width="150" height="30" bgcolor="#D0D0FF">host</td>
<td width="100" height="30" bgcolor="#D0D0FF">Protocol</td>
</tr>
<tr>
<td width="100" height="30">'.$url_len.'</td><td width="100" height="30">'.$url_sym.'</td>
<td width="100" height="30">'.$url_under.'</td>
<td width="100" height="30">'.$url_dot.'</td>
<td width="100" height="30">'.$url_pos.'</td>
<td width="150" height="30">'.$url_host.'</td>
<td width="100" height="30">'.$url_scheme.'</td>
</tr>
</table>';
}
else
{
	$html='
<table border="1">
<tr><p><b>URL Report: </b>'.$phishing_val.'</p></tr>
<tr><p><b>URL:  </b></p>'.$url_val.'</tr>
<tr></tr>
<tr><b>URL Featuring</b></tr>
<tr>
<td width="100" height="30" bgcolor="#D0D0FF">URL Length</td><td width="100" height="30" bgcolor="#D0D0FF">@ Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">- Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">. Symbol</td>
<td width="100" height="30" bgcolor="#D0D0FF">// Symbol</td>
<td width="150" height="30" bgcolor="#D0D0FF">host</td>
<td width="100" height="30" bgcolor="#D0D0FF">Protocol</td>
</tr>
<tr>
<td width="100" height="30">'.$url_len.'</td><td width="100" height="30">'.$url_sym.'</td>
<td width="100" height="30">'.$url_under.'</td>
<td width="100" height="30">'.$url_dot.'</td>
<td width="100" height="30">'.$url_pos.'</td>
<td width="150" height="30">'.$url_host.'</td>
<td width="100" height="30">'.$url_scheme.'</td>
</tr>
</table>';
}


$pdf->WriteHTML($html);
$pdf->Output();
?>