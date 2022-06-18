<?
$txt=file_get_contents("./css/style.css");
$dat=explode("#",$txt);
for($n=0;$n<count($dat);$n++){
	$tmp=substr($dat[$n],0,6);
	$cl[$tmp]++;
}

krsort($cl); 

foreach($cl as $a1 => $a2){
	print($a1.",".$a2."<br>\n");
}
?>
