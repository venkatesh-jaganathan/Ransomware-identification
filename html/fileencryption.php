<?php

// encrypt file
encrypt_file('C:\Users\Venkat\Desktop\Demoencryption\file.txt','C:\Users\Venkat\Desktop\encryptoutput\file2.txt','secretPassword');

function encrypt_file($file, $destination, $passphrase) {
        // Open the file and returns a file pointer resource.
    $handle = fopen($file, "rb") or die("Could not open a file.");
        // Returns the read string.
    $contents = fread($handle, filesize($file));
        // Close the opened file pointer.
    fclose($handle);

    $iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
    $key = substr(md5("\x2D\xFC\xD8".$passphrase, true) . md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
    $opts = array('iv'=>$iv, 'key'=>$key);
    $fp = fopen($destination, 'wb') or die("Could not open file for writing.");
        // Add the Mcrypt stream filter with Triple DES
    stream_filter_append($fp, 'mcrypt.tripledes', STREAM_FILTER_WRITE, $opts);
        // Write content in the destination file.
    fwrite($fp, $contents) or die("Could not write to file.");
       // Close the opened file pointer.
    fclose($fp);

}
?>
