<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
</head>
<body>

    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">
    
        <h3 class="text-header">FASILITAS - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">

            <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
            <input type="hidden" name="_fasilitas_id" id="_fasilitas_id" value=0> 
            <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 
            <label for="txt_keterangan_fasilitas" class="col-sm col-form-label col-form-label-sm">Keterangan Fasilitas</label> 
                         
            <textarea type="text" name="txt_keterangan_fasilitas" id="txt_keterangan_fasilitas" class="form-control" autocomplete="off"></textarea>    
            
            <br>
            <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Fasilitas</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_img_fasilitas"></span>							  
                        <!-- </div> -->
    
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_img_fasilitas_path" id="uploaded_img_fasilitas_path">                         
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="uploaded_img_fasilitas_path_ori" id="uploaded_img_fasilitas_path_ori"> 						 
                
                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_fasilitas').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_fasilitas" class="form-control" id="file_fasilitas"  data-id="test-file" style="display:none;">
                                        <label for="file_fasilitas" id="lbl_file_fasilitas"></label>
                                    </button>	
                                    <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_fasilitas"><i class="bi bi-eraser"></i> Batal</button>				
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

        <h5>Daftar Fasilitas</h5>
        <div id="div_tbl_fasilias"></div>
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
        await load_blank_image()
        await fetch_tbl_fasilitas()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_fasilitas').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    function fetch_tbl_fasilitas(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('fasilitas/fasilitas_admin/get_data_tbl_fasilitas') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){       
            load_tbl_fasilitas(responseData.data[0]);               
        });            
    }

    function load_tbl_fasilitas(data) {  
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_fasilitas">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Keterangan Fasilitas</th>';        
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {                
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td>'+data[count].keterangan+'</td>';  //0              
                html += '   <td style="display:none;">'+data[count].img_path+'</td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_fasilitas" data-id='+data[count].fasilitas_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_fasilitas" data-id='+data[count].fasilitas_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("div_tbl_fasilias").innerHTML = html;           
    }


    $(document).on('change', '#file_fasilitas', function()
	{			
        try {   
            var name_obj =document.getElementById("file_fasilitas").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_fasilitas").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_fasilitas").files[0]);
            var f = document.getElementById("file_fasilitas").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_fasilitas('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_fasilitas(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var fasilitas_id = $('#_fasilitas_id').val()
        var img_file_path_ori = $('#uploaded_img_fasilitas_path').val()
        form_data.append("file_fasilitas", document.getElementById('file_fasilitas').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "fasilitas"); 
        form_data.append("fasilitas_id", fasilitas_id);        
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
                console.log(dataResult)
                var path_view = dataResult.path_view;
                var path_save = dataResult.path_save;
                
                $('#uploaded_img_fasilitas').html("");	
                $('#uploaded_img_fasilitas').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_fasilitas_path').val("")
                $('#uploaded_img_fasilitas_path').val(path_save);  
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
     
        var form_data= $(this).serialize();

        fetch('<?php echo site_url('fasilitas/fasilitas_admin/simpan_fasilitas') ;?>',{
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

                    var fasilitas_id = dataResult.data                   
                    $('#_fasilitas_id').val(fasilitas_id)
                    //data edit, file path from db
                    var file_path_exists = $('#uploaded_img_fasilitas_path_ori').val()
                    //reupload file img
                    var file_path_uploaded = $('#uploaded_img_fasilitas_path').val()             
                    
                    if (status_edit=='true'){
                        //jika ada upload file img baru
                        if (file_path_uploaded!=''){
                            if(file_path_exists!=''){
                                //hapus file yang lama
                                await delete_file_fasilitas(file_path_exists)
                            }                           
                            await upload_file_fasilitas('simpan')
                            await simpan_img_path(fasilitas_id)
                        }                
                        
                    }else{
                        if (file_path_uploaded!=''){
                            await upload_file_fasilitas('simpan')
                            await simpan_img_path(fasilitas_id)  
                        } 
                    }                                   
                                                
                    await fetch_tbl_fasilitas()
                    alert('Simpan data sukses');   
                    await input_area_clear()                                                                               
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    async function delete_file_fasilitas(file_fasilitas_path) {
        var form_data = new FormData();
        form_data.append("img_file_path", file_fasilitas_path);

        await $.ajax(
        {
            url:"<?php echo base_url()?>deletedfile.php",
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
                console.log(dataResult)
                // var path_view = dataResult.path_view;
                // var path_save = dataResult.path_save;
                
                // $('#uploaded_img_fasilitas').html("");	
                // $('#uploaded_img_fasilitas').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                // $('#uploaded_img_fasilitas_path').val("")
                // $('#uploaded_img_fasilitas_path').val(path_view);  
            }
        });

    }


    async function simpan_img_path(fasilitas_id) {                       
        // await upload_file_fasilitas('simpan');  
        let img_file_path =  $('#uploaded_img_fasilitas_path').val();  
        var form_data = new FormData();
        form_data.append("fasilitas_id", fasilitas_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('fasilitas/fasilitas_admin/simpan_img_path') ;?>',{
                    method: 'POST',   
                    //data:{'kegiatan_id':kegiatan_id, 'img_file_path':img_file_path},
                    body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
            //alert('Simpan data sukses');        
            //console.log(dataResult.data);      
            })
        .catch(err => {
            alert(err);
        });           
    }


    function validasi_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];       
        let keterangan_fasilitas = x["txt_keterangan_fasilitas"].value;
             
        if(keterangan_fasilitas==''){      
            valid = false
            $('#txt_keterangan_fasilitas').css('border-color', '#cc0000');	           
        }else{
            $('#txt_keterangan_fasilitas').css('border-color', '');	
        }    
               
        return valid
    }


    $(document).on('click', '#edit_fasilitas', function () {
       
        var _fasilitas_id = $(this).attr("data-id");//trade_code       
        var row_index = $(this).closest("tr").index()+1;        
        var tbl = document.getElementById("tbl_fasilitas")        
        var keterangan_fasilitas =  tbl.rows[row_index].cells[0].innerHTML;       
        var img_path_ori = tbl.rows[row_index].cells[1].innerHTML;
        var img_path = '<?php echo base_url() ;?>'+img_path_ori;
                
        $('#_status_edit').val(true)
        $('#_fasilitas_id').val(_fasilitas_id)
        $('#txt_keterangan_fasilitas').val(keterangan_fasilitas)
        window.editor.setData(keterangan_fasilitas)
        if(img_path_ori!=''){
            $('#uploaded_img_fasilitas_path_ori').val(img_path_ori)
            $('#uploaded_img_fasilitas').html('')
            $('#uploaded_img_fasilitas').append("<img src='"+ img_path + "' class='img-width'>");
        }else{
            $('#uploaded_img_fasilitas_path_ori').val('')
            $('#uploaded_img_fasilitas').html('')
            //$('#uploaded_img_fasilitas').append("<img src='"+ img_path + "' class='img-width'>");
        }
        

    })


    $(document).on('click', '#delete_fasilitas', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var fasilitas_id = $(this).attr("data-id");//trade_code        
        var row_index = $(this).closest("tr").index()+1;       
        var tbl = document.getElementById("tbl_fasilitas")
        var img_file_path = tbl.rows[row_index].cells[1].innerHTML;
   
        fetch('<?php echo site_url('fasilitas/fasilitas_admin/delete_fasilitas') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({fasilitas_id:fasilitas_id, img_file_path:img_file_path}),
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
                    if(img_file_path!=''){
                       delete_file_fasilitas(img_file_path)
                    }               
                    
                    alert('Hapus data sukses');                          
                    fetch_tbl_fasilitas();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })


    $(document).on('click','#btnTambah', function () {                
        input_area_clear()
    })

    function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_fasilitas_id').val(0)        
        $('#txt_keterangan_fasilitas').val('')  
        window.editor.setData('')
        $('#uploaded_img_fasilitas').html('')
        load_blank_image()
        $('#uploaded_img_fasilitas_path').val('')
        $('#uploaded_img_fasilitas_path_ori').val('')
        $('#file_fasilitas').val(null)
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
        Alignment, 
        AutoLink, 
        Link,
        List        
    } from 'ckeditor5';
   
    ClassicEditor
        .create( document.querySelector( '#txt_keterangan_fasilitas' ), {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, 
                       Paragraph, Bold, Italic, Font, Alignment, Link, AutoLink, List                     
            ],           
            toolbar: [
                'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor' , 'alignment', 'link',
                'bulletedList', 'numberedList'
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
            },
            link: {
                    // Automatically add target="_blank" and rel="noopener noreferrer" to all external links.
                    addTargetToExternalLinks: true,

                    // Let the users control the "download" attribute of each link.
                    decorators: [
                        {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'download'
                            }
                        }
                    ]
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
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
        min-height: 100px;    
    }

    .img-width {
        width: 185pt;
        height: 185ptt;
    }
</style>