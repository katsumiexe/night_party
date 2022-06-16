<?
foreach(glob('*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}



echo "<hr>";

foreach(glob('./post/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}


foreach(glob('./library/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}


foreach(glob('./mypage/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}

foreach(glob('./admin/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}


foreach(glob('./mypage/post/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}



foreach(glob('./admin/post/*.php') as $file){
    if(is_file($file)){
		$n=file_get_contents($file);
		$n=str_replace("".TABLE_KEY."","\".TABLE_KEY.\"",$n);
		file_put_contents($file,$n);
    }
}



?>
