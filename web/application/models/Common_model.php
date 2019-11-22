<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

class Common_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
		/* clear cache*/	
	function clear_cache()
	{
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}


	function check_email_username($username='',$email='') {
      $this->db->where('email',$email);
      $this->db->or_where('username',$username);
      //var_dump($username,$email);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
        	return TRUE;
        }
        else{
        	return FALSE;
        }     
              
    }

        function check_email($email='') {
        $this->db->where('email',$email);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }     
              
    }

    function check_token($token='') {
        $this->db->where('token',$token);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }     
              
    }


    function slug_exist($table='',$slug='') {
        $rows = count($this->db->get_where($table, array('slug' => $slug))->result_array());
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }     
              
    }

    function slug_num($table='',$slug='') {
        return count($this->db->get_where($table, array('slug' => $slug))->result_array());          
              
    }



    function get_video_type($video_type_id=''){
    	$query = $this->db->get_where('video_type', array('video_type_id' => $video_type_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['video_type'];

    }

    function get_category_name($category_id=''){
    	$query = $this->db->get_where('post_category', array('post_category_id' => $category_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['category'];

    }


	
		/* get image url */
	function get_img($type = '' , $id = '')
	{
		if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
			$image_url	=	base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
		else
			$image_url	=	base_url().'uploads/user.jpg';
			
		return $image_url;
	}
		/* create and download database backup*/
	function create_backup()
    {
        $this->load->dbutil();  
        $options = array(
                'format'      => 'txt',             
                'add_drop'    => TRUE,              
                'add_insert'  => TRUE,              
                'newline'     => "\n"               
              );     
        
        $tables   = array('');
        $file_name  =   'ovoo_backup_'.date('Y-m-d-H-i-s');
        $backup = $this->dbutil->backup(array_merge($options , $tables));
        $this->load->helper('file');
        write_file('db_backup/'.$file_name.'.sql', $backup); 
        //$this->load->helper('download');
        //force_download($file_name.'.sql', $backup);
        return 'done';
    }
	
	
		/* restore database backup*/	
	function restore_backup()
	{
		
		move_uploaded_file($_FILES['backup_file']['tmp_name'], 'uploads/backup.sql');

		$prefs = array(
            'filepath'						=> 'uploads/backup.sql',
			'delete_after_upload'			=> TRUE,
			'delimiter'						=> ';'
        );
		
		$schema = htmlspecialchars(file_get_contents($prefs['filepath']));

		$query = rtrim( trim($schema), "\n;");

		$query_list = explode(";", $query);
		$this->truncate();	
		

        foreach($query_list as $query){
        	$this->db->query($query);
        }
		/*$restore =& $this->dbutil->restore($prefs);
	*/
        unlink($prefs['filepath']);
	}
	
		/* empty data from table */
	function truncate() {
            $this->db->truncate('access');
            $this->db->truncate('accessories');
            $this->db->truncate('apps');
            $this->db->truncate('brand');
            $this->db->truncate('category');
            $this->db->truncate('computer');
            $this->db->truncate('ip');
            $this->db->truncate('device');
            $this->db->truncate('os');
            $this->db->truncate('supplier');  
    }

    function set_custom_value(){
    	$data['value'] = "Luke Dhaka Company Limited";
             $this->db->where('title' , 'company_name');
             $this->db->update('config' , $data);
             
             $data['value'] = "Gulshan, Dhaka-1200";
             $this->db->where('title' , 'address');
             $this->db->update('config' , $data);
             
             $data['value'] = "880100000000";
             $this->db->where('title' , 'phone');
             $this->db->update('config' , $data);
             
             $data['value'] = "support@spagreen.net";
             $this->db->where('title' , 'system_email');
             $this->db->update('config' , $data);
    }

     function reset_database(){
     	$this->set_custom_value();
     	$this->truncate();
    $prefs = array(
            'filepath'						=> 'uploads/data.sql',
			'delete_after_upload'			=> FALSE,
			'delimiter'						=> ';'
        );
		
		$schema = htmlspecialchars(file_get_contents($prefs['filepath']));

		$query = rtrim( trim($schema), "\n;");

		$query_list = explode(";", $query);
		$this->truncate();
		foreach($query_list as $query){
        	$this->db->query($query);
        }
        unlink($prefs['filepath']);

    }


    public function all_published_slider()
    {
        return $this->db->get_where('slider', array('publication'=> '1'), 8)->result();
    }

    public function all_published_videos($limit='',$page='')
    {
        
        $offset = $page*$limit;
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    public function new_published_videos($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '0');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        return $this->db->get()->result();
    }

    public function latest_published_videos($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '0');
        $this->db->order_by("total_view","desc");
        $this->db->limit(12);
        return $this->db->get()->result();
    }

    public function new_published_tv_series($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        return $this->db->get()->result();
    }

    public function latest_published_tv_series($limit='',$page='')
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("total_view","desc");
        $this->db->limit(12);
        return $this->db->get()->result();
    }



    public function all_published_tv_series()
    {
        $this->db->select('*');
        $this->db->from('videos');
        //$this->db->where("FIND_IN_SET(left(2,10),video_type)>0");
        $this->db->where('is_tvseries', '1');
        $this->db->where('publication', '1');
        $this->db->order_by("total_view","desc");
        $this->db->limit(12);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function all_published_request_movies()
    {
      $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left(3,10),video_type)>0");
        //$this->db->where('video_type', '3');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function all_page_on_primary_menu()
    {
        $this->db->where('primary_menu', '1');
        $this->db->order_by("page_id","ASC");
        $query_result = $this->db->get('page');
        $result = $query_result->result();
        return $result;
    }

    public function all_video_type_on_primary_menu()
    {
        $this->db->where('primary_menu', '1');
        $this->db->order_by("video_type_id","ASC");
        $query_result = $this->db->get('video_type');
        $result = $query_result->result();
        return $result;
    }
    public function all_video_type_on_footer_menu()
    {
        $this->db->where('footer_menu', '1');
        $this->db->order_by("video_type_id","ASC");
        $query_result = $this->db->get('video_type');
        $result = $query_result->result();
        return $result;
    }


    public function all_page_on_footer_menu()
    {
      $this->db->select('*');
        $this->db->from('page');
        $this->db->where('footer_menu', '1');
        $this->db->order_by("page_id","ASC");
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


    
    
    public function all_published_trailers()
    {
        $this->db->select('*');
        $this->db->from('videos');
        //$this->db->where("FIND_IN_SET(left(4,10),video_type)>0");
        $this->db->where('is_tvseries', '0');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(6);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function all_published_genre()
    {

        return  $this->db->get_where('genre', array('publication' => '1'))->result();
    }


    public function all_published_country()
    {

        return  $this->db->get_where('country', array('publication' => '1'))->result();
    }

    public function get_videos_by_slug($slug)
    {
        return $this->db->get_where('videos', array('slug' => $slug))->row();
    }
    public function get_videos_id_by_slug($slug)
    {
        return $this->db->get_where('videos', array('slug' => $slug))->row()->videos_id;
    }
    public function watch_count_by_slug($slug)
    {
        $videos_id          =   $this->db->get_where('videos', array('slug' => $slug))->row()->videos_id;
        $total_view         =   $this->db->get_where('videos', array('slug' => $slug))->row()->total_view;
        //
        $global_counter         =   $this->db->get_where('analytics', array('create_at' => date('Y-m-d')))->row()->counter;
        $data_g['counter'] =    $global_counter + 1;
        $this->db->where('create_at', date('Y-m-d'));
        $this->db->update('analytics', $data_g);
        //
        $data['total_view'] =    $total_view +   1;
        $this->db->where('videos_id', $videos_id);
        $this->db->update('videos', $data);
    }

    public function genre_is_exist($slug)
    {
        $num_rows = $this->db->get_where('genre', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    public function type_is_exist($slug)
    {
        $num_rows = $this->db->get_where('video_type', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    public function get_genrename_by_slug($slug)
    {
        $genre_name = $this->db->get_where('genre', array('slug' => $slug))->row()->name;
        
        //$this->db->select('name');
        //$this->db->from('genre');
        //$this->db->where('slug', $slug);
        //$this->db->order_by("videos_id","desc");
        //$query_result = $this->db->get();
        //$result = $query_result->result();
        return $genre_name;
    }

    public function get_genre_by_slug($slug)
    {
        $genre_id = $this->db->get_where('genre', array('slug' => $slug))->row();
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('genre', $genre_id->genre_id);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);

        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function get_star_id_by_slug($slug)
    {
        if(count($this->db->get_where('star', array('slug' => $slug))->result_array())> 0):
            $star_id = $this->db->get_where('star', array('slug' => $slug))->row()->star_id;
        else:
            $star_id =0;
        endif;
        return $star_id;
    }


    public function get_video_by_star($limit, $start,$star_id)
    {
        $data =array();
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->group_start();
        $this->db->where("FIND_IN_SET($star_id,stars)>0");
        $this->db->or_where("FIND_IN_SET($star_id,director)>0");
        $this->db->or_where("FIND_IN_SET($star_id,writer)>0");
        $this->db->group_end();
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        //var_dump($this->db->last_query());
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return $data;

    }

    public function convert_star_ids_to_names($ids='')
    {
        $names = '';
        if($ids !='' && $ids !=NULL):
            $i = 0;
            $stars =explode(',', $ids);                                                
            foreach ($stars as $star_id):
                if($i>0){ $names .=',';} $i++;
                $names .= $this->common_model->get_star_name_by_id($star_id);
            endforeach;
        endif;
        return $names;
    }


    public function get_video_by_star_record_count($star_id)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->group_start();
        $this->db->where("FIND_IN_SET($star_id,stars)>0");
        $this->db->or_where("FIND_IN_SET($star_id,director)>0");
        $this->db->or_where("FIND_IN_SET($star_id,writer)>0");
        $this->db->group_end();
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $query = $this->db->get();        
        return $query->num_rows();
    }


    public function get_video_by_director($limit, $start,$director)
    {
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('director', $director);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';

    }

    public function get_videos($limit=NULL, $start=NULL)
    {        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('is_tvseries', '0');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }
    }

    public function get_stars($limit=NULL, $start=NULL)
    {        
        $this->db->select('*');
        $this->db->from('star');
        $this->db->where('status', '1');
        $this->db->order_by("star_id","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }
    }



    public function get_tvseries($limit=NULL, $start=NULL)
    {        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }
    }




    public function get_video_by_director_record_count($director)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('director', $director);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();        
        return $query->num_rows();
    }





    public function get_video_by_tags($limit, $start,$tags)
    {
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('tags', $tags);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';

    }
    public function get_video_by_year($limit, $start,$year)
    {
        $this->db->limit($limit, $start);
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('release', $year);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';

    }

    public function get_video_by_tags_record_count($tag)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('tags', $tag);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();        
        return $query->num_rows();
    }

    public function get_video_by_year_record_count($year)
    {
        $query = $this->db->where('release', $year)->get('videos');
        //$this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        //$query = $this->db->get();        
        return $query->num_rows();
    }




    // country
    public function country_is_exist($slug)
    {
        $num_rows = $this->db->get_where('country', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    public function get_country_by_slug($slug)
    {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row();
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('country', $country_id->country_id);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(32);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;

    }

    public function get_country_id_by_name($name)
    {
        $result =count($this->db->get_where('country', array('name' => $name))->result_array());
        if($result >0){
        $country_id = $this->db->get_where('country', array('name' => $name))->row();
        return $country_id->country_id;
        }else{
            $data['name']           = $name;
            $data['description']    = $name;
            $data['slug']           = url_title($name, 'dash', TRUE);
            $data['publication']    = '1';
            $this->db->insert('country', $data);
            return $this->db->insert_id();
        }
    }

    public function get_country_name_by_id($country_id){
        $result =count($this->db->get_where('country', array('country_id' => $country_id))->result_array());
        if($result >0){
            return $this->db->get_where('country', array('country_id' => $country_id))->row()->name;
        }else{
            return "Unknown";
        }
    }
    public function get_country_url_by_id($country_id){
        $result =count($this->db->get_where('country', array('country_id' => $country_id))->result_array());
        if($result >0){
            return site_url().'country/'.$this->db->get_where('country', array('country_id' => $country_id))->row()->slug.'.html';
        }else{
            return "#";
        }
    }


    public function get_country_ids($name='')
    {
        $names          = explode(',', $name);
        $ids            = '';
        $i=0;
        foreach ($names as $name) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_country_id_by_name($name);
        }
        return $ids;
    }

    // genre

    public function get_genre_ids($name='')
    {
        $names          = explode(',', $name);
        $ids            = '';
        $i=0;
        foreach ($names as $name) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_genre_id_by_name($name);
        }
        return $ids;
    }


    public function get_genre_id_by_name($name)
    {
        $result =   count($this->db->get_where('genre', array('name' => $name))->result_array());
        if($result >    0){
        $genre_id = $this->db->get_where('genre', array('name' => $name))->row();
        return $genre_id->genre_id;
        }else{
            $data['name']           = $name;
            $data['description']    = $name;
            $data['slug']           = url_title($name, 'dash', TRUE);
            $data['publication']    = '1';
            $this->db->insert('genre', $data);
            return $this->db->insert_id();
        }

    }

    public function get_genre_name_by_id($genre_id){
        $result =count($this->db->get_where('genre', array('genre_id' => $genre_id))->result_array());
        if($result >0){
            return $this->db->get_where('genre', array('genre_id' => $genre_id))->row()->name;
        }else{
            return "Unknown";
        }
    }
    public function get_genre_url_by_id($genre_id){
        $result =count($this->db->get_where('genre', array('genre_id' => $genre_id))->result_array());
        if($result >0){
            return site_url().'genre/'.$this->db->get_where('genre', array('genre_id' => $genre_id))->row()->slug.'.html';
        }else{
            return "#";
        }
    }


    // star

    public function get_star_ids($type='',$stars='')
    {
        $stars          = explode(',', $stars);
        $ids            = '';
        $i=0;
        foreach ($stars as $star) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_star_id_by_name($type,$star);
        }
        return $ids;
    }
    function get_star_name_by_id($star_id)
    {
        $query  =   $this->db->get_where('star' , array('star_id' => $star_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['star_name'];
    }

    function get_star_slug_by_id($star_id)
    {
        $query  =   $this->db->get_where('star' , array('star_id' => $star_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    public function get_star_id_by_name($type,$name)
    {
        $name =$this->get_filtered_string($name);
        $result =   count($this->db->get_where('star', array('star_name' => $name))->result_array());
        if($result >    0){
        $star_id = $this->db->get_where('star', array('star_name' => $name))->row();
        return $star_id->star_id;
        }else{            
            $data['slug']                   = $this->get_seo_url($name);
            $data['star_name']              = $name;
            $data['star_type']              = $type;
            $data['star_desc']              = ' ';
            $data['status']                 = '1';
            $this->db->insert('star', $data);
            return $this->db->insert_id();
        }

    }

    
    public function movies_record_count()
    {

        $this->db->where("is_tvseries !=","1");
		$this->db->where("publication","1");
        $query = $this->db->get('videos');
        return $query->num_rows();
    }
    public function search_movies_record_count($search='')
    {
        $query = $this->db->like('title', $search)->get('videos');
        $query2 = $this->db->like('title_en', $search)->get('videos');
        return $query->num_rows()+$query2->num_rows();
    }

    
    public function tv_series_record_count()
    {
        return $this->db->get_where('videos', array('is_tvseries'=>'1'))->num_rows();
    }

    public function is_video_published($videos_id)
    {
        $publication                    =   $this->db->get_where('videos' , array('videos_id'=>$videos_id))->row()->publication;
        
        if($publication =='1')
            return true;
        else
            return false;        
    }
    
    public function requested_movie_record_count()
    {
        $query = $this->db->where("FIND_IN_SET(left(3,10),video_type)>0")->get('videos');
        //$query = $this->db->where('video_type', '3')->get('videos');
        
        return $query->num_rows();
    }
    
    public function trailers_record_count()
    {
        $query = $this->db->where("FIND_IN_SET(left(4,10),video_type)>0")->get('videos');
        //$query = $this->db->where('video_type', '4')->get('videos');
        
        return $query->num_rows();
    }
    
   public function fetch_videos($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->select('*');
        $this->db->from('videos');
        //$this->db->where('video_type', '1');
        $this->db->where("FIND_IN_SET(left(1,10),video_type)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

   public function fetch_search_videos($limit, $start,$search) {
        $this->db->limit($limit, $start);
        //if ($this->get_star_id_by_name("actor",$search) == "0"){
        //} else {
             //$star_id = get_star_id_by_slug($search);
        //}
                                                $star_id = $this->get_star_id_by_name('actor',$search);
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('title',$search);
        $this->db->or_like('title_en',$search);
        //$this->db->or_like("FIND_IN_SET(left($star_id,10),stars)>0");
        $this->db->where('publication', '1');
                                                $testit = "FIND_IN_SET(left(13,10),stars)>0";
        //$this->db->or_like("FIND_IN_SET(left(13,10),stars)>0");
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

   
   public function fetch_tv_series($limit, $start) {
        $this->db->limit($limit, $start);        
        $this->db->from('videos');
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function fetch_request_movies($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left(3,10),video_type)>0");
        //$this->db->where('video_type', '3');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(32);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function fetch_trailers($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left(4,10),video_type)>0");
        //$this->db->where('video_type', '4');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(32);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   public function fetch_genre_video_by_slug($limit, $start, $slug) { 
        //$genre_id = $this->db->get_where('genre', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->from('videos');
        if ($slug == 'akcni'){
           $this->db->where("FIND_IN_SET(left(1,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(74,10),genre)>0"); 
           $this->db->or_where("FIND_IN_SET(left(91,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(95,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(107,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(155,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(164,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(181,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(192,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(209,10),genre)>0");
        }
        if ($slug == 'tv-show'){
           $this->db->where("FIND_IN_SET(left(2,10),genre)>0");
        }
        if ($slug == 'sci-fi'){
           $this->db->where("FIND_IN_SET(left(3,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(85,10),genre)>0");
        }
        if ($slug == 'dobrodruzne'){
           $this->db->where("FIND_IN_SET(left(4,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(22,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(79,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(83,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(98,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(106,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(153,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(168,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(169,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(182,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(191,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(194,10),genre)>0");
        }
        if ($slug == 'animovane'){
           $this->db->where("FIND_IN_SET(left(110,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(76,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(126,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(5,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(159,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(187,10),genre)>0");
        }

        if ($slug == 'zivotopisne'){
           $this->db->where("FIND_IN_SET(left(6,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(86,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(108,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(116,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(176,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(208,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(210,10),genre)>0");
        }
        if ($slug == 'komedie'){
           $this->db->where("FIND_IN_SET(left(7,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(78,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(93,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(99,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(101,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(137,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(150,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(151,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(167,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(183,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(188,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(190,10),genre)>0");
        }
        if ($slug == 'kratke'){
            $this->db->where("FIND_IN_SET(left(160,10),genre)>0");
            $this->db->where("FIND_IN_SET(left(197,10),genre)>0");
            $this->db->where("FIND_IN_SET(left(211,10),genre)>0");
        }
        if ($slug == 'krimi'){
           $this->db->where("FIND_IN_SET(left(8,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(75,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(89,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(96,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(111,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(143,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(152,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(165,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(178,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(198,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(200,10),genre)>0");
        }
        if ($slug == 'dokumentarni'){
           $this->db->where("FIND_IN_SET(left(9,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(61,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(147,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(147,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(173,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(199,10),genre)>0");
        }
        if ($slug == 'drama'){
           $this->db->where("FIND_IN_SET(left(10,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(24,10),genre)>0");
        }
        if ($slug == 'rodinne'){
           $this->db->where("FIND_IN_SET(left(11,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(77,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(84,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(100,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(127,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(139,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(145,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(158,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(166,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(184,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(195,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(201,10),genre)>0");
        }
        if ($slug == 'fantasy'){
           $this->db->where("FIND_IN_SET(left(12,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(25,10),genre)>0");
        }
        if ($slug == 'historie'){
           $this->db->where("FIND_IN_SET(left(13,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(82,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(141,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(148,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(161,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(171,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(185,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(202,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(207,10),genre)>0");
        }
        if ($slug == 'horror'){
           $this->db->where("FIND_IN_SET(left(14,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(104,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(157,10),genre)>0");
        }
        if ($slug == 'hudebni'){
           $this->db->where("FIND_IN_SET(left(15,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(88,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(114,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(117,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(125,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(162,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(172,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(177,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(204,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(206,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(213,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(214,10),genre)>0");
        }
        if ($slug == 'mystery'){
           $this->db->where("FIND_IN_SET(left(16,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(68,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(105,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(179,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(189,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(196,10),genre)>0");
        }
        if ($slug == 'thriller'){
           $this->db->where("FIND_IN_SET(left(17,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(23,10),genre)>0");
        }
        if ($slug == 'valecne'){
           $this->db->where("FIND_IN_SET(left(18,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(92,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(102,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(123,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(140,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(156,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(163,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(174,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(180,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(203,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(212,10),genre)>0");
        }
        if ($slug == 'western'){
           $this->db->where("FIND_IN_SET(left(19,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(103,10),genre)>0");
        }
        if ($slug == 'romanticke'){
           $this->db->where("FIND_IN_SET(left(21,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(80,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(94,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(138,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(142,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(144,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(149,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(154,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(170,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(175,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(193,10),genre)>0");
           $this->db->or_where("FIND_IN_SET(left(205,10),genre)>0");
        }

        if ($slug == 'eroticke'){
           $this->db->where("FIND_IN_SET(left(136,10),genre)>0");
        }
        //$this->db->where('publication', '1');
        //$this->db->order_by("videos_id","desc");
        //$this->db->limit(24);
        $query = $this->db->get();     

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
   }

   public function fetch_video_type_video_by_slug($limit, $start, $slug) {
        $video_type = $this->db->get_where('video_type', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left($video_type->video_type_id,10),video_type)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        //$this->db->limit(24);
        $query = $this->db->get();     

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
   }

   public function fetch_genre_video_by_slug_record_count($slug)
    {
       // $genre_id = $this->db->get_where('genre', array('slug' => $slug))->row(); // GET GENRE ID 

        if ($slug == 'akcni'){
          $query = $this->db->where("find_in_set(1,genre) >",0)->get('videos');
          $query2 = $this->db->where("find_in_set(74,genre) >",0)->get('videos');
          $query3 = $this->db->where("find_in_set(91,genre) >",0)->get('videos');
          $query4 = $this->db->where("find_in_set(95,genre) >",0)->get('videos');
          $query5 = $this->db->where("find_in_set(107,genre) >",0)->get('videos');
          $query6 = $this->db->where("find_in_set(155,genre) >",0)->get('videos');
          $query7 = $this->db->where("find_in_set(164,genre) >",0)->get('videos');
          $query8 = $this->db->where("find_in_set(181,genre) >",0)->get('videos');
          $query9 = $this->db->where("find_in_set(192,genre) >",0)->get('videos');
          $query10 = $this->db->where("find_in_set(209,genre) >",0)->get('videos');
            $ret = $query->num_rows();
            $ret2 = $query2->num_rows();
            $ret3 = $query3->num_rows();
            $ret4 = $query4->num_rows();
            $ret5 = $query5->num_rows();
            $ret6 = $query6->num_rows();
            $ret7 = $query7->num_rows();
            $ret8 = $query8->num_rows();
            $ret9 = $query9->num_rows();
            $ret10 = $query10->num_rows();
            $return_blak =  $ret+$ret2+$ret3+$ret4+$ret5+$ret6+$ret7+$ret8+$ret9+$ret10;
        }
        
        if ($slug == 'tv-show'){
           $query = $this->db->where(array('genre'=>'2'))->get('videos');
            $return_blak = $query->num_rows();
        }

        if ($slug == 'sci-fi'){
           $query = $this->db->where("find_in_set(3,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(85,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows();
        }

        if ($slug == 'dobrodruzne'){
           $query = $this->db->where("find_in_set(4,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(22,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(79,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(83,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(98,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(106,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(153,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(168,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(169,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(182,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(191,genre) >",0)->get('videos');
           $query12 = $this->db->where("find_in_set(194,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows()+$query12->num_rows();
        }

        // <<<<<<<<<<<<<<<<<<<<<<<<<<< ZDE JE MOŽNÁ CHYBA >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        if ($slug == 'animovane'){
           $query = $this->db->where("find_in_set(5,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(76,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(126,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(110,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(159,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(187,genre) >",0)->get('videos');
            $ret = $query->num_rows();
            $ret2 = $query2->num_rows();
            $ret3 = $query3->num_rows();
            $ret4 = $query4->num_rows();
            $ret5 = $query5->num_rows();
            $ret6 = $query6->num_rows();
           $return_blak = $ret+$ret2+$ret3+$ret4+$ret5+$ret6;
        }

        if ($slug == 'zivotopisne'){
           $query = $this->db->where("find_in_set(6,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(86,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(108,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(116,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(176,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(208,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(210,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows();
        }

        if ($slug == 'komedie'){
           $query = $this->db->where("find_in_set(7,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(78,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(93,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(99,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(101,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(137,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(150,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(151,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(167,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(183,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(188,genre) >",0)->get('videos');
           $query12 = $this->db->where("find_in_set(190,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows()+$query12->num_rows();
        }

        if ($slug == 'krimi'){
           $query = $this->db->where("find_in_set(8,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(75,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(89,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(96,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(111,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(143,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(152,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(165,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(178,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(198,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(200,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows();
        }

        if ($slug == 'dokumentarni'){
            $query = $this->db->where("find_in_set(9,genre) >",0)->get('videos');
            $query2 = $this->db->where("find_in_set(61,genre) >",0)->get('videos');
            $query3 = $this->db->where("find_in_set(147,genre) >",0)->get('videos');
            $query4 = $this->db->where("find_in_set(173,genre) >",0)->get('videos');
            $query5 = $this->db->where("find_in_set(199,genre) >",0)->get('videos');
            $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows();
        }

        if ($slug == 'drama'){
           $query = $this->db->where("find_in_set(10,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(24,genre) >",0)->get('videos');
            $return_blak = $query->num_rows()+$query2->num_rows();
        }

        if ($slug == 'rodinne'){
            $query = $this->db->where("find_in_set(11,genre) >",0)->get('videos');
            $query2 = $this->db->where("find_in_set(77,genre) >",0)->get('videos');
            $query3 = $this->db->where("find_in_set(84,genre) >",0)->get('videos');
            $query4 = $this->db->where("find_in_set(100,genre) >",0)->get('videos');
            $query5 = $this->db->where("find_in_set(127,genre) >",0)->get('videos');
            $query6 = $this->db->where("find_in_set(139,genre) >",0)->get('videos');
            $query7 = $this->db->where("find_in_set(145,genre) >",0)->get('videos');
            $query8 = $this->db->where("find_in_set(158,genre) >",0)->get('videos');
            $query9 = $this->db->where("find_in_set(166,genre) >",0)->get('videos');
            $query10 = $this->db->where("find_in_set(184,genre) >",0)->get('videos');
            $query11 = $this->db->where("find_in_set(195,genre) >",0)->get('videos');
            $query12 = $this->db->where("find_in_set(201,genre) >",0)->get('videos');
            $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows()+$query12->num_rows();
        }

        if ($slug == 'fantasy'){
           $query = $this->db->where("find_in_set(12,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(25,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows();
        }

         if ($slug == 'kratke'){
           $query = $this->db->where("find_in_set(160,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(197,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(211,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows();
        }

        if ($slug == 'historie'){
           $query = $this->db->where("find_in_set(13,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(82,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(141,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(148,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(161,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(171,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(185,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(202,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(207,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows();
        }

        if ($slug == 'horror'){
          $query = $this->db->where("find_in_set(14,genre) >",0)->get('videos');
          $query2 = $this->db->where("find_in_set(104,genre) >",0)->get('videos');
          $query3 = $this->db->where("find_in_set(157,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows();
        }
                
        if ($slug == 'hudebni'){
           $query = $this->db->where("find_in_set(15,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(88,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(114,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(117,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(125,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(162,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(172,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(177,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(204,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(206,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(213,genre) >",0)->get('videos');
           $query12 = $this->db->where("find_in_set(214,genre) >",0)->get('videos');
            $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows()+$query12->num_rows();
        }

        if ($slug == 'mystery'){
           $query = $this->db->where("find_in_set(16,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(68,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(105,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(179,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(189,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(196,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows();
        }

        if ($slug == 'thriller'){
           $query = $this->db->where("find_in_set(17,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(23,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows();
        }

        if ($slug == 'valecne'){
           $query = $this->db->where("find_in_set(18,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(92,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(102,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(123,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(140,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(156,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(163,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(174,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(180,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(203,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(212,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows();
        }

        if ($slug == 'western'){
           $query = $this->db->where("find_in_set(19,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(103,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows();
        }

        if ($slug == 'romanticke'){
           $query = $this->db->where("find_in_set(21,genre) >",0)->get('videos');
           $query2 = $this->db->where("find_in_set(80,genre) >",0)->get('videos');
           $query3 = $this->db->where("find_in_set(94,genre) >",0)->get('videos');
           $query4 = $this->db->where("find_in_set(138,genre) >",0)->get('videos');
           $query5 = $this->db->where("find_in_set(142,genre) >",0)->get('videos');
           $query6 = $this->db->where("find_in_set(144,genre) >",0)->get('videos');
           $query7 = $this->db->where("find_in_set(149,genre) >",0)->get('videos');
           $query8 = $this->db->where("find_in_set(154,genre) >",0)->get('videos');
           $query9 = $this->db->where("find_in_set(170,genre) >",0)->get('videos');
           $query10 = $this->db->where("find_in_set(175,genre) >",0)->get('videos');
           $query11 = $this->db->where("find_in_set(193,genre) >",0)->get('videos');
           $query12 = $this->db->where("find_in_set(203,genre) >",0)->get('videos');
           $return_blak = $query->num_rows()+$query2->num_rows()+$query3->num_rows()+$query4->num_rows()+$query5->num_rows()+$query6->num_rows()+$query7->num_rows()+$query8->num_rows()+$query9->num_rows()+$query10->num_rows()+$query11->num_rows()+$query12->num_rows();
        }
        
        if ($slug == 'eroticke'){
           $query = $this->db->where("find_in_set(136,genre) >",0)->get('videos');
           $return_blak = $query->num_rows();
        }
        //$query = $this->db->where(array('genre'=>$genre_id->genre_id))->get('videos'); // ARRAY GET VIDEO WHERE CONTAINS GENRE ID
        return $return_blak;
    }

    public function fetch_video_type_video_by_slug_record_count($slug)
    {
        $video_type = $this->db->get_where('video_type', array('slug' => $slug))->row();
        $query = $this->db->where(array('video_type'=>$video_type->video_type_id))->get('videos');
        
        return $query->num_rows();
    }



    public function fetch_country_video_by_slug($limit, $start, $slug) {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left($country_id->country_id,10),country)>0");
        //$this->db->where('country', $country_id->country_id);
        //$this->db->where('video_type', '3');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
   }

   public function fetch_country_video_by_slug_record_count($slug)
    {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row();
        $query = $this->db->where(array('country'=>$country_id->country_id))->get('videos');
        
        return $query->num_rows();
    }


    public function fetch_blog_post($limit, $start) {
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","DESC");
        $this->db->limit(10);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
   }

   public function fetch_blog_post_record_count()
    {
        
        $query = $this->db->where(array('publication'=>'1'))->get('posts');
        
        return $query->num_rows();
    }
    public function post_comments_record_count_by_id($id='')
    {
        
        $query = $this->db->where(array('post_id'=>$id, 'comment_type'=>'1','publication'=>'1'))->get('post_comments');
        
        return $query->num_rows();
    }

    public function fetch_blog_post_by_category_record_count($slug)
    {        
        $category_id = $this->db->get_where('post_category', array('slug' => $slug))->row();
        $this->db->where("FIND_IN_SET(left($category_id->post_category_id,10),category_id)>0");
        $this->db->where('publication', '1');
        $query = $this->db->get('posts');        
        return $query->num_rows();
    }
    public function fetch_blog_post_by_category($limit, $start, $slug)
    {
        $category_id = $this->db->get_where('post_category', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->where("FIND_IN_SET(left($category_id->post_category_id,10),category_id)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(10);
        $query = $this->db->get('posts');        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
    }

    public function fetch_blog_post_by_author_record_count($slug)
    {        
        $author_id = $this->db->get_where('user', array('slug' => $slug))->row();
        $this->db->where('user_id',$author_id->user_id);
        $this->db->where('publication', '1');
        $query = $this->db->get('posts');        
        return $query->num_rows();
    }
    public function fetch_blog_post_by_author($limit, $start, $slug)
    {
        $author_id = $this->db->get_where('user', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->where('user_id',$author_id->user_id);
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(10);
        $query = $this->db->get('posts');        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
    }






   
   public function search_result($search)
   {
     $this->db->like('title',$search);
     $this->db->or_like('title_en',$search);
     $query  =   $this->db->get('videos');
         return $query->result();
   }


   function get_image_url($type = '' , $id = '')
    {
        if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
            $image_url  =   base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
        else
            $image_url  =   base_url().'uploads/user.jpg';
            
        return $image_url;
    }

    // function get_video_thumb_url($videos_id = '')
    // {
    //     return file_get_contents('http://movieswatchonlinefree.com/thumbnail/get_movie_thumbnail?videos_id='.$videos_id);
    // }

    // function get_video_poster_url($videos_id = '')
    // {
    //     return file_get_contents('http://movieswatchonlinefree.com/thumbnail/get_movie_poster?videos_id='.$videos_id);
    // }

    function get_video_thumb_url($videos_id = '', $movie_title = '')
    {
        if(file_exists('uploads/video_thumb/'.$videos_id.'.jpg')){

            $image_url  =   base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
            $ch = curl_init($image_url);

             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
             curl_setopt($ch, CURLOPT_HEADER, TRUE);
             curl_setopt($ch, CURLOPT_NOBODY, TRUE);

             $data = curl_exec($ch);
             $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

             curl_close($ch);
             if ($size == "-1"){
                $url = 'http://ovoo.spagreen.net/movie-scrapper/get_movie_info_title.php?title='.urlencode($movie_title);
                $data_pre = file_get_contents($url);
                $data = json_decode($data_pre, true);
                if (isset($data['Poster']) && $data['Poster'] != "N/A"){
                    $image_url = $data['Poster'];
                } else {
                    $image_url  =   base_url().'uploads/default_image/thumbnail.jpg';
                }
            } else {
                $image_url = base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
            }
        }
        else{
            if ($movie_title != ""){
                $url = 'http://ovoo.spagreen.net/movie-scrapper/get_movie_info_title.php?title='.urlencode($movie_title);
                $data_pre = file_get_contents($url);
                $data = json_decode($data_pre, true);
                if (isset($data['Poster']) && $data['Poster'] != "N/A"){
                    $image_url = $data['Poster'];
                } else {
                    $image_url  =   base_url().'uploads/default_image/thumbnail.jpg';
                }
            } else {
                    $image_url  =   base_url().'uploads/default_image/thumbnail.jpg';
                }
            
        }
            
        return $image_url;
    }

    function get_video_poster_url($videos_id = '')
    {
        if(file_exists('uploads/poster_image/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/poster_image/'.$videos_id.'.jpg';
        else if(file_exists('uploads/video_thumb/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
        else
            $image_url  =   base_url().'uploads/default_image/poster.jpg';
            
        return $image_url;
    }

    function get_video_poster_admin_url($videos_id = '')
    {
        if(file_exists('uploads/poster_image/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/poster_image/'.$videos_id.'.jpg';
        
        else
            $image_url  =   base_url().'uploads/default_image/poster.jpg';
            
        return $image_url;
    }





   function get_name_by_id($user_id)
    {
        $query  =   $this->db->get_where('user' , array('user_id' => $user_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['name'];
    }
    

    function get_slug_by_user_id($user_id)
    {
        $query  =   $this->db->get_where('user' , array('user_id' => $user_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    function get_category_name_by_id($category_id)
    {
        $query  =   $this->db->get_where('post_category' , array('post_category_id' => $category_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['category'];
    }

    function get_slug_by_category_id($category_id)
    {
        $query  =   $this->db->get_where('post_category' , array('post_category_id' => $category_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    public function post_is_exist($slug='')
    {
        $num_rows = $this->db->get_where('posts', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    public function get_posts_by_slug($slug)
    {
        return $this->db->get_where('posts', array('slug' => $slug))->row();
    }

    public function related_posts($id='')
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where("FIND_IN_SET(left($id,10),category_id)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(2);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function create_small_thumbnail($source='', $destination='', $width='',$height=''){
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['height']   = $height;
        $config['width'] = $width;
        $config['new_image'] = $destination;//you should have write permission here..
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function get_page_details_by_slug($slug='')
    {
        return $this->db->get_where('page', array('slug' => $slug))->row();
    }

    public function page_is_exist($slug='')
    {
        $num_rows = $this->db->get_where('page', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    function get_video_title_by_id($videos_id)
    {
        $query  =   $this->db->get_where('videos' , array('videos_id' => $videos_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['title'];
    }


    function escapeString($val) {
    $db = get_instance()->db->conn_id;
    $val = mysqli_real_escape_string($db, $val);
    return $val;
    }

    function time_ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


public function grab_image($file_url,$save_to){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $file_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 140);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    $output = curl_exec($ch);
    $file = fopen($save_to, "w+");
    fputs($file, $output);
    fclose($file);
}



function get_extension($file) {
 $extension = explode(".", $file);
 $ext = end($extension);
 return $ext ? $ext : 'link';
}
function get_filtered_string($string) {
    //Lower case everything
    //$string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    //$string = preg_replace("/[^a-zA-Z]/", "", $string);
    $string = trim($string);
    $string = preg_replace("/[^ \w]+/", "", $string);
    //$string = preg_replace("/[^a-zA-Z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    //$string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    //$string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
function get_seo_url($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function get_total_episods_by_seasons_id($seasons_id){
    return count($this->db->get_where('episodes', array('seasons_id'=>$seasons_id))->result_array());
}
function get__seasons_name_by_id($seasons_id=''){
    $seasons =$this->db->get_where('seasons' , array('seasons_id'=>$seasons_id));
    if($seasons->num_rows() >0){
        return $seasons->row()->seasons_name;
    }else{
        return 'Seasons Not Found';
    }
}

function get_title_by_videos_id($videos_id=''){
    $video =$this->db->get_where('videos' , array('videos_id'=>$videos_id));
    if($video->num_rows() >0){
        return $video->row()->title;
    }else{
        return 'Title Not Found';
    }
}

function get_slug_by_videos_id($videos_id=''){
    $video =$this->db->get_where('videos' , array('videos_id'=>$videos_id));
    if($video->num_rows() >0){
        return $video->row()->slug;
    }else{
        return '';
    }
}
function get_title_by_posts_id($posts_id){
     $total = count($this->db->get_where('posts' , array('posts_id'=>$posts_id))->result_array());
     if($total > 0){
        return $this->db->get_where('posts' , array('posts_id'=>$posts_id))->row()->post_title;        
     }else{
        return "Not Found";
    }
}
}


