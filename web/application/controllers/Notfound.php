<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Notfound extends CI_Controller{
	function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->database();

        //cache controling
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        
    }
    
    public function index(){
        $data['all_published_genre']= $this->common_model->all_published_genre();
        $data['all_published_country']= $this->common_model->all_published_country();
        $data['title'] = 'Stránka nebyla nalezena';
        $data['page_name']='404';
        $this->load->view('front_end/index',$data);
    }
}

