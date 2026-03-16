<?php

function check_session()
{
	// $CI= & get_instance();
	// $session=$CI->session->userdata('status_login');
	// IF($session!='OK')
	// {
	// 	redirect('auth/login');
	// }

	if(!isset($_COOKIE['cms-mdn-user'])) {
		// $data['pesan'] = "";            
		// $this->template->load('template','frm_login',$data); 
		redirect('auth/login'); 		
	} 

}

function check_session_ujian() {
	if(!isset($_COOKIE['cms-swi-ujian'])) {
		// $data['pesan'] = "";            
		// $this->template->load('template','frm_login',$data); 
		redirect('auth/pre_login_ujian'); 		
	} 
}

function get_session()
{
	$CI= & get_instance();
	$session=$CI->session->userdata('user_name');		
	return $session;
}

?>