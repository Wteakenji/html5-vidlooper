<?php


//$video = 'uploads/1-2017-11-15T13-28-33-832Z.webm';

 
// Location where video thumbnail to store
$thumbnail_path = 'uploads/1/thumbnail/test.jpg';
$second             = 1;
$thumbSize       = '150x150';
 
// Video file name without extension(.mp4 etc)
$videoname  = 'uploads/1/1-2017-11-15T13-28-33-832Z';
$video_file_path = 'uploads/1/1-2017-11-15T13-28-33-832Z.webm';

 
// FFmpeg Command to generate video thumbnail
//{$ffmpeg_installation_path}
 
//$cmd = "ffmpeg -i {$video_file_path} -deinterlace -an -ss {$second} -t 00:00:01  -s {$thumbSize} -r 1 -y -vcodec mjpeg -f mjpeg {$thumbnail_path} 2>&1";

$image  = 'uploads/1/thumbnail/test2.jpg';
$cmd = "ffmpeg -i $video_file_path -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
 
exec($cmd, $output, $retval);

var_dump($output);
 
if ($retval)
{
    echo 'error in generating video thumbnail';
}
else
{
    echo 'Thumbnail generated successfully';
    echo $thumb_path = $thumbnail_path . $videoname . '.jpg';
}

?>