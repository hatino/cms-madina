<?php
require FCPATH.'vendor/autoload.php';
        
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pelajaran_admin extends ci_controller{

    function __construct() {
        parent::__construct();      
        $this->load->model('pelajaran/mdl_pelajaran');       
        check_session();
    }

    function show_pelajaran_adm() {   
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');  
        $this->template->load('template_admin','pelajaran/frm_pelajaran_adm',$data); 
    }

    function show_upload_pelajaran() {
        $data['kode_jenjang'] = $this->input->get('kode_jenjang');  
        $this->template->load('template_admin','pelajaran/frm_upload_pelajaran',$data); 
    }
    
    function get_data_tbl_pelajaran() {
        try {
            $kode_jenjang = $this->input->get('kode_jenjang');
            $data = $this->mdl_pelajaran->get_data_pelajaran($kode_jenjang)->result();
            $data2 = $this->mdl_pelajaran->get_data_tbl_pelajaran($kode_jenjang)->result();

            echo json_encode(array('status'=>true, 'data'=>[$data], 'data2'=>[$data2], 'message'=>"")) ; 
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }
    }

    function get_data_tbl_pelajaran_api() {
        $kode_jenjang = $this->input->get('kode_jenjang');
        //$url = "https://localhost/cms-swi/index.php/pelajaran/pelajaran_admin/get_data_tbl_pelajaran?kode_jenjang=".$kode_jenjang;
        $url = "https://www.swiislamicschool.sch.id/cms-swi/index.php/pelajaran/pelajaran_admin/get_data_tbl_pelajaran?kode_jenjang=".$kode_jenjang;

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

    function simpan_import_pelajaran(){
        try {
        
            $data = json_decode(file_get_contents("php://input"), true);
            date_default_timezone_set('Asia/Jakarta');
            //var_dump($data);
            //exit();
            $data_rows =  count($data['data'][0]);
           
            if ($data_rows > 0) {
                $jenjang =  $data['data'][0][0]['group_cls'];                
                $this->db->delete('pelajaran', ['group_cls'=> $jenjang]);

                $insert_arr_mst = array(
                    'group_cls' => $jenjang,
                    'pelajaran' => $data['data'][0][0]['pelajaran'],
                    'register_user' => '',
                    'register_date' => date('Y-m-d H:i:s'),
                    'update_user' => '',
                    'update_date' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('pelajaran', $insert_arr_mst);
            }

            //exit();
            $jenjang = $data['data2'][0][0]['group_cls']; 
            $this->db->delete('upload_mata_pelajaran', ['group_cls'=> $jenjang]);

            foreach ($data['data2'][0] as $row) {         
                $insert_arr_dtl = array(
                    'group_cls' => $row['group_cls'],
                    'kelompok_mapel' => $row['kelompok_mapel'],               
                    'nama_pelajaran' => $row['nama_pelajaran'],
                    'no_urut' => $row['no_urut'],
                    'register_user' => '',
                    'register_date' => date('Y-m-d H:i:s'),
                    'update_user' => '',
                    'update_date' => date('Y-m-d H:i:s'),
                    'kelas' => $row['kelas']
                );
                $this->db->insert('upload_mata_pelajaran', $insert_arr_dtl);
            }

            echo json_encode(array('status'=>true, 'data'=>'', 'message'=>"Simpan berhasil")) ;
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }

    }
    
    function simpan_pelajaran_admin(){
        try {                            
                include 'conn.php';
                $username = $this->session->userdata('username');                
                $pelajaran = $this->input->post('txt_pelajaran'); 
                $kode_jenjang = $this->input->post('txt_kode_jenjang'); 
                                    
                $sql ="CALL sp_simpan_pelajaran(     
                    '$kode_jenjang',               
                    '$pelajaran',                          
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

    function simpan_upload_pelajaran() {
        try {                            
            include 'conn.php';
            $username = $this->session->userdata('username'); 
            $data = $this->input->post('data');            
            $data_arr[] = json_decode($data);          
            $data1 = $data_arr[0];           
                       
            $conn->autocommit(FALSE);
            foreach($data1 as $key => $value)
            {
                $stdArray[$key] = (array) $value;  
                $no = $stdArray[$key]['no'];  
                $unit_sekolah = $stdArray[$key]['unit_sekolah'];   
                $kelas = $stdArray[$key]['kelas'];
                $kelompok_mapel = $stdArray[$key]['kelompok_mapel'];
                $nama_pelajaran = $stdArray[$key]['nama_pelajaran'];      
                                
                $sql ="CALL sp_simpan_upload_pelajaran(     
                    '$unit_sekolah',               
                    '$no', 
                    '$kelas',
                    '$kelompok_mapel',
                    '$nama_pelajaran',
                    '$username')";

                // print_r($sql);
              
                if (mysqli_query($conn, $sql)) {
                    $rows = mysqli_affected_rows($conn); 
                }else {
                    $err_code = mysqli_errno($conn);
                    if($err_code==1062){
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
                    }
                    else{
                        echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                            	
                    }            
                }                          
            }                              
            $conn->commit();
			$conn->autocommit(TRUE);

            mysqli_close($conn);
            if($rows>0){        
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data sukses'));
            }else{
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Simpan data tidak berhasil'));
            }            
           
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>"", 'message'=>$e->errorMessage())) ;
        }
    }
    
    function delete_pelajaran() {
        include 'conn.php';
        $kode_jenjang = $this->input->post('kode_jenjang');
        $pelajaran = $this->input->post('pelajaran');
        $kelas = $this->input->post('kelas');

        $query ="
        delete  from upload_mata_pelajaran       
        where   group_cls = '$kode_jenjang'
        and     nama_pelajaran = '$pelajaran'
        and     kelas = '$kelas'
        ";
        // print_r($query);
        
        if (mysqli_query($conn, $query)) {
            $rows = mysqli_affected_rows($conn);                
            if($rows>0){        
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data sukses'));               
            }else{
                echo json_encode(array('status'=>true,'data'=>'', 'message'=>'Hapus data tidak berhasil'));
            }                
        } 
        else{
            $err_code = mysqli_errno($conn);
            if($err_code==1062){
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Data Sudah Ada"));
            }else{
                echo json_encode(array("status"=>false,"data"=>"","message"=>"Error description: [" . mysqli_errno($conn) . "] " . mysqli_error($conn)));                 
            }            
        }    
    }

    function proses_upload_file_pelajaran() {
        $upload_file = $_FILES['file_pelajaran']['name'];
        $extension = pathinfo($upload_file,PATHINFO_EXTENSION);
        if($extension=='xls'){
            $reader= new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }else if($extension=='xlsx'){           
            $reader= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();            
        }
        
        $spreadsheet=$reader->load($_FILES['file_pelajaran']['tmp_name']);
        $sheetdata=$spreadsheet->getActiveSheet()->toArray();
        // echo '<pre>';
        // print_r($sheetdata);
        echo json_encode(array('status'=>true, 'data'=>[$sheetdata], 'message'=>"")) ;  
    }

    function cek_upload_pelajaran_exists() {
        try {
            $unit_sekolah = $this->input->get('unit_sekolah');
            $kelas = $this->input->get('kelas');
            $nama_pelajaran = $this->input->get('nama_pelajaran');
           
            $data = $this->mdl_pelajaran->cek_upload_pelajaran_exists($unit_sekolah, $kelas, $nama_pelajaran)->result();           
            echo json_encode(array('status'=>true, 'data'=>[$data], 'message'=>"")) ; 
            
        } catch (customException $e) {
            echo json_encode(array('status'=>false, 'data'=>$data, 'message'=>$e->errorMessage())) ;
        }
    }

    function generateXls_siswa_baru_template(){      

        header('Content-Type:application/vnd.ms-excel');        
        header('Content-Disposition:attachment; filename="template_siswa_baru.xlsx" ');
        header('Content-Transfer-Encoding: binary');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO.');
        $sheet->setCellValue('B1', 'KODE TAHUN AJARAN');
        $sheet->setCellValue('C1', 'UNIT SEKOLAH');
        $sheet->setCellValue('D1', 'NIS');
        $sheet->setCellValue('E1', 'NAMA');
        $sheet->setCellValue('F1', 'ALAMAT');
                       
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // foreach (range('A','D') as $col) {    
        //     $sheet->getColumnDimension($col)->setAutoSize(true);
        // }        
       
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
             
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C0C0C0');

        $writer = new Xlsx($spreadsheet);
        //$writer->save(FCPATH.'uploads/Data karyawan.xlsx');
        $writer->save("php://output");
        exit;
        //echo "<script>window.location = 'Data karyawan.xlsx'</script>";
    }

}