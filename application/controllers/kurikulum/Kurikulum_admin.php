
<?php
class Kurikulum_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('kurikulum/Mdl_kurikulum'); 
        check_session();
    }

    function show_kurikulum_admin() {            
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');   
        $this->template->load('template_admin','kurikulum/frm_kurikulum_admin', $data);   
    }

    function simpan_kurikulum(){        
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username');                     
            $_kode_jenjang = $this->input->post('_kode_jenjang');
            $penjelasan = $this->input->post('txt_penjelasan');
            $sistem_pembelajaran = $this->input->post('txt_sistem_pembelajaran');
            $uploaded_img_kurikulum_path = $this->input->post('uploaded_img_kurikulum_path'); 
            
            $sql ="CALL sp_simpan_kurikulum(
                    '$_kode_jenjang',
                    '$penjelasan',
                    '$sistem_pembelajaran',
                    '$uploaded_img_kurikulum_path',                   
                    '$username')";                              
                    
            if (mysqli_query($conn, $sql)) {
                $rows = mysqli_affected_rows($conn);                
                if($rows>0){                    
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
                }else{
                    echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
                }                
            } 
            else 
            {
                $err_code = mysqli_errno($conn);
                if($err_code==1062)
                {
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                }
                else{
                    echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));
                    //echo("Error description: " . mysqli_error($conn));            	
                }            
            }
           
            mysqli_close($conn);
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }


    function get_data_kurikulum_api() {
        $kode_jenjang = $this->input->get('kode_jenjang');
        //$url = "https://localhost/cms-swi/index.php/kurikulum/kurikulum/get_data_kurikulum?kode_jenjang=".$kode_jenjang;
        $url = "https://www.swiislamicschool.sch.id/cms-swi/index.php/kurikulum/kurikulum/get_data_kurikulum?kode_jenjang=".$kode_jenjang;

        $options = [
            "http" => [
                "method" => "GET",
                "header" => 
                    "Content-Type: application/json\r\n".
                    "Authorization: Bearer 123456\r\n".
                    "Cookie: cms-swi-user=guru\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        echo $response;
        
    }

    function simpan_import_kurikulum(){
        try {
        
            $data = json_decode(file_get_contents("php://input"), true);
            date_default_timezone_set('Asia/Jakarta');
            //var_dump($data);
                      
            $jenjang =  $data['data'][0][0]['group_cls'];        
            //echo $jenjang;    
            //exit();    
            
            $this->db->where('group_cls', $jenjang);
            $query = $this->db->get('kurikulum');
            $result = $query->result();
            //var_dump($result);
            $num_rows = $query->num_rows();

            if($num_rows > 0){
                $update_arr = array(                    
                    'penjelasan' => $data['data'][0][0]['penjelasan'],
                    'sistem_pembelajaran_nilai' => $data['data'][0][0]['sistem_pembelajaran_nilai'],                   
                    'update_user' => '',
                    'update_date' => date('Y-m-d H:i:s')
                );
                $this->db->update('kurikulum', $update_arr, ['group_cls' => $jenjang]);        

            }else{
                $insert_arr = array(
                    'group_cls' => $jenjang,
                    'penjelasan' => $data['data'][0][0]['penjelasan'],
                    'sistem_pembelajaran_nilai' => $data['data'][0][0]['sistem_pembelajaran_nilai'],
                    'register_user' => '',
                    'register_date' => date('Y-m-d H:i:s'),
                    'update_user' => '',
                    'update_date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('kurikulum', $insert_arr);                
            }
            
            echo json_encode(array('status'=>true, 'data'=>'', 'message'=>"Simpan berhasil")) ;
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }

    }


}
?>