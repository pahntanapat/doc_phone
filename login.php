<?php
require_once('class.session.php');

$act = isset($_REQUEST['act'])? $_REQUEST['act']: NULL;

if($act=='logout'){
	Session::logout();
}else{
	Session::check(Session::ROLE_LOGIN_PAGE);
}

if($act=='login'){
	require_once('config.php');
	require_once('class.user.php');
	require_once('class.ajax.php');
	$user = new User(SQL());
	if($user->login($_POST['user'], $_POST['pw'])){
		Ajax::redir();
	}elseif(Ajax::isAjax()){
		Ajax::msg('Wrong Username or Password');
	}else{
		$act='Wrong Username or Password';
	}
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
</head>

<body>
<h1>Log in</h1>
<form action="login.php" method="POST" enctype="application/x-www-form-urlencoded" name="login" id="login" title="log in">
  <label for="user">Username:</label>
  <input type="text" name="user" id="user">
  <br>
  <label for="pw">Password:</label>
  <input type="password" name="pw" id="pw">
  <br>
  <button type="submit">Log in</button>
  <input name="act" type="hidden" id="act" value="login">
</form>
<?php if($act!=NULL){ ?><p><?php echo($act);?></p><?php } var_dump($_SESSION); ?>
</body>
</html>