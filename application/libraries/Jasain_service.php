<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Jasain_service
 */
class Jasain_service
{
    public function __construct()
	{
        $this->config->load('jasain_service', TRUE);
        $this->load->model('m_jasain_service');
		$this->load->library('session');
    }
    /**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 * @param string $method
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->m_jasain_service, $method) )
		{
			throw new Exception('Undefined method m_jasain_service::' . $method . '() called');
		}
		return call_user_func_array( array($this->m_jasain_service, $method), $arguments);
	}
    /**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @param    string $var
	 *
	 * @return    mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
    }
}