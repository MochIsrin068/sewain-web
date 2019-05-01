<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 */
	protected $errors;
    protected $messages;
    /**
	 * delimiters
	 *
	 * @var string
	 */
    protected $message_start_delimiter;
    protected $message_end_delimiter;
    protected $error_start_delimiter;
    protected $error_end_delimiter;
    /**
	 * select
	 *
	 * @var array
	 */
    public $_ion_select = array();
     /**
	 * where
	 *
	 * @var array
	 */
    public $_ion_where = array();
    	/**
	 * Like
	 *
	 * @var array
	 */
    public $_ion_like = array();
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
		// By default, use CI's db that should be already loaded
		$CI =& get_instance();
		$this->db = $CI->db;
		$this->config->load('my_model', TRUE);

		$this->messages    = array();
		$this->errors      = array();

		$delimiters_source = $this->config->item('delimiters_source', 'my_model');
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
	// DATABASE BASIC QUERY OPERATIONS
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
    
    // DATABASE BASIC OPERATIONS
	///////////////////********************************************* *////////////////////********************************************* */
	
    // HANDLING MESSAGE AND ERROR
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
			// $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= $this->message_start_delimiter . $message . $this->message_end_delimiter;
		}

		return $_output;
	}

	/**
	 * messages as array
	 *
	 * Get the messages as an array
	 *
	 * @param bool $langify
	 *
	 * @return array
	 * @author Raul Baldner Junior
	 */
	public function messages_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->messages as $message)
			{
				// $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
				$_output[] = $this->message_start_delimiter . $message . $this->message_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->messages;
		}
	}

	/**
	 * clear_messages
	 *
	 * Clear messages
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
			// $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
			$_output .= $this->error_start_delimiter . $error . $this->error_end_delimiter;
		}

		return $_output;
	}

	/**
	 * errors as array
	 *
	 * Get the error messages as an array
	 *
	 * @param bool $langify
	 *
	 * @return array
	 * @author Raul Baldner Junior
	 */
	public function errors_array($langify = TRUE)
	{
		if ($langify)
		{
			$_output = array();
			foreach ($this->errors as $error)
			{
				// $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
				$_output[] = $this->error_start_delimiter . $error . $this->error_end_delimiter;
			}
			return $_output;
		}
		else
		{
			return $this->errors;
		}
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
}

