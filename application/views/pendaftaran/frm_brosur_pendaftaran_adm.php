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
    <div style="line-height: 35px;"><br></div>
    <div class="container mt-5">             
        
        <h3 class="text-header fw-bold mb-1">Brosur - <?php echo $kode_jenjang; ?></h3>
        <hr style="margin-top: 1px;">
    
        <form method="post" id="simpan_form">
            <input type="hidden" name="txt_status_edit" id="txt_status_edit" value=false> 
            <input type="hidden" id="txt_kode_jenjang" name="txt_kode_jenjang">
            <input type="hidden" name="txt_brosur_id" id="txt_brosur_id" value=0>

            <table class="table table-sm"  style="margin-bottom:5px;">
                <tr class="borderless-top borderless-bottom">
                    <td width="140">
                        <label for="div_list_thn_ajaran" class="col-sm col-form-label col-form-label-sm">Tahun Ajaran</label> 
                    </td>
                    <td>
                        <div class="input-group-sm col-sm-8">
                        <div class="input-group input-group-sm">
                            <div class="input-group input-group-sm col-sm-10" name="div_list_thn_ajaran" id="div_list_thn_ajaran"></div>                                                                
                        </div> 
                        </div>  
                    </td>    
                </tr>
            </table>
            <hr>
            <table class="table table-sm"  style="margin-bottom:5px;">
                <tr class="borderless-top borderless-bottom">
                    <td width="140">
                        <label for="txt_keterangan_brosur" class="col-sm col-form-label col-form-label-sm">Keterangan Brosur</label> 
                    </td>
                    <td>
                        <div class="input-group-sm col-sm-8">
                        <div class="input-group input-group-sm">
                        <input type="text" name="txt_keterangan_brosur" id="txt_keterangan_brosur" class="form-control" autocomplete="off"> 
                        </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="card group-sm col-sm-3" id="card_img_brosur">                        
                <div class="card-header">Upload Photo Brosur</div>
                <div class="card-body ">    
                    <!-- <div class="card">   -->
                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                        <span id="uploaded_image_brosur"></span>							  
                    <!-- </div> -->

                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                    <input type="hidden" name="uploaded_image_brosur_path" id="uploaded_image_brosur_path">                         
                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                    <input type="hidden" name="txtpath_image_brosur_ori" id="txtpath_image_brosur_ori"> 						 

                    <table>
                        <tr>
                            <td width="200">
                                <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('file_brosur').click()" style="margin-top: 5px;">
                                    <i class="bi bi-upload"></i> Browse<input type="file" name="file_brosur" class="form-control" id="file_brosur"  data-id="test-file" style="display:none;">
                                    <label for="file_brosur" id="lbl_file_brosur"></label>
                                </button>&nbsp;
                                <button type="button" class="btn btn-secondary btn-shadow btn-sm" style="margin-top: 5px;" id="kosong_file_brosur"><i class="bi bi-eraser"></i> Batal</button>				
                            </td>
                        </tr>	  		
                    </table>	                                          
                </div>

                <div class="card-footer text-muted">
                    Jenis File : jpg, jpeg, png <br>
                    Max Size : 2 MB
                </div>
            </div>
            
            <div style="line-height: 10px;"><br></div>
            <button type="submit" id="btn_submit" class="btn btn-sm btn-shadow btn-submit"><i class="bi bi-save2"></i> Simpan</button>    
        </form>
        <hr>
        <h5>Daftar Brosur</h5>
        <div id="div_tbl_brosur"></div>
        <br>
        <br>

    </div>
</body>
</html>

<script type="text/javascript">

    async function init_form() {   
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'  
        $('#txt_kode_jenjang').val(kode_jenjang)        
        await load_list_thn_ajaran(kode_jenjang)
        await load_blank_image()   
        await fetch_tbl_brosur()
        //await load_tbl_brosur([])     
    }
   
    function load_blank_image() {        
        var path_blank_image = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';       
        $('#uploaded_image_brosur').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    async function load_list_thn_ajaran(kode_jenjang) 
	{		        
		await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_thn_ajaran_with_status_open');?>?kode_jenjang='+kode_jenjang+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                      
            var data = responseData.data[0]            
			var html = '';
				html += '<select name="list_thn_ajaran" id="list_thn_ajaran" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++){
                if(data[count].status_open=='1'){
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'" selected>'+data[count].thn_ajaran_nama+ '</option>';
                }else{
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'">'+data[count].thn_ajaran_nama+ '</option>';
                }				
			}							
				html += '</select>'
			document.getElementById('div_list_thn_ajaran').innerHTML = html;	
		});     	
	}  

    $(document).on('change','#list_thn_ajaran', function () {
        fetch_tbl_brosur()   
    })

    $(document).on('click', '#edit_brosur', function () {
        var brosur_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_brosur")
        var keterangan_brosur =  tbl.rows[row_index].cells[0].innerHTML;         
        var img_path = tbl.rows[row_index].cells[2].innerHTML;
           
        $('#txt_status_edit').val(true)
        $('#txt_keterangan_brosur').val(keterangan_brosur)
        $('#txt_brosur_id').val(brosur_id)        
        $('#uploaded_image_brosur_path').val(img_path)
        $('#uploaded_image_brosur').html('')
        $('#uploaded_image_brosur').append("<img src='"+ img_path + "' class='img-width'>");
        document.documentElement.scrollTop = 0;
    })

    $(document).on('click', '#delete_brosur', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var brosur_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_brosur")        
        var img_file_path = tbl.rows[row_index].cells[2].innerHTML;
             
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/delete_brosur') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({brosur_id:brosur_id, img_file_path:img_file_path}),
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
                    fetch_tbl_brosur();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

    $(document).on('change', '#file_brosur', async function(){        
        var name = document.getElementById("file_brosur").files[0].name;		 
        var ext = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
        {
            alert("Invalid Image File");
        }

        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file_brosur").files[0]);
        var f = document.getElementById("file_brosur").files[0];
        var fsize = f.size||f.fileSize;
        if(fsize > 2000000)
        {
                    alert("Image File Size is very big");
        }
        else
        {
                await upload_file_brosur('upload');
                
        }
    });

    
    $(document).on('submit','#simpan_form', async function () {
        event.preventDefault();         
        var status_edit = $('#txt_status_edit').val()

        var valid_data = true;
        var thn_ajaran_cls = $('#list_thn_ajaran').val()        
        if(thn_ajaran_cls==''){
            valid_data = false
            $('#list_thn_ajaran').css('border-color', '#cc0000');
        }else{
            $('#list_thn_ajaran').css('border-color', '');
        }

        let file_brosur = $('#file_brosur').val()                
        if(file_brosur==''){
            valid_data = false
            $('#card_img_brosur').css('border-color', '#cc0000');
        }else{
            $('#card_img_brosur').css('border-color', '');
        }

        // var keterangan_brosur = $('#txt_keterangan_brosur').val()
        // if(keterangan_brosur==''){
        //     valid_data = false
        //     $('#txt_keterangan_brosur').css('border-color', '#cc0000');
        // }else{
        //     $('#txt_keterangan_brosur').css('border-color', '');
        // }
        // alert(valid_data)
        if (valid_data==false){
            alert('Silahkan isi data yang diperlukan');            
            return false;
        }

       
        //SIMPAN TERLEBIH DAHULU FILE IMGNYA
        //let file_brosur = $('#file_brosur').val()
        if (status_edit=='true' && file_brosur != ''){
            await upload_file_brosur('simpan');
        }
        var form_data= $(this).serialize();
        fetch("<?php echo site_url('pendaftaran/pendaftaran_admin/simpan_brosur');?>",{
                    method: 'POST',   
                    body: new URLSearchParams(form_data),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then( async dataResult => {
                console.log(dataResult);
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"                    
                    }else{         
                        //tidak terjadi error                             
                        alert(dataResult.message);                                                                                 
                    }
                }else{
                    var brosur_id = dataResult.data
                    $('#txt_brosur_id').val(brosur_id)
                    if (status_edit=='false'){                        
                        await simpan_img_path(brosur_id)   
                    }
                    $('#txt_status_edit').val(true)                                  
                    await fetch_tbl_brosur()
                    await input_area_clear()
                    alert(dataResult.message);
                }                   
            })
        .catch(err => {
            alert(err);
        });    
    })


    async function simpan_img_path(brosur_id) {                       
        await upload_file_brosur('simpan');  
        let img_file_path =  $('#uploaded_image_brosur_path').val();  
        var form_data = new FormData();
        form_data.append("brosur_id", brosur_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/simpan_img_path') ;?>',{
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

    async function upload_file_brosur($par) {
            var form_data = new FormData();
            if ($par=='upload'){
                $status_simpan = 'false';
            }else{
                $status_simpan = 'true';
            }
                                   
            var kode_jenjang = $('#txt_kode_jenjang').val(); 
            var brosur_id = $('#txt_brosur_id').val();
            var thn_ajaran_cls = $('#list_thn_ajaran').val();  
            var img_file_path_ori = $('#uploaded_image_brosur_path').val();

            form_data.append("file_brosur", document.getElementById('file_brosur').files[0]);  
            form_data.append("status_simpan", $status_simpan); 
            form_data.append("kode_jenjang", kode_jenjang);    
            form_data.append("brosur_id", brosur_id);       
            form_data.append("thn_ajaran_cls", thn_ajaran_cls);
            form_data.append("jenis_dokumen", "brosur");             
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
                   
                    $('#uploaded_image_brosur').html("");	
                    $('#uploaded_image_brosur').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#uploaded_image_brosur_path').val("")
                    $('#uploaded_image_brosur_path').val(path_view);   
                }
            });
    }
    
    function fetch_tbl_brosur() {
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = $('#txt_kode_jenjang').val()
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_tbl_brosur') ;?>?thn_ajaran_cls='+thn_ajaran_cls+'&kode_jenjang='+kode_jenjang+'')
        .then(response => response.json()) 
        .then(dataResult =>{load_tbl_brosur(dataResult.data)})
        .catch(err => {
            alert(err);
        });     
    }

    function load_tbl_brosur(data) {  
       console.log(data.length)
       var html = '';
       html += '<div>';
       html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_brosur">';            
       html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
       html += '		<tr class="text-nowrap">';                                        
       html += '		   <th>Keterangan Brosur</th>';
       html += '           <th>Image</th>';      
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
               html += '   <td width="20%">'+data[count].keterangan_brosur+'</td>';  //0                
               html += '   <td width="20%" style="text-align:center;"><img src='+ data[count].img_path +'?'+ new Date().getTime()+' width="100pt", height="80pt"></td>';             
               html += '   <td style="display:none;">'+data[count].img_path+'</td>';
               html += '   <td style="display:none;">'+data[count].brosur_id+'</td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="edit_brosur" data-id='+data[count].brosur_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
               html += '   <td align="center" style="cursor: pointer;"> <a id="delete_brosur" data-id='+data[count].brosur_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
               html += '</tr>';                                                                                                   
           }
           html += '</tbody>';      
           //$('#pesan').find("h6:first").text(dataResult.length + ' records');
       }                
       html += '</table>';
       html += '</div>';
                       
       document.getElementById("div_tbl_brosur").innerHTML = html;           
   }

   function input_area_clear() {
        $('#txt_status_edit').val(false)
        $('#txt_brosur_id').val(0)        
        $('#txt_keterangan_brosur').val('')       
        $('#uploaded_image_brosur').html('')
        load_blank_image()       
        $('#file_brosur').val(null)
    }
    

</script>

<style>
    .img-width {
        width: 185pt;
        height: 185pt;
    }
</style>