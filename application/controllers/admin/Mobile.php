<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('m_mobile');
		$this->config->load('sewain', TRUE);
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Mobile Setting";
		$this->data[ "mobile_settings" ] = $this->m_mobile->mobile_settings()->result();
		$this->render( "admin/mobile/V_list" );
	}
	public function edit()
    {
		if( !($_POST) )	redirect(site_url('admin/mobile'));  

        $this->load->library( array( 'form_validation' ) ); 

		$this->form_validation->set_rules('version',  $this->lang->line('mobile_version'), 'trim|required');
		$this->form_validation->set_rules('message_code',  $this->lang->line('mobile_message_code'), 'trim|required');
		$this->form_validation->set_rules('message',  $this->lang->line('mobile_message'), 'trim|required');
		if ( $this->form_validation->run() === TRUE )
		{
			$data['version'] 	= $this->input->post('version');
			$data['message_code'] 			= $this->input->post('message_code');
			$data['message'] 			= $this->input->post('message');

			$data_param['id'] 			= $this->input->post('id');
			
			
			if($this->m_mobile->update( $data, $data_param  ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->m_mobile->messages() ) );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->m_mobile->errors() ) );
			}
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_mobile->errors() ? $this->m_mobile->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect(site_url('admin/mobile'));  
	}
}