<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Public_Controller
{
        function __construct()
        {
                parent::__construct();
                $this->load->library( array( 'form_validation' ) ); 
                $this->load->helper('form');
                $this->config->load('user_auth', TRUE);
                $this->load->helper(array('url', 'language'));
                $this->lang->load('auth');
        }

        public function login() 
        {
                $this->form_validation->set_rules('identity', 'identity', 'required');
                $this->form_validation->set_rules('user_password','user_password','trim|required');
                if ($this->form_validation->run() == true) 
                {
                        if ($this->user_auth->login($this->input->post('identity'), $this->input->post('user_password') ))
                        {
                                //if the login is successful
                                //redirect them back to the home page
                                $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->user_auth->messages() ) );

                                if( $this->user_auth->is_admin()) redirect(site_url('/admin'));

                                redirect( site_url('/user') , 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                        else
                        {
                                // if the login was un-successful
                                // redirect them back to the login page
                                $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->user_auth->errors() ) );
                                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                }else{
                        
                        $this->render( "V_login_page" );
                }
        }
    
        public function register() 
        {
                $tables = $this->config->item('tables', 'user_auth');
		$identity_column = $this->config->item('identity', 'user_auth');
                $this->data['identity_column'] = $identity_column;

                $this->form_validation->set_rules('user_first_name',  $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('user_last_name', $this->lang->line('create_user_validation_lname_label') , 'trim|required');
                if ($identity_column !== 'user_email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['table_user'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('user_email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['table_user'] . '.user_email]');
		}
                $this->form_validation->set_rules('user_phone', $this->lang->line('create_user_validation_phone_label'), 'trim|required');
		$this->form_validation->set_rules('user_address', $this->lang->line('create_user_validation_address_label'), 'trim|required');
		
		$this->form_validation->set_rules('user_password', $this->lang->line('create_user_validation_password_label') , 'required|min_length[' . $this->config->item('min_password_length', 'user_auth') . ']|max_length[' . $this->config->item('max_password_length', 'user_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'trim|required');

                if ( $this->form_validation->run() === TRUE )
		{
			$user_email = strtolower($this->input->post('user_email'));
			$user_phone = strtolower($this->input->post('user_phone'));
                        $identity = ($identity_column === 'user_email') ? $user_email : $this->input->post('identity');
			$user_password = $this->input->post('user_password');

			$additional_data = array(
				'user_first_name' => $this->input->post('user_first_name'),
				'user_last_name' => $this->input->post('user_last_name'),
				'user_address' => $this->input->post('user_address'),
			);
		}
                if ($this->form_validation->run() === TRUE && $this->user_auth->register($identity, $user_password, $user_email, $user_phone , $additional_data) )
		{
			
			// check to see if we are creating the user
			// redirect them back to the admin page
                        $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->user_auth->messages() ) );
			redirect("auth/login", 'refresh');
		}
                else
                {
                        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->user_auth->errors() ? $this->user_auth->errors() : $this->session->flashdata('message')));
                        if(  !empty( validation_errors() ) || $this->user_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
                        
                        $this->data['user_first_name'] = array(
				'name' => 'user_first_name',
				'id' => 'user_first_name',
                                'type' => 'text',
                                'placeholder' => 'Nama Depan',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_first_name', 'alan'),
			);
			$this->data['user_last_name'] = array(
				'name' => 'user_last_name',
				'id' => 'user_last_name',
                                'type' => 'text',
                                'placeholder' => 'Nama Belakang',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_last_name', "hetfield"),
			);
			$this->data['user_email'] = array(
				'name' => 'user_email',
				'id' => 'user_email',
                                'type' => 'text',
                                'placeholder' => 'Email',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_email', "admin@admin.com"),
			);
			$this->data['user_phone'] = array(
				'name' => 'user_phone',
				'id' => 'user_phone',
                                'type' => 'text',
                                'placeholder' => 'Nomor HP',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_phone', "1234"),
			);
			$this->data['user_address'] = array(
				'name' => 'user_address',
				'id' => 'user_address',
                                'type' => 'text',
                                'placeholder' => 'Alamat',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_address', "jalanan"),
			);
			$this->data['user_password'] = array(
				'name' => 'user_password',
				'id' => 'user_password',
                                'type' => 'password',
                                'placeholder' => 'Password',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('user_password', "admin"),
			);
			
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
                                'type' => 'password',
                                'placeholder' => 'Konfirmasi Password',
                                'class' => 'form-control',
				'value' => $this->form_validation->set_value('password_confirm', "admin"),
			);
                        $this->render( "V_register_page" );
                }
        }

        public function logout()
        {
                $this->data['title'] = "Logout";

                // log the user out
                $logout = $this->user_auth->logout();

                // redirect them to the login page
                $this->session->set_flashdata('message', $this->user_auth->messages());
                redirect(site_url(), 'refresh');
        }
}