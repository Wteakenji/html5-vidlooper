<?php
$link = mysqli_connect('localhost', 'root', 'LastRoofAmokRoll');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';


$webrtc = mysqli_select_db($link, "webrtc") or die("Could not select webrtc");



//execute the SQL query and return records
/*$result = mysql_query("SELECT topic_id, topic_phrase, topic_status FROM tbl_topic");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
   echo "ID:".$row{'topic_id'}." Topic:".$row{'topic_phrase'}."Status: ". $row{'topic_status'}."<br>";
}*/


//mysql_close($link);
?>