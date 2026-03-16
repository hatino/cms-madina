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
       
        <h3 class="text-header">KEGIATAN - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">

            <form method="post" id="simpan_form">

                <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
                <input type="hidden" name="_kegiatan_id" id="_kegiatan_id" value=0> 
                <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 
                <label for="txt_nama_kegiatan" class="col-sm col-form-label col-form-label-sm">Nama Kegiatan</label> 
                <div class="input-group input-group-sm">
                    <input type="text" name="txt_nama_kegiatan" id="txt_nama_kegiatan" class="form-control" autocomplete="off"> 
                </div>
                <label for="dt_tgl_kegiatan" class="col-sm col-form-label col-form-label-sm">Tanggal Kegiatan</label>      
                <div class="input-group-sm col-sm-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="dt_tgl_kegiatan" id="dt_tgl_kegiatan" class="form-select" autocomplete="off">      
                    </div>
                </div>
                <label for="txt_deskripsi_kegiatan" class="col-sm col-form-label col-form-label-sm">Deskripsi</label> 
                <textarea type="text" name="txt_deskripsi_kegiatan" id="txt_deskripsi_kegiatan" class="form-control" autocomplete="off"></textarea>    
                
                <br>
                <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Kegiatan</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_img_kegiatan"></span>							  
                        <!-- </div> -->
    
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_img_kegiatan_path" id="uploaded_img_kegiatan_path">                         
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="txtpath_img_kegiatan_ori" id="txtpath_img_kegiatan_ori"> 						 
                
                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_kegiatan').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_kegiatan" class="form-control" id="file_kegiatan"  data-id="test-file" style="display:none;">
                                        <label for="file_kegiatan" id="lbl_file_kegiatan"></label>
                                    </button>	
                                    <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_kegiatan"><i class="bi bi-eraser"></i> Batal</button>				
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
            <h5>Daftar Kegiatan</h5>
            <div id="div_tbl_kegiatan"></div>
            <br>
            <br>
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
        Font
    } from 'ckeditor5';
   
    ClassicEditor
        .create( document.querySelector( '#txt_deskripsi_kegiatan' ), {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, Paragraph, Bold, Italic, Font ],           
            toolbar: [
                'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ],
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

<script type="text/javascript">
   
    async function init_form() {       
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'      
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;
        
        $('#_kode_jenjang').val(kode_jenjang) 
        set_tgl(new Date())       
        await load_blank_image()
        await fetch_tbl_kegiatan()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_kegiatan').append("<img src='"+ path_blank_image + "' class='img-width'>");
        $('#uploaded_img_kegiatan_path').val(path_blank_image)
    }
    
    function fetch_tbl_kegiatan(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('kegiatan/kegiatan_admin/get_data_tbl_kegiatan') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){       
            load_tbl_kegiatan(responseData.data[0]);               
        });            
    }
    
    function load_tbl_kegiatan(data) {  
       
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_kegiatan">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Nama Kegiatan</th>';
        html += '           <th>Tgl Kegiatan</th>';
        html += '           <th>Deskripsi</th>';
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {
            console.log(data)
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {
                var tgl = set_tgl_kegiatan(new Date (data[count].tgl_kegiatan))
                             
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td width="20%">'+data[count].nama_kegiatan+'</td>';  //0                
                html += '   <td width="10%">'+tgl+'</td>';
                html += '   <td>'+data[count].deskripsi+'</td>';
                html += '   <td style="display:none;">'+data[count].img_path+'</td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_kegiatan" data-id='+data[count].kegiatan_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_kegiatan" data-id='+data[count].kegiatan_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("div_tbl_kegiatan").innerHTML = html;           
    }

    function set_tgl_kegiatan(tgl) {
        var new_date = tgl.getFullYear() +"-"+ ("0"+(tgl.getMonth()+1)).slice(-2) +"-"+ ("0"+tgl.getDate()).slice(-2)
        return new_date
    }

    $(document).on('click', '#edit_kegiatan', function () {
        var _kegiatan_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_kegiatan")
        var nama_kegiatan =  tbl.rows[row_index].cells[0].innerHTML;
        var tgl_kegiatan =  tbl.rows[row_index].cells[1].innerHTML;
        var deskripsi =  tbl.rows[row_index].cells[2].innerHTML;
        var img_path = tbl.rows[row_index].cells[3].innerHTML;
    
        $('#_status_edit').val(true)
        $('#_kegiatan_id').val(_kegiatan_id)
        $('#txt_nama_kegiatan').val(nama_kegiatan)
        $('#dt_tgl_kegiatan').val (tgl_kegiatan)
        window.editor.setData(deskripsi)
        
        $('#uploaded_img_kegiatan_path').val(img_path)
        $('#uploaded_img_kegiatan').html('')
        $('#uploaded_img_kegiatan').append("<img src='"+ img_path + "' class='img-width'>");

    })

    $(document).on('submit','#simpan_form', async function () {

       event.preventDefault(); 
       var status_edit = $('#_status_edit').val()
      
       var valid_data = await validasi_submit();        
       if( valid_data == false){	        
           alert('Silahkan isi data yang diperlukan');
           return false;
       }    

       let deskripsi = $('#txt_deskripsi_kegiatan').val();   
       if( deskripsi == false){	        
            $('#txt_deskripsi_kegiatan').focus();
           alert('Silahkan isi deskripsi');
           return false;
       }    
    
       let cek_file_kosong = $('#uploaded_img_kegiatan_path').val()     
       let position = cek_file_kosong.indexOf("blank_photo");     
       if (position > -1 ){
            alert('Silahkan upload photo kegiatan');
            return false;
       }

       let file_kegiatan_content =  $('#file_kegiatan').val();     
       if (status_edit=='true' && file_kegiatan_content !=''){
            await upload_file_kegiatan('simpan')
       }
       
       var form_data= $(this).serialize();

       fetch('<?php echo site_url('kegiatan/kegiatan_admin/simpan_kegiatan') ;?>',{
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
                   var kegiatan_id = dataResult.data                   
                   $('#_kegiatan_id').val(kegiatan_id)

                   if (status_edit=='false'){                        
                        await simpan_img_path(kegiatan_id)   
                   }
                  
                   $('#_status_edit').val(true)                                  
                   await fetch_tbl_kegiatan()
                   alert('Simpan data sukses');    
                   //fetch_data_profile_yayasan()                                                             
               }
           })
       .catch(err => {
           alert(err);
       });    
    })

  async function simpan_img_path(kegiatan_id) {
                       
        await upload_file_kegiatan('simpan');  
        let img_file_path =  $('#uploaded_img_kegiatan_path').val();  
        var form_data = new FormData();
        form_data.append("kegiatan_id", kegiatan_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('kegiatan/kegiatan_admin/simpan_img_path') ;?>',{
                    method: 'POST',   
                    //data:{'kegiatan_id':kegiatan_id, 'img_file_path':img_file_path},
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
        let nama_kegiatan = x["txt_nama_kegiatan"].value;
        let tgl_kegiatan = x['dt_tgl_kegiatan'].value;          
      
        if(nama_kegiatan==''){      
            valid = false
            $('#txt_nama_kegiatan').css('border-color', '#cc0000');	           
        }else{
            $('#txt_nama_kegiatan').css('border-color', '');	
        }    
        if(tgl_kegiatan==''){      
            valid = false
            $('#dt_tgl_kegiatan').css('border-color', '#cc0000');	           
        }else{
            $('#dt_tgl_kegiatan').css('border-color', '');	
        }    
               
        return valid
    }


    $(document).on('change', '#file_kegiatan', function()
	{			
        try {   
            var name_obj =document.getElementById("file_kegiatan").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_kegiatan").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_kegiatan").files[0]);
            var f = document.getElementById("file_kegiatan").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_kegiatan('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_kegiatan(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var kegiatan_id = $('#_kegiatan_id').val()
        var img_file_path_ori = $('#uploaded_img_kegiatan_path').val()
        form_data.append("file_kegiatan", document.getElementById('file_kegiatan').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "kegiatan"); 
        form_data.append("kegiatan_id", kegiatan_id);        
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
                
                $('#uploaded_img_kegiatan').html("");	
                $('#uploaded_img_kegiatan').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_kegiatan_path').val("")
                $('#uploaded_img_kegiatan_path').val(path_view);                  
            }
        });

    }


    $(document).on('click', '#delete_kegiatan', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var kegiatan_id = $(this).attr("data-id");//trade_code        
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_kegiatan")
        var img_file_path = tbl.rows[row_index].cells[3].innerHTML;
        
        fetch('<?php echo site_url('kegiatan/kegiatan_admin/delete_kegiatan') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({kegiatan_id:kegiatan_id, img_file_path:img_file_path}),
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
                    fetch_tbl_kegiatan();
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
        $('#_kegiatan_id').val(0)        
        $('#txt_nama_kegiatan').val('')
        set_tgl(new Date())        
        window.editor.setData("")        
        $('#uploaded_img_kegiatan').html('')
        load_blank_image()       
        $('#file_kegiatan').val(null)
    }
 
   function set_tgl(date) {
        $('#dt_tgl_kegiatan').datepicker({
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
    .ck-editor__editable_inline {
        min-height: 100px;    
    }
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }

</style>