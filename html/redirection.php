<!--
Created by Venkatesh J
Date:07-09-2017
Details:Home Page for Redirection phase
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Redirection Checker</title>
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
            <p class="home_title">Redirection Checker</p>
        </div>
        <div class="col-md-2">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
          <div class="well">
          <form action="redirection.php" method="POST">
          <div class="row">
            <div class="col-md-3">
              <label class="home_label">Enter website URL:</label>
            </div>
            <div class="col-md-9">
              <div class="input-group input-group-lg">
                <span class="input-group-addon" id="sizing-addon1"><span class="glyphicon glyphicon-link"></span></span>
                <input type="text" name="url" class="form-control" id="url" placeholder="http://www.domain.com" aria-describedby="sizing-addon1" required>
              </div>
            </div>
          </div><br/>
          <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
              <input type="submit" name="submit" class="btn btn-default"  value="Perform check" id="redirect_submit">
            </div>
          </div><br/>
          </form>
<?php
 $GLOBALS['url']= '';
?>






          <?php
   include("simple_html_dom.php");
   $crawled_urls=array();
   $found_urls=array();
   function rel2abs($rel, $base){
    if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
    extract(parse_url($base));
    $path = preg_replace('#/[^/]*$#', '', $path);
    if ($rel[0] == '/') $path = '';
    $abs = "$host$path/$rel";
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
    $abs=str_replace("../","",$abs);
    return $scheme.'://'.$abs;
   }
   function perfect_url($u,$b){
    $bp=parse_url($b);
    if(($bp['path']!="/" && $bp['path']!="") || $bp['path']==''){
     if($bp['scheme']==""){$scheme="http";}else{$scheme=$bp['scheme'];}
     $b=$scheme."://".$bp['host']."/";
    }
    if(substr($u,0,2)=="//"){
     $u="http:".$u;
    }
    if(substr($u,0,4)!="http"){
     $u=rel2abs($u,$b);
    }
    return $u;
   }

//for domain address separation
   function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $pieces['scheme']."://".$pieces['host'];
  }
  return false;
}

//array declaration for storing domain names
$domain_name = array();

   function crawl_site($u){
    global $crawled_urls;
    $uen=urlencode($u);
    if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time())))){
     $html = file_get_html($u);
     $crawled_urls[$uen]=date("YmdHis");

     //to check for the forms action
     $form_links = 1;
     $form_action = NULL;
     $form_input = array();
     $i=1;


if(parse_url($GLOBALS['url_val'], PHP_URL_HOST) == 'localhost')
{
echo '<button type="button" style="float:right" class="btn btn-default" data-toggle="collapse" data-target="#demo">Form & Script Details</button>';
}
echo '<div id="demo" class="collapse">';
if(parse_url($GLOBALS['url_val'], PHP_URL_HOST) == 'localhost')
{

     foreach($html->find("form") as $li)
     {
      $form_id = $li->id;
      ?>
      <input type="hidden" value="<?php echo $form_id; ?>" id="form_idval">
      <?php
      $form_action = $li->id;
      $form_links++;
      foreach($html->find("input") as $li_input)
      {
      ?>
      <input type="hidden" value="<?php echo $li_input->id; ?>" id="<?php echo $i; ?>">
      <?php
          $i++;
      }
      ?>
      <input type="hidden" value="<?php echo $i; ?>" id="input_count">
      <?php
      echo "<div class='well'><h4><b>Form Details:</b></h4><b>Action: </b>".$li->action."<br/><b>Submit: </b><span id='form_href_val'></span></div>";
     }
}
else
{

     foreach($html->find("form") as $li)
     {
      echo "<div class='well'><h4><b>Form Details:</b></h4><b>Action: </b>".$li->action."<br/></div>";
     }
}

foreach($html->find("script") as $li){
        $url=perfect_url($li->src,$u);
      $enurl=urlencode($url);
      if(parse_url($url, PHP_URL_HOST) == parse_url($GLOBALS['url_val'],PHP_URL_HOST))
      {
          $script_link = $url;
      }
}


if(parse_url($GLOBALS['url_val'], PHP_URL_HOST) == 'localhost')
{

if($script_link)
{

  echo "<div class='well'><h4><b>Script Details:</b></h4>";
//script analysis
$file = fopen($script_link, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
  {
    $var = fgets($file);
    $strlength = strlen($var);
    $location_cal = $strlength - 2;
    if(strpos( $var, "location" ))
    {
      echo "<b>Windows Location script Details :</b>";
      echo nl2br(substr($var,25)."");
    }
    else if(strpos( $var, "open" ))
    {
      echo "<b>Windows Open script Details :</b>";
      echo nl2br(substr($var,12)."");
    }
    else if(strpos( $var, "eval" ))
    {
      echo "<b>Windows eval script Details :</b>";
      echo nl2br($var."");
    }
    else if(strpos($var,"encodeURI")){
      echo "<b>Windows encodeURI script Details :</b>";
      echo nl2br($var."");
    }
    else
    {

    }

  }
fclose($file);
echo "</div>";
}

}

echo '</div>';

     echo "<div float='right'><a href='#' data-toggle='modal' data-target='#my_model' target='blank'><span class='label label-default'>All Links</span></a></div>";
     echo "  <!-- Modal -->
  <div class='modal fade' id='my_model' role='dialog'>
    <div class='modal-dialog' style='width:1000px'>

      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Base Links</h4>
        </div>
        <div class='modal-body'>
          <iframe src='url_redirection.php' width='960' height='500'></iframe>
        </div>
      </div>

    </div>
  </div>";
     echo "<h4><b>From href links</b></h4>";
     $i=0;
     $count = 1;
     $other_links = 1;
     echo "<table class='table table-striped'><thead><tr><th>S.No</th><th>Base Links</th><th>Action</th></tr></thead><tbody>";
     file_put_contents("url_redirection.php", "");
     $f=fopen("url_redirection.php","a+");
     fwrite($f,"<html><head></head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'><body><div class='well'><h3>Links of site <b>$u</b></h3></div><table class='table table-striped'><thead><tr><th>S.No</th><th>Base Links</th></tr></thead><tbody>");
     foreach($html->find("a") as $li){
      $url=perfect_url($li->href,$u);
      $enurl=urlencode($url);
      if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java"){
       $found_urls[$enurl]=1;
       if(isset($domain_name))
       {
        fwrite($f,"<tr><td>$other_links</td><td><a href='$url'>$url</a></td></tr>");
        $other_links++;
       }
       if(isset($domain_name) && in_array(get_domain($url), $domain_name))
       {

       }
       else
       {
        $domain_name[$i] = get_domain($url);
        if($domain_name[$i] != "")
        {
    echo "<tr><td>".$count."</td><td><a target='_blank' href='".$domain_name[$i]."'>".$domain_name[$i]."</a></td><td><a href='../index.php?url=$domain_name[$i]' title='Check Phishing' target='blank'><button class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-search'></span></button></a></td></tr>";
           $i++;
       $count++;
       }
       }

      }
     }
     fwrite($f,"</tbody></table></</html>");
     fclose($f);
     echo "</tbody></table>";

$check_iframe = 1;
          foreach($html->find("iframe") as $li){
     if($check_iframe == 1)
     {
     echo "<h4><b>From Iframes links</b></h4>";
     echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th>S.No</th><th>Base Links</th><th>Action</th></tr></thead><tbody>";
     }
     //$check_iframe =0;
      $url=perfect_url($li->src,$u);
      $enurl=urlencode($url);
      if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java" && array_key_exists($enurl,$found_urls)==0){
       $found_urls[$enurl]=1;
       echo "<tr><td>".$check_iframe."</td><td><a target='_blank' href='".$url."'>".$url."</a></td><td><a href='../index.php?url=$url' title='Check Phishing' target='blank'><button class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-search'></span></button></a></td></tr>";
      }
      $check_iframe++;
     }
     echo "</tbody></table></div>";
    }
   }
   if(isset($_POST['submit'])){
    $url=$_POST['url'];
    if(filter_var($url, FILTER_VALIDATE_URL) === FALSE){
      echo '<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> A valid URL please.
</div>';
    }else{
     //for response code

?>


<!--for getting the form submit links -->
<?php
if(parse_url($url, PHP_URL_HOST) == 'localhost')
{

?>

   <iframe  style="display: none;" src="<?php echo $url; ?>" id="iframe"></iframe>

<?php
}
?>
      <script>
  iframe.onload = function() {
    // we can get the reference to the inner window
    let iframeWindow = iframe.contentWindow;
    try {
      // ...but not to the document inside it
      let doc = iframe.contentDocument;
    } catch(e) {
      //alert(e); // Security Error (another origin)
    }

    // also we can't read the URL of the page in it
    try {
      var form_iddata = document.getElementById('form_idval').value;
      var form_inputcount = document.getElementById('input_count').value;
      var count;
      for(count =1;count < (form_inputcount-1);count++)
      {
        var form_inputidval = document.getElementById(count).value;
        document.getElementById('iframe').contentWindow.document.getElementById(form_inputidval).value = "DemoValue31";
      }
      //alert(iframe.contentWindow.location);
      document.getElementById('iframe').contentWindow.document.getElementById(form_iddata).submit();
      document.getElementById('iframe').contentWindow.location;
      alert(document.getElementById("iframe").contentWindow.location.href);
      document.getElementById("form_href_val").innerHTML = document.getElementById("iframe").contentWindow.location.href;
    } catch(e) {
      //alert(e); // Security Error
    }

    // ...but we can change it (and thus load something else into the iframe)!
    //iframe.contentWindow.location = '/'; // works

    iframe.onload = null; // clear the handler, to run this code only once
  };
      </script>

<?php


$domain1 = $url;

function get_http_response_code($domain1) {
  $headers = get_headers($domain1);
  return substr($headers[0], 9, 3);
}

$get_http_response_code = get_http_response_code($domain1);

          if ($get_http_response_code !== NULL) {

                switch ($get_http_response_code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($get_http_response_code) . '"');
                    break;
                }
              }

 //to get the redirected urls
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

test_expand_url($_POST["url"], $_POST["url"]);

$url = $GLOBALS['url_val'];

if($tiny_url)
{
echo "<div class='well'><b>Link:  </b>".$domain1 ."<br/><b>Status Code:  </b>".$get_http_response_code ." ". $text."<br/><b>Alternative Link: </b>".$url."</div>";
}
else
{
echo "<div class='well'><b>Link:  </b>".$domain1 ."<br/><b>Status Code:  </b>".$get_http_response_code ." ". $text."</div>";
}




     $f=fopen("url-crawled.html","a+");
     fwrite($f,"<div><a href='$url'>$url</a> - ".date("Y-m-d H:i:s")."</div>");
     fclose($f);
     echo "<div class='row'><div id='div1'>";
     crawl_site($url);
     echo "</div></div>";
    }
   }
   ?>
 <?php if(filter_var($url, FILTER_VALIDATE_URL) != FALSE) {?>
<div class="well">
<div class="row">
<div class="col-md-10">
</div>
<div class="col-md-2">
              <a href="report_redirection.php?url=<?php echo $_POST['url']; ?>" target="blank"><button class="btn btn-primary btn-default" sytle="float:left" id="check_submit"><span class="glyphicon glyphicon-file"></span> Report</button></a>
</div>
</div>

</div>
<?php } ?>
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
