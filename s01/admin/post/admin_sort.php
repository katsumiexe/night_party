<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];
$group		=$_POST['group'];


if($group == "staff_sort"){
	$n=0;
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace('sort_item','',$a2);
		$sql="UPDATE wp00000_cast SET";
		$sql.=" cast_sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}

}elseif($group == "contents_sort"){
	$n=0;
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace('sort_item','',$a2);
		$sql="UPDATE wp00000_contents SET";
		$sql.=" sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}
}

exit();
?>
