<?php 

  include_once('session.php');
  include_once('db.php');


$vid = mysqli_real_escape_string($_GET['vid']);


$result = mysqli_query($link, "SELECT * FROM tbl_topic WHERE topic_id=".$vid);
$row = mysqli_fetch_array($result);

if(isset($_POST['submit'])){ //check if form was submitted
  
    $translit = mysqli_real_escape_string($_POST['translit']);
    $translat = mysqli_real_escape_string($_POST['translat']);

    if($vid != NULL){

      //$result = mysql_query("UPDATE tbl_topic SET topic_transliteration='".$translit."' WHERE topic_id=".$vid.")");
      $sql = mysqli_query($link, 'UPDATE tbl_topic
      SET topic_transliteration="'.$translit.'", topic_translation="'.$translat.'"
      WHERE topic_id='.$vid);

      header("Location: video.php?vid=".$vid);
      //$userrow = mysql_fetch_array($result);
    }

    

   
  //$input = $_POST['username']; //get input text
}

function clean($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $preg = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return $preg;
}

?>
<!DOCTYPE html>
<!--
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
-->
<html>
<head>

  <meta charset="utf-8">
  <meta name="description" content="WebRTC code samples">
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximum-scale=1">
  <meta itemprop="description" content="Client-side WebRTC code samples">
  <meta itemprop="image" content="../../../images/webrtc-icon-192x192.png">
  <meta itemprop="name" content="WebRTC code samples">
  <meta name="mobile-web-app-capable" content="yes">
  <meta id="theme-color" name="theme-color" content="#ffffff">

  <title>Request</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">


  <link rel="icon" sizes="192x192" href="../../../images/webrtc-icon-192x192.png">
  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="css/main.css">

</head>

<body>

  <div id="container">

    <div align="right"><a href="index.php">Home</a> | username: <?php echo $_SESSION['username']; ?>, <a href="signout.php">signout</a></div>

    <h1> <span>Edit Request</span></h1>

    <div class="row">
      <div class="col-lg-9">
        <div class="row">
         <form method="post" action="">
            <h3>Transliteration</h3>
            <input name="translit" style="width: 300px; height: 25px; padding:4px;" type="text" value="<?php echo $row[2]; ?>"><br>
            <h3>Translation</h3>
            <input name="translat" style="width: 300px; height: 25px; padding:4px;" type="text" value="<?php echo $row[3]; ?>"><br><br>
            <div>
              <input name="submit" value="Submit" type="submit">
            </div>

          </form>

        </div>
      </div>
      <div class="col-lg-3">
        
      </div>
    </div>
    

    

    


  </div>

  


</body>
</html>
