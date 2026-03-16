<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body>

    <body onload="init_form()"></body>
    
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>
        <h3 class="text-header mb-1"><strong>Profil Sekolah</strong></h3>
        <hr style="margin: 3px 0;">

            <form method="post" id="simpan_form">

                <table class="table table-borderless" style="margin-bottom: 5px;">
                    <tr>
                        <td width="150">
                            <label for="list_jenjang_div" class="col-sm col-form-label col-form-label-sm">Unit Sekolah</label> 
                        </td>
                        <td>
                            <div class="input-group-sm col-sm-8">
                            <div class="input-group input-group-sm">
                                <div class="input-group input-group-sm" name="list_jenjang_div" id="list_jenjang_div"></div>
                            </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="table table-sm">
                    <tr class="borderless-bottom">
                        <td >
                            <label for="txt_nama_sekolah" class="col-sm col-form-label col-form-label-sm">Nama Sekolah</label>
                            <div class="input-group-sm col-sm-12">
                                <input type="text" name="txt_nama_sekolah" id="txt_nama_sekolah" class="form-control">                            
                            </div>
                        </td>                                      
                    </tr>                              
                    <tr class="borderless-bottom">
                        <td >
                            <label for="txt_alamat" class="col-sm col-form-label col-form-label-sm">Alamat</label>
                            <div class="input-group input-group-sm col-sm-10">
                                <textarea type="text" name="txt_alamat" id="txt_alamat" class="form-control"></textarea>
                            </div>
                        </td>                                         
                    </tr>
                    <tr class="borderless-bottom">
                        <td width="120">
                            <label for="txt_telp" class="col-sm col-form-label col-form-label-sm">Telp.</label>
                            <div class="input-group input-group-sm col-sm-10">
                                <input type="text" name="txt_telp" id="txt_telp" class="form-control">                            
                            </div>
                        </td>                                                           
                    </tr>            
                    <tr class="borderless-bottom">
                        <td width="120">
                            <label for="txt_hotline" class="col-sm col-form-label col-form-label-sm">No. Hotline</label>
                            <div class="input-group input-group-sm col-sm-10">
                                <input type="text" name="txt_hotline" id="txt_hotline" class="form-control">                            
                            </div>
                        </td>                                                 
                    </tr>
                    <tr class="borderless-bottom">
                        <td width="120">
                            <label for="txt_hotline" class="col-sm col-form-label col-form-label-sm">Petugas</label>
                            <div class="input-group input-group-sm col-sm-10">
                                <input type="text" name="txt_petugas" id="txt_petugas" class="form-control">                            
                            </div>
                        </td>                                                 
                    </tr>      
                                    
                </table>
                
                <hr style="margin-bottom: 5px; border: 2px solid red;">

                <label for="txt_google_map" class="col-sm col-form-label col-form-label-sm">Lokasi (Google Map)</label>
                <div class="input-group input-group-sm col-sm-10">
                    <textarea type="text" name="txt_google_map" id="txt_google_map" class="form-control" rows="4"></textarea>                            
                </div>

                <hr style="margin-bottom: 5px; border: 2px solid red;">            

                <label for="txt_visi" class="col-sm col-form-label col-form-label-sm">VISI</label>               
                <textarea name="txt_visi" id="txt_visi" class="editor form-control"></textarea>                           
                <label for="txt_misi" class="col-sm col-form-label col-form-label-sm">MISI</label>               
                <textarea name="txt_misi" id="txt_misi" class="editor form-control"></textarea>                 
               
                <div style="line-height: 5px;">
                    <br>
                </div>

                <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Visi dan Misi</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_img_visimisi_unit_sekolah"></span>							  
                        <!-- </div> -->
    
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_img_visimisi_unit_sekolah_path" id="uploaded_img_visimisi_unit_sekolah_path"> 
                        <input type="hidden" name="uploaded_img_visimisi_unit_sekolah_del_temp" id="uploaded_img_visimisi_unit_sekolah_del_temp"> 
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="txtpath_img_visimisi_unit_sekolah_ori" id="txtpath_img_visimisi_unit_sekolah_ori"> 						 
                
                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('file_visimisi_unit_sekolah').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_visimisi_unit_sekolah" class="form-control" id="file_visimisi_unit_sekolah"  data-id="test-file" style="display:none;">
                                        <label for="file_visimisi_unit_sekolah" id="lbl_file_visimisi_unit_sekolah"></label>
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-shadow btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_visimisi_unit_sekolah"><i class="bi bi-eraser"></i> Batal</button>				
                                </td>
                            </tr>	  		
                        </table>	 	
                    
                    </div>
                    <div class="card-footer text-muted">
                        Jenis File : jpg, jpeg, png <br>
                        Max Size : 2 MB
                    </div>
                </div>
                                                         
                <hr>
                <button type="submit" id="btnSubmit" class="btn btn-shadow btn-submit btn-sm"><i class="bi bi-save2"></i> Submit</button>                
                <br>
                <br>
                <br>
            
            </form>
    </div>
    
</body>
</html>

<!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5.css"> -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />

<!-- <script type="importmap">
    {
        "imports": {
            "ckeditor5": "./ckeditor/ckeditor5/ckeditor5.js",
            "ckeditor5/": "./ckeditor/ckeditor5/"            
        }
    }
</script> -->

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
        await fetch_list_jenjang()         
    }

    function load_blank_image() {        
        var path_blank_image = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';       
        $('#uploaded_img_visimisi_unit_sekolah').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    function fetch_list_jenjang() {
        fetch('<?php echo site_url('master/thn_ajaran/get_data_list_jenjang');?>').then(function(response){                   
            return response.json();    
        }).then(function (responseData){ 
            var data = responseData.data[0]
			var html = '';
				html += '<select name="list_jenjang" id="list_jenjang" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++)
			{
				html += '   <option style="color:black" value="'+data[count].group_cls +'">'+data[count].deskripsi+ '</option>';
			}							
				html += '</select>'
			document.getElementById('list_jenjang_div').innerHTML = html;	          
        });   
    }


    $(document).on('change', '#list_jenjang', function () {
        fetch_data_profile_unit_sekolah();
    })
    
    
    async function fetch_data_profile_unit_sekolah() {
        var list_jenjang = $('#list_jenjang').val()
        var result_data = await fetch('<?php echo site_url("master/profil/get_data_profil_unit_sekolah");?>?list_jenjang='+list_jenjang+'', {method:"GET", mode: "no-cors" })          
        const result = await result_data.json()         
        let x = result.data[0][0]       
        
        if(result.data[0].length > 0){
            $('#txt_nama_sekolah').val(x.nama)
            $('#txt_alamat').val(x.alamat)
            $('#txt_telp').val(x.telp)
            $('#txt_hotline').val(x.no_hotline)  
            $('#txt_petugas').val(x.nama_petugas)
            $('#txt_google_map').val(x.google_map);            
            window.editors[0].setData(x.visi)
            window.editors[1].setData(x.misi)
                                   
            var path_visi;
            if (x.photo_visi_path==null || x.photo_visi_path=='' || x.photo_visi_path==undefined){	
                path_visi = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';           				                
                $('#txtpath_img_visimisi_unit_sekolah_ori').val(''); 
                $('#uploaded_img_visimisi_unit_sekolah_path').val('');
                $('#uploaded_img_visimisi_unit_sekolah').html('');
                $('#uploaded_img_visimisi_unit_sekolah').append("<img src='"+ path_visi + "' class='img-width'>");									
                $('#file_visimisi_unit_sekolah').val(null)
            }else{
                path_visi = x.photo_visi_path;						
                $('#txtpath_img_visimisi_unit_sekolah_ori').val(path_visi); 
                $('#uploaded_img_visimisi_unit_sekolah_path').val(path_visi);
                $('#uploaded_img_visimisi_unit_sekolah').html('');
                $('#uploaded_img_visimisi_unit_sekolah').append("<img src='"+ path_visi + "' class='img-width'>");					
            }     
        }else{
            $('#txt_nama_sekolah').val('')
            $('#txt_alamat').val('')
            $('#txt_telp').val('')
            $('#txt_hotline').val('') 
            $('#txt_petugas').val('')
            window.editors[0].setData('')
            window.editors[1].setData('')
            path_visi = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';           				                
            $('#txtpath_img_visimisi_unit_sekolah_ori').val(''); 
            $('#uploaded_img_visimisi_unit_sekolah_path').val('');
            $('#uploaded_img_visimisi_unit_sekolah').html('');
            $('#uploaded_img_visimisi_unit_sekolah').append("<img src='"+ path_visi + "' class='img-width'>");
            $('#file_visimisi_unit_sekolah').val(null)
            $('#txt_google_map').val();
                                   
        }
    }


    $(document).on('change', '#file_visimisi_unit_sekolah', async function()
	{			
        try {   
            var name_obj =document.getElementById("file_visimisi_unit_sekolah").files[0];       
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_visimisi_unit_sekolah").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_visimisi_unit_sekolah").files[0]);
            var f = document.getElementById("file_visimisi_unit_sekolah").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                
                await upload_file_visimisi_unit_sekolah('upload');
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_visimisi_unit_sekolah(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }
        
        form_data.append("file_visimisi_unit_sekolah", document.getElementById('file_visimisi_unit_sekolah').files[0]);  
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "visimisi_unit_sekolah");  
        var kode_jenjang = $('#list_jenjang').val()        
        form_data.append("kode_jenjang", kode_jenjang);
        var img_file_path_ori = $('#uploaded_img_visimisi_unit_sekolah_path').val();             
        form_data.append("img_file_path_ori", img_file_path_ori);
                    
        await $.ajax(
        {
            url:"<?php echo base_url()?>uploadfile.php",
            //url:"uploadfile",    
            method:"POST",
            data: form_data,
            contentType: false,            
            cache: false,
            processData: false,            
            success:function(dataResult)
            {    	
                var dataResult = JSON.parse(dataResult);
                var path_view = dataResult.path_view;
                var path_save = dataResult.path_save;
                
                $('#uploaded_img_visimisi_unit_sekolah').html("");	
                $('#uploaded_img_visimisi_unit_sekolah').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_visimisi_unit_sekolah_path').val("");
                $('#uploaded_img_visimisi_unit_sekolah_path').val(path_view);                       
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
       let file_visimisi_unit_sekolah = $('#file_visimisi_unit_sekolah').val();
       if (file_visimisi_unit_sekolah !=''){
        await upload_file_visimisi_unit_sekolah('simpan');
       }
      
       var form_data= $(this).serialize();
       fetch("<?php echo site_url('master/profil/simpan_profil_unit_sekolah');?>",{
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
                   alert('Simpan data sukses');    
                   //fetch_data_profile_yayasan()                                                             
               }
           })
       .catch(err => {
           alert(err);
       });    
  })


  async function validasi_submit() {
        let valid=true;		
        x = document.forms['simpan_form']
        var list_jenjang = x['list_jenjang'].value;
        var nama_yayasan = x['txt_nama_sekolah'].value;
        var alamat= x['txt_alamat'].value;
        var telp = x['txt_telp'].value;
        var no_hotline = x['txt_hotline'].value;

        if(list_jenjang==''){
            valid = false
            $('#list_jenjang').css('border-color', '#cc0000');
        }else{
            $('#list_jenjang').css('border-color', '');
        }     
                
        if(nama_yayasan==''){
            valid = false
            $('#txt_nama_sekolah').css('border-color', '#cc0000');
        }else{
            $('#txt_nama_sekolah').css('border-color', '');
        }     

        if(alamat==''){
            valid = false
            $('#txt_alamat').css('border-color', '#cc0000');
        }else{
            $('#txt_alamat').css('border-color', '');
        }     

        if(telp==''){
            valid = false
            $('#txt_telp').css('border-color', '#cc0000');
        }else{
            $('#txt_telp').css('border-color', '');
        }     

        if(no_hotline==''){
            valid = false
            $('#txt_hotline').css('border-color', '#cc0000');
        }else{
            $('#txt_hotline').css('border-color', '');
        }     

        return valid
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