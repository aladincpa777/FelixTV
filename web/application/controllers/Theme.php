<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Theme extends CI_Controller{   
    
	function __construct(){
			parent::__construct();
			$this->load->database();
		
       		/*cache controling*/
			$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
    }
    
    /*default index function, redirects to login/dashboard */
    public function index(){
        if ($this->session->userdata('user_id') == '')
            redirect(base_url() . 'index.php?login', 'refresh');        
    }
    function change($param1='' , $param2=''){
        $user_id =$this->session->userdata('user_id');
        $login_type =$this->session->userdata('login_type');
        if ($user_id == '')
            redirect(base_url() . 'index.php?login', 'refresh');
        if($param1=='add'){
            ;
            $data['theme_color'] = $this->input->post('color');
            $this->db->where('user_id' , $user_id);
            $this->db->update('user' , $data);
            redirect(base_url() . 'index.php?'.$login_type.'/manage_theme', 'refresh'); 
        }
        else{
            //var_dump($param1);
            $data['theme_color'] = '#'.$param1;
            $this->db->where('user_id' , $user_id);
            $this->db->update('user' , $data);
            redirect(base_url() . 'index.php?'.$login_type.'/manage_theme', 'refresh');  
        }

    }
}
?>