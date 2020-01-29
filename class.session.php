<?php
class Session {
	const ROLE_VIEW = 0;
	const ROLE_EDIT_SCHED = 1;
	const ROLE_EDIT_DOC = 2;
	const ROLE_EDIT_TASK_LIST = 4;
	const ROLE_EDIT_USER = 8;
	const ROLE_LOGIN_PAGE = -1;
	
	
	public static
	function start() {
		if(session_id()=='')
			if ( !session_start() )
				throw new ErrorException( 'Unable to Start session! Please Contact Admin' );
	}
	public static
	function login( $id, $user, $title, $name, $lname, $role = self::ROLE_VIEW ) {
		self::start();

		$_SESSION[ 'sid' ] = session_id();
		$_SESSION[ 'id' ] = $id;
		$_SESSION[ 'user' ] = $user;
		$_SESSION[ 'title' ] = $title;
		$_SESSION[ 'name' ] = $name;
		$_SESSION[ 'lastname' ] = $lname;
		$_SESSION['role'] = $role;
		return true;
	}
	public static
	function logout() {
		self::start();
		session_unset();
		if ( session_destroy() )
			return ( true );
		else
			throw new ErrorException( 'Unable to Log out! Fail to Destroy Session, please contact admin.' );
	}
	public static function getName() {
		self::start();
		return ( $_SESSION[ 'title' ] . $_SESSION[ 'name' ] . ' ' . $_SESSION[ 'lastname' ] );
	}
	public static function check($role = self::ROLE_VIEW, $redirect = true) {
		self::start();
		$login = ($role==self::ROLE_LOGIN_PAGE);
		if(isset($_SESSION[ 'sid' ]) && ($_SESSION[ 'sid' ] == session_id()) && isset($_SESSION[ 'id' ])){
			if((($role==self::ROLE_VIEW) || (($_SESSION['role'] & $role)==$role)) && (!$login))
				return(true);
			elseif($redirect){
				require_once('class.ajax.php');
				Ajax::redir('./');
			}
		}elseif($login)
			return(true);
		
		if($redirect){
			require_once('class.ajax.php');
			Ajax::redir('login.php');
		}
		return(false);		
	}
}


?>