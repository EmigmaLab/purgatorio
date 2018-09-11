<?php

/**
 * 
 * Singleton class
 *
 */

final class PG_Queries_Class {

	private static $instances = array();

	/*
	******************************************************************************************************
		Private constructor methods so nobody else can instance it
	******************************************************************************************************
	*/
    protected function __construct() {

    }

    protected function __clone() {

    }

    /*
	******************************************************************************************************
		Prevent unserializing of an instance of the class via the global function unserialize()
	******************************************************************************************************
	*/
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    /*
	******************************************************************************************************
		Static creation of a new single instance
	******************************************************************************************************
	*/
    public static function getInstance() {
        $class = get_called_class(); // late-static-bound class name
        if ( ! isset(self::$instances[$class]) ) {
            self::$instances[$class] = new static;
        }
        return self::$instances[$class];
    }
    
    /*
	******************************************************************************************************
		Basic query setter
	******************************************************************************************************
	*/
	private function set_basic_args($cpt, $posts_per_page, $orderby=array('date' => 'DESC'), $meta_key=''){
		$args = array(
		    'post_type'			=> $cpt,
		    'posts_per_page'	=> $posts_per_page,
		    'meta_key' 		  	=> $meta_key,
			'orderby' 	  	  	=> $orderby
		);
		
		return $args;
	}
	
	/*
	******************************************************************************************************
		Meta query setter
	******************************************************************************************************
	*/
	private function set_meta_args($key, $value, $type, $compare){
		$meta_query = array(
			'meta_query' => array(
				array(
	        		'key'       => $key,
	        		'value'     => $value,
	        		'type'      => $type,
	        		'compare'   => $compare
				)
        	)
		);
		
		return $meta_query;
	}
	
	/*
	******************************************************************************************************
		Date query setter
	******************************************************************************************************
	*/
	private function set_date_args($retrieve, $range){
		$date_query = array(
			'date_query' => array(
				array(
	        		$retrieve => date('Y-m-d', strtotime($range))
				)
        	)
		);
		
		return $date_query;
	}
	
	/*
	******************************************************************************************************
		Taxonomy query setter
	******************************************************************************************************
	*/
	private function set_tax_args($tax, $id){
		$tax_query = array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> $tax,
					'field' 	=> 'id',
					'terms' 	=> pg_get_translated_term($id),
					'operator' 	=> 'IN'
				)
			)
		);
		
		return $tax_query;
	}
	
	/*
	******************************************************************************************************
		Make query
	******************************************************************************************************
	*/
	private function make_query($args) {
		$query = new WP_Query( $args );
		wp_reset_postdata();
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get latest posts
	******************************************************************************************************
	*/
	public function get_latest_posts($cpt, $posts_per_page, $orderby='') {
		$args = $this->set_basic_args($cpt, $posts_per_page, $orderby);
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get posts by year
	******************************************************************************************************
	*/
	public function get_posts_by_year($cpt, $year) {
		if( ! $year ) $year = date('Y');
		$args = $this->set_basic_args($cpt, -1);
		$args['year'] = $year;

		$query = $this->make_query($args);
		
		return $query;
	}

	/*
	******************************************************************************************************
		Get posts from specific period
	******************************************************************************************************
	*/
	public function get_posts_after($cpt, $posts_per_page, $date_query='14 days ago') {
		$args = array_merge(
			$this->set_basic_args($cpt, $posts_per_page),
			$this->set_meta_args('datetime', '', 'CHAR', '=')
		);
		if($date_query){
			$args = array_merge(
				$args,
				array('date_query' => array(
			        array(
			            'after' => $date_query
			        )
			    ))
			);
		}
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get posts by search parameter (title, content, excerpt)
	******************************************************************************************************
	*/
	public function get_posts_by_search_param($cpt, $posts_per_page, $orderby='', $search_param) {
		$args = $this->set_basic_args($cpt, $posts_per_page, $orderby);
		if($search_param){
			$args['s'] = $search_param;
		}
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get posts by taxonomy
	******************************************************************************************************
	*/
	public function get_latest_posts_by_taxonomy($cpt, $posts_per_page, $tax, $term_id) {
		$args = array_merge(
			$this->set_basic_args($cpt, $posts_per_page, array( 'menu_order' => 'ASC', 'title' => 'ASC' ), ''),
			$this->set_tax_args($tax, $term_id)
		);
		
		return  $this->make_query($args);
	}
	
	/*
	******************************************************************************************************
		Get children posts
	******************************************************************************************************
	*/
	public function get_children_posts($cpt, $posts_per_page, $post_parent_id, $orderby='') {
		$args = $this->set_basic_args($cpt, $posts_per_page, $orderby, '', $post_parent_id);
		$childrens = array();
		$childrens = get_children($args);

		return $childrens;
	}
	
	/*
	******************************************************************************************************
		Get posts filtered by meta key
	******************************************************************************************************
	*/
	public function get_latest_posts_meta_filtered($cpt, $posts_per_page, $orderby='', $key, $value, $type, $compare) {
		$args = array_merge(
			$this->set_basic_args($cpt, $posts_per_page, $orderby, $meta_key),
			$this->set_meta_args($key, $value, $type, $compare)
		);
		
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get event based post
	******************************************************************************************************
	*/
	public function get_eventdate_posts($cpt, $posts_per_page, $key, $compare='>=') {
		$query = $this->get_latest_posts_meta_filtered($cpt, $posts_per_page, array('meta_value' => 'ASC'), $key, date('Y-m-d H:i:s'), 'CHAR', $compare);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get date based post
	******************************************************************************************************
	*/
	public function get_datebased_posts($cpt, $retrieve, $range) {
		$args = array_merge(
			$this->set_basic_args($cpt, -1),
			$this->set_date_args($retrieve, $range)
		);
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get taxonomy term's posts
	******************************************************************************************************
	*/
	public function get_term_posts($cpt, $tax, $term_id) {
		$args = array_merge(
			$this->set_basic_args($cpt, -1),
			$this->set_tax_args($tax, $term_id)
		);
		$query = $this->make_query($args);
		
		return $query;
	}
	
	/*
	******************************************************************************************************
		Get posts sorted by term
	******************************************************************************************************
	*/
	public function sorted_tax_query($cpt, $tax) {
		$terms = get_terms($tax);
		$members = array();
		foreach($terms as $term){
			$args = array_merge(
				$this->set_basic_args($cpt, -1, array( 'menu_order' => 'ASC', 'title' => 'ASC' ), ''),
				$this->set_tax_args($tax, $term->term_id)
			);
			$data = get_posts($args);
			$members[$term->term_id]['term'] = $term;
			$members[$term->term_id]['posts'] = $data;
		}
		
		return $members;
	}
}

?>