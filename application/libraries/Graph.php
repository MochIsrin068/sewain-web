<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph  
{
	 /**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $graph = array();
	public $domain = array();
	public $domain_ind = array();

	public $ARRAY  = array();
	public $PARENT = array();
	public $VISIT  = array();

	public function __construct(  )
	{
		$this->load->model('m_graph');
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
		if (!method_exists( $this->m_graph, $method) )
		{
			throw new Exception('Undefined method m_graph::' . $method . '() called');
		}
		return call_user_func_array( array($this->m_graph, $method), $arguments);
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
	 * graph
	 *
	 * @param int|array $domain1
	 * @param int|array $domain2
	 * @return static
	 * @author madukubah
	 */
	public function create_graph( $domain1, $domain2, $mode = 'graph')
    {
		 $this->create_domain( array_merge( $domain1, $domain2 ) )  ;

		 $this->graph = array_fill(0, count( $this->domain ), array() );
		for($i=0; $i< count( $domain1 ); $i++ )
		{	
			$this->graph[ $this->domain[ $domain1[$i] ] ] [] = $this->domain[ $domain2[$i] ];
			if( $mode == 'graph' )
				$this->graph[ $this->domain[ $domain2[$i] ] ] [] = $this->domain[ $domain1[$i] ];	
		}
		
		return  $this->graph ;
	}
	/**
	 * parse_graph
	 * convrt data table (from database ) to graph
	 * @return static
	 * @author madukubah
	 */
	public function parse_graph( $data, $mode = 'digraph')
    {
		$this->graph = array();
		$ARR = array();
		for($i=0; $i< count( $data ); $i++ )
		{
			if( !is_array( $data[ $i ]->adj_list ) )
				$data[ $i ]->adj_list = explode(",", $data[ $i ]->adj_list );

			$ARR = array_merge( $ARR, $data[ $i ]->adj_list );
			array_push($ARR, $data[ $i ]->node );
		}
		 $this->create_domain( array_merge( $ARR ) )  ;
		
		 $this->graph = array_fill(0, count( $this->domain ), array() );
		foreach( $data as $list )
		{
			for($i=0; $i< count( $list->adj_list ); $i++ )
			{
				$list->adj_list[$i] = $this->domain[ $list->adj_list[$i] ] ;
			}
			$this->graph[ $this->domain[ $list->node ] ] = $list->adj_list;
		}
		return $this->graph ;
	}
	/**
	 * update
	 *
	 * @return array array of node
	 * @author madukubah
	 */
	public function update( $graph )
    {
		$DATA = array();
		$data = array();
		for($i=0; $i< count( $graph ); $i++)
		{
			if( !empty( $graph[ $i ] ) )
			{
				$data["node"] = $this->domain_ind[ $i ];
				for($j=0; $j< count( $graph[ $i ] ); $j++ )
				{
					$graph[ $i ][ $j ]  = $this->domain_ind[ $graph[ $i ][ $j ] ] ;
				}
				// array_pop( $graph[ $i ] );
				$data["adj_list"] =  implode( ",", $graph[ $i ] );
				$data_param["node"] = $data["node"] ;
				$this->m_graph->update( $data, $data_param );
				array_push($DATA, $data );
			}
		}
		// echo var_dump( $DATA );
	}
	/**
	 * tree
	 *
	 * @return array tree
	 * @author madukubah
	 */
	public function tree( $parent )
    {
		$tree = array();
		$this->PARENT = array();
		$this->VISIT = array();

		$parent = $this->domain[ $parent ];
		$this->VISIT = array_fill(0, count( $this->domain ), 0);
		$this->PARENT = array_fill(0, count( $this->domain ), 0);
		$tree[] = $this->make_tree( $parent );
		return $tree;
	}
	/**
	 * make_tree
	 *
	 * @return array tree
	 * @author madukubah
	 */
	public function make_tree( $parent )
    {
		if( $this->VISIT[ $parent ] ) return NULL ;
		$this->VISIT[ $parent ] = TRUE;
		$item = array();
		$item["index"] = $parent;
		$item["value"] =  $this->domain_ind[ $parent ];
		$item["child"] = array();
		for( $i=0; $i< count( $this->graph[ $parent ] ); $i++ )
		{
			if( ( $child = $this->make_tree( $this->graph[ $parent ][$i] ) ) != NULL)
			{
				$this->PARENT[ $this->graph[ $parent ][$i] ] = $parent;
				$item["child"][] = $child;
			}
		}
		return $item;
	}
	/**
	 * get_domain
	 *
	 * @return array array of node
	 * @author madukubah
	 */
	public function get_domain( $mode = 'index')
    {
		if( $mode == 'index' ) return  $this->domain_ind;
		return  $this->domain;
	}
	/**
	 * create_domain
	 * create domain for indexing node ( normalize nodes )
	 * @return array array of node
	 * @author madukubah
	 */
	public function create_domain( $domain )
    {
		$data_array = array();
		foreach($domain as $item)
		{
			if( ! in_array($item, $data_array) )
				$data_array[] = $item;
		}
		sort( $data_array );
		$i=0;
		 foreach($data_array as $data )
		 {
			$this->domain[$data] = $i;
			$this->domain_ind[ $i ] = $data;
			$i++;
		 }
		return $this->domain;
	}
	
	public function clear(  )
    {
		$this->graph = array();
		$this->domain = array();
		$this->domain_ind = array();

		$this->ARRAY = array();
		$this->VISIT = array();
	}

}
