<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5-content.css"> -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    
</head>
<body>  
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">             
        <div class="row">
            <div class="col-md-9 ">
                <h3 class="text-header" style="text-transform: uppercase">Informasi Pendaftaran  <a id="nama_jenjang_div"></a></h3>
                <h5 id="div_thn_ajaran_nama" class="text-header"></h5>
                <hr style="margin-top: 5px;">
                <div id="div_info_pendaftaran" class="ck-content"></div>
            </div>

            <div class="col-md-3 ">
                <div class="card shadow-sm" style="width: 18rem;" >                   
                    <!--img src="..." class="card-img-top" alt="..."-->
                    <div class="card-body">
                    
                      <p class="card-text" align="center">FORM PENDAFTARAN</p>
                      <div align="center">
                      <a href="#" class="btn btn-sm btn-submit" id="btn_daftar"><i class="bi bi-pencil-square"></i> Dafar Sekarang</a>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="card shadow-sm" style="width: 18rem;">                   
                    <!--img src="..." class="card-img-top" alt="..."-->
                    <div class="card-body">
                    
                      <p class="card-text" align="center">KONFIRMASI PEMBAYARAN</p>
                      <div align="center">
                      <a href="#" class="btn btn-sm btn-secondary" id="btn_konfirmasi"><i class="bi bi-check-square"></i> Konfirmasi</a>
                      </div>
                    </div>
                  </div>
            </div>

           
        </div>

    </div>
</body>
</html>

<script  type="text/javascript">

    async function init_form() {  
        var kode_jenjang = '<?php echo $kode_jenjang; ?>'   
        //var nama_jenjang = '<?php echo $nama_jenjang; ?>'           

        var nama_jenjang = ''
        if (kode_jenjang=='RA'){
            nama_jenjang = ' - RA/TK'
        }else{
            if (kode_jenjang=='MI'){
                nama_jenjang = ' - MI/SD'
            }else{
                nama_jenjang = ' - '+kode_jenjang
            }
        }
        document.getElementById('nama_jenjang_div').innerHTML = nama_jenjang;

        var thn_ajaran_cls = await cek_thn_ajaran_aktif(kode_jenjang, nama_jenjang)             
        await fetch_data_info_pendaftaran(kode_jenjang, thn_ajaran_cls)
        <?php simpan_kunjungan(); ?>
    }

    function fetch_data_info_pendaftaran(kode_jenjang, thn_ajaran_cls) {       
        fetch('<?php echo site_url('pendaftaran/pendaftaran/get_data_info_pendaftaran_ui') ;?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{            
            var data = responseData.data[0]
			console.log(data[0])
            var info = data[0].info_pendaftaran
            if (info==undefined){
                //window.editor.setData('')
                document.getElementById("div_info_pendaftaran").innerHTML = ""
            }else{
                
                document.getElementById("div_info_pendaftaran").innerHTML = info
                //document.getElementById("div_info_pendaftaran").innerHTML = "<table><tbody><tr><td>test test</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table>"
                // editorInstance.setData( '<p>Hello world!<p>' );
                    
            }            
		});   
    }

    $(document).on('click', '#btn_daftar', async function() {         
        var kode_jenjang = '<?php echo $kode_jenjang; ?>'
        var nama_jenjang = '<?php echo $nama_jenjang; ?>'  
        var thn_ajaran_cls = await cek_thn_ajaran_aktif(kode_jenjang, nama_jenjang)
        
        if (thn_ajaran_cls ==false){
            return false
        }else{
            window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_input_pendaftaran') ;?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""
        }            
    })


    $(document).on('click', '#btn_konfirmasi', async function() {    
        var kode_jenjang = '<?php echo $kode_jenjang; ?>'
        var nama_jenjang = '<?php echo $nama_jenjang; ?>'  
        var thn_ajaran_cls = await cek_thn_ajaran_aktif(kode_jenjang, nama_jenjang)  
        if (thn_ajaran_cls ==false){
            return false
        }else{      
            window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_konfirmasi_pembayaran') ;?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""
        }
    })


    async function cek_thn_ajaran_aktif(kode_jenjang, nama_jenjang) {        
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_thn_ajaran_aktif_ui') ;?>?kode_jenjang='+kode_jenjang+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()  
        var data = result.data[0]
        
        var thn_ajaran_cls = data[0].thn_ajaran_cls
        var thn_ajaran_nama = data[0].thn_ajaran_nama      
        document.getElementById("div_thn_ajaran_nama").innerHTML = thn_ajaran_nama

        if (result.thn_ajaran_id==2){
        
            let date = new Date(result.tgl_mulai);
            const day = date.toLocaleString('default', { day: '2-digit' });
            const month = date.toLocaleString('default', { month: 'short' });
            const year = date.toLocaleString('default', { year: 'numeric' });
            const tgl_mulai  = day + '-' + month + '-' + year;
          
            alert ("Pendaftaran PPDB belum dibuka, insya Allah akan dibuka pada tgl "+tgl_mulai)
            return false
        }
        return thn_ajaran_cls
    }

</script>

