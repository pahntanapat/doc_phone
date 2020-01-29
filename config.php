<?php
# config file

class config{
	const ROOT_USER = 'root';
	const ROOT_PW = '789';
}

function SQL(){
	$db='doc_phone';
	$user='root';
	$pw='053721872';
	return new PDO('mysql:host=localhost;dbname='.$db,$user,$pw);
}

function redir($page = 'login.php'){
	header('location: '.$page);
	exit();
}



?>