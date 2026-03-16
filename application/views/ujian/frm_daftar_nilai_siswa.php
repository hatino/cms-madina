<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body onload="init_form()"></body>    

    <div class="gradient-over-image">     
        <h3 class="text-light text-shadow-black"><span id="jenis_penilaian"></h3>          
        <h5 class="text-info text-shadow-black"><span id="deskripsi_thnajaran"></h5>
        <h5 class="text-warning"><span id="semester"></h5>        
        <h5 class="text-light"><span id="nama_siswa"></h5>       
    </div>
    
    <div class="container mt-4"> 
        <button type="button" id="btn_kembali" class="btn btn-sm btn-dark btn-shadow"><i class="bi bi-back"></i>&nbsp;Kembali</button>  
        <div style="line-height: 10px;"><br> </div>     
        <div class="tscroll">
            <div id="tbl_daftar_nilai_siswa_div" class="table-responsive table-height"></div>       
        </div>
    </div>

    <footer style="margin-top: 60px;"></footer>
    
</body>
</html>

<script type="text/javascript">    
    var user_id = '<?php echo $username ;?>'
    var status_user = '<?php echo $status_user ;?>'
    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>'
        
    function init_form() {
        document.getElementById('jenis_penilaian').innerHTML = 'Daftar Nilai ' + jenis_penilaian.toLocaleUpperCase();
        document.getElementById('semester').innerHTML = 'Semester '+semester
        
        get_data_header()
        fetch_tbl_daftar_nilai()
    }

    async function get_data_header() {
        var rs_thnajaran = await fetch('<?php echo site_url('ujian/master/get_thnajaran') ; ?>?thnajaran='+thnajaran+'', {method:"GET", mode: "no-cors" })
        var rs = await rs_thnajaran.json()
        var thnajaran_name = ''
        if (rs.data.length>0){
            thnajaran_name = rs.data[0].deskripsi
        }
        document.getElementById('deskripsi_thnajaran').innerHTML = thnajaran_name

        var rs_nama_siswa = await fetch('<?php echo site_url('ujian/master/get_nama_siswa') ; ?>?nis='+user_id+'', {method:"GET", mode: "no-cors" })
        var rs_nama = await rs_nama_siswa.json()
        var nama_siswa = ''       
        if (rs_nama.data.length>0){
            nama_siswa = rs_nama.data[0].nama
        }
        document.getElementById('nama_siswa').innerHTML = nama_siswa        
    }

    function fetch_tbl_daftar_nilai() {       
        var params = new URLSearchParams()
        params.append('thnajaran',thnajaran)
        params.append('semester',semester)
        params.append('jenis_penilaian',jenis_penilaian)
        params.append('nis', user_id)
                
        fetch('<?php echo site_url('ujian/daftar_nilai/get_tbl_daftar_nilai_siswa');?>?'+params.toString()+'')
        .then(function(response){
            return response.json();    
        }).then( function (responseData){  
            console.log(responseData.data)
            load_tbl_daftar_nilai(responseData.data); 
        });            
    }

    function load_tbl_daftar_nilai(data) {        
        var html = '';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_bank_soal">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No</th>';
        html += '			<th>Kode Mata pelajaran</th>';  
        html += '			<th>Nama Mata pelajaran</th>';        
        html += '			<th>Nilai</th>';       
        html += '		</tr>';       		
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            var no=0
            html += '<tbody class="col-form-label-sm">';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr id="'+ no +'">';                
                html += '   <td width="40pt" style="vertical-align: middle; min-width:50pt; text-align:center;">'+no+'</td>';//0
                html += '   <td style="vertical-align: middle; max-width:80pt;" class="text-nowrap">'+data[count].matapel_cls+'</td>';  //1
                html += '   <td style="vertical-align: middle;" class="text-nowrap">'+data[count].deskripsi+'</td>';//2               
                
                if(data[count].nilai==null){
                    html += '   <td style="vertical-align: middle; min-width:100pt; text-align:center;"></td>';//5                                      
                }else{
                    html += '   <td style="vertical-align: middle; min-width:100pt; text-align:center;">'+Math.trunc(data[count].nilai)+'</td>';//5                                      
                }          
                
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';
                                
        document.getElementById("tbl_daftar_nilai_siswa_div").innerHTML = html;  
        //document.getElementById("tbl_bank_soal_div").style.height = "550px";       
    }

    $(document).on('click', '#btn_kembali', function () {        
        //history.back()  
        window.location.href="<?php echo site_url("dashboard/show_dashboard_ujian") ?>?status_user_login="+status_user+" "                                       
    })

</script>

<style>
     .gradient-over-image {
        background-color: #0d3d57;
        width: 100%;
        height: 260px;
        margin: 0px auto;
        padding-top: 80px;
        color: white; /* Biar tulisan kelihatan */
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);

        /* --- Lapisan Background --- */
        background-image:
            /* 1. Lapisan Gradien (harus transparan agar pola di bawahnya terlihat) */            
            /*linear-gradient(to right, rgba(189, 97, 81, 0.7), rgba(175, 33, 23, 0.7)),*/ /* Pink ke Biru Langit, dengan transparansi 70% */
            /* 2. Lapisan Pola Gambar (ini di bawah gradien) */
            url('http://www.transparenttextures.com/patterns/gray-floral.png'); /* Contoh URL pola, ganti dengan milikmu */

        background-size:
            auto,          /* Gradien akan mengisi penuh area */
            100px 100px;   /* Ukuran satu unit pola gambar (sesuaikan) */

        background-repeat:
            /*no-repeat,*/     /* Gradien tidak perlu diulang */
            repeat;        /* Pola gambar akan diulang */

        /* Opsional: Mode pencampuran warna antar lapisan */
        background-blend-mode: overlay; /* Coba juga 'multiply' atau 'screen' */
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
</style>