<?php
class Berita extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('berita/mdl_berita');  
        $this->load->library('template');     
        //check_session();
    }

    function show_berita() {                   
        $data['page'] = $this->input->get('page');
        $this->template->load('template','berita/frm_berita', $data);   
    }

    function show_berita_dtl() {             
        $data['berita_id'] = $this->input->get('berita_id');   
        $data['page'] = $this->input->get('page');      
        $this->template->load('template','berita/frm_berita_dtl',$data);   
    }

    function get_data_berita_dtl() {
        try {
            $berita_id = $this->input->get('berita_id'); 
            $data=$this->mdl_berita->get_data_berita_dtl($berita_id)->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }
    
    function get_data_berita_home() {
        try {            
            $data=$this->mdl_berita->get_data_berita_home()->result();
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;  
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

    function get_data_berita() {
        try {                 
            include 'conn.php';       
            $page = $this->input->get('page');           
            $limit = $this->input->get('limit'); 
            $offset = ((int)$page - 1) * (int)$limit;            
          
            $query="
            select  berita_id, judul_berita, deskripsi_berita, img_path, img_path_2, img_path_3, register_date            
            from    berita       
            order by register_date desc
            limit $limit offset $offset ";
                         
            $sth = mysqli_query($conn, $query);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }

            $query2="select count(*) as count from berita ";
            $result = mysqli_query($conn, $query2);
            $tot_rows =0;
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // print_r($row['count']);
                $tot_rows = $row['count'];
            }
           
            $tot_pages = ceil($tot_rows/$limit);
            //print_r($result) ;
          
            echo json_encode(array(
                'status'=>true,
                'message'=>"",
                'data'=>[$rows],                
                'page'=> $page,
                'limit'=> $limit,
                'total_page'=> $tot_pages
            ));
           
            mysqli_close($conn);
            // $data=$this->mdl_berita->get_data_tbl_berita()->result();   
            // echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>"")) ;   
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }

}
?>