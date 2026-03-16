<?php
class Kegiatan extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('kegiatan/mdl_kegiatan');       
        //check_session();
    }

    function show_kegiatan() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template','kegiatan/frm_kegiatan',$data);   
    }

    function get_data_kegiatan() {
        try {            
            include 'conn.php';
            $kode_jenjang = $this->input->get('kode_jenjang');
            //$kode_jenjang = 'RA';
            $page = $this->input->get('page');
            $limit = $this->input->get('limit');
            $offset = ($page - 1) * $limit;
            
            $query="
            select kg.kegiatan_id, kg.nama_kegiatan, kg.tgl_kegiatan, kg.deskripsi, kg.img_path, us.nama 
            from   kegiatan kg
            left join  profil_unit_sekolah us
            on     kg.group_cls = us.group_cls
            where  kg.group_cls = '$kode_jenjang' limit $limit offset $offset ";
                         
            $sth = mysqli_query($conn, $query);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }

            $query2="select count(*) as count from kegiatan where group_cls = '$kode_jenjang' ";
            $result = mysqli_query($conn, $query2);
            $tot_rows =0;
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // print_r($row['count']);
                $tot_rows = $row['count'];
            }

           
            $tot_pages = ceil($tot_rows/$limit);
            //print_r($result) ;
            //print_r($tot_pages);

            
            //echo json_encode(array('status'=>true, 'data'=>[$rows], 'message'=>""));
            echo json_encode(array(
                'status'=>true,
                'message'=>"",
                'data'=>[$rows],                
                'page'=> $page,
                'limit'=> $limit,
                'total_page'=> $tot_pages
            ));
           
            mysqli_close($conn);
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
}
?>