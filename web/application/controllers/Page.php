<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 
class Page extends CI_Controller{
    
    public function index($slug=''){
    	$page = $this->common_model->page_is_exist($slug);
        if ($slug !='' && $slug !=NULL && $page) {
            $data['page_details']= $this->common_model->get_page_details_by_slug($slug);
            $data['title'] = $data['page_details']->page_title;
            $data['focus_keyword'] = $data['page_details']->focus_keyword;
            $data['meta_description'] = $data['page_details']->meta_description;
            $data['page_name']='page';
            $this->load->view('front_end/index',$data);        
        }else{
            redirect('error', 'refresh');
        }
    }

    public function about_us(){
        $data['title'] = 'About us';
        $data['page_name']='about';
        $this->load->view('front_end/index',$data);
    }
}

