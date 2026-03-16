<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>       
      
    
</head>
<body onload="init_form()">
       
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>
        <h3 class="text-header"><strong>Sejarah Yayasan</strong></h3>
        <hr style="margin-top: 5px;">

            <form method="post" id="simpan_form">
                <textarea name="txt_sejarah" id="txt_sejarah" class="editor form-control"></textarea>  

                <div style="line-height: 5px;">
                    <br>
                </div>

                <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Sejarah</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_image_sejarah"></span>							  
                        <!-- </div> -->

                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_image_sejarah_path" id="uploaded_image_sejarah_path">                         
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="txtpath_image_sejarah_ori" id="txtpath_image_sejarah_ori"> 						 

                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-shadow btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_sejarah').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_sejarah" class="form-control" id="file_sejarah"  data-id="test-file" style="display:none;">
                                        <label for="file_sejarah" id="lbl_file_sejarah"></label>
                                    </button>&nbsp;	
                                    <button type="button" class="btn btn-shadow btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_sejarah"><i class="bi bi-eraser"></i> Batal</button>				
                                </td>
                            </tr>	  		
                        </table>	  
                                            
                    </div>

                    <div class="card-footer text-muted">
                        Jenis File : jpg, jpeg, png <br>
                        Max Size : 2 MB
                    </div>
                </div>

                <hr style="margin-bottom: 5px;">
                <button type="submit" id="btnSubmit" class="btn btn-shadow btn-submit btn-sm"><i class="bi bi-save2"></i> Submit</button>
                <!-- <button type="button" id="btnClear" class="btn btn-clear btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Clear</button>
                <button type="button" id="btnDelete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button> -->
                <br>
                <br>
                <br>
            </form>
    </div>
    
</body>
</html>


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

    window.editors = {};

    document.querySelectorAll( '.editor' ).forEach( ( node, index ) => {
    ClassicEditor
        .create( node, {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, Paragraph, Bold, Italic, Font, Alignment ],           
                toolbar: [
                    'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'alignment'
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
        .then( newEditor => {
            window.editors[ index ] = newEditor 
        } );
    } );       
</script>


<script type="text/javascript">
   
    async function init_form() {        
        await load_blank_image()   
        await fetch_data_sejarah_yayasan()
    }
   
    function load_blank_image() {        
        var path_blank_image = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';       
        $('#uploaded_image_sejarah').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    async function fetch_data_sejarah_yayasan() {       
       var result_data = await fetch("<?php echo site_url('sejarah/sejarah_admin/get_data_sejarah_yayasan');?>", {method:"GET", mode: "no-cors" })           
       const result = await result_data.json()                             
       if(result.data.length > 0){   
           let x = result.data[0]                            
           window.editors[0].setData(x.sejarah)        
           var path_sejarah;
           if (x.photo_sejarah_path==null || x.photo_sejarah_path=='' || x.photo_sejarah_path==undefined){	                 
               path_sejarah = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';						
               $('#txtpath_image_sejarah_ori').val('');     
               $('#uploaded_image_sejarah_path').val('');            
               $('#uploaded_image_sejarah').html('');
               $('#uploaded_image_sejarah').append("<img src='"+ path_sejarah + "' class='img-width'>");  
               $('#file_sejarah').val(null)             							
               
           }else{
               path_sejarah = x.photo_sejarah_path;			                				
               $('#txtpath_image_sejarah_ori').val(path_sejarah); 
               $('#uploaded_image_sejarah_path').val(path_sejarah);                 
               $('#uploaded_image_sejarah').html('');
               $('#uploaded_image_sejarah').append("<img src='"+ path_sejarah+'?'+ new Date().getTime()+"' class='img-width' id='img_new'>");                
           }
        }
    }

    $(document).on('change', '#file_sejarah', async function(){
        
        var name = document.getElementById("file_sejarah").files[0].name;		 
        var ext = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
        {
            alert("Invalid Image File");
        }

        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_sejarah").files[0]);
        var f = document.getElementById("file_sejarah").files[0];
        var fsize = f.size||f.fileSize;
        if(fsize > 2000000)
        {
                    alert("Image File Size is very big");
        }
        else
        {
                await upload_file_sejarah('upload');
                
        }
    });

    $(document).on('submit','#simpan_form', async function (event) {
       event.preventDefault();         
       txt_sejarah = $('#txt_sejarah').val()
       if(txt_sejarah==''){
            alert('Silahkan isi sejarah');
            window.editors[0].focus();
            return false;
       }    
       //SIMPAN TERLEBIH DAHULU FILE IMGNYA
       let file_sejarah = $('#file_sejarah').val()
       if (file_sejarah != ''){
           await upload_file_sejarah('simpan');
       }
       var form_data= $(this).serialize();
       await fetch("<?php echo site_url('sejarah/sejarah_admin/simpan_sejarah_yayasan');?>",{
                   method: 'POST',   
                   body: new URLSearchParams(form_data),
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
                   //tidak terjadi error                             
                   alert(dataResult.message);                                                                                 
               }
           })
       .catch(err => {
           alert(err);
       });    
    })
 
 
    async function upload_file_sejarah($par) {
            var form_data = new FormData();
            if ($par=='upload'){
                $status_simpan = 'false';
            }else{
                $status_simpan = 'true';
            }
            
            form_data.append("file_sejarah", document.getElementById('file_sejarah').files[0]);  
            form_data.append("status_simpan", $status_simpan); 
            form_data.append("jenis_dokumen", "sejarah"); 
            var img_file_path_ori = $('#uploaded_image_sejarah_path').val();
            form_data.append("img_file_path_ori", img_file_path_ori);
            
            await $.ajax(
            {
                //url:"/upload",
                url:"<?php echo base_url()?>uploadfile.php",    
                method:"POST",
                data: form_data,
                contentType: false,
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
                   
                    $('#uploaded_image_sejarah').html("");	
                    $('#uploaded_image_sejarah').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#uploaded_image_sejarah_path').val("")
                    $('#uploaded_image_sejarah_path').val(path_view);   
                }
            });
    }

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