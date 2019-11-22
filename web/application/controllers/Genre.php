<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Genre extends CI_Controller {

	public function index($slug=''){
		 //
        $global_counter         =   $this->db->get_where('analytics', array('create_at' => date('Y-m-d')))->row()->counter;
        $data_g['counter'] =    $global_counter + 1;
        $this->db->where('create_at', date('Y-m-d'));
        $this->db->update('analytics', $data_g);
        //
		$genre = $this->common_model->genre_is_exist($slug);
        if ($slug !='' && $slug !=NULL && $genre) {
			$config = array();
			$config["base_url"] = base_url() . "genre/".$slug;
			$config["total_rows"] = $this->common_model->fetch_genre_video_by_slug_record_count($slug);
			$config["per_page"] = 24;
			$config["uri_segment"] = 3;
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
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["all_published_videos"] = $this->common_model->fetch_genre_video_by_slug($config["per_page"], $page, $slug);
			$data["links"] = $this->pagination->create_links();
			$data['total_rows']=$config["total_rows"];
			$data['genre_name']=$this->common_model->get_genrename_by_slug($slug);
			$data['all_published_genre']= $this->common_model->all_published_genre();
			$data['all_published_country']= $this->common_model->all_published_country();
			$data['title'] = 'Sleduj '.$this->common_model->get_genrename_by_slug($slug).' filmy & TV Seriály online';
			$data['page_name']='genre';
			$this->load->view('front_end/index',$data);
		}else{
            redirect('error', 'refresh');
        }
	}

}