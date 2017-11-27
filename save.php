<?php
// via: https://github.com/muaz-khan/RecordRTC/blob/master/RecordRTC-to-PHP/save.php
header("Access-Control-Allow-Origin: *");

include_once('db.php');

function selfInvoker()
{
    if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename']) && !isset($_POST['video-id'])) {
        echo 'PermissionDeniedError';
        return;
    }

    $fileName = '';
    $tempName = '';
    $vid = '';
    $user = '';

    if (isset($_POST['audio-filename'])) {
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES['audio-blob']['tmp_name'];
        $vid = $_POST['video-id'];
        $user = $_POST['video-user'];
    } else {
        $fileName = $_POST['video-filename'];
        $tempName = $_FILES['video-blob']['tmp_name'];
        $vid = $_POST['video-id'];
        $user = $_POST['video-user'];
    }

    if (empty($fileName) || empty($tempName)) {
        echo 'PermissionDeniedError';
        return;
    }
    $filePath = 'uploads/' . $vid . '/' . $fileName;

    if (!file_exists('uploads/' . $vid )) {
        mkdir('uploads/' . $vid , 0777, true);
    }

    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'PermissionDeniedError';
        //continue;
    }

    if (!move_uploaded_file($tempName, $filePath)) {
        echo ('Problem saving file.');
        return;
    }



    $second     = 1;
    $video_file_path = $filePath; //'uploads/1/1-2017-11-15T13-28-33-832Z.webm';
    $thumb = basename($video_file_path,".webm").'.jpg';
    $image  = 'uploads/'. $vid .'/'.$thumb;
    $cmd = "ffmpeg -i $video_file_path -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
     
    exec($cmd, $output, $retval);

    //generate thumb
    /*$frame = 10;
    $movie = $filePath;
    $thumbnail = 'thumbnail.png';
    $mov = new ffmpeg_movie($movie);
    var_dump($mov); exit();
    $frame = $mov->getFrame($frame);
    if ($frame) {
        $gd_image = $frame->toGDImage();
        if ($gd_image) {
            imagepng($gd_image, $thumbnail);
            imagedestroy($gd_image);
            //echo '<img src="'.$thumbnail.'">';
        }
    }*/



    $rectype = 1;
    $query = mysqli_query($link, "SELECT record_id, record_topic, record_file, record_date, record_user FROM tbl_recording WHERE record_type=1 AND record_topic=".$vid);
    $number_of_rows = mysqli_num_rows($query); 
    if($number_of_rows >= 4){
        $rectype = 2;
    }

    //
    $result = mysqli_query($link, "INSERT INTO tbl_recording (record_topic, record_file, record_user, record_type, record_thumb) VALUES (".$vid.", '".$fileName."', '".$user."', ".$rectype.", '".$thumb."')");

    echo ($filePath);
}
selfInvoker();
?>