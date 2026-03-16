<?php
class Prestasi extends ci_controller{

    function __construct() {
        parent::__construct();
        $this->load->model('prestasi/Mdl_prestasi');        
    }

    function show_prestasi(){        
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');          
        $this->template->load('template','prestasi/frm_prestasi',$data); 
    }

    function get_data_prestasi() {
        try {            
            include 'conn.php';
            $kode_jenjang = $this->input->get('kode_jenjang');           
            $tahun = $this->input->get('tahun');
            if($tahun==''){
                $tahun = date("Y-m-d");
            }
            
            $query="
            select  year(tgl_prestasi) as tahun 
            from    prestasi where group_cls = '$kode_jenjang'           
            group by year(tgl_prestasi)
            order by year(tgl_prestasi) desc
            limit   5 ";
            $result = mysqli_query($conn, $query); 
            $rows_tahun = array();           
            if(mysqli_num_rows($result) > 0) {
                while($r = mysqli_fetch_assoc($result)) {
                    $rows_tahun[] = $r;
                }                
            }

            $query2="
            select  prestasi_id
                ,   group_cls
                ,   tgl_prestasi
                ,   IFNULL(nama_siswa,'') as nama_siswa
                ,   jenis_prestasi
                ,   peringkat
                ,   IFNULL(tingkat_lomba,'') as tingkat_lomba
                ,   tempat_kegiatan
                ,   img_path
            from    prestasi            
            where   year(tgl_prestasi) = '$tahun' 
            and     group_cls = '$kode_jenjang'  
            order   by tgl_prestasi desc ";
                         
            $sth = mysqli_query($conn, $query2);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }
    
            //print_r($result) ;
            
            //echo json_encode(array('status'=>true, 'data'=>[$rows], 'message'=>""));
            echo json_encode(array(
                'status'=>true,
                'message'=>"",
                'data'=>[$rows],                
                'data_tahun'=> [$rows_tahun]                
            ));
           
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }    
    }
    
    function get_data_prestasi_home() {
        try {
            $data = $this->Mdl_prestasi->get_data_prestasi_home()->result();           
            echo json_encode(array('status'=>true, 'data'=>$data, 'message'=>""));
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }

}
?>