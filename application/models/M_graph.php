<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_graph extends MY_Model
{
	
	public $tables = array();
    public $join = array();
    public function __construct()
	{
		parent::__construct();
		$this->config->load('graph', TRUE);
        $this->tables = $this->config->item('tables', 'graph');
	}
	/**
	 * update
	 *
	 * @param array  $data
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function update( $data, $data_param  )
    {
		$this->db->trans_begin();
		$data = $this->_filter_data($this->tables['graph'], $data);
		$this->db->update($this->tables['graph'], $data, $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}

		$this->db->trans_commit();
		return TRUE;
	}
    /**
	 * graph
	 *
	 * @param int|array|null $id
	 * @return static
	 * @author madukubah
	 */
	public function graph( $id = NULL  )
    {
		if (isset($id))
		{
			$this->where($this->tables['graph'].'.id', $id);
        }

		$this->limit(1);
		$this->order_by($this->tables['graph'].'.id', 'desc');
		
		$this->graphs();
		return $this;
	}
	/**
	 * graphs
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function graphs( $scope = NULL )
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
			    $this->tables['graph'].'.*'
			));
		}
		//scope
        if (isset($scope) )
		{
            if (!is_array($scope) )
			{
				$scope = Array($scope);
            }
            if (isset($scope) && !empty($scope))
			{
                if( !empty($scope) )
                {
                    $this->db->where_in( $this->tables['graph'].'.scope' , $scope);
                }
            }
        }
        //scope
        // run each where that was passed
		if ( isset($this->_ion_where) && ! empty($this->_ion_where) )
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}
			$this->_ion_where = array();
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
        
        $this->response = $this->db->get($this->tables['graph']);
		return $this;
    }
	
	// MASSAGES AND ERROR
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
		$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
		parent::set_message( $messageLang );
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
	public function set_error( $error )
	{
		$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
		parent::set_error( $errorLang );
	}
}