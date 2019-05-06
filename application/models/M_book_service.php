<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_book_service extends MY_Model
{
    /**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $tables = array();
    public $join = array();
    public function __construct()
	{
		parent::__construct();
		$this->config->load('book_service', TRUE);
		$this->lang->load('sewain');
		$this->tables = $this->config->item('tables', 'book_service');
		$this->join = $this->config->item('join', 'book_service');
	}
	/**
	 * create
	 *
	 * @param array  $data
	 * @param array  $genre_ids
	 * @return static
	 * @author madukubah
	 */
	public function create( $data,  $genre_ids )
    {
		// Filter the data passed
        $data["create_date"] = time();
        $data = $this->_filter_data($this->tables['book'], $data);

        $this->db->insert($this->tables['book'], $data);
        $id = $this->db->insert_id($this->tables['book'] . '_id_seq');
		
		if( isset($id) )
		{
			$this->set_message('book_creation_successful');
			$this->add_genres( $id, $genre_ids  );
			return $id;
		}
		$this->set_error('book_creation_unsuccessful');
        return FALSE;
	}
	/**
	 * add_genres
	 *
	 * @param array  $data
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function add_genres( $book_id, $genre_ids  )
    {
		$return = 0;
		foreach( $genre_ids as $i => $genre_id )
		{
			if(
				$this->db->insert(
					$this->tables['book_genre'],
					array(
						$this->join['book'] => (float)$book_id,
					  	$this->join['genre']  => (float)$genre_id
					)
				  )
			){
				$return++;
			}
		}
		return $return;

	}
	/**
	 * remove_genres
	 *
	 * @param array  $data
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function remove_genres( $data_param  )
    {
		$this->db->trans_begin();

		$this->db->delete($this->tables['book_genre'], $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('book_delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		return TRUE;

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
		$data = $this->_filter_data($this->tables['book'], $data);

		$this->db->update($this->tables['book'], $data, $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('book_update_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('book_update_successful');
		return TRUE;
	}
	/**
	 * delete
	 *
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function delete( $data_param  )
    {
		$this->db->trans_begin();

		$this->db->delete($this->tables['book'], $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('book_delete_unsuccessful');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('book_delete_successful');
		return TRUE;
	}
	/**
	 * book
	 *
	 * @param int|array|null $id = id_categories
	 * @return static
	 * @author madukubah
	 */
	public function book( $id = NULL  )
    {
		if (isset($id))
		{
			$this->where($this->tables['book'].'.id', $id);
        }

		$this->limit(1);
        $this->order_by($this->tables['book'].'.id', 'desc');

		$this->books();

		return $this;
	}

	public function search( $query = NULL, $genre_ids = array() )
    {
		if (isset($query))
		{
			$this->like( $this->tables['book'].".title" , $query );
        }
		$this->books( NULL, $genre_ids );

		return $this;
	}
	/**
	 * categories
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function books( $user_id = NULL, $genre_ids = array() )
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
			    $this->tables['book'].'.*',
			    $this->tables['category'].'.name as category_name',
			));
		}
		// 
		// join with table_category
		$this->db->distinct();
		$this->db->join(
			$this->tables['category'],
			$this->tables['book'].'.'.$this->join['category'].'='.$this->tables['category'].'.id',
			'inner'
		);
		// 
		// filter by user_id(s) if passed
		if (isset($user_id))
		{
			$this->where($this->tables['book'].'.user_id', $user_id);
		}
		// filter by user_id(s) if passed
		if (!empty($genre_ids))
		{
			if (!is_array($genre_ids))
			{
				$genre_ids = Array($genre_ids);
			}
			
			if (isset($genre_ids) && !empty($genre_ids))
			{
				$this->db->distinct();
				$this->db->join(
				    $this->tables['book_genre'],
				    $this->tables['book_genre'].'.'.$this->join['book'].'='.$this->tables['book'].'.id',
				    'inner'
				);
			}
			// foreach ( $genre_ids as $genre_id)
			// {
			// 	$this->db->where_in($this->tables['book_genre'].'.'.$this->join['genre'],  array( $genre_id ) ) ;
			// }
			$this->db->where_in($this->tables['book_genre'].'.'.$this->join['genre'],  ( $genre_ids ) ) ;
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
        $this->response = $this->db->get($this->tables['book']);
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
		$messageLang = $this->lang->line($message) ? $this->lang->line($message) : $message;
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
		$errorLang = $this->lang->line($error) ? $this->lang->line($error) : $error;
		parent::set_error( $errorLang );
	}
}