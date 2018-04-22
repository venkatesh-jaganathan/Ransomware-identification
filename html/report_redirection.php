<?php
//for href links
$html_hreftitle = "<p><b>Base Links</b></p>";
//array declaration for storing domain names
$GLOBALS['domain_name'] = array();
$GLOBALS['domain_var'] = array();
$GLOBALS['html_links'] = array();
$i = 0;
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
     $i=0;
     $count = 1;
     $other_links = 1;
     foreach($html->find("a") as $li){
      $url=perfect_url($li->href,$u);
      $enurl=urlencode($url);
      if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java"){
       $found_urls[$enurl]=1;
       if(isset($domain_name) && in_array(get_domain($url), $domain_name))
       {

       }
       else
       {
        $domain_name[$i] = get_domain($url);
        if($domain_name[$i] != "")
        {
        $html_links[$i] = '<p>'.$domain_name[$i].'</p>';
           $i++; 
       $count++;   
       }         
       }

      }
     }

}
 return $html_links;
}

$domain_var =crawl_site($_GET["url"]);
//for the domain and status code
$domain1 = $_GET["url"];

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

test_expand_url($_GET["url"], $_GET["url"]);

$url = $GLOBALS['url_val'];

?>
<?php
require('html_table.php');
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

if($tiny_url)
{
  $html='
<table border="1">
<tr><p><b>Link: </b>'.$domain1.'</p></tr>
<tr><p><b>Status Code:  </b></p>'.$get_http_response_code ." ". $text.'</tr>
<tr><p><b>Alternative Link:  </b></p>'.$url.'</tr>
</table>';
}
else
{
  $html='
<table border="1">
<tr><p><b>Link: </b>'.$domain1.'</p></tr>
<tr><p><b>Status Code:  </b></p>'.$get_http_response_code ." ". $text.'</tr>
</table>';
}
 

$pdf->WriteHTML($html);
$pdf->WriteHTML($html_hreftitle);
for($i=0;$i<sizeof($domain_var);$i++)
{
  $pdf->WriteHTML($domain_var[$i]);
}
$pdf->Output();
?>