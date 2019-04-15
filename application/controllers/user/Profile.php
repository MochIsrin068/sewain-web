<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends User_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library( array( 'form_validation' ) ); 
		$this->load->helper('form');
		$this->config->load('user_auth', TRUE);
		$this->load->helper(array('url', 'language'));
		$this->lang->load('auth');
			
	}
	public function index()
	{	
		$this->data[ "page_name" ] = "Profile";
		$this->data[ "users" ] = $this->user_auth->user(  )->result();
		$this->render( "user/profile/V_detail" );
	}
	public function edit()
	{	

		$this->data[ "page_name" ] = "Edit Profile";
		$this->data[ "users" ] =  $this->user_auth->user(  )->result();
		if ( $this->form_validation->run() === TRUE )
		{

		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->user_auth->errors() ? $this->user_auth->errors() : $this->session->flashdata('message')));
			if(  !empty( validation_errors() ) || $this->user_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
			
			foreach( $this->data[ "users" ] as $user ):
				$this->data['user_first_name'] = array(
					'name' => 'user_first_name',
					'id' => 'user_first_name',
					'type' => 'text',
					'placeholder' => 'Nama Depan',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_first_name', $user->user_first_name),
				);
				$this->data['user_last_name'] = array(
					'name' => 'user_last_name',
					'id' => 'user_last_name',
					'type' => 'text',
					'placeholder' => 'Nama Belakang',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_last_name', $user->user_last_name),
				);
				$this->data['user_email'] = array(
					'name' => 'user_email',
					'id' => 'user_email',
					'type' => 'text',
					'placeholder' => 'Email',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_email', $user->user_email),
				);
				$this->data['user_phone'] = array(
					'name' => 'user_phone',
					'id' => 'user_phone',
					'type' => 'text',
					'placeholder' => 'Nomor HP',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_phone', $user->user_phone),
				);
				$this->data['user_address'] = array(
					'name' => 'user_address',
					'id' => 'user_address',
					'type' => 'text',
					'placeholder' => 'Alamat',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_address', $user->user_address),
				);
			endforeach;

			$this->render( "user/profile/V_edit" );
		}
	}
}