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
        <h3 class="text-header mb-1 fw-bold">Kurikulum - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">
        <button type="button" id="btn_import" class="btn-sm mb-3 btn-shadow btn-primary">Import dari www.swiislamicshcool.sch.id</button>

        <form method="post" id="simpan_form">
            <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 

            <label for="txt_sejarah" class="col-sm col-form-label col-form-label-sm">Penjelasan : </label>
            <textarea name="txt_penjelasan" id="txt_penjelasan" class="editor form-control"></textarea>  
            <br>
            <label for="txt_sejarah" class="col-sm col-form-label col-form-label-sm">Sistem Pembelajaran dan Penilaian : </label>
            <textarea name="txt_sistem_pembelajaran" id="txt_sistem_pembelajaran" class="editor form-control"></textarea> 
            <br>
            <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Kurikulum</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_img_kurikulum"></span>							  
                        <!-- </div> -->
    
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_img_kurikulum_path" id="uploaded_img_kurikulum_path">                         
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="txtpath_img_kurikulum_ori" id="txtpath_img_kurikulum_ori"> 						 
                
                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('file_kurikulum').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_kurikulum" class="form-control" id="file_kurikulum"  data-id="test-file" style="display:none;">
                                        <label for="file_kurikulum" id="lbl_file_kurikulum"></label>
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-secondary btn-shadow btn-sm" style="margin-top: 5px;" id="hapus_file_kurikulum"><i class="bi bi-eraser"></i> Batal</button>				
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
                <button type="submit" id="btnSubmit" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Submit</button>

                <br><br>
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
    var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
    var data_kurikulum = false;
    
    document.addEventListener('DOMContentLoaded', async function() {
       
        await init_form()
        
        document.querySelector('#btn_import').addEventListener('click', async function import_pelajaran() {       
            
            let response = await fetch('<?php echo site_url('kurikulum/kurikulum_admin/get_data_kurikulum_api') ;?>?kode_jenjang='+kode_jenjang)
            let dataResult = await response.json()
            
            if(dataResult.status==true) {               
                if(dataResult.data[0].length > 0){                    
                    if(data_kurikulum == true){
                        let tanya = confirm('Data sudah ada, apakah ingin ditimpa menggunakan data import?')
                        if (tanya==true){
                            hasil = await simpan_import_kurikulum(dataResult) 
                            alert(hasil.message)      
                            fetch_data_kurikulum(kode_jenjang)                        
                        }
                        return false
                    }
                    hasil = await simpan_import_kurikulum(dataResult)
                    alert(hasil.message)   
                    fetch_data_kurikulum(kode_jenjang)
                    
                }else{
                    alert('Data tidak ditemukan')
                }
            }else{
                alert('Terjadi kesalahan import data')
            }   
        })
    
        async function simpan_import_kurikulum(data) {
            var json_data = JSON.stringify(data);   
            let result_data = await fetch('<?php echo site_url('kurikulum/kurikulum_admin/simpan_import_kurikulum') ;?>',{
                        method: 'POST',   
                        body: json_data,
                        //body: form_data,
                        //headers: {'Content-Type': 'multipart/json'}                  
                    })
            let result = await result_data.json()
            return result        
        }
    })


    async function init_form() {    
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;
        $('#_kode_jenjang').val(kode_jenjang)       
        await load_blank_image()
        await fetch_data_kurikulum(kode_jenjang)
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_kurikulum').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    async function fetch_data_kurikulum(kode_jenjang) {   
        
        let respose = await fetch('<?php echo site_url('kurikulum/kurikulum/get_data_kurikulum');?>?kode_jenjang='+kode_jenjang+'')
        let responseData = await respose.json()
        var data = responseData.data[0]  
        var x = data[0]     
       
        if (data.length>0){
            data_kurikulum = true            
            window.editors[0].setData(x.penjelasan)
            window.editors[1].setData(x.sistem_pembelajaran_nilai)	
            var img_path = x.img_path

            if (x.img_path==null || x.img_path=='' || x.img_path==undefined){	
                img_path = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';           				                
                $('#txtpath_img_kurikulum_ori').val(''); 
                $('#uploaded_img_kurikulum_path').val('');
                $('#uploaded_img_kurikulum').html('');
                $('#uploaded_img_kurikulum').append("<img src='"+ img_path + "' class='img-width'>");									
                $('#file_kurikulum').val(null)
            }else{
                img_path = x.img_path;						
                $('#txtpath_img_kurikulum_ori').val(img_path); 
                $('#uploaded_img_kurikulum_path').val(img_path);
                $('#uploaded_img_kurikulum').html('');
                $('#uploaded_img_kurikulum').append("<img src='"+ img_path + "' class='img-width'>");					
            }     

        }else{
            window.editors[0].setData("")
            window.editors[1].setData("")	              
        }       
    }


    $(document).on('change', '#file_kurikulum', function()
	{			
        try {   
            var name_obj =document.getElementById("file_kurikulum").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_kurikulum").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_kurikulum").files[0]);
            var f = document.getElementById("file_kurikulum").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_kurikulum('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_kurikulum($par) {
            var form_data = new FormData();
            if ($par=='upload'){
                $status_simpan = 'false';
            }else{
                $status_simpan = 'true';
            }
            
            form_data.append("file_kurikulum", document.getElementById('file_kurikulum').files[0]);  
            form_data.append("status_simpan", $status_simpan);           
            form_data.append("jenis_dokumen", "kurikulum"); 
            var kode_jenjang = $('#_kode_jenjang').val();
            form_data.append("kode_jenjang", kode_jenjang); 
            var img_file_path_ori = $('#uploaded_img_kurikulum_path').val();
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
                   
                    $('#uploaded_img_kurikulum').html("");	
                    $('#uploaded_img_kurikulum').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#uploaded_img_kurikulum_path').val("")
                    $('#uploaded_img_kurikulum_path').val(path_view);   
                }
            });
    }


    $(document).on('submit','#simpan_form', async function () {
       
       event.preventDefault();  
                    
       var valid_data = await validasi_submit();        
       if( valid_data == false){	        
           alert('Silahkan isi data yang diperlukan');
           return false;
       }    
    
       //SIMPAN TERLEBIH DAHULU FILE IMGNYA
       let file_kurikulum = $('#file_kurikulum').val()
       if (file_kurikulum != ''){
           await upload_file_kurikulum('simpan');
       }
             
       var form_data= $(this).serialize();

       await fetch("<?php echo site_url('kurikulum/kurikulum_admin/simpan_kurikulum');?>",{
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


    async function validasi_submit() {
        let valid=true;		
        x = document.forms['simpan_form']
        var penjelasan = x['txt_penjelasan'].value;
               
        if(penjelasan==''){
            valid = false
            $('#txt_penjelasan').css('border-color', '#cc0000');
        }else{
            $('#txt_penjelasan').css('border-color', '');
        }     
        
        return valid;
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