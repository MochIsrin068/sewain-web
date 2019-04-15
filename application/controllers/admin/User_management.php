<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends Admin_Controller {
	public function __construct(){
		parent::__construct();

		
	} 
	public function index( $id_user = NULL )
	{
		$this->data[ "page_name" ] = "User Management";
		
		if( !$id_user == NULL )
		{
			$this->data[ "users" ] = $this->user_auth->user( $id_user )->result();
			$this->render( "admin/user_management/V_detail" );
		} 
		else
		{
			$this->data[ "users" ] = $this->user_auth->users()->result();
			$this->render( "admin/user_management/V_list" );
		}
	}
}
