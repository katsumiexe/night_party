<?
include_once('../../library/sql_post_admin.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$img_code	=$_POST["img_code"];

$img_top	=str_replace("px","",$_POST["img_top"]);
$img_left	=str_replace("px","",$_POST["img_left"]);
$img_width	=str_replace("px","",$_POST["img_width"]);

$img_zoom	=$_POST["img_zoom"];
$img_rote	=$_POST["img_rote"]+0;

$width_s	=$_POST["width_s"];
$width_l	=$_POST["width_l"];

$task		=$_POST["task"];
$post_id	=$_POST["post_id"];
	
$st_top		=$_POST["st_top"];
$st_left	=$_POST["st_left"];
$st_width	=$_POST["st_width"];
$st_height	=$_POST["st_height"];
$st_url		=$_POST["st_url"];
$st_op		=$_POST["st_op"];
$st_rotate	=$_POST["st_rotate"];

$n=0;
if($img_code){
	$size=600;
	$img2 		= imagecreatetruecolor($size,$size);

	$back = imagecolorallocate($img2, 255, 255, 255);
	imagefill($img2, 0, 0, $back);

	$tmp_top	=ceil( ( $width_s - $img_top ) * ( 1800 / $img_width ) );
	$tmp_left	=ceil( ( $width_s - $img_left ) * ( 1800 / $img_width ) );
	$tmp_width	=$width_l  * ( 1800 / $img_width );

	if($img_rote ==90){
		$new_img = imagecreatefromstring(base64_decode($img_code));	
		$img = imagerotate($new_img, 270, 0, 0);

	}elseif($img_rote ==270){
		$new_img = imagecreatefromstring(base64_decode($img_code));
		$img = imagerotate($new_img, 90, 0, 0);

	}elseif($img_rote ==180){
		$new_img = imagecreatefromstring(base64_decode($img_code));
		$img = imagerotate($new_img, 180, 0, 0);

	}else{
		$img = imagecreatefromstring(base64_decode($img_code));
	}

	ImageCopyResampled($img2, $img, 0, 0, $tmp_left, $tmp_top, $size, $size, $tmp_width, $tmp_width);

	if($st_top){
		ksort($st_top);
		foreach($st_top as $a1 => $a2){
			if($a2){
				$top	=ceil((str_replace("px","",$st_top[$a1])-$width_s)*($size / $width_l));
				$left	=ceil((str_replace("px","",$st_left[$a1])-$width_s)*($size / $width_l));
				$width	=ceil(str_replace("px","",$st_width[$a1])*($size / $width_l));
				$height	=ceil(str_replace("px","",$st_height[$a1])*($size / $width_l));

				if($st_op[$a1] < 1){
					$st_url[$a1]=str_replace(".png","a.png",$st_url[$a1]);
				}

				$stamp_img	= imagecreatefrompng("../".$st_url[$a1]);	
				imagealphablending($stamp_img, false);
				imagesavealpha($stamp_img, true);
				$top2=85;
				$left2=85;

				if($st_rotate[$a1] > 0 ){
					$rotate		=360-$st_rotate[$a1];
					$stamp_img	=imagerotate($stamp_img, $rotate, 0, 0);
					$width2		=imagesx($stamp_img);
					$height2	=imagesy($stamp_img);
					$top2		=ceil($width2-600)/2+85;	
					$left2		=ceil($height2-600)/2+85;	
				}

				imagecopyresampled($img2, $stamp_img, $left, $top, $left2, $top2, $width, $height, 430, 430);
			}
		}
	}
}

$tmpfname = tempnam('tmp', 'pngtmp_');
$tmp=imagepng($img2, $tmpfname);
$data = @file_get_contents($tmpfname);
unlink($tmpfname);
if($data) $img_64 = base64_encode($data);

echo $img_64;
exit()
?>
