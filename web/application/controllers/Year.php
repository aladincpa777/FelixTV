<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

class Year extends CI_Controller {

	public function index(){
                
}
public function find($param1=''){
        if($param1 !=''  || $param1!=NULL){                     
                $year=str_replace("%20"," ",$param1);
                $config = array();
                $config["base_url"] = base_url() . "year/".$year;
                $config["total_rows"] = $this->common_model->get_video_by_year_record_count($year);
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

                $config['suffix']=        '.html'; 

                $this->pagination->initialize($config);
                $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;      
                $data["all_published_videos"] = $this->common_model->get_video_by_year($config["per_page"], $page, $year);
                $data["links"] = $this->pagination->create_links();
                $data['total_rows']=$config["total_rows"];
                $data['year']=$year;
                $data['all_published_genre']= $this->common_model->all_published_genre();
                $data['all_published_country']= $this->common_model->all_published_country();
                $data['title'] = "Sleduj filmy a seriály z roku ".$year. " online";
                $data['page_name']='year';
                $this->load->view('front_end/index',$data);
        }
        else{
                $data['title'] = "Search movie by year";
                $data['page_name']='years';
                $this->load->view('front_end/index',$data);    
        }
}

}