<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
   
</head>
<body onload="init_form()">   
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>
        <h3 class="text-header fw-bold mb-1">Daftar Calon Siswa - <a id="nama_jenjang_div"></a></h3>
        <hr style="margin-top: 1px;">

        <table class="table table-sm"  style="margin-bottom:5px;">
            <tr class="borderless-top borderless-bottom">
                <td width="140">
                    <label for="div_list_thn_ajaran" class="col-sm col-form-label col-form-label-sm">Tahun Ajaran</label> 
                </td>
                <td>
                    <div class="input-group-sm col-sm-8">
                    <div class="input-group input-group-sm">                    
                        <div class="input-group input-group-sm col-sm-10" name="div_list_thn_ajaran" id="div_list_thn_ajaran"></div>                                                                
                    </div> 
                    </div>  
                </td>    
            </tr>
        </table>

        <div class="tscroll">
            <div id="tbl_daftar_calon_siswa_div" class="table-responsive table-height"></div>
        </div>   
        
        <div style="line-height: 5px;">
        <br >
        </div>
        <button type="button" class="btn btn-success btn-sm btn-shadow" id="btnExcel">
        <img src="<?php echo base_url() ?>/images/images_ui/XLS-icon.png" alt="" width='20' height='20'  style="cursor: pointer;"> Eksport to Excel
        </button>
    </div>

</body>
</html>

<script type="text/javascript">

    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'
        // var nama_jenjang = '';
        // if(kode_jenjang=='RA'){
        //     nama_jenjang = 'RA/TK'
        // }else{
        //     if (kode_jenjang=='MI'){
        //         nama_jenjang = 'MI/SD'
        //     }else{
        //         if(kode_jenjang=='SMPIT'){
        //             nama_jenjang = 'SMPIT'
        //         }
        //     }
        // }
        document.getElementById('nama_jenjang_div').innerHTML = kode_jenjang;
        await load_list_thn_ajaran(kode_jenjang)
        await fetch_tbl_daftar_calon_siswa()         
    }

    $(document).on('change', '#list_thn_ajaran', async function () {        
        await fetch_tbl_daftar_calon_siswa()
    })

    async function load_list_thn_ajaran(kode_jenjang) 
	{		        
		await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_thn_ajaran_with_status_open') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                      
            var data = responseData.data[0]
			var html = '';
				html += '<select name="list_thn_ajaran" id="list_thn_ajaran" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++){
                if(data[count].status_open=='1'){
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'" selected>'+data[count].thn_ajaran_nama+ '</option>';
                }else{
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'">'+data[count].thn_ajaran_nama+ '</option>';
                }				
			}							
				html += '</select>'
			document.getElementById('div_list_thn_ajaran').innerHTML = html;	
		});     	
	}   
    

    function fetch_tbl_daftar_calon_siswa() {          
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
              
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_tbl_daftar_calon_siswa') ;?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'')
        .then(function(response) {
            return response.json();
        }).then(function (responseData) {            
            if (responseData.status==true){
                load_tbl_daftar_calon_siswa(responseData.data[0])
                return true;
            }else{
                alert(responseData.message);
                return false;
            }
                        
        }).catch(function(error) {
            alert(error)
        })    
    }

    function load_tbl_daftar_calon_siswa(data) {        
        var html = '';           
    
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_daftar_calon_siswa">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th></th>';                                    
        html += '			<th>Siswa ID</th>';
        html += '			<th>No Pendaftaran</th>';
        html += '			<th>Siswa Baru/Pindahan</th>';
        html += '			<th>Kelas</th>';
        html += '			<th>NISN</th>';
        html += '			<th>Nama Lengkap</th>';     
        html += '			<th>Nama Panggilan</th>';  
        html += '			<th>Tempat & Tgl Lahir</th>';     
        html += '			<th>Jenis Kelamin</th>';
        html += '			<th>Anak Ke</th>';     
        html += '			<th>Jml Saudara</th>';     
        html += '			<th>Golongan Darah</th>';
        html += '			<th>No. HP</th>';
        html += '			<th>Alamat</th>';
        html += '			<th>Nama Sekolah Asal</th>';
        html += '			<th>Alamat Sekolah Asal</th>';        
        html += '           <th>Berat Badan</th>';
        html += '           <th>Tinggi Badan</th>';
        html += '           <th>Sifat</th>';
        html += '           <th>Anak Inklusi</th>';
        html += '           <th>Membayar Biaya Inklusi</th>';      
        html += '           <th>Nama Ayah</th>';
        html += '           <th>Tempat & Tgl Lahir Ayah</th>';
        html += '			<th>Agama Ayah</th>';
        html += '           <th>Pendidikan Ayah</th>';
        html += '           <th>Pekerjaan Ayah</th>';      
        html += '           <th>Nama Ibu</th>';
        html += '           <th>Tempat & Tgl Lahir Ibu</th>';
        html += '			<th>Agama Ibu</th>';          
        html += '           <th>Pendidikan Ibu</th>';
        html += '           <th>Pekerjaan Ibu</th>';        
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            html += '<tbody>';         
            for(var count = 0; count < data.length; count++)
            {     
                html += '<tr class = "col-form-label-sm text-nowrap" id="'+ count +'">';
                html += '   <td style="min-width:25pt; text-align:center; cursor: pointer" title="Klik untuk lihat detail"><i style = "color:purple;" class="bi bi-display detail"></i></td>';  //0
                html += '   <td style="min-width:30pt">'+data[count].siswa_id+'</td>';  //1
                html += '   <td style="min-width:30pt">'+data[count].no_pendaftaran+'</td>';  //2   
                html += '   <td style="min-width:30pt">'+data[count].jenis_pendaftaran+'</td>';  //3 
                html += '   <td style="min-width:30pt">'+data[count].kelas_cls+'</td>';  //4
                html += '   <td style="min-width:30pt">'+data[count].nisn+'</td>';  //5                      
                html += '   <td style="max-width:200pt">'+data[count].nama+'</td>';  //6                   
                html += '   <td>'+data[count].nama_panggilan+'</td>';  //7
                html += '   <td>'+data[count].tempat_lahir+ ', '+ data[count].tgl_lahir+'</td>';  //8
                html += '   <td>'+data[count].jenis_kelamin+'</td>';  //9
                html += '   <td>'+data[count].anak_ke+'</td>';  //10
                html += '   <td>'+data[count].jml_saudara+'</td>';  //11
                html += '   <td>'+data[count].golongan_darah+'</td>';  //12   
                html += '   <td>'+data[count].no_hp+'</td>';  //13
                html += '   <td>'+data[count].alamat+'</td>';  //14   
                html += '   <td>'+data[count].nama_sekolah_asal+'</td>'; //15
                html += '   <td>'+data[count].alamat_sekolah_asal+'</td>'; //16
                html += '   <td>'+data[count].berat_badan+'</td>'; //17
                html += '   <td>'+data[count].tinggi_badan+'</td>'; //18
                html += '   <td>'+data[count].sifat+'</td>'; //19
                html += '   <td>'+data[count].status_anak_inklusi+'</td>'; //20
                html += '   <td>'+data[count].status_bayar_biaya_inklusi+'</td>'; //21     
                html += '   <td>'+data[count].nama_ayah+'</td>'; //22
                html += '   <td>'+data[count].tempat_lahir_ayah+', '+data[count].tgl_lahir_ayah+'</td>'; //23
                html += '   <td>'+data[count].agama_ayah+'</td>'; //24
                html += '   <td>'+data[count].pendidikan_ayah+'</td>'; //25
                html += '   <td>'+data[count].pekerjaan_ayah+'</td>';  //26            
                html += '   <td>'+data[count].nama_ibu+'</td>';  //27
                html += '   <td>'+data[count].tempat_lahir_ibu+', '+data[count].tgl_lahir_ibu+'</td>'; //28
                html += '   <td>'+data[count].agama_ibu+'</td>'; //29
                html += '   <td>'+data[count].pendidikan_ibu+'</td>'; //30
                html += '   <td>'+data[count].pekerjaan_ibu+'</td>';  //31             
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }         
        
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_daftar_calon_siswa_div").innerHTML = html;  

    }


    $(document).on('click', '.detail', function () {       
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_daftar_calon_siswa")
        var siswa_id =  tbl.rows[row_index].cells[1].innerHTML;  
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran_admin/show_siswa_detail') ;?>?siswa_id="+siswa_id+"&kode_jenjang="+kode_jenjang+" "
    })

    $(document).on('click', '#btnExcel', function () {
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran_admin/generateXls_daftar_calon_siswa') ;?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+" "
         
    })

</script>