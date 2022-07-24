<?
include_once('../sample1/library/sql.php');
/*
ini_set('display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$now=date("Y-m-d H:i:s");

$sql	 ="UPDATE sheet SET
 `fin`='{$_POST["fin"]}',
 `date`='{$now}',
 `info_0`='{$_POST["info_0"]}',
 `info_1`='{$_POST["info_1"]}',
 `info_2`='{$_POST["info_2"]}',
 `info_3`='{$_POST["info_3"]}',
 `info_4`='{$_POST["info_4"]}',
 `info_5`='{$_POST["info_5"]}',
 `info_6`='{$_POST["info_6"]}',
 `info_7`='{$_POST["info_7"]}',
 `info_8`='{$_POST["info_8"]}',
 `info_9`='{$_POST["info_9"]}',
 `info_10`='{$_POST["info_10"]}',
 `info_11`='{$_POST["info_11"]}',
 `info_12`='{$_POST["info_12"]}',
 `info_13`='{$_POST["info_13"]}',
 `info_14`='{$_POST["info_14"]}',

`pf_0`='{$_POST["pf_0"]}',
`pf_1`='{$_POST["pf_1"]}',
`pf_2`='{$_POST["pf_2"]}',
`pf_3`='{$_POST["pf_3"]}',
`pf_4`='{$_POST["pf_4"]}',
`pf_5`='{$_POST["pf_5"]}',
`pf_6`='{$_POST["pf_6"]}',
`pf_7`='{$_POST["pf_7"]}',
`op_0`='{$_POST["op_0"]}',
`op_1`='{$_POST["op_1"]}',
`op_2`='{$_POST["op_2"]}',
`op_3`='{$_POST["op_3"]}',
`op_4`='{$_POST["op_4"]}',
`op_5`='{$_POST["op_5"]}',
`op_6`='{$_POST["op_6"]}',
`op_7`='{$_POST["op_7"]}',
`op_8`='{$_POST["op_8"]}',
`op_9`='{$_POST["op_9"]}',
`op_10`='{$_POST["op_10"]}',
`op_11`='{$_POST["op_11"]}',
`pg_0`='{$_POST["pg_0"]}',
`pg_1`='{$_POST["pg_1"]}',
`rec_0`='{$_POST["rec_0"]}',
`rec_1`='{$_POST["rec_1"]}',
`rec_2`='{$_POST["rec_2"]}',
`rec_3`='{$_POST["rec_3"]}',
`rec_4`='{$_POST["rec_4"]}',
`rec_5`='{$_POST["rec_5"]}',
`rec_6`='{$_POST["rec_6"]}',
`rec_7`='{$_POST["rec_7"]}',
`rec_8`='{$_POST["rec_8"]}',
`rec_c_1`='{$_POST["rec_c_1"]}',
`rec_c_2`='{$_POST["rec_c_2"]}',
`rec_c_3`='{$_POST["rec_c_3"]}',
`rec_c_4`='{$_POST["rec_c_4"]}',
`rec_c_5`='{$_POST["rec_c_5"]}',
`rec_c_6`='{$_POST["rec_c_6"]}',
`rec_c_7`='{$_POST["rec_c_7"]}',
`rec_c_8`='{$_POST["rec_c_8"]}',
`bn_0`='{$_POST["bn_0"]}',
`bn_1`='{$_POST["bn_1"]}',
`ck_1`='{$_POST["ck_1"]}',
`ck_2`='{$_POST["ck_2"]}',
`ck_3`='{$_POST["ck_3"]}',
`ck_4`='{$_POST["ck_4"]}',
`ck_5`='{$_POST["ck_5"]}',
`ck_6`='{$_POST["ck_6"]}',
`ck_7`='{$_POST["ck_7"]}',
`ck_8`='{$_POST["ck_8"]}',
`ck_9`='{$_POST["ck_9"]}',
`ck_10`='{$_POST["ck_10"]}',
`ck_11`='{$_POST["ck_11"]}',
`ck_12`='{$_POST["ck_12"]}',
`ck_13`='{$_POST["ck_13"]}',
`ck_14`='{$_POST["ck_14"]}',
`ck_15`='{$_POST["ck_15"]}'
 WHERE `code`='{$_POST["code"]}'
";
mysqli_query($mysqli,$sql);

$sql	 ="UPDATE sheet_pay SET
 `pay_0`='{$_POST["pay_0"]}',
`pay_1`='{$_POST["pay_1"]}',
`pay_2`='{$_POST["pay_2"]}',
`pay_3`='{$_POST["pay_3"]}',
`pay_4`='{$_POST["pay_4"]}',
`pay_5`='{$_POST["pay_5"]}',
`pay_6`='{$_POST["pay_6"]}',
`pay_7`='{$_POST["pay_7"]}',
`pay_8`='{$_POST["pay_8"]}',
`pay_9`='{$_POST["pay_9"]}',
`pay_c_0`='{$_POST["pay_c_0"]}',
`pay_c_1`='{$_POST["pay_c_1"]}',
`pay_c_2`='{$_POST["pay_c_2"]}',
`pay_c_3`='{$_POST["pay_c_3"]}',
`pay_c_4`='{$_POST["pay_c_4"]}',
`pay_c_5`='{$_POST["pay_c_5"]}',
`pay_c_6`='{$_POST["pay_c_6"]}',
`pay_c_7`='{$_POST["pay_c_7"]}',
`pay_c_8`='{$_POST["pay_c_8"]}',
`pay_c_9`='{$_POST["pay_c_9"]}'
 WHERE `pay_code`='{$_POST["code"]}'
";

echo $sql;

mysqli_query($mysqli,$sql);
exit()
?>
