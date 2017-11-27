<?php 

  include_once('session.php');
  include_once('db.php');

  $vid = mysqli_real_escape_string($_GET['vid']);

  if(isset($_GET['rid'])){
    $rid = mysqli_real_escape_string($_GET['rid']);
  }else{
    $rid = NULL;
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

  <title>Video</title>

  <link rel="icon" sizes="192x192" href="../../../images/webrtc-icon-192x192.png">
  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="css/main.css">

</head>

<body style="padding: 0 !important;">

  


  <div style="padding:20px;">
        <div align="right"><a href="index.php">Home</a> | username: <?php echo $_SESSION['username']; ?>, <a href="signout.php">signout</a></div>

      <?php
        $result = mysqli_query($link, "SELECT * FROM tbl_topic WHERE topic_id=".$vid);
        $row = mysqli_fetch_array($result);
      ?>
      <div style="text-align: center; margin-top: 100px;">
        <h1> <span><?php echo $row[1]; ?></span> <a href="request-edit.php?vid=<?php echo $vid; ?>">edit</a></h1> 
        <br/><br/><br/>
        <h1>Transliteration: <?php echo $row[2]; ?></h1>
        <br/><br/><br/>
        <h1>Translation: <?php echo $row[3]; ?></h1>
      </div>
      

  </div>
  

  <!--<script src="js/main.js"></script>-->
  <script type="text/javascript">

      setTimeout(function(){ window.location = "https://54.174.118.236/webrtc/video.php?vid="+<?php echo $vid; ?>; }, 3000);
      
      

  </script>



</body>
</html>
