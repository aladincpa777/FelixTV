<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Blog extends CI_Controller {

	public function index(){
    	$blog_enable                =   $this->db->get_where('config' , array('title'=>'blog_enable'))->row()->value;
    	if($blog_enable =='1'):
			$config = array();
			$config["base_url"] = base_url() . "blog";
			$config["total_rows"] = $this->common_model->fetch_blog_post_record_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
			$config['full_tag_close'] = '</ul></div><!--pagination-->';

			$config['first_link'] = '«';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = '»';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';

			$config['suffix']= 	'.html'; 

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$data["all_published_posts"] = $this->common_model->fetch_blog_post($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
			$data['total_rows']=$config["total_rows"];
			$data['all_published_genre']= $this->common_model->all_published_genre();
			$data['all_published_country']= $this->common_model->all_published_country();
			$data['title'] = $this->db->get_where('config' , array('title'=>'blog_title'))->row()->value;
			$data['page_name']='blog';
			$this->load->view('front_end/index',$data);
		else:
			redirect('error', 'refresh');
		endif;
	}

	public function details($slug=''){
    	$blog_enable                =   $this->db->get_where('config' , array('title'=>'blog_enable'))->row()->value;		
		$post = $this->common_model->post_is_exist($slug);
		if ($slug != '' && $slug !=NULL && $post && $blog_enable=='1'):
            $data['post_details'] = $this->common_model->get_posts_by_slug($slug);
            $data['all_published_genre'] = $this->common_model->all_published_genre();
            $data['all_published_country'] = $this->common_model->all_published_country();
            $data['page_name'] = 'blog_details';
            $data['title'] = $data['post_details']->post_title;
            $data['focus_keyword'] = $data['post_details']->focus_keyword;
            $data['meta_description'] = $data['post_details']->meta_description;
            $this->load->view('front_end/index', $data);
        else:
        	redirect('error', 'refresh');
        endif;
	}

    public function category($slug=''){
		if ($slug == '') {
            redirect('error');           
		}
		$config = array();
		$config["base_url"] = base_url() . "blog/category/".$slug;
		$config["total_rows"] = $this->common_model->fetch_blog_post_by_category_record_count($slug);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '«';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = '»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';

		$config['suffix']=      '.html'; 

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["all_published_posts"] = $this->common_model->fetch_blog_post_by_category($config["per_page"], $page, $slug);
		$data["links"] = $this->pagination->create_links();
		$data['total_rows']=$config["total_rows"];
		$data['all_published_genre']= $this->common_model->all_published_genre();
		$data['all_published_country']= $this->common_model->all_published_country();
		$data['title'] = 'Watch movies & TV-Series online';
		$data['page_name']='blog';
		$this->load->view('front_end/index',$data);
		//var_dump($data);
    }


    public function author($slug=''){
		if ($slug == '') {
            redirect('error');           
		}

		$config = array();
		$config["base_url"] = base_url() . "blog/author/".$slug;
		$config["total_rows"] = $this->common_model->fetch_blog_post_by_author_record_count($slug);
		//var_dump($config["total_rows"]);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '«';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = '»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';

		$config['suffix']=      '.html'; 

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["all_published_posts"] = $this->common_model->fetch_blog_post_by_author($config["per_page"], $page, $slug);
		$data["links"] = $this->pagination->create_links();
		$data['total_rows']=$config["total_rows"];
		$data['all_published_genre']= $this->common_model->all_published_genre();
		$data['all_published_country']= $this->common_model->all_published_country();
		$data['title'] = 'Watch movies & TV-Series online';
		$data['page_name']='blog';
		$this->load->view('front_end/index',$data);
		//var_dump($data);
    }



}