<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// library plugin req boostrap
class Book_service  {
	protected $id;
	protected $title;
	protected $description;
	protected $language;
	protected $author;
	protected $page_count;
	protected $publisher;

	protected $category_id;

	public function __construct(  )
	{
		$this->id ="";
		$this->title ="title";
		$this->description="description";
		$this->language="language";
		$this->author="author";
		$this->page_count=1;
		$this->publisher="publisher";
		$this->price="10000";
		$this->category_id=0;

		$this->config->load('book_service', TRUE);
        $this->load->model('m_book_service');
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

		if (!method_exists( $this->m_book_service, $method) )
		{
			throw new Exception('Undefined method m_book_service::' . $method . '() called');
		}

		return call_user_func_array( array($this->m_book_service, $method), $arguments);
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
	 * add_book
	 *
	 * @param array data
	 * @return bool
	 * @author madukubah
	 **/
	public function add_book( $data, $genre_ids )
	{
		if( ( $file_data =  $this->upload_photo( "images" ) ) == FALSE )
		{
			$this->set_error( 'book_creation_unsuccessful' );
			return FALSE;
		}
		$data["images"] = array();
		foreach( $file_data as $i => $val )
		{
			$data["images"][] = $file_data[$i]["file_name"];
		}
		$data["images"] = implode(";", $data["images"] );

		$user = $this->user_auth->user()->row();//curr user
		$data["user_id"] = $user->id_user;
		
		return $this->m_book_service->create( $data, $genre_ids );
	}
	/**
	 * edit_book
	 *
	 * @param array data
	 * @return bool
	 * @author madukubah
	 **/
	public function edit_book( $data, $data_param, $genre_ids )
	{	
		$book = $this->m_book_service->book( $data_param['id'] )->row();
		$book_genres = $this->m_genre->genres( $data_param['id'] )->result();
		$this->sync_genre( $book_genres , $genre_ids, $book->id );

		return $this->m_book_service->update( $data, $data_param  );
	}
	/**
	 * delete_image
	 *
	 * @param int  data
	 * @param int  book_id
	 * @return bool
	 * @author madukubah
	 **/
	public function delete_image( $image_index, $book_id )
	{	
		$book = $this->book_service->book( $book_id )->row();
		$images = explode(";", $book->images );

		if( count($images) <=1 )
		{
			$this->set_error( 'image_only_one' );
			return FALSE;
		}

		$this->remove_photo( $images[ $image_index ] );

		unset( $images[ $image_index ] );

		$images = implode(";", $images );
		$data["images"] = $images;
		$data_param['id'] = $book_id;
		return $this->m_book_service->update( $data, $data_param  );
	}
	/**
	 * delete_image
	 *
	 * @param int  book_id
	 * @return bool
	 * @author madukubah
	 **/
	public function add_image( $book_id )
	{	
		if( ( $file_data =  $this->upload_photo( "images" ) ) == FALSE )
		{
			$this->set_error( 'add_image_unsuccessful' );
			return FALSE;
		}

		$book = $this->book_service->book( $book_id )->row();
		$images = explode(";", $book->images );
		foreach( $file_data as $i => $val )
		{
			$images[] = $file_data[$i]["file_name"];
		}

		$images = implode(";", $images );
		$data["images"] = $images;
		$data_param['id'] = $book_id;
		return $this->m_book_service->update( $data, $data_param  );
	}


	protected function sync_genre( $curr_genres , $new_genre_ids, $book_id )
	{	
		$removes_ids= array();
		$visit = array();
		foreach( $new_genre_ids as $id )
		{
			$visit[ $id ] = $id;
		}

		foreach( $curr_genres as $genre )
		{
			if(  isset( $visit[ $genre->id ] ) ){
				unset( $visit[ $genre->id ] );
			}else{

				$removes_ids[] = array( "genre_id" => $genre->id, "book_id" => $book_id  ) ;
			}
		}
		
		foreach( $removes_ids as $id )
		{
			$this->m_book_service->remove_genres( $id );
		}
		if( !empty( $visit ) ) $this->m_book_service->add_genres( $book_id, $visit );
	}
	/**
	 * delete_book
	 *
	 * @param array data
	 * @return bool
	 * @author madukubah
	 **/
	public function delete_book( $data )
	{	
		$data_param[ "book_id" ] = $data['id'];
		if( !$this->m_book_service->remove_genres( $data_param ) ) return FALSE;

		$book = $this->m_book_service->book( $data['id'] )->row();
		if( $this->m_book_service->delete( $data ) )
		{
			$book->images = explode(";", $book->images);
			foreach( $book->images as $image )
			{
				$this->remove_photo( $image );
			}
			return TRUE;
		}
		return FALSE;
	}
	/**
	 * get_validation_config
	 *
	 * @return array
	 * @author alanHetfielD
	 **/
	public function get_validation_config()
	{
		$config = array(
			array(
				   'field' => 'title',
					'label' => $this->lang->line('title'),
					'rules' =>  'trim|required',
			),
			array(
				'field' => 'description',
				 'label' => $this->lang->line('description'),
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'language',
				 'label' => $this->lang->line('language'),
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'author',
				 'label' => $this->lang->line('author'),
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'page_count',
				 'label' => $this->lang->line('page_count'),
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'publisher',
				 'label' => $this->lang->line('publisher'),
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'price',
				 'label' => $this->lang->line('price'),
				 'rules' =>  'trim|required',
			 ),
			 array(
				'field' => 'genre_ids[]',
				 'label' => $this->lang->line('genre_name'),
				 'rules' =>  'trim|required',
		 	),
		);
		return $config;
	}

	protected function set_checked( array $data, $target_id  )
	{
		foreach( $data as $item ){
			if($target_id ==  $item->id ) return "checked";
		}
		return "";
	}
	/**
	 * get_form_data
	 *
	 * @return array
	 * @author alanHetfielD
	 **/
	public function get_form_data( $book_id = -1 )
	{
		if( $book_id != -1 )
		{
			$book = $this->m_book_service->book( $book_id )->row();
			$this->title 		= $book->title;
			$this->description	= $book->description;
			$this->language		= $book->language;
			$this->author		= $book->author;
			$this->page_count	= $book->page_count;
			$this->publisher	= $book->publisher;
			$this->price		= $book->price;
			$this->category_id  = $book->category_id;
		}
		$this->load->model('m_category');
		$this->load->model('m_genre');
		$categories = $this->m_category->categories()->result();
		$category_select = array();
		foreach( $categories as $category )
		{
			$category_select[ $category->id ] = $category->name;
		}
		$genres = $this->m_genre->genres()->result();
		$book_genres = $this->m_genre->genres( $book_id )->result();
		// echo var_dump( $book_genres );

		$genre_options =" <label>".$this->lang->line('genre_name')."</label><br> ";
		foreach($genres as $n => $item)
		{	
			$genre_options .= form_checkbox("genre_ids[]", $item->id ,set_checkbox('genre_ids[]', $item->id), ' '.$this->set_checked( $book_genres, $item->id  ).' id="basic_checkbox_'.$n.'"');
			$genre_options .= '<label for="basic_checkbox_'.$n.'"> '. $item->name .'</label><br>';
		}

		if( $this->router->fetch_method() == "edit" )
		{
			$data['id'] = array(
				'name' => 'id',
				'label' => 'id',
				'id' => 'id',
				'type' => 'hidden',
				'placeholder' => $this->lang->line('title'),
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('id', $book->id),
			);
		}
		$data['title'] = array(
			'name' => 'title',
			'label' => 'title',
			'id' => 'title',
			'type' => 'text',
			'placeholder' => $this->lang->line('title'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('title', $this->title),
		);
		$data['description'] = array(
			'name' => 'description',
			'label' => 'description',
			'id' => 'description',
			'type' => 'text',
			'placeholder' => $this->lang->line('description'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('description', $this->description),
		);
		$data['language'] = array(
			'name' => 'language',
			'label' => 'language',
			'id' => 'language',
			'type' => 'text',
			'placeholder' => $this->lang->line('language'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('language', $this->language),
		);
		$data['author'] = array(
			'name' => 'author',
			'label' => 'author',
			'id' => 'language',
			'type' => 'text',
			'placeholder' => $this->lang->line('author'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('author', $this->author),
		);
		$data['page_count'] = array(
			'name' => 'page_count',
			'label' => 'page_count',
			'id' => 'page_count',
			'type' => 'number',
			'min' => '1',
			'placeholder' => $this->lang->line('page_count'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('page_count', $this->page_count),
		);
		$data['publisher'] = array(
			'name' => 'publisher',
			'label' => 'publisher',
			'id' => 'publisher',
			'type' => 'text',
			'placeholder' => $this->lang->line('publisher'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('publisher', $this->publisher),
		);
		$data['price'] = array(
			'name' => 'price',
			'label' => 'price',
			'id' => 'price',
			'min' => '1',
			'type' => 'number',
			'placeholder' => $this->lang->line('price'),
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('price', $this->price),
		);
		$data['images'] = array(
			'name' => 'images[]',
			'label' => 'images',
			'id' => 'images',
			'type' => 'file',
			'multiple' => '',
			'class' => 'form-control',
		);
		$data['category_id'] = array(
			'name' => 'category_id',
			'label' => 'category_name',
			'id' => 'category_id',
			'class' => 'form-control',
			'options' => $category_select,
			'selected' => $this->category_id ,
		);

		$data['genres'] = $genre_options;

		$button_label = array(
			"add" =>"add_label",
			"edit" =>"edit_label",
		);
		$data['submit'] = array(
			'data' => 'submit',
			'value' => $this->lang->line( $button_label[ $this->router->fetch_method() ] ),
			'id' => 'submit',
			'type' => 'submit',
			'class' => 'btn  pull-right btn-success',
		);
		return $data;
	}
	/**
	 * upload_photo
	 *
	 * @return true
	 * @author alanHetfielD
	 **/
	protected function upload_photo( $file )
	{
		$user = $this->user_auth->user()->row();//curr user
		$upload = $this->config->item('upload', 'book_service');

		$config                         = $upload;
		$config['file_name'] 			=  $config['file_name'].$user->id_user."_".time();

		$this->load->library('upload');
		$this->upload->initialize($config);

		if ( ! $this->upload->do_multi_upload( $file ) )
		{
			$this->set_error( $this->upload->display_errors() );
			$this->set_error( 'upload_unsuccessful' );
			return FALSE;
		}
		else
		{
			$file_data = $this->upload->get_multi_upload_data();
			if( !empty( $this->upload->display_errors() ) ){
				$this->set_message( $this->upload->display_errors() );
			}
			$this->set_message('upload_successful');
			return $file_data;
		}
		$this->set_error( 'upload_unsuccessful' );
		return FALSE;
	}
	/**
	 * remove images
	 *param string| $file
	 *param string| $table
	 * @return true
	 * @author alanHetfielD
	 **/
	public function remove_photo( $file_name )
	{
		$upload = $this->config->item('upload', 'book_service');
		$config['upload_path']          = $upload['upload_path'];

		return @unlink( $config['upload_path'].$file_name );
	}
}
