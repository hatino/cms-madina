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
        <h3 class="text-header fw-bold">Upload Pelajaran <a id="nama_jenjang_div"></h3>
        <h5 class="text-header" style="text-transform: uppercase"><div id="thn_ajaran_nama_div"></div></h5>
       
        <hr style="margin-top: 5px; margin-bottom: 10px;">

        <form method="post" id="proses_form">            
            
            <div style="line-height: 5px;">
                <br>
            </div>
            <div class="input-group input-group-sm">
                <label for="txt_pelajaran" id="lbl_pelajaran">Pilih File </label>&nbsp;&nbsp;
                <input type="text" name="txt_pelajaran" id="txt_pelajaran" class="form-control" autocomplete="off">
            </div>
           
            <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('file_pelajaran').click()" style="margin-top: 5px;">
                <i class="bi bi-search"></i> Browse<input type="file" name="file_pelajaran" class="form-control" id="file_pelajaran"  data-id="test-file" style="display:none;">
                <label for="file_pelajaran" id="lbl_file_pelajaran"></label>
            </button>&nbsp;
            <button type="submit" class="btn btn-clear btn-shadow btn-sm" style="margin-top: 5px;" id="proses_upload"><i class="bi bi-gear-wide-connected"></i> Proses Upload</button>&nbsp;
            <button type="button" class="btn btn-success btn-shadow btn-sm" style="margin-top: 5px;" id="btn_download_template"><i class="bi bi-download"></i> Download Template</button>

            <hr>
            <h5>Daftar Pelajaran</h5>
            <div id="tbl_pelajaran_div"></div>       

        </form>
        <button type="button" id="btnSubmit" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Submit</button>
        <br>
        <br>

    </div>
    
</body>
</html>


<script type="text/javascript">

    function init_form() {
        load_tbl_upload_pelajaran([[[]]])
    }

    $(document).on('click', '#btn_download_template', function () {       
        window.location.href="<?php echo site_url('pelajaran/pelajaran_admin/generateXls_pelajaran_template') ;?>"
    })

    $(document).on('change', '#file_pelajaran', function() {			
        try {   

            load_tbl_upload_pelajaran([[[]]])
            
            var name_obj =document.getElementById("file_pelajaran").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_pelajaran").files[0].name;
            $('#txt_pelajaran').val(name)
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['xls','xlsx']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_pelajaran").files[0]);
            var f = document.getElementById("file_pelajaran").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            
            // var file_pelajaran = $('#file_pelajaran').val()
            //console.log(name_obj)
            // $('#txt_pelajaran').val(file_pelajaran)

        } catch (error) {
            $('#txt_pelajaran').val('')
            // alert(error)
        }
	});
    
    $(document).on('click', '#btnSubmit', async function () {
        //cek apakah file excel nya sudah pilih
        let file_pelajaran = $('#file_pelajaran').val()
        if (file_pelajaran == ''){
            $('#txt_pelajaran').focus()
            alert('file tidak ditemukan')
            return false
        }

        //cek apakah sudah proses upload
        var tbl = document.getElementById("tbl_upload_pelajaran")
        var rows_length = $("#tbl_upload_pelajaran tr").length;        
        if(rows_length==1){
            alert('Tidak ada data yang akan diupload')
            return false;
        }

        //cek apakah ada data yang kurang
        var data_arr = [];
        var formData = new FormData;
        var nama_pelajaran_temp = '';
        var nama_pelajaran = '';
        var group_cls = '';
        var kelas = '';
        for (var i = 1; i < rows_length; i++) {                
            unit_sekolah =  tbl.rows[i].cells[1].innerHTML
            kelas = tbl.rows[i].cells[2].innerHTML
            nama_pelajaran_temp = tbl.rows[i].cells[4].innerHTML  
            nama_pelajaran = nama_pelajaran_temp.replace("'","''")
            //nama_pelajaran = tbl.rows[i].cells[4].innerHTML  

            item = {}
            item['no'] = tbl.rows[i].cells[0].innerHTML
            item['unit_sekolah'] = unit_sekolah
            item['kelas'] = kelas
            item['kelompok_mapel'] = tbl.rows[i].cells[3].innerHTML
            item['nama_pelajaran'] = nama_pelajaran           
            item['pesan'] = tbl.rows[i].cells[5].innerHTML  
            if (item['pesan'] != '' ){
                alert('Mohon untuk perbaiki data terlebih dahulu')
                return false
            }     
            data_arr.push(item);
        }        
                
        var result_cek = await fetch('<?php echo site_url('pelajaran/pelajaran_admin/cek_upload_pelajaran_exists') ; ?>?unit_sekolah='+unit_sekolah+'&kelas='+kelas+'&nama_pelajaran='+nama_pelajaran+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()              
        var row_num = result.data[0].length
        if(row_num > 0){
            var msg = confirm("Data sudah ada, apakah ingin diganti?");
            if(msg==false){
             return false;
            }
        }

        var json_data = JSON.stringify(data_arr);       
        formData.append('data', json_data)
        await fetch('<?php echo site_url('pelajaran/pelajaran_admin/simpan_upload_pelajaran') ;?>',{
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
                        //alert(dataResult.message);
                        console.log(dataResult.message)
                    }                   
                }else{    
                    alert('Simpan data sukses');      
                    load_tbl_upload_pelajaran([[[]]])                                                                     
                }
            })
        .catch(err => {
            //alert(err);
            console.log(err);
        });    
    })


    $(document).on('submit','#proses_form', async function () {
        event.preventDefault(); 
              
        let file_pelajaran = $('#file_pelajaran').val()
        if (file_pelajaran == ''){
            $('#txt_pelajaran').focus()
            alert('file tidak ditemukan')
            return false
        }

        $('body').addClass('waiting')

        var form_data = new FormData();              
        form_data.append("file_pelajaran", document.getElementById('file_pelajaran').files[0]);         
        await $.ajax(
        {
            url:"<?php echo site_url('pelajaran/pelajaran_admin/proses_upload_file_pelajaran') ;?>",            
            method:"POST",
            data: form_data,
            contentType: false,            
            cache: false,
            processData: false,           
            success:function(dataResult)
            {    	               
                var dataResult = JSON.parse(dataResult);                
                load_tbl_upload_pelajaran(dataResult.data)
                $('body').removeClass('waiting')
            }
        });           
    })

    async function load_tbl_upload_pelajaran(data_dtl) {
        console.log(data_dtl)
        if (data_dtl){
           var data = data_dtl[0]           
        }else{
            //alert('test')
        }

        var pesan = ''; 
        var html = '';     
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_upload_pelajaran">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No.</th>';  
        html += '			<th>Unit Sekolah</th>';  
        html += '			<th>Kelas</th>';              
        html += '			<th>Kelompok MAPEL</th>';                                    
        html += '			<th>Nama Pelajaran</th>';       
        html += '			<th>Pesan</th>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data[0].length>1)
        {                      
            var no = '', unit_sekolah = '', kelas = '', kelompok_mapel='', nama_mapel = '';
            html += '<tbody>';         
            
            for(var count = 1; count < data.length; count++)
            {     
                pesan = ''; 
                no = data[count][0];
                unit_sekolah = data[count][1]   
                kelas =  data[count][2]            
                kelompok_mapel = data[count][3]
                nama_mapel = data[count][4]
               
                if (no==null || no == ''){
                    pesan += 'No. kosong, ' 
                }    
                if (unit_sekolah==null || unit_sekolah == ''){
                    pesan += 'unit sekolah kosong, ' 
                }         

                var valid_unit_sekolah = await cek_unit_sekolah_exists(unit_sekolah)
                if(valid_unit_sekolah == 'false' && unit_sekolah != null){
                    pesan += 'unit sekolah tidak ditemukan, ' 
                }

                if (kelompok_mapel==null || kelompok_mapel == ''){
                    pesan += 'kelompok mapel kosong, ' 
                }              
                if (nama_mapel==null || nama_mapel == ''){
                    pesan += 'nama mapel kosong, ' 
                }
               
                pesan = pesan.substring(0,pesan.length -2)

                html += '<tr class = "col-form-label-sm" id="'+ count +'">';                
                html += '   <td style="min-width:30pt">'+no+'</td>';  //0     
                html += '   <td style="min-width:30pt">'+unit_sekolah+'</td>';  //0
                html += '   <td style="min-width:30pt">'+kelas+'</td>';  //0
                html += '   <td style="min-width:30pt">'+kelompok_mapel+'</td>';  //0
                html += '   <td style="min-width:30pt">'+nama_mapel+'</td>';  //0              
                html += '   <td style="min-width:30pt;color:red">'+pesan+'</td>';  //0
                html += '</tr>';    
            }         
            html += '</tbody>';   
        }
        html += '</table>';
                               
        document.getElementById("tbl_pelajaran_div").innerHTML = html;  

        if (pesan != ''){
            alert('Ditemukan data yang tidak valid silahkan diperbaiki')
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

    // async function cek_thn_ajaran_exists(thn_ajaran) {
    //     var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/cek_thn_ajaran_exists') ; ?>?thn_ajaran='+thn_ajaran+'', {method:"GET", mode: "no-cors" })  
    //     var result = await result_cek.json()              
    //     var row_num = result.data[0].length
    //     if(row_num>0){
    //         return 'true'
    //     }else{
    //         return 'false'
    //     }
    // }

    // async function cek_nis_double(nis, thn_ajaran) {
    //     var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/cek_nis_double') ; ?>?nis='+nis+'&thn_ajaran='+thn_ajaran+'', {method:"GET", mode: "no-cors" })  
    //     var result = await result_cek.json()
    //     console.log(result.data[0]) 
    //     var row_num = result.data[0].length
    //     if(row_num>0){
    //         return 'false'
    //     }else{
    //         return 'true'
    //     }
    // }
    

</script>


<style>
    body.waiting * {
        cursor: progress;
    }
</style>