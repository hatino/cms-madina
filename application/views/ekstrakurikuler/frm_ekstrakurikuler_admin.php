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
        
        <h3 class="text-header">EKSTRAKURIKULER - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">
            <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
            <input type="hidden" name="_ekstrakurikuler_id" id="_ekstrakurikuler_id" value=0> 
            <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 
            
            <label for="txt_nama_ekstrakurikuler" class="col-sm col-form-label col-form-label-sm">Nama Ekstrakurikuler</label> 
            <div class="input-group input-group-sm">
                <input type="text" name="txt_nama_ekstrakurikuler" id="txt_nama_ekstrakurikuler" class="form-control" autocomplete="off"> 
            </div>

            <br>
            <div class="card group-sm col-sm-3">                        
                <div class="card-header">Upload Photo Ekstrakurikuler</div>
                <div class="card-body ">    
                    <!-- <div class="card">   -->
                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                        <span id="uploaded_img_ekstrakurikuler"></span>							  
                    <!-- </div> -->

                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                    <input type="hidden" name="uploaded_img_ekstrakurikuler_path" id="uploaded_img_ekstrakurikuler_path">                         
                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                    <input type="hidden" name="txtpath_img_ekstrakurikuler_ori" id="txtpath_img_ekstrakurikuler_ori"> 						 
            
                    <table>
                        <tr>
                            <td width="200">
                                <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_ekstrakurikuler').click()" style="margin-top: 5px;">
                                    <i class="bi bi-upload"></i> Browse<input type="file" name="file_ekstrakurikuler" class="form-control" id="file_ekstrakurikuler"  data-id="test-file" style="display:none;">
                                    <label for="file_ekstrakurikuler" id="lbl_file_ekstrakurikuler"></label>
                                </button>	
                                <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_ekstrakurikuler"><i class="bi bi-eraser"></i> Batal</button>				
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
        <h5>Daftar Ekstrakurikuler</h5>
        <div id="div_tbl_ekstrakurikuler"></div>
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
        //await set_tgl(new Date())        
        await load_blank_image()
        await fetch_data_tbl_ekstrakurikuler()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_ekstrakurikuler').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    function fetch_data_tbl_ekstrakurikuler(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'
        fetch('<?php echo site_url('ekstrakurikuler/Ekstrakurikuler_admin/get_data_tbl_ekstrakurikuler') ;?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
            return response.json();
        }).then(function (responseData){
            load_tbl_ekstrakurikuler(responseData.data[0]);
        });            
    }

    function load_tbl_ekstrakurikuler(data) {  
       
       var html = '';
       html += '<div>';
       html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_ekstrakurikuler">';            
       html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
       html += '		<tr class="text-nowrap">';                                        
       html += '			<th>Nama Ektrakurikuler</th>';          
       html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
       html += '		</tr>';
       html += '   </thead>';      
       
       if(data.length>0)
       {
           console.log(data)
           html += '<tbody>';
           for(var count = 0; count < data.length; count++)
           {                                         
               html += '<tr class = "col-form-label-sm" id="'+ count +'">';
               html += '   <td>'+data[count].nama_ekstrakurikuler+'</td>';  //0 
               html += '   <td style="display:none;">'+data[count].img_path+'</td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="edit_ekstrakurikuler" data-id='+data[count].ekstrakurikuler_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="delete_ekstrakurikuler" data-id='+data[count].ekstrakurikuler_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
               html += '</tr>';                                                                                                   
           }
           html += '</tbody>';      
           //$('#pesan').find("h6:first").text(dataResult.length + ' records');
       }                
       html += '</table>';
       html += '</div>';
                       
       document.getElementById("div_tbl_ekstrakurikuler").innerHTML = html;           
   }


   $(document).on('submit','#simpan_form', async function () {
        event.preventDefault(); 
        var status_edit = $('#_status_edit').val()

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    

        let file_ekstrakurikuler = $('#file_ekstrakurikuler').val()
        if (status_edit=='true' && file_ekstrakurikuler != ''){
            await upload_file_ekstrakurikuler('simpan')
        }

        var form_data= $(this).serialize();

        fetch('<?php echo site_url('ekstrakurikuler/ekstrakurikuler_admin/simpan_ekstrakurikuler') ;?>',{
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
                    var ekstrakurikuler_id = dataResult.data                   
                    $('#_ekstrakurikuler_id').val(ekstrakurikuler_id)

                    if (status_edit=='false'){                        
                        await simpan_img_path(ekstrakurikuler_id)   
                    }
                
                    $('#_status_edit').val(true)                                  
                    await fetch_data_tbl_ekstrakurikuler()                    
                    alert('Simpan data sukses');    
                    //fetch_data_profile_yayasan()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    function validasi_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];       
        let nama_ekstrakurikuler = x["txt_nama_ekstrakurikuler"].value;
        
        if(nama_ekstrakurikuler==''){      
            valid = false
            $('#txt_nama_ekstrakurikuler').css('border-color', '#cc0000');	           
        }else{
            $('#txt_nama_ekstrakurikuler').css('border-color', '');	
        }    
        return valid
    }

    $(document).on('change', '#file_ekstrakurikuler', function()
	{			
        try {   
            var name_obj =document.getElementById("file_ekstrakurikuler").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_ekstrakurikuler").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_ekstrakurikuler").files[0]);
            var f = document.getElementById("file_ekstrakurikuler").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_ekstrakurikuler('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});

    async function upload_file_ekstrakurikuler(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var ekstrakurikuler_id = $('#_ekstrakurikuler_id').val()
        var img_file_path_ori = $('#uploaded_img_ekstrakurikuler_path').val()
        form_data.append("file_ekstrakurikuler", document.getElementById('file_ekstrakurikuler').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "ekstrakurikuler"); 
        form_data.append("ekstrakurikuler_id", ekstrakurikuler_id);        
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
                
                $('#uploaded_img_ekstrakurikuler').html("");	
                $('#uploaded_img_ekstrakurikuler').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_ekstrakurikuler_path').val("")
                $('#uploaded_img_ekstrakurikuler_path').val(path_view);                  
            }
        });
    }

    async function simpan_img_path(ekstrakurikuler_id) {                       
        await upload_file_ekstrakurikuler('simpan');  
        let img_file_path =  $('#uploaded_img_ekstrakurikuler_path').val();  
        var form_data = new FormData();
        form_data.append("ekstrakurikuler_id", ekstrakurikuler_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('ekstrakurikuler/ekstrakurikuler_admin/simpan_img_path') ;?>',{
                    method: 'POST',   
                    //data:{'ekstrakurikuler_id':ekstrakurikuler_id, 'img_file_path':img_file_path},
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


    $(document).on('click','#btnTambah', function () {                
        input_area_clear()
    })

    function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_ekstrakurikuler_id').val(0)        
        $('#txt_nama_ekstrakurikuler').val('')     
        $('#uploaded_img_ekstrakurikuler').html('')
        load_blank_image()
        $('#uploaded_img_ekstrakurikuler_path').val('')
        $('#file_ekstrakurikuler').val(null)
    }

    $(document).on('click', '#edit_ekstrakurikuler', function () {
        var _ekstrakurikuler_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_ekstrakurikuler")
        var nama_ekstrakurikuler =  tbl.rows[row_index].cells[0].innerHTML;       
        var img_path = tbl.rows[row_index].cells[1].innerHTML;
    
        $('#_status_edit').val(true)
        $('#_ekstrakurikuler_id').val(_ekstrakurikuler_id)
        $('#txt_nama_ekstrakurikuler').val(nama_ekstrakurikuler)               
        $('#uploaded_img_ekstrakurikuler_path').val(img_path)
        $('#uploaded_img_ekstrakurikuler').html('')
        $('#uploaded_img_ekstrakurikuler').append("<img src='"+ img_path + "' class='img-width'>");
    })


    $(document).on('click', '#delete_ekstrakurikuler', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var ekstrakurikuler_id = $(this).attr("data-id");//trade_code        
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_ekstrakurikuler")
        var img_file_path = tbl.rows[row_index].cells[1].innerHTML;
        
        fetch('<?php echo site_url('ekstrakurikuler/ekstrakurikuler_admin/delete_ekstrakurikuler') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({ekstrakurikuler_id:ekstrakurikuler_id, img_file_path:img_file_path}),
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
                    fetch_data_tbl_ekstrakurikuler();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

</script>


<style>  
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }

</style>