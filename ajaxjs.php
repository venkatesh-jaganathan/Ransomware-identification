<?php
// Fetching Values From URL
$name2 = $_POST['url_name'];
$connection = mysql_connect("localhost", "root", ""); // Establishing Connection with Server..
$db = mysql_select_db("ransomware", $connection); // Selecting Database
if (isset($_POST['url_name'])) {

$sql = "SELECT phish_url FROM phish_table WHERE phish_url= '$name2'";
//echo $sql;
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0) {
    // output data of each row
       echo "URL Already Added to DB";
} else {
   	
$query = mysql_query("insert into phish_table(phish_url) values ('$name2')"); //Insert Query
echo "URL Added to DB Succesfully";
}

}
mysql_close($connection); // Connection Closed;
?>