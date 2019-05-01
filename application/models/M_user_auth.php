<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_user_auth extends CI_Model
{	
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $tables = array();
	public $join = array();
	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 */
	protected $errors;
	protected $messages;
	/**
	 * error start delimiter
	 *
	 * @var string
	 */
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 */
	protected $error_end_delimiter;
	/**
	 * caching of users and their groups
	 *
	 * @var array
	 */
	public $_cache_user_in_group = array();

	/**
	 * caching of groups
	 *
	 * @var array
	 */
	protected $_cache_groups = array();
	/**
	 * Where
	 *
	 * @var array
	 */
	public $_ion_where = array();

	/**
	 * Select
	 *
	 * @var array
	 */
	public $_ion_select = array();

	/**
	 * Like
	 *
	 * @var array
	 */
	public $_ion_like = array();

	/**
	 * Limit
	 *
	 * @var string
	 */
	public $_ion_limit = NULL;

	/**
	 * Offset
	 *
	 * @var string
	 */
	public $_ion_offset = NULL;

	/**
	 * Order By
	 *
	 * @var string
	 */
	public $_ion_order_by = NULL;

	/**
	 * Order
	 *
	 * @var string
	 */
	public $_ion_order = NULL;
	/**
	 * Response
	 *
	 * @var string
	 */
	protected $response = NULL;
	/**
	 * Database object
	 *
	 * @var object
	 */
	protected $db;

    public function __construct()
	{
		$this->config->load('user_auth', TRUE);
		$this->lang->load('ion_auth');
		// initialize the database
		$group_name = $this->config->item('database_group_name', 'user_auth');
		if (empty($group_name))
		{
			// By default, use CI's db that should be already loaded
			$CI =& get_instance();
			$this->db = $CI->db;
		}
		else
		{
			// For specific group name, open a new specific connection
			$this->db = $this->load->database($group_name, TRUE, TRUE);
		}
		// initialize db tables data
		$this->tables = $this->config->item('tables', 'user_auth');
		// initialize data

		$this->identity_column = $this->config->item('identity', 'user_auth');

		$this->join = $this->config->item('join', 'user_auth');
		// initialize messages and error
		$this->messages    = array();
		$this->errors      = array();
		$delimiters_source = $this->config->item('delimiters_source', 'user_auth');
		// load the error delimeters either from the config file or use what's been supplied to form validation
		if ($delimiters_source === 'form_validation')
		{
			// load in delimiters from form_validation
			// to keep this simple we'll load the value using reflection since these properties are protected
			$this->load->library('form_validation');
			$form_validation_class = new ReflectionClass("CI_Form_validation");

			$error_prefix = $form_validation_class->getProperty("_error_prefix");
			$error_prefix->setAccessible(TRUE);
			$this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
			$this->message_start_delimiter = $this->error_start_delimiter;

			$error_suffix = $form_validation_class->getProperty("_error_suffix");
			$error_suffix->setAccessible(TRUE);
			$this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
			$this->message_end_delimiter = $this->error_end_delimiter;
		}
		else
		{
			// use delimiters from config
			$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'user_auth');
			$this->message_end_delimiter = $this->config->item('message_end_delimiter', 'user_auth');
			$this->error_start_delimiter = $this->config->item('error_start_delimiter', 'user_auth');
			$this->error_end_delimiter = $this->config->item('error_end_delimiter', 'user_auth');
		}
    }
    /**
	 * Verifies if the session should be rechecked according to the configuration item recheck_timer. If it does, then
	 * it will check if the user is still active
	 * @return bool
	 */
    public function recheck_session()
    {
        $recheck = (NULL !== $this->config->item('recheck_timer', 'user_auth')) ? $this->config->item('recheck_timer', 'user_auth') : 0;
        if( $recheck !== 0 )
        {

        }
        return (bool)$this->session->userdata('identity');
    }

	public function login( $identity, $password, $remember=FALSE)
	{
		// echo $identity.$password;
		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}
		$sql = "
			SELECT a.* from table_user a
			WHERE a.$this->identity_column = '$identity'
			ORDER BY a.id_user DESC 
			LIMIT 1
		";
		$query = $this->db->query( $sql );
		// echo var_dump( $sql );
		if ($query->num_rows() === 1)
		{
			$user = $query->row();
			if( md5( $password ) == $user->user_password ){
				if ($user->user_status == 0)
				{
					$this->set_error('login_unsuccessful_not_active');
					return FALSE;
				}
				$this->set_session($user);
				$this->update_last_login($user->id_user);
				// Regenerate the session (for security purpose: to avoid session fixation)
				$this->_regenerate_session();
				
				$this->set_message('login_successful');

				return TRUE;
			}
		}

		$this->set_error('login_unsuccessful');
        return false;
	}
	/**
	 * Identity check
	 *
	 * @return bool
	 * @author Mathew
	 */
	public function identity_check($identity = '')
	{
		if (empty($identity))
		{
			return FALSE;
		}

		return $this->db->where($this->identity_column, $identity)
						->limit(1)
						->count_all_results($this->tables['table_user']) > 0;
	}
	/**
	 * set_session
	 *
	 * @param object $user
	 *
	 * @return bool
	 * @author jrmadsen67
	 */
	public function set_session($user)
	{
		$session_data = array(
			'identity'             		=> $user->{$this->identity_column},
		    $this->identity_column		=> $user->{$this->identity_column},
		    'user_email'                => $user->user_email,
		    'user_username'             => $user->user_username,
		    'user_phone'                => $user->user_phone,
		    'id_user'              		=> $user->id_user, 
		    'old_last_login'       		=> $user->user_last_login,
		    'user_name'       			=> $user->user_first_name." ".$user->user_last_name  ,
		    'user_image'       			=> $user->user_image,
		);

		$this->session->set_userdata($session_data);

		return TRUE;
	}
	/**
	 * update_last_login
	 *
	 * @param int|string $id
	 *
	 * @return bool
	 * @author Ben Edmunds
	 */
	public function update_last_login($id_user)
	{
		$this->load->helper('date');
		$this->db->update($this->tables['table_user'], array('user_last_login' => time()), array('id_user' => $id_user));
		return $this->db->affected_rows() == 1;
	}
	/**
	 * Register
	 *
	 * @param    string $identity
	 * @param    string $user_password
	 * @param    string $user_email
	 * @param    string $user_phone
	 * @param    array  $additional_data
	 * @param    array  $groups
	 *
	 * @return    bool
	 * @author    Mathew
	 */
	public function register($identity, $user_password, $user_email, $user_phone, $additional_data = array(), $groups = array())
	{
		$manual_activation = $this->config->item('manual_activation', 'user_auth');
		if ($this->identity_check($identity))
		{
			$this->set_error('account_creation_duplicate_identity');
			return FALSE;
		}
		else if (!$this->config->item('default_group', 'user_auth') && empty($groups))
		{
			$this->set_error('account_creation_missing_default_group');
			return FALSE;
		}
		$query = $this->db->get_where($this->tables['table_group'], array('group_name' => $this->config->item('default_group', 'user_auth')), 1)->row();
		
		if (!isset($query->id_group) && empty($groups))
		{
			$this->set_error('account_creation_invalid_default_group');
			return FALSE;
		}
		// capture default group details
		$default_group = $query;
		// IP Address
		$ip_address = $this->_prepare_ip($this->input->ip_address());
		// hash pass
		$user_password = md5( $user_password );
		// Users table.
		$data = array(
			$this->identity_column => $identity,
			'user_username' => $identity,
			'user_password' => $user_password,
			'user_email' => $user_email,
			'user_phone' => $user_phone,
			'ip_address' => $ip_address,
			'create_date' => time(),
			'user_status' => ($manual_activation === FALSE ? 1 : 0)
		);
		
		$user_data = array_merge($this->_filter_data($this->tables['table_user'], $additional_data), $data);
		

		$this->db->insert($this->tables['table_user'], $user_data);
		$id_user = $this->db->insert_id($this->tables['table_user'] . '_id_seq');
		// echo var_dump( $id_user );
		// add in groups array if it does n't exists and stop adding into default group if default group ids are set
		if (isset($default_group->id_group) && empty($groups))
		{
			$groups[] = $default_group->id_group;
		}
		if (!empty($groups))
		{
			// add to groups
			foreach ($groups as $group)
			{
				$this->add_to_group($group, $id_user);
			}
		}
		
		return (isset($id_user)) ? $id_user : FALSE;
	}
	/**
	 * update
	 *
	 * @param int|string $id
	 * @param array      $data
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 */
	public function update($id_user, array $data)
	{

		$user = $this->user($id_user)->row();

		$this->db->trans_begin();

		if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
		{
			$this->db->trans_rollback();
			$this->set_error('account_creation_duplicate_identity');

			$this->set_error('update_unsuccessful');

			return FALSE;
		}

		// Filter the data passed
		$data = $this->_filter_data($this->tables['table_user'], $data);

		if (array_key_exists($this->identity_column, $data) || array_key_exists('user_password', $data) || array_key_exists('user_email', $data))
		{
			if (array_key_exists('user_password', $data))
			{
				if( ! empty($data['user_password']))
				{
					$data['user_password'] = md5( $data['user_password'] ); 
				}
				else
				{
					// unset password so it doesn't effect database entry if no password passed
					unset($data['user_password']);
				}
			}
		}

		$this->db->update($this->tables['table_user'], $data, array('id_user' => $user->id_user));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('update_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('update_successful');
		return TRUE;
	}
	/**
	 * delete_user
	 *
	 * @param int|string $id
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 */
	public function delete_user($id_user)
	{
		$this->db->trans_begin();

		// remove user from groups
		$this->remove_from_group(NULL, $id_user);

		// delete user from users table should be placed after remove from group
		$this->db->delete($this->tables['table_user'], array('id_user' => $id_user));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->set_error('delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('delete_successful');
		return TRUE;
	}

	/**
	 * @param string $table
	 * @param array  $data
	 *
	 * @return array
	 */
	protected function _filter_data($table, $data)
	{
		$filtered_data = array();
		$columns = $this->db->list_fields($table);

		if (is_array($data))
		{
			foreach ($columns as $column)
			{
				if (array_key_exists($column, $data))
					$filtered_data[$column] = $data[$column];
			}
		}

		return $filtered_data;
	}
	// DATABASE OPERATION
	/**
	 * @param array|string $select
	 *
	 * @return static
	 */
	public function select($select)
	{
		$this->_ion_select[] = $select;

		return $this;
	}
	/**
	 * @param array|string $where
	 * @param null|string  $value
	 *
	 * @return static
	 */
	public function where($where, $value = NULL)
	{

		if (!is_array($where))
		{
			$where = array($where => $value);
		}

		array_push($this->_ion_where, $where);

		return $this;
	}
	/**
	 * @param string      $like
	 * @param string|null $value
	 * @param string      $position
	 *
	 * @return static
	 */
	public function like($like, $value = NULL, $position = 'both')
	{

		array_push($this->_ion_like, array(
			'like'     => $like,
			'value'    => $value,
			'position' => $position
		));

		return $this;
	}
	/**
	 * @param string $by
	 * @param string $order
	 *
	 * @return static
	 */
	public function order_by($by, $order='desc')
	{
		$this->_ion_order_by = $by;
		$this->_ion_order    = $order;

		return $this;
	}
	/**
	 * @param int $limit
	 *
	 * @return static
	 */
	public function limit($limit)
	{
		$this->_ion_limit = $limit;

		return $this;
	}
	/**
	 * @param int $offset
	 *
	 * @return static
	 */
	public function offset($offset)
	{
		$this->_ion_offset = $offset;

		return $this;
	}
	/**
	 * @return object|mixed
	 */
	public function row()
	{
		$row = $this->response->row();

		return $row;
	}

	/**
	 * @return array|mixed
	 */
	public function row_array()
	{
		$row = $this->response->row_array();

		return $row;
	}

	/**
	 * @return mixed
	 */
	public function result()
	{
		$result = $this->response->result();

		return $result;
	}

	/**
	 * @return array|mixed
	 */
	public function result_array()
	{
		$result = $this->response->result_array();

		return $result;
	}
		/**
	 * @return int
	 */
	public function num_rows()
	{
		$result = $this->response->num_rows();

		return $result;
	}
	// DATABASE OPERATION
	/**
	 * get_users_groups
	 *
	 * @param int|string|bool $id
	 *
	 * @return CI_DB_result
	 * @author Ben Edmunds
	 */
	public function get_users_groups($id_user = FALSE)
	{
		// if no id was passed use the current users id
		$id_user || $id_user = $this->session->userdata('id_user');

		return $this->db->select($this->tables['table_user_group'].'.'.$this->join['table_group'].' as id_group, '.$this->tables['table_group'].'.group_name, '.$this->tables['table_group'].'.group_description')
		                ->where($this->tables['table_user_group'].'.'.$this->join['table_user'], $id_user)
		                ->join($this->tables['table_group'], $this->tables['table_user_group'].'.'.$this->join['table_group'].'='.$this->tables['table_group'].'.id_group')
		                ->get($this->tables['table_user_group']);
	}
	/**
	 * add_to_group
	 *
	 * @param array|int|float|string $group_ids
	 * @param bool|int|float|string  $user_id
	 *
	 * @return int
	 * @author Ben Edmunds
	 */
	public function add_to_group($group_ids, $id_user = FALSE)
	{
		// if no id was passed use the current users id
		$id_user || $id_user = $this->session->userdata('id_user');

		if(!is_array($group_ids))
		{
			$group_ids = array($group_ids);
		}
		$return = 0;
		// Then insert each into the database
		foreach ($group_ids as $id_group)
		{
			// Cast to float to support bigint data type
			if ($this->db->insert(
								  $this->tables['table_user_group'],
								  array(
								  	$this->join['table_group'] => (float)$id_group,
									$this->join['table_user']  => (float)$id_user
								  )
								)
			)
			{
				if (isset($this->_cache_groups[$id_group]))
				{
					$group_name = $this->_cache_groups[$id_group];
				}
				else
				{
					$group = $this->group($id_group)->result();
					$group_name = $group[0]->group_name;
					$this->_cache_groups[$id_group] = $group_name;
				}
				$this->_cache_user_in_group[$id_user][$id_group] = $group_name;

				// Return the number of groups added
				$return++;
			}
		}

		return $return;
	}
		/**
	 * remove_from_group
	 *
	 * @param array|int|float|string|bool $group_ids
	 * @param int|float|string|bool $user_id
	 *
	 * @return bool
	 * @author Ben Edmunds
	 */
	public function remove_from_group($group_ids = FALSE, $id_user = FALSE)
	{
		// user id is required
		if (empty($id_user))
		{
			return FALSE;
		}

		// if group id(s) are passed remove user from the group(s)
		if (!empty($group_ids))
		{
			if (!is_array($group_ids))
			{
				$group_ids = array($group_ids);
			}
			foreach ($group_ids as $group_id)
			{
				// Cast to float to support bigint data type
				$this->db->delete(
					$this->tables['table_user_group'],
					array($this->join['table_group'] => (float)$group_id, $this->join['table_user'] => (float)$id_user)
				);
				if (isset($this->_cache_user_in_group[$id_user]) && isset($this->_cache_user_in_group[$id_user][$group_id]))
				{
					unset($this->_cache_user_in_group[$id_user][$group_id]);
				}
			}
			$return = TRUE;
		}
		// otherwise remove user from all groups
		else
		{
			// Cast to float to support bigint data type
			if ($return = $this->db->delete($this->tables['table_user_group'], array($this->join['table_user'] => (float)$id_user)))
			{
				$this->_cache_user_in_group[$id_user] = array();
			}
		}
		return $return;
	}
	/**
	 * group
	 *
	 * @param int|string|null $id
	 *
	 * @return static
	 * @author Ben Edmunds
	 */
	public function group($id_group = NULL)
	{

		if (isset($id_group))
		{
			$this->where($this->tables['table_group'].'.id_group', $id_group);
		}

		$this->limit(1);
		$this->order_by('id_group', 'desc');

		return $this->groups();
	}
	/**
	 * groups
	 *
	 * @return static
	 * @author Ben Edmunds
	 */
	public function groups()
	{
		// run each where that was passed
		if (isset($this->_ion_where) && !empty($this->_ion_where))
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}
			$this->_ion_where = array();
		}

		if (isset($this->_ion_limit) && isset($this->_ion_offset))
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);

			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);

			$this->_ion_limit  = NULL;
		}

		// set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);
		}
		$this->response = $this->db->get($this->tables['table_group']);
		return $this;
	}
	/**
	 * user
	 *
	 * @param int|string|null $id
	 *
	 * @return static
	 * @author Ben Edmunds
	 */
	public function user($id_user = NULL)
	{
		// if no id was passed use the current users id
		$id_user = isset($id_user) ? $id_user : $this->session->userdata('id_user');

		$this->limit(1);
		$this->order_by($this->tables['table_user'].'.id_user', 'desc');
		$this->where($this->tables['table_user'].'.id_user', $id_user);

		$this->users();

		return $this;
	}
	/**
	 * users
	 *
	 * @param array|null $groups
	 *
	 * @return static
	 * @author Ben Edmunds
	 */
	public function users($groups = NULL)
	{
		if (isset($this->_ion_select) && !empty($this->_ion_select))
		{
			foreach ($this->_ion_select as $select)
			{
				$this->db->select($select);
			}

			$this->_ion_select = array();
		}
		else
		{
			// default selects
			$this->db->select(array(
			    $this->tables['table_user'].'.*',
			    $this->tables['table_user'].'.id_user as id_user',
			    $this->tables['table_user'].'.id_user as id_user'
			));
		}

		// filter by group id(s) if passed
		if (isset($groups))
		{
			// build an array if only one group was passed
			if (!is_array($groups))
			{
				$groups = Array($groups);
			}

			// join and then run a where_in against the group ids
			if (isset($groups) && !empty($groups))
			{
				$this->db->distinct();
				$this->db->join(
				    $this->tables['table_user_group'],
				    $this->tables['table_user_group'].'.'.$this->join['table_user'].'='.$this->tables['table_user'].'.id_user',
				    'inner'
				);
			}

			// verify if group name or group id was used and create and put elements in different arrays
			$group_ids = array();
			$group_names = array();
			foreach($groups as $group)
			{
				if(is_numeric($group)) $group_ids[] = $group;
				else $group_names[] = $group;
			}
			$or_where_in = (!empty($group_ids) && !empty($group_names)) ? 'or_where_in' : 'where_in';
			// if group name was used we do one more join with groups
			if( !empty($group_names) )
			{
				$this->db->join($this->tables['table_group'], $this->tables['table_user_group'] . '.' . $this->join['table_group'] . ' = ' . $this->tables['table_group'] . '.id_group', 'inner');
				$this->db->where_in($this->tables['table_group'] . '.group_name', $group_names);
			}
			if( !empty($group_ids) )
			{
				$this->db->{$or_where_in}($this->tables['table_user_group'].'.'.$this->join['table_group'], $group_ids);
			}
		}

		// run each where that was passed
		if ( isset($this->_ion_where) && ! empty($this->_ion_where) )
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}

			$this->_ion_where = array();
		}

		if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}

			$this->_ion_like = array();
		}

		if( isset( $this->_ion_limit ) && isset( $this->_ion_offset ) )
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);
			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);
			$this->_ion_limit  = NULL;
		}
		// set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);

			$this->_ion_order    = NULL;
			$this->_ion_order_by = NULL;
		}
		$this->response = $this->db->get($this->tables['table_user']);
		return $this;
	}
	
	/**
	 * @deprecated Now just returns the given string for backwards compatibility reasons
	 * @param string $ip_address The IP address
	 *
	 * @return string The given IP address
	 */
	protected function _prepare_ip($ip_address) {
		return $ip_address;
	}
		/**
	 * set_message_delimiters
	 *
	 * Set the message delimiters
	 *
	 * @param string $start_delimiter
	 * @param string $end_delimiter
	 *
	 * @return true
	 * @author Ben Edmunds
	 */
	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_error_delimiters
	 *
	 * Set the error delimiters
	 *
	 * @param string $start_delimiter
	 * @param string $end_delimiter
	 *
	 * @return true
	 * @author Ben Edmunds
	 */
	public function set_error_delimiters($start_delimiter, $end_delimiter)
	{
		$this->error_start_delimiter = $start_delimiter;
		$this->error_end_delimiter   = $end_delimiter;

		return TRUE;
	}
	
	/**
	 * set_error
	 *
	 * Set an error message
	 *
	 * @param string $error The error to set
	 *
	 * @return string The given error
	 * @author Ben Edmunds
	 */
	public function set_error($error)
	{
		$this->errors[] = $error;
		return $error;
	}
	/**
	 * errors
	 *
	 * Get the error message
	 *
	 * @return string
	 * @author Ben Edmunds
	 */
	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
			$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
			$_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
		}
		return $_output;
	}
	/**
	 * clear_errors
	 *
	 * Clear Errors
	 *
	 * @return true
	 * @author Ben Edmunds
	 */
	public function clear_errors()
	{
		$this->errors = array();

		return TRUE;
	}
	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @param string $message The message
	 *
	 * @return string The given message
	 * @author Ben Edmunds
	 */
	public function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	/**
	 * messages
	 *
	 * Get the messages
	 *
	 * @return string
	 * @author Ben Edmunds
	 */
	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
		}

		return $_output;
	}
	/**
	 * clear_messages
	 *
	 * @return true
	 * @author Ben Edmunds
	 */
	public function clear_messages()
	{
		$this->messages = array();

		return TRUE;
	}


	/**
	 * Regenerate the session without losing any data
	 *
	 */
	protected function _regenerate_session() {

		if (substr(CI_VERSION, 0, 1) == '2')
		{
			// Save sess_time_to_update and set it temporarily to 0
			// This is done in order to forces the sess_update method to regenerate
			$old_sess_time_to_update = $this->session->sess_time_to_update;
			$this->session->sess_time_to_update = 0;

			// Call the sess_update method to actually regenerate the session ID
			$this->session->sess_update();

			// Restore sess_time_to_update
			$this->session->sess_time_to_update = $old_sess_time_to_update;
		}
		else
		{
			$this->session->sess_regenerate(FALSE);
		}
	}
	
}