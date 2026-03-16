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
        
        <h3 class="text-header">PRESTASI - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">
            <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
            <input type="hidden" name="_prestasi_id" id="_prestasi_id" value=0> 
            <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 
            <label for="dt_tgl_prestasi" class="col-sm col-form-label col-form-label-sm">Tanggal Lomba</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="dt_tgl_prestasi" id="dt_tgl_prestasi" class="form-control" autocomplete="off"> 
            </div>
            <label for="txt_jenis_prestasi" class="col-sm col-form-label col-form-label-sm">Nama Siswa</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_nama_siswa" id="txt_nama_siswa" class="form-control" autocomplete="off"> 
            </div>
            <label for="txt_jenis_prestasi" class="col-sm col-form-label col-form-label-sm">Nama Lomba</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_jenis_prestasi" id="txt_jenis_prestasi" class="form-control" autocomplete="off"> 
            </div>
            <label for="txt_peringkat" class="col-sm col-form-label col-form-label-sm">Juara</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_peringkat" id="txt_peringkat" class="form-control" autocomplete="off"> 
            </div>
            <label for="txt_peringkat" class="col-sm col-form-label col-form-label-sm">Tingkat Lomba</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_tingkat_lomba" id="txt_tingkat_lomba" class="form-control" autocomplete="off"> 
            </div>
            <label for="txt_tempat_kegiatan" class="col-sm col-form-label col-form-label-sm">Tempat Lomba</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_tempat_kegiatan" id="txt_tempat_kegiatan" class="form-control" autocomplete="off"> 
            </div>
            <br>
            <div class="card group-sm col-sm-3">                        
                <div class="card-header">Upload Photo Prestasi</div>
                <div class="card-body ">    
                    <!-- <div class="card">   -->
                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                        <span id="uploaded_img_prestasi"></span>							  
                    <!-- </div> -->

                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                    <input type="hidden" name="uploaded_img_prestasi_path" id="uploaded_img_prestasi_path">                         
                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                    <input type="hidden" name="txtpath_img_prestasi_ori" id="txtpath_img_prestasi_ori"> 						 
            
                    <table>
                        <tr>
                            <td width="200">
                                <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_prestasi').click()" style="margin-top: 5px;">
                                    <i class="bi bi-upload"></i> Browse<input type="file" name="file_prestasi" class="form-control" id="file_prestasi"  data-id="test-file" style="display:none;">
                                    <label for="file_prestasi" id="lbl_file_prestasi"></label>
                                </button>	
                                <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="btn_hapus_img"><i class="bi bi-eraser"></i> Batal</button>				
                            </td>
                        </tr>	  		
                    </table>	  	
                
                </div>
                <div class="card-footer text-muted">
                    Jenis File : jpg, jpeg, png <br>
                    Max Size : 2 MB
                </div>
            </div>
            <br>         
            <button type="submit" id="btnSubmit" class="btn btn-submit btn-sm"><i class="bi bi-save2"></i> Submit</button>
            <button type="button" id="btnTambah" class="btn btn-clear btn-sm"><i class="bi bi-file-earmark-plus"></i> Tambah</button>
            <hr>

        </form>
        <h5>Daftar Prestasi</h5>
        <div id="div_tbl_prestasi"></div>
        <br>
        <br>

    </div>

</body>
</html>

<script type="text/javascript">
   
    async function init_form() {       
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'        
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;  

        $('#_kode_jenjang').val(kode_jenjang)   
        await set_tgl(new Date())        
        await load_blank_image()
        await fetch_data_tbl_prestasi()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_prestasi').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    function fetch_data_tbl_prestasi(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'
        fetch('<?php echo site_url('prestasi/Prestasi_admin/get_data_tbl_prestasi') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();
        }).then(function (responseData){
            load_tbl_prestasi(responseData.data[0]);
        });            
    }

    async function load_tbl_prestasi(data) {  
       
       var html = '';
       html += '<div>';
       html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_prestasi">';            
       html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
       html += '		<tr class="text-nowrap">';   
       html += '           <th>Tgl Lomba</th>';    
       html += '           <th>Nama Siswa</th>';                                     
       html += '		   <th>Nama Lomba</th>';
       html += '		   <th>Juara</th>';
       html += '		   <th>Tingkat Lomba</th>';
       html += '		   <th>Tempat Lomba</th>';
       html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
       html += '		</tr>';
       html += '   </thead>';      
       
       if(data.length>0)
       {
           console.log(data)
           html += '<tbody>';
           for(var count = 0; count < data.length; count++)
           {
               var tgl = await set_tgl_prestasi(new Date (data[count].tgl_prestasi))              
               html += '<tr class = "col-form-label-sm" id="'+ count +'">';
               html += '   <td>'+tgl+'</td>';//0  
               html += '   <td>'+data[count].nama_siswa+'</td>';  //1 
               html += '   <td>'+data[count].jenis_prestasi+'</td>';  //2     
               html += '   <td>'+data[count].peringkat+'</td>';
               html += '   <td>'+data[count].tingkat_lomba+'</td>';
               html += '   <td>'+data[count].tempat_kegiatan+'</td>';
               html += '   <td style="display:none;">'+data[count].img_path+'</td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="edit_prestasi" data-id='+data[count].prestasi_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="delete_prestasi" data-id='+data[count].prestasi_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
               html += '</tr>';                                                                                                   
           }
           html += '</tbody>';      
           //$('#pesan').find("h6:first").text(dataResult.length + ' records');
       }                
       html += '</table>';
       html += '</div>';
                       
       document.getElementById("div_tbl_prestasi").innerHTML = html;           
   }


   function set_tgl_prestasi(tgl) {
        var new_date = tgl.getFullYear() +"-"+ ("0"+(tgl.getMonth()+1)).slice(-2) +"-"+ ("0"+tgl.getDate()).slice(-2)
        return new_date
    }

    $(document).on('click', '#btn_hapus_img', function () {
        var file_path =  $('#uploaded_img_prestasi_path').val()
        var prestasi_id = $('#_prestasi_id').val()
        alert(prestasi_id)
                
        var file_path_idx = file_path.indexOf("images_ui")      
        if(file_path == '' || file_path_idx > -1 ){
                alert('file image tidak ditemukan')
                return false
        }      
       
        var pesan = confirm('Apakah Anda yakin ingin menghapus image ?')
        if (pesan==false){
            return false
        }

        fetch('<?php echo site_url('prestasi/prestasi_admin/delete_image_prestasi') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({file_path:file_path,prestasi_id:prestasi_id}),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
                console.log(dataResult);
                if(dataResult.status==true){
                    $('#uploaded_img_prestasi').html('')
                    $('#uploaded_img_prestasi_path').val('')
                    load_blank_image()
                }                
            })
        .catch(err => {
            alert(err);
        });          
    })


   $(document).on('change', '#file_prestasi', function()
	{			
        try {   
            var name_obj =document.getElementById("file_prestasi").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_prestasi").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_prestasi").files[0]);
            var f = document.getElementById("file_prestasi").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_prestasi('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_prestasi(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var prestasi_id = $('#_prestasi_id').val()
        var img_file_path_ori = $('#uploaded_img_prestasi_path').val()
        form_data.append("file_prestasi", document.getElementById('file_prestasi').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "prestasi"); 
        form_data.append("prestasi_id", prestasi_id);        
        form_data.append("img_file_path_ori", img_file_path_ori);

        await $.ajax(
        {
            url:"<?php echo base_url()?>uploadfile.php",
            //url:"uploadfile",    
            method:"POST",
            data: form_data,
            contentType: false,
            //contentType: 'multipart/form-data',
            cache: false,
            processData: false,
            /*
            beforeSend:function(){
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");				    
            },   
            */
            success:function(dataResult)
            {    	
                var dataResult = JSON.parse(dataResult);
                var path_view = dataResult.path_view;
                var path_save = dataResult.path_save;
                
                $('#uploaded_img_prestasi').html("");	
                $('#uploaded_img_prestasi').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_prestasi_path').val("")
                $('#uploaded_img_prestasi_path').val(path_view);                  
            }
        });

    }


    $(document).on('submit','#simpan_form', async function () {

        event.preventDefault(); 
        var status_edit = $('#_status_edit').val()

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    

        let file_prestasi = $('#file_prestasi').val()
        if (status_edit=='true' && file_prestasi != ''){
            await upload_file_prestasi('simpan')
        }

        var form_data= $(this).serialize();

        fetch('<?php echo site_url('prestasi/prestasi_admin/simpan_prestasi') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data),
                    //body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(async (dataResult) => {               
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{       
                    var prestasi_id = dataResult.data                   
                    $('#_prestasi_id').val(prestasi_id)

                    if (status_edit=='false'){                        
                        await simpan_img_path(prestasi_id)   
                    }
                
                    $('#_status_edit').val(true)                                  
                    await fetch_data_tbl_prestasi()
                    alert('Simpan data sukses');    
                    //fetch_data_profile_yayasan()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });    
    })


    async function simpan_img_path(prestasi_id) {                       
        await upload_file_prestasi('simpan');  
        let img_file_path =  $('#uploaded_img_prestasi_path').val();  
        var form_data = new FormData();
        form_data.append("prestasi_id", prestasi_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('prestasi/prestasi_admin/simpan_img_path') ;?>',{
                    method: 'POST',   
                    //data:{'prestasi_id':prestasi_id, 'img_file_path':img_file_path},
                    body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
            //alert('Simpan data sukses');        
            console.log(dataResult.data);      
            })
        .catch(err => {
            alert(err);
        });           
    }
               
    function validasi_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];              
        let tgl_prestasi = x['dt_tgl_prestasi'].value;
        let jenis_prestasi = x["txt_jenis_prestasi"].value;        
        let peringkat = x["txt_peringkat"].value; 
        let tempat_kegiatan = x["txt_tempat_kegiatan"].value; 
        
        if(tgl_prestasi==''){      
            valid = false
            $('#dt_tgl_prestasi').css('border-color', '#cc0000');	           
        }else{
            $('#dt_tgl_prestasi').css('border-color', '');	
        }    
        if(jenis_prestasi==''){      
            valid = false
            $('#txt_jenis_prestasi').css('border-color', '#cc0000');	           
        }else{
            $('#txt_jenis_prestasi').css('border-color', '');	
        }    
        if(peringkat==''){      
            valid = false
            $('#txt_peringkat').css('border-color', '#cc0000');	           
        }else{
            $('#txt_peringkat').css('border-color', '');	
        }    
        if(tempat_kegiatan==''){      
            valid = false
            $('#txt_tempat_kegiatan').css('border-color', '#cc0000');	           
        }else{
            $('#txt_tempat_kegiatan').css('border-color', '');	
        }    
        
        return valid
    }


    $(document).on('click', '#edit_prestasi', function () {
        var _prestasi_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_prestasi")
        var tgl_prestasi =  tbl.rows[row_index].cells[0].innerHTML;
        var nama_siswa =  tbl.rows[row_index].cells[1].innerHTML;
        var jenis_prestasi =  tbl.rows[row_index].cells[2].innerHTML;       
        var peringkat =  tbl.rows[row_index].cells[3].innerHTML;
        var tingkat_lomba =  tbl.rows[row_index].cells[4].innerHTML;
        var tempat_kegiatan =  tbl.rows[row_index].cells[5].innerHTML;
        var img_path = tbl.rows[row_index].cells[6].innerHTML;
          
        $('#_status_edit').val(true)
        $('#_prestasi_id').val(_prestasi_id)
        $('#dt_tgl_prestasi').val (tgl_prestasi)
        $('#txt_nama_siswa').val(nama_siswa)
        $('#txt_jenis_prestasi').val(jenis_prestasi)
        $('#txt_peringkat').val(peringkat)
        $('#txt_tingkat_lomba').val(tingkat_lomba)
        $('#txt_tempat_kegiatan').val(tempat_kegiatan)
      
        if (img_path!=''){
            $('#uploaded_img_prestasi_path').val(img_path)
            $('#uploaded_img_prestasi').html('')
            $('#uploaded_img_prestasi').append("<img src='"+ img_path + '?'+ new Date().getTime()+"' class='img-width'>");            
        }else{
            $('#uploaded_img_prestasi_path').val('')
            $('#uploaded_img_prestasi').html('')
            load_blank_image()
        }  
        document.documentElement.scrollTop = 0;     
    })
    

    $(document).on('click','#btnTambah', function () {                
        input_area_clear()
    })

    function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_prestasi_id').val(0)               
        var tgl = set_tgl_prestasi(new Date())        
        $('#dt_tgl_prestasi').val(tgl)
        $('#txt_nama_siswa').val('')
        $('#txt_jenis_prestasi').val('')
        $('#txt_peringkat').val('')
        $('#txt_tingkat_lomba').val('')
        $('#txt_tempat_kegiatan').val('')

        $('#uploaded_img_prestasi').html('')
        load_blank_image()
        $('#uploaded_img_prestasi_path').val('')
        $('#file_kegiatan').val(null)
    }


    $(document).on('click', '#delete_prestasi', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var prestasi_id = $(this).attr("data-id");//trade_code        
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_prestasi")
        var img_file_path = tbl.rows[row_index].cells[4].innerHTML;
        
        fetch('<?php echo site_url('prestasi/prestasi_admin/delete_prestasi') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({prestasi_id:prestasi_id, img_file_path:img_file_path}),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
                console.log(dataResult);
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{                                      
                    alert('Hapus data sukses');                          
                    fetch_data_tbl_prestasi();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })


    function set_tgl(date) {
        $('#dt_tgl_prestasi').datepicker({
        format:"yyyy-mm-dd",
        //toggleActive: true,
        autoclose: true,            
        changeMonth: true,
        changeYear: true,
        todayHighlight: true
        }).datepicker('setDate', date); 
    }

</script>

<style>  
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }

</style>