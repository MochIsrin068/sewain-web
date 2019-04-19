<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_jasain_service extends CI_Model
{
    /**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $tables = array();
    public $join = array();
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

        $this->config->load('jasain_service', TRUE);
        $this->tables = $this->config->item('tables', 'jasain_service');
        $this->join = $this->config->item('join', 'jasain_service');
    }
    /**
	 * service
	 *
	 * @param int|string|null $id_user
	 *
	 * @return static
	 * @author madukubah
	 */
	public function service($id_user = NULL)
	{
		// if no id was passed use the current users id
		$id_user = isset($id_user) ? $id_user : $this->session->userdata('id_user');

		$this->limit(1);
		$this->order_by($this->tables['table_service'].'.id_user', 'desc');
		$this->where($this->tables['table_service'].'.id_user', $id_user);

		$this->services();

		return $this;
	}
    /**
	 * services
	 *
	 * @param array|null $categories
	 *
	 * @return static
	 * @author madukubah
	 */
    public function services( $categories = NULL )
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
			    $this->tables['table_service'].'.*'
			));
		}
        //id_categories
            // TODO : jikan ada categories maka lakukan filter untuk categories 
        //id_categories
        // run each where that was passed
		if ( isset($this->_ion_where) && ! empty($this->_ion_where) )
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}

			$this->_ion_where = array();
		}
        // set like
        if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}

			$this->_ion_like = array();
		}
        //set limit / offset
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
        $this->response = $this->db->get($this->tables['table_service']);
		return $this;
    }
    /**
	 * portofolio
	 *
	 * @param int|null $id_portofolio = id_portofolio
	 *
	 * @return static
	 * @author madukubah
	 */
    public function portofolio( $id_portofolio = NULL )
    {
        if (isset($id_portofolio))
		{
			$this->where($this->tables['table_portofolio'].'.id_portofolio', $id_portofolio);
        }
        $this->limit(1);
		$this->order_by('id_portofolio', 'desc');

		return $this->portofolios();
    }
    /**
	 * portofolios
	 *
	 * @param array|null $users = id_user
	 * @param array|null $users = id_user
	 *
	 * @return static
	 * @author madukubah
	 */
    public function portofolios( $id_services = NULL , $users = NULL )
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
			    $this->tables['table_portofolio'].'.*'
			));
		}
        //user
        if (isset($users) )
		{
            // build an array if only one group was passed
			if (!is_array($users))
			{
				$users = Array($users);
            }
            // join and then run a where_in against the group ids
			if (isset($users) && !empty($users))
			{
				$this->db->distinct();
				$this->db->join(
				    $this->tables['table_service'],
				    $this->tables['table_service'].'.'.$this->join['table_service'].'='.$this->tables['table_portofolio'].'.id_service',
				    'inner'
                );
                $this->db->join(
				    $this->tables['table_user'],
				    $this->tables['table_user'].'.'.$this->join['table_user'].'='.$this->tables['table_service'].'.id_user',
				    'inner'
                );
                
                $id_users = array();
                foreach($users as $user)
                {
                    $id_users[] = $user;
                }
                if( !empty($id_users) )
                {
                    $this->db->where_in($this->tables['table_user'].'.'.$this->join['table_user'], $id_users);
                }
			}
        }
        //user
        // run each where that was passed
		if ( isset($this->_ion_where) && ! empty($this->_ion_where) )
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}

			$this->_ion_where = array();
		}
        // set like
        if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->or_like($like['like'], $like['value'], $like['position']);
			}

			$this->_ion_like = array();
		}
        //set limit / offset
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
        $this->response = $this->db->get($this->tables['table_portofolio']);
		return $this;
    }







    // DATABASE BASIC OPERATIONS
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
}