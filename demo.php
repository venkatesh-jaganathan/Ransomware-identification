<?php
/**
* Expand short urls
*
* @param <string> $url - Short url
* @return <string> - Longer version of the short url
*/
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
    echo $url;
    return $url;
}
/**
 * Test Short urls
 */
function test_expand_url($short_url, $expected_long_url) {
    $actual_long_url = expand_url($short_url);
    if ($actual_long_url == $expected_long_url) {
        return "Pass for $short_url <br>";
    } else {
        return "Fail for $short_url <br>";
    }
}
// Run testcases 
echo test_expand_url('http://s.id/D00', 'http://warpspire.com/talks/chooseyouradventure/?utm_source=twitterfeed&utm_medium=twitter');
echo test_expand_url('http://t.co/hyK0qQCR', 'http://warpspire.com/talks/chooseyouradventure/?utm_source=twitterfeed&utm_medium=twitter');
echo test_expand_url('http://sudarmuthu.com', 'http://sudarmuthu.com');
?>