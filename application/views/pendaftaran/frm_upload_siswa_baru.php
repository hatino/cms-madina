<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
</head>
<body>

    <body onload="init_form()"></body>   
    <div class="container mt-5">      
         <div style="line-height: 35px;"><br></div>
        <h3 class="text-header fw-bold">Upload Siswa Baru <a id="nama_jenjang_div"></h3>
        <h5 class="text-header"><div id="thn_ajaran_nama_div"></div></h5>
       
        <hr style="margin-top:5px; margin-bottom: 10px;">

        <form method="post" id="proses_form">            
            
            <div style="line-height: 5px;">
                <br>
            </div>
            <div class="input-group input-group-sm">
                <label for="file_siswa_baru" id="lbl_siswa_baru">Pilih File </label>&nbsp;&nbsp;
                <input type="text" name="txt_siswa_baru" id="txt_siswa_baru" class="form-control" autocomplete="off">
            </div>
            
            <button type="button" class="btn btn-success btn-shadow btn-sm" style="margin-top: 5px;" id="btn_download_template"><i class="bi bi-download"></i> Download Template</button>&nbsp;
            <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('file_siswa_baru').click()" style="margin-top: 5px;">
                <i class="bi bi-search"></i> Browse<input type="file" name="file_siswa_baru" class="form-control" id="file_siswa_baru"  data-id="test-file" style="display:none;">
                <label for="file_siswa_baru" id="lbl_file_siswa_baru"></label>
            </button>&nbsp;
            <button type="submit" class="btn btn-clear btn-shadow btn-sm" style="margin-top: 5px;" id="proses_upload"><i class="bi bi-gear-wide-connected"></i> Proses Upload</button>				
                                                
            <hr>
            <h5>Daftar Siswa Baru</h5>
            <div id="tbl_siswa_baru_div"></div>       

        </form>
        <button type="button" id="btnSubmit" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Submit</button>        
        <br>
        <br>

    </div>
    
</body>
</html>


<script type="text/javascript">

    function init_form() {
        load_tbl_upload_siswa_baru([[[]]])
    }

    $(document).on('click', '#btn_download_template', function () {       
        window.location.href="<?php echo site_url('pelajaran/pelajaran_admin/generateXls_siswa_baru_template') ;?>"
    })

    $(document).on('change', '#file_siswa_baru', function() {			
        try {   
            
            load_tbl_upload_siswa_baru([[[]]])

            var name_obj =document.getElementById("file_siswa_baru").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_siswa_baru").files[0].name;
            $('#txt_siswa_baru').val(name)
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['xls','xlsx']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_siswa_baru").files[0]);
            var f = document.getElementById("file_siswa_baru").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            
            // var file_siswa_baru = $('#file_siswa_baru').val()
            //console.log(name_obj)
            // $('#txt_siswa_baru').val(file_siswa_baru)

        } catch (error) {
            $('#txt_siswa_baru').val('')
            // alert(error)
        }
	});


    $(document).on('click', '#btnSubmit', function () {
        //cek apakah file excel nya sudah pilih
        let file_siswa_baru = $('#file_siswa_baru').val()
        if (file_siswa_baru == ''){
            $('#txt_siswa_baru').focus()
            alert('file tidak ditemukan')
            return false
        }

        //cek apakah sudah proses upload
        var tbl = document.getElementById("tbl_upload_siswa")
        var rows_length = $("#tbl_upload_siswa tr").length;        
        if(rows_length==1){
            alert('Tidak ada data yang akan diupload')
            return false;
        }

        //cek apakah ada data yang kurang
        var data_arr = [];
        var formData = new FormData;
        for (var i = 1; i < rows_length; i++) {     
            item = {}
            item['thn_ajaran'] = tbl.rows[i].cells[1].innerHTML
            item['unit_sekolah'] = tbl.rows[i].cells[2].innerHTML
            item['nis'] = tbl.rows[i].cells[3].innerHTML
            item['nama'] = tbl.rows[i].cells[4].innerHTML
            item['alamat'] = tbl.rows[i].cells[5].innerHTML 
            item['pesan'] = tbl.rows[i].cells[6].innerHTML  
            if (item['pesan'] != '' ){
                alert('Mohon untuk perbaiki data terlebih dahulu')
                return false
            }     
            data_arr.push(item);
        }        

        var json_data = JSON.stringify(data_arr);       
        formData.append('data', json_data)
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/simpan_upload_siswa') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(formData),
                    //body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(async (dataResult) => {   
                console.log(dataResult)            
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{    
                    alert('Simpan data sukses');      
                    load_tbl_upload_siswa_baru([[[]]])                                                                     
                }
            })
        .catch(err => {
            alert(err);
        });    
    })


    $(document).on('submit','#proses_form', async function () {
        event.preventDefault(); 
              
        let file_siswa_baru = $('#file_siswa_baru').val()
        if (file_siswa_baru == ''){
            $('#txt_siswa_baru').focus()
            alert('file tidak ditemukan')
            return false
        }

        var form_data = new FormData();              
        form_data.append("file_siswa_baru", document.getElementById('file_siswa_baru').files[0]);         
        await $.ajax(
        {
            url:"<?php echo site_url('pendaftaran/pendaftaran_admin/proses_upload_file') ;?>",            
            method:"POST",
            data: form_data,
            contentType: false,            
            cache: false,
            processData: false,           
            success:function(dataResult)
            {    	               
                var dataResult = JSON.parse(dataResult);                
                load_tbl_upload_siswa_baru(dataResult.data)
            }
        });           
    })

    async function load_tbl_upload_siswa_baru(data_dtl) {   
        console.log(data_dtl)  
        if (data_dtl){
           var data = data_dtl[0]          
        }else{
            //alert('test')
        }

        var pesan = ''; 
        var html = '';     
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_upload_siswa">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No.</th>';  
        html += '			<th>Thn Ajaran</th>';              
        html += '			<th>Unit Sekolah</th>';                                    
        html += '			<th>NIS</th>';
        html += '			<th>Nama</th>';
        html += '			<th>Alamat</th>';
        html += '			<th>Pesan</th>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data[0].length>1)
        {                      
            var no = '', thn_ajaran = '', unit_sekolah = '', nis='', nama = ''; alamat = '', nis_temp ='';
            html += '<tbody>';         
            for(var count = 1; count < data.length; count++)
            {     
                pesan = ''; 
                no = data[count][0];
                thn_ajaran = data[count][1]                
                unit_sekolah = data[count][2]
                nis = data[count][3]
                nama = data[count][4]
                alamat = data[count][5]

                if (nis==nis_temp){
                    pesan += 'nis double, ' 
                }
                nis_temp = nis
               
                var valid_thn_ajaran = await cek_thn_ajaran_exists(thn_ajaran)
                if(valid_thn_ajaran == 'false' && thn_ajaran != null){
                    pesan += 'thn ajaran tidak ditemukan, ' 
                }

                var valid_unit_sekolah = await cek_unit_sekolah_exists(unit_sekolah)
                if(valid_unit_sekolah == 'false' && unit_sekolah != null){
                    pesan += 'unit sekolah tidak ditemukan, ' 
                }

                var valid_nis_double = await cek_nis_double(nis, thn_ajaran)
                if(valid_nis_double == 'false'){
                    pesan += 'nis sudah diupload sebelumnya , ' 
                }

                if (thn_ajaran==null || thn_ajaran == ''){
                    pesan += 'thn ajaran kosong, ' 
                }         
                if (unit_sekolah==null || unit_sekolah == ''){
                    pesan += 'unit sekolah kosong, ' 
                }              
                if (nama==null || nama == ''){
                    pesan += 'nama kosong, ' 
                }
                if (alamat==null || alamat == ''){
                    pesan += 'alamat kosong, ' 
                }
                
                pesan = pesan.substring(0,pesan.length -2)

                html += '<tr class = "col-form-label-sm" id="'+ count +'">';                
                html += '   <td style="min-width:30pt">'+no+'</td>';  //0
                html += '   <td style="min-width:30pt">'+thn_ajaran+'</td>';  //0
                html += '   <td style="min-width:30pt">'+unit_sekolah+'</td>';  //0
                html += '   <td style="min-width:30pt">'+nis+'</td>';  //0
                html += '   <td style="min-width:30pt">'+nama+'</td>';  //0
                html += '   <td style="min-width:30pt">'+alamat+'</td>';  //0
                html += '   <td style="min-width:30pt;color:red">'+pesan+'</td>';  //0
                html += '</tr>';    
            }         
            html += '</tbody>';   
        }
        html += '</table>';
                               
        document.getElementById("tbl_siswa_baru_div").innerHTML = html;  

        if (pesan != ''){
            alert('Ditemukan data yang tidak valid silahkan diperbaiki')
        }
    }

    async function cek_thn_ajaran_exists(thn_ajaran) {
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/cek_thn_ajaran_exists') ; ?>?thn_ajaran='+thn_ajaran+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()              
        var row_num = result.data[0].length
        if(row_num>0){
            return 'true'
        }else{
            return 'false'
        }
    }
    
    async function cek_unit_sekolah_exists(unit_sekolah) {
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/cek_unit_sekolah_exists') ; ?>?unit_sekolah='+unit_sekolah+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()              
        var row_num = result.data[0].length
        if(row_num>0){
            return 'true'
        }else{
            return 'false'
        }
    }

    async function cek_nis_double(nis, thn_ajaran) {
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/cek_nis_double') ; ?>?nis='+nis+'&thn_ajaran='+thn_ajaran+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()
        console.log(result.data[0]) 
        var row_num = result.data[0].length
        if(row_num>0){
            return 'false'
        }else{
            return 'true'
        }
    }
    

</script>