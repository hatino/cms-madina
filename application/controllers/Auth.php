<?php

use SebastianBergmann\Environment\Console;

class Auth extends ci_controller{

    function __construct(){
        parent::__construct();
        $this->load->model('mdl_user');
    }

    function login() 
    {              
        if(isset($_POST['username']))
        {           
            $user_name = $this->input->post('username');
            $password = $this->input->post('password');
            $hasil = $this->mdl_user->login($user_name,$password);
            //echo $hasil;
            if($hasil==1){
            //if($hasil!=-1){
                $sid = 'cms-mdn-user';                
                $this->session->set_userdata(array('status_login'=>'OK', 'user_name'=>$user_name));                                
                setcookie($sid, $user_name, time() + (86400), "/"); // 86400 = 1 day
                $session_exists = $this->mdl_user->check_session_exists($user_name,$sid);                
                $rows_affected = $this->mdl_user->simpan_data_session_login($user_name, $session_exists, $sid);

                echo json_encode(array('status'=>true, 'data'=>$hasil, 'message'=>"")); 
                //redirect('/dashboard/show_dashboard_admin');
            }else{   
                // $data['pesan'] ='user id atau password tidak ditemukan';
                // $this->load->view('frm_login',$data);
                 echo json_encode(array('status'=>false, 'data'=>$hasil, 'message'=>"user id atau password tidak ditemukan")); 
            }            
            
        }else{            
            $data['pesan'] = "";
            //$this->load->view('frm_login',$data);
            $this->template->load('template','frm_login',$data);  
        }        
    }

    function login_ujian(){      
        if(isset($_POST['username'])){           
            $user_name = $this->input->post('username');
            $password = $this->input->post('password');
            $status_user = $this->input->post('status_user_login');
            $hasil = $this->mdl_user->login_ujian($user_name,$password,$status_user);     
           
            if($hasil>-1){            
                $sid = 'cms-swi-ujian';
                $status = 'status-user';
                $this->session->set_userdata(array('status_login'=>'OK', 'user_name'=>$user_name));
                //redirect('dashboard');
                setcookie($sid, $user_name, time() + (86400), "/"); // 86400 = 1 day
                setcookie($status, $status_user, time() + (86400), "/"); // 86400 = 1 day
                $session_exists = $this->mdl_user->check_session_exists($user_name,$sid); 
                $rows_status_affected = $this->mdl_user->simpan_data_status_user_login($user_name, $sid, $status_user);               
                $rows_affected = $this->mdl_user->simpan_data_session_login($user_name, $session_exists, $sid);

                echo json_encode(array('status'=>true, 'data'=>$hasil, 'message'=>"")); 
                //redirect('/dashboard/show_dashboard_admin');
            }else{   
                // $data['pesan'] ='user id atau password tidak ditemukan';
                // $this->load->view('frm_login',$data);
                 echo json_encode(array('status'=>false, 'data'=>$hasil, 'message'=>"User name/password tidak ditemukan")); 
            }  
        }else{            
            //$data['pesan'] = "";
            $this->load->view('system/frm_pre_login_ujian');
            //$this->template->load('template','frm_pre_login_ujian',$data);  
        }        
    }

    function pre_login_ujian(){        
            $data['pesan'] = "";
            //$this->load->view('frm_login',$data);
            $this->load->view('system/frm_pre_login_ujian');
    }
   
    function logout()
    {
        $this->session->sess_destroy();

        if(isset($_COOKIE['cms-mdn-user'])) {
            $sid = 'cms-mdn-user';
            $user_name = $_COOKIE['cms-mdn-user'];           
            $session_exists = $this->mdl_user->check_session_exists($user_name, $sid);
            $rows_affected = $this->mdl_user->simpan_data_session_logout($user_name, $session_exists, $sid);

            setcookie('cms-mdn-user', '', time() - 3600, "/");
            //setcookie('status-user-cms', '', time() - 3600, "/");
        }         
        redirect('auth/login');        
    }

    function logout_ujian()
    {
        $this->session->sess_destroy();

        if(isset($_COOKIE['cms-swi-ujian'])) {
            $sid = 'cms-swi-ujian';
            $user_name = $_COOKIE['cms-swi-ujian'];
            $session_exists = $this->mdl_user->check_session_exists($user_name, $sid);
            $rows_affected = $this->mdl_user->simpan_data_session_logout($user_name, $session_exists, $sid);

            setcookie('cms-swi-ujian', '', time() - 3600, "/");
            setcookie('status-user', '', time() - 3600, "/");
        }         
        redirect('auth/login_ujian');        
    }

    function set_user_status(){
        $status_user = $this->input->post('status_user_login');
        echo $status_user;
        setcookie('status-user-cms', $status_user, time() + (86400), "/"); // 86400 = 1 day
        echo json_encode(array('status'=>true, 'data'=>"", 'message'=>"status sudah disimpan")); 
    }   
}