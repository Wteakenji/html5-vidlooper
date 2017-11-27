<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

//var_dump($_POST);
//var_dump('SESSION'.$_SESSION['username']);
include_once('db.php');
if(isset($_POST['submit'])){ //check if form was submitted
  if (!isset($_SESSION) || !isset($_SESSION['username']) ) {
    $username = clean($_POST['username']);
    $password = md5(clean($_POST['password']));

    $result = mysqli_query($link, "SELECT * FROM tbl_user WHERE user_username='".$username."'");
    $userrow = mysqli_fetch_array($result);

    //var_dump($userrow[2]);
    if($password == $userrow[2]){
      session_start();
      $_SESSION['username'] = $username;
      //$_SESSION['password'] = clean($_POST['password']);
      header("Location: index.php");
    }
    //var_dump($userrow);
   
    //var_dump('POST: '.$_POST['username']);
  }
  //$input = $_POST['username']; //get input text
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $preg = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return substr($preg, 0, 12);
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

  <title>User</title>

  <link rel="icon" sizes="192x192" href="../../../images/webrtc-icon-192x192.png">
  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="css/main.css">
  <style type="text/css">
    h3{border-top:none; padding: 0;}
  </style>

</head>

<body>

  <div id="container">

    

    
    
    
    <form method="post" action="">
      <h3>Username</h3>
      <input type="text" name="username" style="width: 300px; height: 25px; padding:4px;" required="required"><br/>
      <h3>Password</h3>
      <input type="password" name="password" style="width: 300px; height: 25px; padding:4px;" required="required">
      <div>
        <input type="submit" name="submit" value="Sign In">
      </div>

    </form>
    
    




  </div>

  


</body>
</html>
