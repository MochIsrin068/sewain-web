<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		echo var_dump( $this->jasain_service->portofolios( 15 ) );
	}
}