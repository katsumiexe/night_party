<?
$list[0]	=file_get_contents("style.css");
$list[1]	=file_get_contents("style_t.css");
$list[2]	=file_get_contents("style_s.css");

for($s=0;$s<3;$s++){
	$fp=explode("\n",$list[$s]);
	if($fp){
		for($n=0;$n<count($fp);$n++){
			$tmp=trim($fp[$n]);
			if($tmp){
				if(substr($tmp,0,1) == "." && substr($tmp,-1,1) == "{"){
					$tmp2=substr($tmp,1,-1)."a";
					$main[0][$tmp2]=1;

				}elseif(substr($tmp,0,1) == "#" && substr($tmp,-1,1) == "{"){
					$tmp2=substr($tmp,1,-1)."b";
					$main[1][$tmp2]=1;

				}elseif(substr($tmp,0,1) == "@" && substr($tmp,-1,1) == "{"){
					$tmp2=substr($tmp,1,-1)."c";
					$main[2][$tmp2]=1;


				}elseif(substr($tmp,0,1) == "}"){
					asort($box[$s][$tmp2]);
					foreach($box[$s][$tmp2] as $b1){
						$dat[$s][$tmp2] .=$b1;
					}	
					$tmp2="";

				}else{
					$tmp3=explode(":",$tmp);
					if(trim($tmp3[1])){
						$tmp4=trim($tmp3[0]);
						$tmp5=strlen($tmp4);
						if($tmp5 > 16) $tmp5=16;

						$tmp6=ceil((16-$tmp5) / 4);

						for($t=0;$t<$tmp6+1;$t++){
							$tmp7.="\t";
						}
						$box[$s][$tmp2][]="\t".$tmp4.$tmp7.":".$tmp3[1]."\n";
						$tmp7="";

					}else{
						$box[$s][$tmp2][]="\t".$tmp3[0]."\n";
					
					}
				}
			}
		}
	}
	for($d=0;$d<3;$d++){
		ksort($main[$d]);

		foreach($main[$d] as $a1 => $a2){
			$tmp_a=substr($a1,-1,1);
			if($tmp_a == "a"){
				print( ".".substr($a1,0,-1)."{\n");

			}elseif($tmp_a == "b"){
				print( "#".substr($a1,0,-1)."{\n");

			}elseif($tmp_a == "c"){
				print( "@".substr($a1,0,-1)."{\n");
			}

			echo $dat[$s][$a1];
			echo "}\n\n";
		}
	}
		echo "/*-■-------------------------■-*/\n";
}
?>
