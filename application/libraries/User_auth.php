<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_auth
 */
class User_auth
{
	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group;

    public function __construct()
	{
        $this->config->load('user_auth', TRUE);
        $this->load->model('m_user_auth');
		$this->load->library('session');
		$this->load->helper(array('cookie', 'language','url'));
		
		// pointer
		$this->_cache_user_in_group =& $this->m_user_auth->_cache_user_in_group;
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
		if (!method_exists( $this->m_user_auth, $method) )
		{
			throw new Exception('Undefined method User_auth::' . $method . '() called');
		}
		if($method == 'create_user')
		{
			return call_user_func_array(array($this, 'register'), $arguments);
		}
		if($method=='update_user')
		{
			return call_user_func_array(array($this, 'update'), $arguments);
		}

		return call_user_func_array( array($this->m_user_auth, $method), $arguments);
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
    /**
	 * Auto logs-in the user if they are remembered
	 * @return bool Whether the user is logged in
	 * @author Mathew
	 **/
	public function logged_in()
	{
		$recheck = $this->m_user_auth->recheck_session();
		return $recheck;
	}
	/**
	 * register
	 *
	 * @param string $identity
	 * @param string $user_password
	 * @param string $user_email
	 * @param string $user_phone
	 * @param array  $additional_data
	 * @param array  $group_ids
	 *
	 * @return int|array|bool The new user's ID if e-mail activation is disabled or Ion-Auth e-mail activation was
	 *                        completed; or an array of activation details if CI e-mail validation is enabled; or FALSE
	 *                        if the operation failed.
	 * @author Mathew
	 */
	public function register($identity, $user_password, $user_email, $user_phone, $additional_data = array(), $group_ids = array())
	{
		$email_activation = $this->config->item('email_activation', 'ion_auth');
		$id = $this->m_user_auth->register($identity, $user_password, $user_email, $user_phone, $additional_data, $group_ids );
		if (!$email_activation)
		{
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}
		}else{
			// TODO : prosedur aktivasi Email
		}
	}
	/**
	 * @param int|string|bool $id
	 *
	 * @return bool Whether the user is an administrator
	 * @author Ben Edmunds
	 */
	public function is_admin($id_user = FALSE)
	{

		$admin_group = $this->config->item('admin_group', 'user_auth');

		return $this->in_group($admin_group, $id_user);
	}
	/**
	 * @param int|string|array $check_group group(s) to check
	 * @param int|string|bool  $id          user id
	 * @param bool             $check_all   check if all groups is present, or any of the groups
	 *
	 * @return bool Whether the/all user(s) with the given ID(s) is/are in the given group
	 * @author Phil Sturgeon
	 **/
	public function in_group($check_group, $id_user = FALSE, $check_all = FALSE)
	{
		$id_user || $id_user = $this->session->userdata('id_user');

		if (!is_array($check_group))
		{
			$check_group = array($check_group);
		}

		if (isset($this->_cache_user_in_group[$id_user]))
		{
			$groups_array = $this->_cache_user_in_group[$id_user];
		}
		else
		{
			$users_groups = $this->m_user_auth->get_users_groups($id_user)->result();
			$groups_array = array();
			foreach ($users_groups as $group)
			{
				$groups_array[$group->id_group] = $group->group_name;
			}
			$this->_cache_user_in_group[$id_user] = $groups_array;
			// echo  "id_user ".$id_user."<br>" ;
			// echo var_dump( $this->_cache_user_in_group )."<br>";
		}
		foreach ($check_group as $key => $value)
		{
			$groups = (is_numeric($value)) ? array_keys($groups_array) : $groups_array;
			// echo var_dump( $groups );
			/**
			 * if !all (default), in_array
			 * if all, !in_array
			 */
			if (in_array($value, $groups) xor $check_all)
			{
				/**
				 * if !all (default), true
				 * if all, false
				 */
				return !$check_all;
			}
		}

		/**
		 * if !all (default), false
		 * if all, true
		 */
		return $check_all;
	}
	/**
	 * upload_photo
	 *
	 * @return true
	 * @author alanHetfielD
	 **/
	public function update( $id_user, $data) 
	{
		if (array_key_exists('user_password', $data))
		{
			$user = $this->user($id_user)->row();
			if( $user->user_password != md5( $data["old_password"] ) )
			{
				$this->set_error('old_password_incorrect');
				$this->set_error('update_unsuccessful');
				return FALSE;
			}
		}
		return $this->m_user_auth->update( $id_user, $data) ;
	}
	/**
	 * upload_photo
	 *
	 * @return true
	 * @author alanHetfielD
	 **/
	public function upload_photo( $file )
	{
		$user = $this->user_auth->user()->row();//curr user
		$upload = $this->config->item('upload', 'user_auth');

		$config                         = $upload;
		$config['file_name'] 			=  $config['file_name'].$user->id_user."_".time();

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload( $file ) )
		{
			$this->set_error( $this->upload->display_errors() );
			$this->set_error( 'upload_unsuccessful' );
			return FALSE;
		}
		else
		{
			$file_data = $this->upload->data();
			$data['user_image'] = $file_data['file_name'];

			// check to see if we are updating the user
			if ( $this->m_user_auth->update( $user->id_user, $data) )
			{
				$this->set_message('upload_successful');
				@unlink( $config['upload_path'].$user->user_image );
				$this->session->set_userdata(array( 'user_image'=> $data['user_image'] ) ) ;
				return TRUE;
			}
		}
		$this->set_error( 'upload_unsuccessful' );
		return FALSE;
	}
	/**
	 * Logout
	 *
	 * @return true
	 * @author Mathew
	 **/
	public function logout()
	{
		// Destroy the session
		$this->session->sess_destroy();

		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		else
		{
			session_start();
			$this->session->sess_regenerate(TRUE);
		}

		$this->set_message('logout_successful');
		return TRUE;
	}
}