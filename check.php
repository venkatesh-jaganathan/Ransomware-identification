<?php

// Make sure that input contains http
 if(substr($blog,0,7) != "http://")
  $blog = "http://" . $blog;
  
// Make sure that blog URL ends with a slash
 if(substr($blog, -1) != "/")
  $blog = $blog . "/";

// Determine the count of blog posts
 $url = $blog . "atom.xml?redirect=false&start-index=1&max-results=1";

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

 $xml = curl_exec($ch) ;
 curl_close($ch);

// Parse the XML ouput to determine the count
 $x = strpos($xml, "<openSearch:totalResults>") + strlen("<openSearch:totalResults>");
 $y = strpos($xml, "</openSearch:totalResults>");
 $c = substr($xml, $x, $y-$x);

// Generate the XML sitemap for robots.txt
  if ($c >=1) {
    echo "# Blogger Sitemap generated on " . date("Y.m.d") . "<br />";
    echo "User-agent: *<br/>Disallow: /search<br/>Allow: /<br />";
    for($x=1; $x<=$c; $x=$x+500) {
        echo "<br/>Sitemap: " . $blog . "atom.xml?redirect=false&start-index=" . $x . "&max-results=500";
     }
  }

?>