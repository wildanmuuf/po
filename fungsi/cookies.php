<?php
function DelCookie($field, $time){
	unset($_COOKIE[$field]);
	setcookie($field,'', $time,'/');
}

function SetCookies($field, $value, $time){
  setcookie($field, $value, $time, '/');
}


?>
