<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>     
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">
       
        <div style="line-height: 25px;"><br></div> 
        <?php if ( $form_id =="admin_form") { ?>
            <h3 class="text-header fw-bold">Data Siswa (Detail) - <span id="span_nama_unit"></span></h3>
        <?php } else { ?>
            <h3 class="text-header fw-bold">Informasi Data Siswa - <span id="span_nama_unit"></span></h3>
        <?php } ?>
        
        <h5 class="text-header"><span id="span_nama_thn_ajaran"></span></h5>
        <hr style="margin-top: 5px;">

        <input type="hidden" id="txt_siswa_id">
             
        <?php if ( $form_id =="admin_form") { ?>
            <h5 class="text-header">BIODATA &nbsp;&nbsp;<button id="btn_daftar_calon_siswa" class="btn btn-sm btn-warning text-secondary"><i class="bi bi-search"></i> Daftar Calon Siswa</button></h5>
        <?php } else { ?>
            <h5 class="text-header">BIODATA</h5>
        <?php } ?>


        <div id="div_siswa_detail"></div>
        <div id="file_path_photo"></div>        
        <br>
        <div id="file_path_ktp_ayah"></div>
        <br>
        <div id="file_path_ktp_ibu"></div>
        <br>
        <div id="file_path_kk"></div>
        <br>
        <div id="file_path_akta_kelahiran"></div>
        <br>

        <div id="bukti_pembayaran"></div>
        <div id="status_pengecekan_data"></div>
        <br><br><br>
        
    </div>

    
    
</body>
</html>

<script type="text/javascript">
    const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
  
    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'               
        var siswa_id = '<?php echo $siswa_id ;?>' 
        var form_id =  '<?php echo $form_id ;?>'  
               
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang    
        await fetch_data_siswa_detail(siswa_id)
    }

    $(document).on('click', '#btn_daftar_calon_siswa', function () {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'
        window.location.href="<?php echo base_url('index.php/pendaftaran/pendaftaran_admin/show_daftar_calon_siswa') ; ?>?kode_jenjang="+kode_jenjang+""
    })

    $(document).on('click', '#btn_submit', function () {  
        
        var img_path =  $('#img_siswa_detail_path').val()
        if (img_path==''){
            var info = confirm('Bukti Pembayaran belum dikirimkan, apakah tetap ingin diproses?')
            if(info==false){
                return false
            }
        }
        var chk_setuju = document.getElementById("chk_setuju")
        var chk_setuju_ori = $('#chk_setuju_ori').val()
        if (chk_setuju.checked==false && chk_setuju_ori=='0'){
           alert('Silakan centrang Pernyataan Hasil Pengecekan Data/Dokumen ')
           $('#lbl_hasil_cek_dokumen').css('display','inline')
           return false
        }       
        $('#lbl_hasil_cek_dokumen').css('display','none') 
        if (chk_setuju.checked==false && chk_setuju_ori=='1'){
           var konfirmasi = confirm('Apakah Anda yakin ingin membatalkan hasil pengecekan dokumen?')
           if(konfirmasi==false){
                return false
           }
           
        }       
       
        var cek_dokumen_temp = '';
        if(chk_setuju.checked==true){
            cek_dokumen_temp="1" 
        }else{
            cek_dokumen_temp="0"
        }

        var siswa_id = $('#txt_siswa_id').val()
       
        fetch('<?php echo site_url('pendaftaran/pendaftaran/simpan_hasil_cek_dokumen') ;?>',{
                    method: 'POST',
                    body: new URLSearchParams({
                            siswa_id:siswa_id, 
                            cek_dokumen_temp:cek_dokumen_temp
                        })
                })
        .then(response => response.json()) 
        .then(dataResult => {
            alert(dataResult.message);        
            })
        .catch(err => {
            alert(err);
        });           
        
    })

    function fetch_data_siswa_detail(siswa_id) {                   
         fetch('<?php echo site_url('pendaftaran/pendaftaran/get_data_siswa_detail') ;?>?siswa_id='+siswa_id+'')
         .then(function(response) 
         {                   
             return response.json();    
         }).then(function (responseData) 
         {                        
             var data = responseData.data[0]   
             console.log(responseData) 
             if (data.length>0){    
                var html = '';                                                                   
                var tgl = new Date(data[0].tgl_lahir)                   
                var tgl_kelahiran = tgl.getDay() + ' ' + months[tgl.getMonth()] +' ' + tgl.getFullYear() 
                $('#txt_siswa_id').val(data[0].siswa_id)                
                html +='<table class="table table-sm table-bordered table-striped table-sticky">'; 
                html +='    <tr><td><b>Siswa ID</b></td></tr>';
                html +='    <tr><td>'+data[0].siswa_id+'</td></tr>';  
                html +='    <tr><td><b>No. Pendaftaran</b></td></tr>';   
                html +='    <tr><td>'+data[0].no_pendaftaran+'</td></tr>';
                html +='    <tr><td><b>Jenis Pendaftaran</b></td></tr>';   
                html +='    <tr><td>'+data[0].jenis_pendaftaran+'</td></tr>';
                html +='    <tr><td><b>Kelas</b></td></tr>';   
                html +='    <tr><td>'+data[0].kelas_cls+'</td></tr>';
                html +='    <tr><td><b>NISN</b></td></tr>';   
                html +='    <tr><td>'+data[0].nisn+'</td></tr>';
                html +='    <tr><td><b>Nama</b></td></tr>'; 
                html +='    <tr><td>'+data[0].nama+'</td></tr>'; 
                html +='    <tr><td><b>Nama Panggilan</b></td></tr>'; 
                html +='    <tr><td>'+data[0].nama_panggilan+'</td></tr>';
                html +='    <tr><td><b>Tempat Lahir</b></td></tr>'; 
                html +='    <tr><td>'+data[0].tempat_lahir+'</td></tr>'; 
                html +='    <tr><td><b>Tanggal Lahir</b></td></tr>'; 
                html +='    <tr><td>'+tgl_kelahiran+'</td></tr>'; 
                html +='    <tr><td><b>Jenis Kelamin</b></td></tr>'; 
                html +='    <tr><td>'+data[0].jenis_kelamin+'</td></tr>';                
                html +='    <tr><td><b>Anak Ke-</b></td></tr>'; 
                html +='    <tr><td>'+data[0].anak_ke+'</td></tr>'; 
                html +='    <tr><td><b>Jumlah Saudara Kandung</b></td></tr>'; 
                html +='    <tr><td>'+data[0].jml_saudara+'</td></tr>'; 
                html +='    <tr><td><b>Golongan Darah</b></td></tr>'; 
                html +='    <tr><td>'+data[0].golongan_darah+'</td></tr>'; 
                html +='    <tr><td><b>No. HP</b></td></tr>'; 
                html +='    <tr><td>'+data[0].no_hp+'</td></tr>'; 
                html +='    <tr><td><b>Alamat</b></td></tr>'; 
                html +='    <tr><td>'+data[0].alamat+'</td></tr>'; 
                html +='    <tr><td><b>Nama Sekolah Asal</b></td></tr>'; 
                html +='    <tr><td>'+data[0].nama_sekolah_asal+'</td></tr>'; 
                html +='    <tr><td><b>Alamat Sekolah Asal</b></td></tr>'; 
                html +='    <tr><td>'+data[0].alamat_sekolah_asal+'</td></tr>'; 
                html +='    <tr><td><b>Berat Badan (Kg)</b></td></tr>'; 
                html +='    <tr><td>'+data[0].berat_badan+'</td></tr>'; 
                html +='    <tr><td><b>Tinggi Badan (cm)</b></td></tr>'; 
                html +='    <tr><td>'+data[0].tinggi_badan+'</td></tr>'; 
                html +='    <tr><td><b>Sifat</b></td></tr>'; 
                html +='    <tr><td>'+data[0].sifat+'</td></tr>';
                html +='    <tr><td><b>Anak Inklusi</b></td></tr>'; 
                html +='    <tr><td>'+data[0].status_anak_inklusi+'</td></tr>'; 
                html +='    <tr><td><b>Membayar Biaya Inklusi</b></td></tr>'; 
                html +='    <tr><td>'+data[0].status_bayar_biaya_inklusi+'</td></tr>';                       
                html +='</table>';                
               
                html +='<h5 class="text-header">ORANG TUA / WALI MURID</h5>';
                html +='<h6>DATA AYAH</h6>';
                html +='<table class="table table-sm table-bordered table-striped table-sticky">'; 
                html +='    <tr><td><b>Nama Ayah</b></td></tr>'; 
                html +='    <tr><td>'+data[0].nama_ayah+'</td></tr>';
                html +='    <tr><td><b>Tempat & Tgl Lahir</b></td></tr>'; 
                html +='    <tr><td>'+data[0].tempat_lahir_ayah+', '+data[0].tgl_lahir_ayah+'</td></tr>';
                html +='    <tr><td><b>Agama</b></td></tr>'; 
                html +='    <tr><td>'+data[0].agama_ayah+'</td></tr>';
                html +='    <tr><td><b>Pendidikan Ayah</b></td></tr>'; 
                html +='    <tr><td>'+data[0].pendidikan_ayah+'</td></tr>';
                html +='    <tr><td><b>Pekerjaan Ayah</b></td></tr>'; 
                html +='    <tr><td>'+data[0].pekerjaan_ayah+'</td></tr>';               
                html +='</table>';

                html +='<h6>DATA IBU</h6>';
                html +='<table class="table table-sm table-bordered table-striped table-sticky">'; 
                html +='    <tr><td><b>Nama Ibu</b></td></tr>'; 
                html +='    <tr><td>'+data[0].nama_ibu+'</td></tr>';
                html +='    <tr><td><b>Tempat & Tgl Lahir</b></td></tr>'; 
                html +='    <tr><td>'+data[0].tempat_lahir_ibu+', '+data[0].tgl_lahir_ibu+'</td></tr>';
                html +='    <tr><td><b>Agama</b></td></tr>'; 
                html +='    <tr><td>'+data[0].agama_ibu+'</td></tr>';
                html +='    <tr><td><b>Pendidikan Ibu</b></td></tr>'; 
                html +='    <tr><td>'+data[0].pendidikan_ibu+'</td></tr>';
                html +='    <tr><td><b>Pekerjaan Ibu</b></td></tr>'; 
                html +='    <tr><td>'+data[0].pekerjaan_ibu+'</td></tr>';                
                html +='</table>';
                html +='<br>';
                html +='<h5 class="text-header">DOKUMEN PERSYARATAN</h5>';
                                               
                document.getElementById("div_siswa_detail").innerHTML = html

                document.getElementById("span_nama_thn_ajaran").innerHTML = data[0].thn_ajaran_nama
                             
                //FILE PTHOTO SISWA                
                var file_photo_path = "<?php echo base_url() ?>" + data[0].file_path_photo
                $('#file_path_photo').html("");	
                var html_2 = '<h6>PHOTO SISWA</h6>';
                if (file_photo_path.substring(file_photo_path.length-3)=='pdf'){
                    html_2+= "<object width='400px' height='400px' data='"+file_photo_path+"'></object>";                    
                }else{                    
                    html_2 += "<img src='"+file_photo_path+'?'+ new Date().getTime()+"' class='img-width'>";
                }
                html_2+= "<div style='line-height: 5px;'><br></div>";

                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    html_2+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+file_photo_path+"' download>Download File Photo Siswa</a></button>"; 
                <?php }  ?>        
                document.getElementById("file_path_photo").innerHTML = html_2 
              

                //FILE KTP AYAH
                var file_ktp_ayah_path = "<?php echo base_url() ?>" + data[0].file_path_ktp_ayah    
                $('#file_path_ktp_ayah').html("");	
                var html_3 = '<h6>KTP AYAH</h6>';
                if (file_ktp_ayah_path.substring(file_ktp_ayah_path.length-3)=='pdf'){
                    html_3+= "<object width='400px' height='400px' data='"+file_ktp_ayah_path+"'></object>";                   
                }else{
                    html_3 += "<img src='"+file_ktp_ayah_path+'?'+ new Date().getTime()+"' class='img-width'>";                   
                }         
                html_3+= "<div style='line-height: 5px;'><br></div>";    
                
                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    html_3+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+file_ktp_ayah_path+"' download>Download File KTP Ayah</a></button>"; 
                <?php }  ?>                       
                document.getElementById("file_path_ktp_ayah").innerHTML = html_3


                //FILE KTP IBU
                var file_ktp_ibu_path = "<?php echo base_url() ?>" + data[0].file_path_ktp_ibu    
                $('#file_path_ktp_ibu').html("");	
                var html_4 = '<h6>KTP IBU</h6>';
                if (file_ktp_ibu_path.substring(file_ktp_ibu_path.length-3)=='pdf'){
                    html_4+= "<object width='400px' height='400px' data='"+file_ktp_ibu_path+"'></object>";                   
                }else{
                    html_4 += "<img src='"+file_ktp_ibu_path+'?'+ new Date().getTime()+"' class='img-width'>";                   
                }         
                html_4+= "<div style='line-height: 5px;'><br></div>";    
                
                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    html_4+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+file_ktp_ibu_path+"' download>Download File KTP Ibu</a></button>"; 
                <?php }  ?>
                document.getElementById("file_path_ktp_ibu").innerHTML = html_4

                //FILE KARTU KELUARGA
                var file_kk_path = "<?php echo base_url() ?>" + data[0].file_path_kk    
                $('#file_path_kk').html("");	
                var html_5 = '<h6>KARTU KELUARGA</h6>';
                if (file_kk_path.substring(file_kk_path.length-3)=='pdf'){
                    html_5+= "<object width='400px' height='400px' data='"+file_kk_path+"'></object>";                   
                }else{
                    html_5 += "<img src='"+file_kk_path+'?'+ new Date().getTime()+"' class='img-width'>";                   
                }         
                html_5+= "<div style='line-height: 5px;'><br></div>";     

                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    html_5+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+file_kk_path+"' download>Download File Kartu Keluarga</a></button>"; 
                <?php }  ?>
                document.getElementById("file_path_kk").innerHTML = html_5


                //FILE AKTA KELAHIRAN
                var file_akta_kelahiran_path = "<?php echo base_url() ?>" + data[0].file_path_akta_kelahiran    
                $('#file_path_akta_kelahiran').html("");	
                var html_6 = '<h6>AKTA KELAHRAN</h6>';
                if (file_akta_kelahiran_path.substring(file_akta_kelahiran_path.length-3)=='pdf'){
                    html_6+= "<object width='400px' height='400px' data='"+file_akta_kelahiran_path+"'></object>";                   
                }else{
                    html_6 += "<img src='"+file_akta_kelahiran_path+'?'+ new Date().getTime()+"' class='img-width'>";                   
                }         
                html_6+= "<div style='line-height: 5px;'><br></div>"; 

                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    html_6+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+file_akta_kelahiran_path+"' download>Download File Akta Kelahiran</a></button>"; 
                <?php }  ?>
                document.getElementById("file_path_akta_kelahiran").innerHTML = html_6
                

                //FILE BUKTI TRANSFER
                var path_img = data[0].path_bukti_transfer;
                var html_7 = '';                
                html_7+= '<div class="card group-sm col-sm-4">';                        
                html_7+= '   <div class="card-header">BUKTI PEMBAYARAN</div>';
                html_7+= '   <div class="card-body ">   ';
                // html_7+= '       <div id="img_siswa_detail"></div>';
                // html_7+= '       <input type="hidden" id="img_siswa_detail_path">';
                if (path_img!=''){
                    // $('#img_siswa_detail').html("");	
                    // $('#img_siswa_detail').append("<img src='"+path_img+'?'+ new Date().getTime()+"' class='img-width'>")                    
                                       
                    html_7+= "<img src='"+path_img+'?'+ new Date().getTime()+"' class='img-width'>";
                    
                    //jika admin maka dimunculkan fungsi download
                    <?php if ( $form_id =="admin_form") { ?>
                        html_7+= "<button class='btn btn-sm btn-dark'><i class='bi bi-download'></i>&nbsp;<a href='"+path_img+"' download>Download File Bukti Pembayaran</a></button>";
                    <?php }  ?> 
                }

                html_7+= '   </div>';
                html_7+= '   </div>';
                html_7+= '</div>';
                html_7+= '';
                html_7+= '<br>';
                html_7+= '';  
                // $('#img_siswa_detail_path').val(path_img)      
                document.getElementById("bukti_pembayaran").innerHTML = html_7         
                
                
                var html_8 = '';                
                html_8+= '<h6>Pernyataan Hasil Pengecekan Data/Dokumen (dicentrang) : ';
                html_8+= '       <label style="display: none;" id="lbl_hasil_cek_dokumen" for=""><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>';
                html_8+= '</h6> ';
                html_8+= '<hr style="margin-top: 5px; margin-bottom: 5px;"> ';
                html_8+= '<label id="lbl_pernyataan" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label> ';
                html_8+= '<table class="table table-sm table-borderless"> ';
                html_8+= '  <tr> ';
                html_8+= '      <td> ';
                html_8+= '           <input type="checkbox" id="chk_setuju" name="chk_setuju" class="checkbox form-check-input"> ';
                html_8+= '           <label for="chk_setuju">&nbsp Ya, data dan dokumen sudah dicek dan lengkap</label> ';
                html_8+= '           <input type="hidden" id="chk_setuju_ori" name="chk_setuju_ori" class="checkbox form-check-input"> ';
                html_8+= '               <div class="row"> ';
                html_8+= '                   <div class="col"> '; 
                html_8+= "                   (Jika data dan dokumen sudah dicek dan lengkap, tekan tombol 'Simpan Pernyataan Hasil Pengecekan')";                        
                html_8+= '                   </div> ';                     
                html_8+= '               </div> ';                 
                html_8+= '       </td> ';
                html_8+= '   </tr> ';
                html_8+= '</table> ';
                html_8+= '<button type="button" id="btn_submit" class="btn btn-sm btn-submit"><i class="bi bi-save2"></i> Simpan Pernyataan Hasil Pengecekan</button> ';
                
                //jika admin maka dimunculkan fungsi download
                <?php if ( $form_id =="admin_form") { ?>
                    document.getElementById("status_pengecekan_data").innerHTML = html_8                      
                   
                    var cek_dokumen = document.getElementById('chk_setuju')
                    if(data[0].status_cek_dokumen==1){
                        cek_dokumen.checked=true
                        $('#chk_setuju_ori').val()
                    }else{
                        cek_dokumen.checked=false
                    }
                    $('#chk_setuju_ori').val(data[0].status_cek_dokumen)                   

                <?php }  ?>


                
                <?php if ( $form_id =="user_form") { ?>
                    var html_9 = '<br>';
                    html_9 +='<h5 class="text-header">STATUS PENGECEKAN DATA/DOKUMEN :</h5>';
                    // html_9+= '<hr style="margin-top: 5px; margin-bottom: 5px;"> ';

                    if(data[0].status_cek_dokumen==1){
                        html_9+= '<h5 class="text-success"><i class="bi bi-check-circle-fill"></i> Dokumen sudah lengkap</h5>';
                    }else{
                        if(data[0].path_bukti_transfer==''){
                            html_9+= '<h5 class="text-danger">Bukti transer belum diunggah</h5>';
                        }else{
                            html_9+= '<h5 class="text-warning">Menunggu proses pengecekan</h5>';
                        }
                    }

                    document.getElementById("status_pengecekan_data").innerHTML = html_9 
                <?php }  ?>
                               
                
            }            
         });   
     }

</script>


<style>   
    .img-width {
        width: 250pt;
        height: 250ptt;
    }

    a:link, a:visited {  
        color: white;      
    }


</style>