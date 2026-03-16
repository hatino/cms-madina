<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">             
        
        <h3 class="text-header"><strong>Lowongan</strong></h3>
        <hr style="margin-top: 5px;">
    
        <form method="post" id="simpan_form">
            <input type="hidden" name="_status_edit" id="_status_edit" value=false>         
            <input type="hidden" name="_lowongan_id" id="_lowongan_id" value=0>

            <div class="row">
                <div class="col-sm-2">
                    <label for="list_status_lowongan" class="col-sm col-form-label col-form-label-sm">Status Lowongan</label>                                      
                </div>
                <div class="col-sm-4">
                <div class="input-group input-group-sm">   
                    <select name="list_status_lowongan" id="list_status_lowongan" class="form-select">
                        <option style="color:black" value="1" selected>Buka</option>
                        <option style="color:black" value="0">Tutup</option>
                    </select>
                </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-2">
                    <label for="txt_deskripsi_lowongan" class="col-sm col-form-label col-form-label-sm">Deskripsi</label> 
                </div>
                <div class="col-sm-10">
                    <textarea type="text" name="txt_deskripsi_lowongan" id="txt_deskripsi_lowongan" class="form-control" autocomplete="off"></textarea>    
                </div>
            </div>

            <br>
            <div class="card group-sm col-sm-3">                        
                <div class="card-header">Upload Photo lowongan</div>
                <div class="card-body ">    
                    <!-- <div class="card">   -->
                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                        <span id="uploaded_img_lowongan"></span>							  
                    <!-- </div> -->

                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                    <input type="hidden" name="uploaded_img_lowongan_path" id="uploaded_img_lowongan_path">                         
                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                    <input type="hidden" name="txtpath_img_lowongan_ori" id="txtpath_img_lowongan_ori"> 						 
            
                    <table>
                        <tr>
                            <td width="200">
                                <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_lowongan').click()" style="margin-top: 5px;">
                                    <i class="bi bi-upload"></i> Browse<input type="file" name="file_lowongan" class="form-control" id="file_lowongan"  data-id="test-file" style="display:none;">
                                    <label for="file_lowongan" id="lbl_file_lowongan"></label>
                                </button>	
                                <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_lowongan"><i class="bi bi-eraser"></i> Batal</button>				
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
            <hr id="batas">

            <h5>Daftar Lowongan</h5>
            <div id="div_tbl_lowongan"></div>
            <br>
                                            
        </form>
    </div>
</body>
</html>


<script type="text/javascript">   
    async function init_form() {
        await load_blank_image()
        await fetch_tbl_lowongan()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_lowongan').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    $(document).on('change', '#file_lowongan', function()
	{			
        try {   
            var name_obj =document.getElementById("file_lowongan").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_lowongan").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_lowongan").files[0]);
            var f = document.getElementById("file_lowongan").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_lowongan('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});

    async function upload_file_lowongan(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var lowongan_id = $('#_lowongan_id').val()
        var img_file_path_ori = $('#uploaded_img_lowongan_path').val()
        form_data.append("file_lowongan", document.getElementById('file_lowongan').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "lowongan"); 
        form_data.append("lowongan_id", lowongan_id);        
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
                
                $('#uploaded_img_lowongan').html("");	
                $('#uploaded_img_lowongan').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_lowongan_path').val("")
                $('#uploaded_img_lowongan_path').val(path_view);
            }
        });
    }

    $(document).on('submit','#simpan_form', async function () {
        event.preventDefault(); 
        var status_edit = $('#_status_edit').val()
        
        let judul_lowongan = $('#txt_judul_lowongan').val();   
        if( judul_lowongan == false){	    
            $('#txt_judul_lowongan').css('border-color', '#cc0000');	         
            $('#txt_judul_lowongan').focus();
            alert('Silahkan isi judul');
            return false;
        }else{
            $('#txt_judul_lowongan').css('border-color', '');	
        }
        
        let deskripsi = $('#txt_deskripsi_lowongan').val();   
        if( deskripsi == false){	        
            // $('#txt_deskripsi_lowongan').focus();
            window.editor.focus();
            alert('Silahkan isi deskripsi');
            return false;
        }    
       
        let file_lowongan_content =  $('#file_lowongan').val();     
        if (status_edit=='true' && file_lowongan_content !=''){
            await upload_file_lowongan('simpan')
        }

        var form_data= $(this).serialize();

        fetch('<?php echo site_url('lowongan/lowongan_admin/simpan_lowongan') ;?>',{
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
                    var lowongan_id = dataResult.data                   
                    $('#_lowongan_id').val(lowongan_id)

                    if (status_edit=='false' && file_lowongan_content !='' ){                        
                        await simpan_img_path(lowongan_id)   
                    }                
                    $('#_status_edit').val(true)   
                    alert('Simpan data sukses');                                 
                    await fetch_tbl_lowongan()                      
                    await input_area_clear()                                                                        
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    $(document).on('click', '#btnTambah', function () {
        input_area_clear()            
        document.documentElement.scrollTop = 0;
    })

    $(document).on('click', '#edit_lowongan', function () {       
        var lowongan_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_lowongan")
        var status_lowongan =  tbl.rows[row_index].cells[0].innerHTML;    
        var deskripsi_lowongan = tbl.rows[row_index].cells[1].innerHTML; 
        var img_path = tbl.rows[row_index].cells[3].innerHTML;
                   
        $('#_status_edit').val(true)
        $('#_lowongan_id').val(lowongan_id)      
        $('#txt_status_lowongan').val(status_lowongan)        
        window.editor.setData(deskripsi_lowongan)
        $('#uploaded_img_lowongan_path').val(img_path)
        $('#uploaded_img_lowongan').html('')
        $('#uploaded_img_lowongan').append("<img src='"+ img_path + '?'+ new Date().getTime()+"' class='img-width'>");
        document.documentElement.scrollTop = 0;
    })

    $(document).on('click', '#delete_lowongan', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var lowongan_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_lowongan")        
        var img_file_path = tbl.rows[row_index].cells[3].innerHTML;
                     
        fetch('<?php echo site_url('lowongan/lowongan_admin/delete_lowongan') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({lowongan_id:lowongan_id, img_file_path:img_file_path}),
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
                    fetch_tbl_lowongan();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

    async function simpan_img_path(lowongan_id) {                       
        await upload_file_lowongan('simpan');  
        let img_file_path =  $('#uploaded_img_lowongan_path').val();  
        var form_data = new FormData();
        form_data.append("lowongan_id", lowongan_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('lowongan/lowongan_admin/simpan_img_path') ;?>',{
                    method: 'POST',   
                    //data:{'lowongan_id':lowongan_id, 'img_file_path':img_file_path},
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

    function fetch_tbl_lowongan(){      
        fetch('<?php echo site_url('lowongan/lowongan_admin/get_data_tbl_lowongan') ;?>')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){                        
            var data = responseData.data
            console.log(responseData)      
            var html = '';   
            var path_img = '';
            
            var html = '';                
            html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_lowongan">';            
            html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
            html += '		<tr class="text-nowrap">';                                        
            html += '			<th>Judul lowongan</th>';
            html += '           <th>Deskripsi lowongan</th>';
            html += '           <th>Image</th>';
            html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
            html += '		</tr>';
            html += '   </thead>';      

            if(data.length>0)
            {               
                html += '<tbody>';
                for(var count = 0; count < data.length; count++)
                {              
                    path_img = data[count].img_path; 
                    html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                    html += '   <td width="20%">'+data[count].status_lowongan+'</td>';  //0                
                    html += '   <td >'+data[count].deskripsi_lowongan+'</td>';
                    if(data[count].img_path != ''){
                    html += '   <td width="20%" style="text-align:center;"><img src='+ path_img +'?'+ new Date().getTime()+' width="100pt", height="80pt"></td>';             
                    }else{
                    html += '   <td width="20%" style="text-align:center;"></td>';             
                    }                
                    html += '   <td style="display:none;">'+path_img+'</td>';                        
                    html += '   <td align="center" style="cursor: pointer;"> <a id="edit_lowongan" data-id='+data[count].lowongan_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                    html += '   <td align="center" style="cursor: pointer;"> <a id="delete_lowongan" data-id='+data[count].lowongan_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                    html += '</tr>';                                                                                                   
                }
                html += '</tbody>';      
            }	
            html +='</table>';  

            document.getElementById("div_tbl_lowongan").innerHTML = html   
        });            
    }

    function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_lowongan_id').val(0)        
        $('#txt_judul_lowongan').val('')     
        window.editor.setData("")   
        $('#uploaded_img_lowongan').html('')       
        $('#uploaded_img_lowongan_path').val('') 
        load_blank_image()       
        $('#file_lowongan').val(null)
    }

</script>




<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.0/"
        }
    }
</script>

<script type="module">
    import {
        ClassicEditor,
        Table, TableCellProperties, TableProperties, TableToolbar ,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font,
        Alignment
    } from 'ckeditor5';
   
    ClassicEditor
        .create( document.querySelector( '#txt_deskripsi_lowongan' ), {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, Paragraph, Bold, Italic, Font, Alignment ],           
            toolbar: [
                'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor' , 'alignment'
            ],
            alignment : ['left', 'right', 'center', 'justify'],
            table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells',
                        'tableProperties', 'tableCellProperties'
                    ],

                    tableProperties: {
                        // The configuration of the TableProperties plugin.
                        // ...
                    },

                    tableCellProperties: {
                        // The configuration of the TableCellProperties plugin.
                        // ...
                    }
            }
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 200px;    
    }
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }
</style>