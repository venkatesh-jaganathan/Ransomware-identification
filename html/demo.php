<?php
// Disable time limit to keep the script running
set_time_limit(0);
// Domain to start crawling
$domain = "http://webdevwonders.com";
// Content to search for existence
$content = "google-analytics.com/ga.js";
// Tag in which you look for the content
$content_tag = "script";
// Name of the output file
$output_file = "analytics_domains.txt";
// Maximum urls to check
$max_urls_to_check = 100;
$rounds = 0;
// Array to hold all domains to check
$domain_stack = array();
// Maximum size of domain stack
$max_size_domain_stack = 1000;
// Hash to hold all domains already checked
$checked_domains = array();
 
// Loop through the domains as long as domains are available in the stack
// and the maximum number of urls to check is not reached
while ($domain != "" && $rounds < $max_urls_to_check) {
    $doc = new DOMDocument();
 
    // Get the sourcecode of the domain
    @$doc->loadHTMLFile($domain);
    $found = false;
 
    // Loop through each found tag of the specified type in the dom
    // and search for the specified content
    foreach($doc->getElementsByTagName($content_tag) as $tag) {
        if (strpos($tag->nodeValue, $content)) {
            $found = true;
            break;
        }
    }
 
    // Add the domain to the checked domains hash
    $checked_domains[$domain] = $found;
    // Loop through each "a"-tag in the dom
    // and add its href domain to the domain stack if it is not an internal link
    foreach($doc->getElementsByTagName('a') as $link) {
        $href = $link->getAttribute('href');
        if (strpos($href, 'http://') !== false && strpos($href, $domain) === false) {
            $href_array = explode("/", $href);
            // Keep the domain stack to the predefined max of domains
            // and only push domains to the stack that have not been checked yet
            if (count($domain_stack) < $max_size_domain_stack &&
                $checked_domains["http://".$href_array[2]] === null) {
                array_push($domain_stack, "http://".$href_array[2]);
            }
        };
    }
 
    // Remove all duplicate urls from stack
    $domain_stack = array_unique($domain_stack);
    $domain = $domain_stack[0];
    // Remove the assigned domain from domain stack
    unset($domain_stack[0]);
    // Reorder the domain stack
    $domain_stack = array_values($domain_stack);
    $rounds++;
}
 
$found_domains = "";
// Add all domains where the specified search string
// has been found to the found domains string
foreach ($checked_domains as $key => $value) {
    if ($value) {
        $found_domains .= $key."\n";
    }
}
 
// Write found domains string to specified output file
file_put_contents($output_file, $found_domains);
?>