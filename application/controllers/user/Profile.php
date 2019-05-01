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
		$this->data[ "page_title" ] = "Profile";
		$this->data[ "users" ] = $this->user_auth->user(  )->result();
		$this->render( "user/profile/V_detail" );
	}
	public function upload_photo()
	{	
		if ( ! $this->user_auth->upload_photo( 'user_image' ) )
		{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER,  $this->user_auth->errors() ) );
				redirect(site_url('user/profile'));  
		}
		else
		{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->user_auth->messages() ) );
				redirect(site_url('user/profile'));  
		}
	}
	public function edit() //edut curr profile
	{	
		$this->data[ "page_title" ] = "Edit Profile";
		$this->data[ "users" ] =  $this->user_auth->user(  )->result();
		$this->form_validation->set_rules('user_first_name',  $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('user_last_name', $this->lang->line('create_user_validation_lname_label') , 'trim|required');
		$this->form_validation->set_rules('user_phone', $this->lang->line('create_user_validation_phone_label'), 'trim|required');

		if( !empty( $this->input->post('user_password') )  )
		{
			$this->form_validation->set_rules('user_password', $this->lang->line('create_user_validation_password_label') , 'required|min_length[' . $this->config->item('min_password_length', 'user_auth') . ']|max_length[' . $this->config->item('max_password_length', 'user_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'trim|required');
			$this->form_validation->set_rules('old_password', $this->lang->line('create_user_validation_old_password_confirm_label'), 'trim|required');
		}

		if ( $this->form_validation->run() === TRUE )
		{
			$data = array(
				'user_first_name' => $this->input->post('user_first_name'),
				'user_last_name' => $this->input->post('user_last_name'),
				'user_address' => $this->input->post('user_address'),
				'user_phone' => $this->input->post('user_phone'),
			);
			if ( $this->input->post('user_password') )
			{
				$data['user_password'] = $this->input->post('user_password');
				$data['old_password'] = $this->input->post('old_password');
			}

			$user = $this->user_auth->user()->row();//curr user
			// check to see if we are updating the user
			if ( $this->user_auth->update( $user->id_user, $data) )
			{
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->user_auth->messages() ) );
				if ( $this->input->post('user_password') )
				{
					redirect(site_url('auth/logout'));  
				}
				redirect(site_url('user/profile'));  
			}
			else
			{
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->user_auth->errors() ) );
				redirect(site_url('user/profile'));  
			}
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
					'class' => 'form-control form-control-alternative',
					'value' => $this->form_validation->set_value('user_first_name', $user->user_first_name),
				);
				$this->data['user_last_name'] = array(
					'name' => 'user_last_name',
					'id' => 'user_last_name',
					'type' => 'text',
					'placeholder' => 'Nama Belakang',
					'class' => 'form-control form-control-alternative',
					'value' => $this->form_validation->set_value('user_last_name', $user->user_last_name),
				);
				// $this->data['user_email'] = array(
				// 	'name' => 'user_email',
				// 	'id' => 'user_email',
				// 	'type' => 'text',
				// 	'placeholder' => 'Email',
				// 	'class' => 'form-control',
				// 	'value' => $this->form_validation->set_value('user_email', $user->user_email),
				// );
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
					'class' => 'form-control form-control-alternative',
					'value' => $this->form_validation->set_value('user_address', $user->user_address),
				);
				$this->data['old_password'] = array(
					'name' => 'old_password',
					'id' => 'old_password',
					'type' => 'password',
					'placeholder' => 'Password lama',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('old_password'),
				);
				$this->data['user_password'] = array(
					'name' => 'user_password',
					'id' => 'user_password',
					'type' => 'password',
					'placeholder' => 'Password',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('user_password'),
				);
				
				$this->data['password_confirm'] = array(
					'name' => 'password_confirm',
					'id' => 'password_confirm',
					'type' => 'password',
					'placeholder' => 'Konfirmasi Password',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('password_confirm'),
				);
			endforeach;

			$this->render( "user/profile/V_edit" );
		}
	}
}