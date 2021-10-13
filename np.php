<?php
$user	="night-party_np";
$pass	="npnp1941";
$db		="night-party";

$mysqli = mysqli_connect('mysql57.night-party.sakura.ne.jp', 'night-party', 'npnp1941');

//$mysqli = mysqli_connect("localhost", $user, $pass, $db);



if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!mysqli_query($mysqli, "SET a=1")) {
    printf("Error message: %s\n", mysqli_error($mysqli));
}




if(!$mysqli){
	$msg="接続エラーです";
	die("接続エラーだ");
}
echo "DB SETUP";
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
</head>
<body>
<form method="post">
user<input type="text" name="user"><br>
pass<input type="text" name="pass"><br>
db<input type="text" name="db"><br>
key<input type="text" name="key"><br>
<button type="submit">SET</button>
</form>
</body>
</html>
