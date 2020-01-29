<?php
class Base {
	protected $sql;
	public
	function __construct( $sqlConn ) {
		$this->sql = $sqlConn;
	}
}



?>