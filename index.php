<?php 

  include_once('session.php');
  include_once('db.php');

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

  <title>Home</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">


  <link rel="icon" sizes="192x192" href="../../../images/webrtc-icon-192x192.png">
  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="css/main.css">

</head>

<body>

  <div id="container">

    <div align="right">username: <?php echo $_SESSION['username']; ?>, <a href="signout.php">signout</a></div>

    <h1> <span>Home</span></h1>

    <div class="row">
      <div class="col-lg-9">
        <div class="row">
          <?php 


          $rec_limit = 10;

            /* Get total number of records */
           $sql = "SELECT count(topic_id) FROM tbl_topic ";
           $retval = mysqli_query($link,  $sql);
           
           if(! $retval ) {
              die('Could not get data: ' . mysql_error());
           }

           $row = mysqli_fetch_array($retval, MYSQL_NUM );
           $rec_count = $row[0];


            if( isset($_GET{'page'} ) ) {
              $page = $_GET{'page'} + 1;
              $offset = $rec_limit * $page ;
           }else {
              $page = 0;
              $offset = 0;
           }



           $left_rec = $rec_count - ($page * $rec_limit);
           $sql = "SELECT * FROM tbl_topic WHERE topic_status=1 LIMIT $offset, $rec_limit";
              
           $retval = mysqli_query($link,  $sql );
           
           if(! $retval ) {
              die('Could not get data: ' . mysql_error());
           }

           
             //$result = mysql_query("SELECT * FROM tbl_topic WHERE topic_status=1");
             

            while ($row = mysqli_fetch_array($retval)) {


                $getthumb = mysqli_query($link, "SELECT * FROM tbl_recording WHERE record_topic=".$row[0]);
                $rowthumb = mysqli_fetch_array($getthumb);
                //echo $rowthumb[1];
                echo "<div class='col-lg-3'><a href='details.php?vid=".$row[0]."'><img src='uploads/".$row[0]."/".$rowthumb[1]."' /><br/>".$row[3]."</a></div>";
            }




            
             
          ?>
        </div>
          <br/><br/><br/>
        <div>

          <?php

            if( $page > 0 ) {
              $last = $page - 2;
              echo "<a href = \"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
              echo "<a href = \"$_PHP_SELF?page=$page\">Next 10 Records</a>";
           }else if( $page == 0 ) {
              echo "<a href = \"$_PHP_SELF?page=$page\">Next 10 Records</a>";
           }else if( $left_rec < $rec_limit ) {
              $last = $page - 2;
              echo "<a href = \"$_PHP_SELF?page=$last\">Last 10 Records</a>";
           }

          ?>
        </div>
      </div>
      <div class="col-lg-3">
        <div><a class="mybtn" href="request-form.php">Request New Phrase</a></div>
        <hr>
        <?php 
             $result = mysqli_query($link, "SELECT * FROM tbl_topic WHERE topic_status=0");
             

            while ($row = mysqli_fetch_array($result)) {

                echo "<div><a style='color:red;' href='details.php?vid=".$row[0]."'>".$row[1]."</a></div>";
            }
             
          ?>
      </div>
    </div>
    

    

    


  </div>

  


</body>
</html>
