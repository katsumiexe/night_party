<?
/*
お知らせページ処理
*/
include_once('../../library/sql_post.php');

$p		=$_POST["p"];
$page		=$_POST["page"]*5;
$month		=$_POST["month"];

$st=substr($month,0,4)."-".substr($month,4,2)."-01 00:00:00";
$ed=date("Y-m-01 00:00:00",strtotime($st)+3456000);


$sql	 ="SELECT * FROM wp00000_notice";
$sql	.=" LEFT JOIN wp00000_notice_ck ON wp00000_notice.id=wp00000_notice_ck.notice_id";
$sql	.=" WHERE del='0'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND status>0";
$sql	.=" AND wp00000_notice.date BETWEEN '{$st}' AND '{$ed}'";
$sql	.=" ORDER BY wp00000_notice.date DESC";
$sql	.=" LIMIT {$page}, 6";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$row["d"]=substr($row["date"],5,2)."月".substr($row["date"],8,2)."日";
		$notice[]=$row;
		$notice_count++;
	}
}

if($notice_count>5){
	$notice_count=5;
	$dat["next"]=0;
}else{
	$dat["next"]=1;

}

$dat["html"]=" ";

for($n=0;$n<$notice_count;$n++){
$dat["html"].="<div id=\"notice_box_title{$notice[$n]["id"]}\" class=\"notice_box_item nt{$notice[$n]["status"]}\">";

$dat["html"].="<span class=\"notice_d\">{$notice[$n]["d"]}</span>";
$dat["html"].="<span class=\"notice_t\">{$notice[$n]["title"]}</span>";
$dat["html"].="<span class=\"notice_yet{$notice[$n]["status"]}\"></span>";
$dat["html"].="</div>";
}



echo json_encode($dat);
exit();
?>
