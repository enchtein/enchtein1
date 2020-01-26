<?php
session_start ();
function redirect ($url='/index.php', $s){
    header("Location: $url.$s");
	exit();
}
//echo "ghbdtn";
//echo $_GET['new_param'];
$new = $_GET['new_param']+5;
$s= "?new_data=$new";
//echo "<br />".$s; die;
redirect($url='/index.php', $s);
?>