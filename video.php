<?php 

  include_once('session.php');
  include_once('db.php');

  $vid = mysql_real_escape_string($_GET['vid']);

  if(isset($_GET['rid'])){
    $rid = mysql_real_escape_string($_GET['rid']);
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

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
</head>

<body style="padding: 0 !important;">

  <div id="container" style="padding: 0 !important;">

    

    <?php 
       $result = mysql_query("SELECT record_id, record_topic, record_file, record_date, record_user FROM tbl_recording WHERE record_type=1 AND record_topic=".$vid);
       $number_of_rows = mysql_num_rows($result);  

       if($number_of_rows > 0 && $rid != 'rec'){ //$rid != NULL

        if($rid != NULL){
          $mvid = mysql_query("SELECT record_id, record_topic, record_file, record_date, record_user FROM tbl_recording WHERE record_id=".$rid);
          $vidrow = mysql_fetch_array($mvid);
        }else{
          $mvid = mysql_query("SELECT record_id, record_topic, record_file, record_date, record_user FROM tbl_recording WHERE record_topic=".$vid);
          $vidrow = mysql_fetch_array($mvid);
          header("Location: https://test.exact-lab.com/webrtc/video.php?vid=".$vid."&rid=".$vidrow{'record_id'});
        }
        
          
          //var_dump($vidrow);
        ?>
          <video id="gum" style="display: none;" autoplay muted width="100%" height="100%"></video>
          <video id="recorded" src="uploads/<?php echo $vidrow{'record_topic'}.'/'.$vidrow{'record_file'}; ?>" autoplay controls></video>


        <?php
       }else{
    ?>
        <video id="gum" autoplay muted width="100%" height="100%" style="transform: rotateY(180deg); -webkit-transform:rotateY(180deg); -moz-transform:rotateY(180deg);"></video>
        <video style="display: none;" id="recorded" ></video>

        <script type="text/javascript">

        </script>
    <?php
      }
    ?>

    

    

    <img style="display: none; left: 50%; position: relative; margin-left: -400px;" id="loadinggif" src="images/gif-upload.gif">

    
    <div align="center">
      <button style="background: url(images/player_record.png); background-size: cover; height: 100px; cursor: pointer; position: absolute; right: 0; bottom: 0; <?php if($rid != 'rec' && $number_of_rows != 0){echo 'display: none;';}?>" id="record" disabled> </button>
      <button style="display: none;" id="play" disabled>Play</button>
      <button style="display: none;" id="download" disabled>Download</button>
    </div>
    

    

  </div>


  
  <div class="foot">
    <!--<div style="width: 100%; height: 30px; display: block;">Recordings</div>
    <div style="clear: both;"></div>
    <br/><br/><br/><br/>-->
    <div id="container">
      <div id="collection">
            <?php 

             
              $userresult = mysql_query("SELECT record_id, record_topic, record_file, record_date, record_user FROM tbl_recording WHERE record_type=2 AND record_topic=".$vid." AND record_user='".$_SESSION['username']."'");
              //echo $number_of_rows;

              if($number_of_rows > 0){
                $i = 1;
                while ($row = mysql_fetch_array($result)) {

                  $getthumb = mysql_query("SELECT * FROM tbl_recording WHERE record_topic=".$row{'record_topic'});
                  $rowthumb = mysql_fetch_array($getthumb);

                  echo "<div class='viditem'><a href='video.php?vid=".$row{'record_topic'}."&rid=".$row{'record_id'}."' title='".$row{'record_id'}."'><img src='uploads/".$row{'record_topic'}."/".$rowthumb[1]."' /><br/>Video #".$i." by ".$row{'record_user'}."</a></div>";
                   //echo "ID:".$row{'record_id'}." File:".$row{'record_file'}."Date: ". $row{'record_date'}."<br>";
                  $i++;
                }

                while ($row = mysql_fetch_array($userresult)) {
                  
                  $getthumb = mysql_query("SELECT * FROM tbl_recording WHERE record_topic=".$row{'record_topic'});
                  $rowthumb = mysql_fetch_array($getthumb);

                  echo "<div class='viditem'><a href='video.php?vid=".$row{'record_topic'}."&rid=".$row{'record_id'}."' title='".$row{'record_id'}."'><img src='uploads/".$row{'record_topic'}."/".$rowthumb[1]."' /><br/>Video #".$i." by ".$row{'record_user'}."</a></div>";
                   //echo "ID:".$row{'record_id'}." File:".$row{'record_file'}."Date: ". $row{'record_date'}."<br>";
                  $i++;
                }

              }


              
            ?>
          </div>
    </div>
</div>



  <!-- include adapter for srcObject shim -->
  <script src="js/adapter-latest.js"></script>
  <!--<script src="js/main.js"></script>-->
  <script type="text/javascript">
    /*
*  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
*
*  Use of this source code is governed by a BSD-style license
*  that can be found in the LICENSE file in the root of the source
*  tree.
*/

// This code is adapted from
// https://rawgit.com/Miguelao/demos/master/mediarecorder.html

'use strict';

/* globals MediaRecorder */

var mediaSource = new MediaSource();
mediaSource.addEventListener('sourceopen', handleSourceOpen, false);
var mediaRecorder;
var recordedBlobs;
var sourceBuffer;

var gumVideo = document.querySelector('video#gum');
var recordedVideo = document.querySelector('video#recorded');

var recordButton = document.querySelector('button#record');
var playButton = document.querySelector('button#play');
var downloadButton = document.querySelector('button#download');
recordButton.onclick = toggleRecording;
playButton.onclick = play;
downloadButton.onclick = download;

// window.isSecureContext could be used for Chrome
var isSecureOrigin = location.protocol === 'https:' ||
location.hostname === 'localhost';
if (!isSecureOrigin) {
  alert('getUserMedia() must be run from a secure origin: HTTPS or localhost.' +
    '\n\nChanging protocol to HTTPS');
  location.protocol = 'HTTPS';
}

var constraints = {
  audio: true,
  video: true
};

function handleSuccess(stream) {
  recordButton.disabled = false;
  console.log('getUserMedia() got stream: ', stream);
  window.stream = stream;
  if (window.URL) {
    gumVideo.src = window.URL.createObjectURL(stream);
  } else {
    gumVideo.src = stream;
  }
}

function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

navigator.mediaDevices.getUserMedia(constraints).
    then(handleSuccess).catch(handleError);

function handleSourceOpen(event) {
  console.log('MediaSource opened');
  sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');
  console.log('Source buffer: ', sourceBuffer);
}

recordedVideo.addEventListener('error', function(ev) {
  console.error('MediaRecording.recordedMedia.error()');
  alert('Your browser can not play\n\n' + recordedVideo.src
    + '\n\n media clip. event: ' + JSON.stringify(ev));
}, true);

function handleDataAvailable(event) {
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data);
  }
}

function handleStop(event) {
  console.log('Recorder stopped: ', event);
}

function toggleRecording() {
  if (recordButton.textContent === ' ') {
    startRecording();
  } else {
    stopRecording();
    recordButton.textContent = ' ';
    playButton.disabled = false;
    downloadButton.disabled = false;
  }
}

function startRecording() {

  var gumvideo = document.querySelector('video#gum');

  gumvideo.addEventListener('timeupdate', function() {
    // don't have set the startTime yet? set it to our currentTime
    if (!this._startTime) this._startTime = this.currentTime;

    var playedTime = this.currentTime - this._startTime;

    console.log(playedTime);

    if (playedTime >= 5) {this.pause(); stopRecording();} //this.pause();
  });

  recordedBlobs = [];
  var options = {mimeType: 'video/webm;codecs=vp9'};
  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
    console.log(options.mimeType + ' is not Supported');
    options = {mimeType: 'video/webm;codecs=vp8'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
      console.log(options.mimeType + ' is not Supported');
      options = {mimeType: 'video/webm'};
      if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.log(options.mimeType + ' is not Supported');
        options = {mimeType: ''};
      }
    }
  }
  try {
    mediaRecorder = new MediaRecorder(window.stream, options);
  } catch (e) {
    console.error('Exception while creating MediaRecorder: ' + e);
    alert('Exception while creating MediaRecorder: '
      + e + '. mimeType: ' + options.mimeType);
    return;
  }
  console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
  recordButton.textContent = '';
  recordButton.style.backgroundImage = "url('images/player_stop.png')";
  playButton.disabled = true;
  downloadButton.disabled = true;
  mediaRecorder.onstop = handleStop;
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start(10); // collect 10ms of data
  console.log('MediaRecorder started', mediaRecorder);
}

function stopRecording() {
  mediaRecorder.stop();
  console.log('Recorded Blobs: ', recordedBlobs);
  recordedVideo.controls = true;
  // upload each blob to PHP server
  uploadPrep(recordedBlobs);
}

function play() {
  var superBuffer = new Blob(recordedBlobs, {type: 'video/webm'});
  recordedVideo.src = window.URL.createObjectURL(superBuffer);
}

function playmute(){
  var video = document.getElementById("recorded");
  video.muted= true;
  video.play();
  //play();
}

function download() {
  var blob = new Blob(recordedBlobs, {type: 'video/webm'});
  var url = window.URL.createObjectURL(blob);
  var a = document.createElement('a');
  a.style.display = 'none';
  a.href = url;
  a.download = 'test.webm';
  document.body.appendChild(a);
  a.click();
  setTimeout(function() {
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
  }, 100);

  //uploadPrep(blob);
}


function uploadPrep(blob){
  var blob = new Blob(recordedBlobs, {type: 'video/webm'});
  uploadToPHPServer(blob);
}

function uploadToPHPServer(blob) {
    var file = new File([blob], '<?php echo $vid; ?>' + '-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
        type: 'video/webm'
    });

    // create FormData
    var formData = new FormData();
    formData.append('video-filename', file.name);
    formData.append('video-blob', file);
    formData.append('video-id', '<?php echo $vid; ?>');
    formData.append('video-user', '<?php echo $_SESSION['username']; ?>');

    document.getElementById("gum").style.display = "none";
    document.getElementById("record").style.display = "none";

    document.getElementById("loadinggif").style.display = "block";

    makeXMLHttpRequest('https://test.exact-lab.com/webrtc/save.php', formData, function() {
        var downloadURL = 'https://test.exact-lab.com/webrtc/uploads/' + file.name;
        console.log('File uploaded to this path:', downloadURL);
        //document.getElementById("play").style.display = "block";
        document.getElementById("recorded").style.display = "block";
        document.getElementById("loadinggif").style.display = "none";

        play();
    });
}

function makeXMLHttpRequest(url, data, callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            callback();
        }
    };
    request.open('POST', url);
    request.send(data);
}



<?php
  if($number_of_rows > 0 && $rid != 'rec'){ //$rid != NULL
?>
var repcount = 0;
document.getElementById('recorded').addEventListener('ended',myHandler,false);
function myHandler(e) {
    // What you want to do after the event
    if(repcount == 0){
      playmute();
    }
    if(repcount == 1){
      loopEl();
    }
    repcount++;
}

function loopEl(){
  var viditems = document.getElementsByClassName("viditem");
  var limreach = 0;
  for (var i = 0; i < viditems.length; i++)
  {
    //c[0].style.backgroundColor = "yellow";
    //
    console.log(i, viditems.length);
    if(i == (viditems.length-1) ){
      console.log('limreach');
      limreach = 1;
    }

    var c = viditems[i].childNodes;
    var curid = <?php echo $rid; ?>;
    if(c[0].title == curid){
      if(limreach == 1){
        console.log('inside limreach');
        window.location = "https://test.exact-lab.com/webrtc/video.php?vid="+<?php echo $vid; ?>+"&rid=rec";
      }else{
        console.log('next page');
        var cnext = viditems[i+1].childNodes;
        window.location = "https://test.exact-lab.com/webrtc/video.php?vid="+<?php echo $vid; ?>+"&rid="+cnext[0].title;
      }
      
    }

  }
  

}




<?php
  }
?>

//var recVideo = document.getElementById("recorded");
//recVideo.addEventListener("ended", playmute(), false); 





$(document).ready(function() {
  $('.foot').click(function() {
      if($('.foot').hasClass('slide-up')) {
        $('.foot').addClass('slide-down', 1000, 'easeOutBounce');
        $('.foot').removeClass('slide-up'); 
      } else {
        $('.foot').removeClass('slide-down');
        $('.foot').addClass('slide-up', 1000, 'easeOutBounce'); 
      }
  });
});



  </script>



</body>
</html>
