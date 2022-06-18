<?
$list[0]	=file_get_contents("style.css");
$list[1]	=file_get_contents("style_t.css");
$list[2]	=file_get_contents("style_s.css");

$ck[0]	=file_get_contents("../index.php");
$ck[1]	=file_get_contents("../header.php");
$ck[2]	=file_get_contents("../cast.php");
$ck[3]	=file_get_contents("../person.php");
$ck[4]	=file_get_contents("../castblog.php");
$ck[5]	=file_get_contents("../article.php");
$ck[6]	=file_get_contents("../event.php");

for($s=0;$s<1;$s++){

	$fp=explode("\n",$list[$s]);
	if($fp){
		for($n=0;$n<count($fp);$n++){
			$tmp=trim($fp[$n]);
			if($tmp){
				if(substr($tmp,-1,1) == "{"){

					$dat=substr($tmp,1,-1);
					for($a=0;$a<7;$a++){
						if(strpos($ck[$a],$dat)+0 > 0){
							$err=1;
//							break 1;
						}
					}

					if($err !=1){
						echo $tmp."\n";
					}
					$err=0;


				}
			}
		}
	}
}
?>
