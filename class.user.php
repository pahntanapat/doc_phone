<?php
require_once( 'class.base.php' );
class User extends Base {
	const TABLE = 'log_in';
	const COL_USER = 'user';
	const COL_PW = 'pw';
	const COL_TITLE = 'title';
	const COL_NAME = 'name';
	const COL_LNAME = 'lastname';
	const COL_ID = 'id';
	const COL_CITZ_ID = 'citizen_id';
	const COL_ROLE = 'role';

	public function login( $user, $pw ) {
		require_once( 'config.php' );
		# exit( config::ROOT_USER && config::ROOT_PW && $user == config::ROOT_USER && $pw == config::ROOT_PW );
		if ( config::ROOT_USER && config::ROOT_PW && $user == config::ROOT_USER && $pw == config::ROOT_PW ) {
			require_once( 'class.session.php' );
			return ( Session::login( 0, $user, '', 'Root user', '', Session::ROLE_EDIT_DOC|Session::ROLE_EDIT_SCHED|Session::ROLE_EDIT_USER|Session::ROLE_EDIT_TASK_LIST ) );
		}
		

		$s = $this->sql->prepare( 'SELECT * FROM ' . ( self::TABLE ) . ' WHERE ' . ( self::COL_USER ) . '=:u AND ' . ( self::COL_PW ) . '=:p LIMIT 1' );
		$s->bindParam( ':u', $user );
		$s->bindParam( ':p', $pw );
		$s->execute();
		$r = $s->fetch();

		if ( $r ) {
			require_once( 'class.session.php' );

			return ( Session::login( $r[ self::COL_ID ], $r[ self::COL_USER ], $r[ self::COL_TITLE ], $r[ self::COL_NAME ], $r[ self::COL_LNAME ], $r[self::COL_ROLE] ) );
		} else {
			return ( false );
		}
	}
}



?>