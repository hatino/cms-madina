<?php
class Dashboard extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('Mdl_user');             
    }

    function index(){
        //$this->load->view('frm_dashboard');
        $this->template->load('template','system/frm_dashboard');
    }

    function show_dashboard_main(){        
	    $this->template->load('template','system/frm_dashboard_main');
    }

    function show_dashboard_admin(){                     
	    $this->template->load('template_admin','system/frm_dashboard_admin');
    }

    function show_dashboard_siswa(){        
	    $this->template->load('template_siswa','system/frm_dashboard_siswa');
    }

    function show_dashboard_ujian(){        
        if(isset($_COOKIE['cms-swi-ujian'])) {
            $status_user_login = $this->input->get('status_user_login');
            $username = $_COOKIE['cms-swi-ujian']; 
            $data['username'] = $username;         
            $data['status_user_login'] = $status_user_login;        
            $this->template->load('template_ujian','system/frm_dashboard_ujian',$data);
        }else{
             redirect('auth/login_ujian'); 	
        }
        
    }

    function get_user_menu() {
        $user_status = $this->input->get('user_status_login');
        $result = $this->Mdl_user->get_user_menu($user_status)->result();       
        echo json_encode(array("status"=>true,"data"=>$result,"message"=>"")); 
    }

     function get_user_halaman_admin() {
        //$user_status = $this->input->get('user_status_login');           
        $user_status = 'admin';
        if($user_status=='tu'){
            $result = $this->db->get_where('user_menu_halaman_admin',['status_user'=>'tu'])->result_array();   
        }else{
            $result = $this->db->get('user_menu_halaman_admin')->result_array();     
        }
        
        echo json_encode(array("status"=>true,"data"=>$result,"message"=>"")); 
    }

}