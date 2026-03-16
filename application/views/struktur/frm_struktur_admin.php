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
        <h3 class="text-header">STRUKTUR - <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">
            <form method="post" id="simpan_form">

                <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
                <input type="hidden" name="_struktur_id" id="_struktur_id" value=0> 
                <input type="hidden" name="_kode_jenjang" id="_kode_jenjang"> 
                <table class="table table-sm"  style="margin-bottom:5px;">
                    <tr class="borderless-top borderless-bottom">
                        <td width="140">
                            <label for="div_list_kelompok_jabatan" class="col-sm col-form-label col-form-label-sm">Kelompok Jabatan</label> 
                        </td>
                        <td>
                            <div class="input-group-sm col-sm-8">
                            <div class="input-group input-group-sm">                    
                                <div class="input-group input-group-sm col-sm-10" name="div_list_kelompok_jabatan" id="div_list_kelompok_jabatan"></div>                                                                
                            </div> 
                            </div>  
                        </td>    
                    </tr>

                    <tr class="borderless-bottom">
                        <td width ="150" >
                            <label for="txt_jabatan" class="col-sm col-form-label col-form-label-sm">Jabatan</label>
                        </td>
                        <td >
                            <div class="input-group-sm col-sm-8">
                            <div class="input-group input-group-sm col-sm-10">    
                                <input type="text" name="txt_jabatan" id="txt_jabatan" class="form-control" autocomplete="off">
                            </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="borderless-bottom">
                        <td width ="150" >
                            <label for="txt_nama" class="col-sm col-form-label col-form-label-sm">Nama</label>
                        </td>
                        <td >
                            <div class="input-group-sm col-sm-8">
                            <div class="input-group input-group-sm col-sm-10">    
                                <input type="text" name="txt_nama" id="txt_nama" class="form-control" autocomplete="off">
                            </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="borderless-bottom">
                        <td width ="150" >
                            <label for="txt_no_urut" class="col-sm col-form-label col-form-label-sm">No Urut</label>
                        </td>
                        <td >
                            <div class="input-group-sm col-sm-8">
                            <div class="input-group input-group-sm col-sm-10">    
                                <input type="text" name="txt_no_urut" id="txt_no_urut" class="form-control" autocomplete="off">
                            </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <br>
                <div class="card group-sm col-sm-3">                        
                    <div class="card-header">Upload Photo Struktur</div>
                    <div class="card-body ">    
                        <!-- <div class="card">   -->
                            <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                            <span id="uploaded_img_struktur"></span>							  
                        <!-- </div> -->
    
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                        <input type="hidden" name="uploaded_img_struktur_path" id="uploaded_img_struktur_path">                         
                        <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                        <input type="hidden" name="txtpath_img_struktur_ori" id="txtpath_img_struktur_ori"> 						 
                
                        <table>
                            <tr>
                                <td width="200">
                                    <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_struktur').click()" style="margin-top: 5px;">
                                        <i class="bi bi-upload"></i> Browse<input type="file" name="file_struktur" class="form-control" id="file_struktur"  data-id="test-file" style="display:none;">
                                        <label for="file_struktur" id="lbl_file_struktur"></label>
                                    </button>	
                                    <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_struktur"><i class="bi bi-eraser"></i> Batal</button>				
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
            <h5>Daftar Struktur</h5>
            <div class="tscroll">
                <div id="div_tbl_struktur" class="table-responsive table-height"></div>
            </div>
            <br><br>
    </div>
    
</body>
</html>

<script type="text/javascript">
   
    async function init_form() {     
        var kode_jenjang = '<?php echo $kode_jenjang ;?>' 
        $('#_kode_jenjang').val(kode_jenjang)
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;   
        await load_blank_image()
        await load_list_kelompok_jabatan()     
        await fetch_tbl_struktur()
    }

    function load_blank_image() {
        var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';        
        $('#uploaded_img_struktur').append("<img src='"+ path_blank_image + "' class='img-width'>");
    }

    async function load_list_kelompok_jabatan() {
        await fetch('<?php echo site_url('struktur/struktur_admin/get_data_kelompok_jabatan');?>')
        .then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                      
            var data = responseData.data[0]           
			var html = '';
				html += '<select name="list_kelompok_jabatan" id="list_kelompok_jabatan" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++){                
                html += '   <option style="color:black" value="'+data[count].kelompok_jabatan +'">'+data[count].kelompok_jabatan+ '</option>';                			
			}							
				html += '</select>'
			document.getElementById('div_list_kelompok_jabatan').innerHTML = html;	
		});  
    }

    $('#btnTambah').on('click', function () {
        input_area_clear();
    })

    $(document).on('click', '#edit_struktur', function () {        
        var _struktur_id = $(this).attr("data-id");//trade_code       
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_struktur")
        var kelompok_jabatan =  tbl.rows[row_index].cells[0].innerHTML;
        var jabatan =  tbl.rows[row_index].cells[1].innerHTML;
        var nama =  tbl.rows[row_index].cells[2].innerHTML;
        var no_urut = tbl.rows[row_index].cells[3].innerHTML;
        var img_path = tbl.rows[row_index].cells[4].innerHTML;
    
        $('#_status_edit').val(true)
        $('#_struktur_id').val(_struktur_id)
        $('#list_kelompok_jabatan').val(kelompok_jabatan)
        $('#txt_jabatan').val (jabatan)
        $('#txt_nama').val (nama)
        $('#txt_no_urut').val (no_urut)
               
        $('#uploaded_img_struktur_path').val(img_path)
        $('#uploaded_img_struktur').html('')
        if (img_path!=''){
            $('#uploaded_img_struktur').append("<img src='"+ img_path + "' class='img-width'>");
        }else{
            load_blank_image()
        }
        
    })

    
    $(document).on('click', '#delete_struktur', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var struktur_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_struktur")        
        var img_file_path = tbl.rows[row_index].cells[4].innerHTML;
      
        fetch('<?php echo site_url('struktur/struktur_admin/delete_struktur') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({struktur_id:struktur_id, img_file_path:img_file_path}),
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
                    fetch_tbl_struktur();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })
    
    
    $(document).on('submit','#simpan_form', async function () {
       
        event.preventDefault(); 
        var status_edit = $('#_status_edit').val()

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    

        let file_truktur_content =  $('#file_struktur').val();     
        if (status_edit=='true' && file_truktur_content !=''){    //pastikan bahwa object file input diisi /ada       
            await upload_file_struktur('simpan')
        }
       
        var form_data= $(this).serialize();

        fetch('<?php echo site_url('struktur/struktur_admin/simpan_struktur') ;?>',{
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
                    var struktur_id = dataResult.data                   
                    $('#_struktur_id').val(struktur_id)

                    if (status_edit=='false' && file_truktur_content !=''){                        
                        await simpan_img_path(struktur_id)   
                    }
                
                    $('#_status_edit').val(true)                                  
                    await fetch_tbl_struktur()
                    alert('Simpan data sukses');    
                    //fetch_data_profile_yayasan()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });    
    })


    async function simpan_img_path(struktur_id) {
        let file_truktur_content =  $('#file_struktur').val();  
        if (file_truktur_content !=''){            
            await upload_file_struktur('simpan')
        }       
        let img_file_path =  $('#uploaded_img_struktur_path').val();
        var form_data = new FormData();
        form_data.append("struktur_id", struktur_id);        
        form_data.append("img_file_path", img_file_path);

        await fetch('<?php echo site_url('struktur/struktur_admin/simpan_img_path_struktur') ;?>',{
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
        let kelompok_jabatan = x["list_kelompok_jabatan"].value;
        let jabatan = x['txt_jabatan'].value; 
        let nama =  x['txt_nama'].value; 
        let no_urut =  x['txt_no_urut'].value; 
              
        if(kelompok_jabatan==''){      
            valid = false
            $('#list_kelompok_jabatan').css('border-color', '#cc0000');	           
        }else{
            $('#list_kelompok_jabatan').css('border-color', '');	
        }    
        if(jabatan==''){      
            valid = false
            $('#txt_jabatan').css('border-color', '#cc0000');	           
        }else{
            $('#txt_jabatan').css('border-color', '');	
        }    
        if(nama==''){      
            valid = false
            $('#txt_nama').css('border-color', '#cc0000');	           
        }else{
            $('#txt_nama').css('border-color', '');	
        }    
        if(no_urut==''){      
            valid = false
            $('#txt_no_urut').css('border-color', '#cc0000');	           
        }else{
            $('#txt_no_urut').css('border-color', '');	
        }    
        
        return valid
    }

    
    $(document).on('change', '#file_struktur', function(){
        try {   
            var name_obj =document.getElementById("file_struktur").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_struktur").files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_struktur").files[0]);
            var f = document.getElementById("file_struktur").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_struktur('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});


    async function upload_file_struktur(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var struktur_id = $('#_struktur_id').val()        
        var img_file_path_ori = $('#uploaded_img_struktur_path').val()
        form_data.append("file_struktur", document.getElementById('file_struktur').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "struktur"); 
        form_data.append("struktur_id", struktur_id);        
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
                
                $('#uploaded_img_struktur').html("");	
                $('#uploaded_img_struktur').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_struktur_path').val("")
                $('#uploaded_img_struktur_path').val(path_view);              
            }
        });

    }
    

    function fetch_tbl_struktur(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('struktur/struktur_admin/get_data_tbl_struktur') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){            
            load_tbl_struktur(responseData.data[0]);               
        });            
    }
    
    function load_tbl_struktur(data) {  
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_struktur">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Kelompok Jabatan</th>';
        html += '           <th>Jabatan</th>';
        html += '           <th>Nama</th>';
        html += '           <th>No Urut</th>';           
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {                             
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td style="min-width:100pt">'+data[count].kelompok_jabatan+'</td>';
                html += '   <td style="min-width:180pt">'+data[count].nama_jabatan+'</td>';
                html += '   <td style="min-width:180pt">'+data[count].nama+'</td>';
                html += '   <td style="min-width:80pt">'+data[count].no_urut+'</td>';
                html += '   <td style="display:none;">'+data[count].img_path+'</td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_struktur" data-id='+data[count].struktur_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_struktur" data-id='+data[count].struktur_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("div_tbl_struktur").innerHTML = html;           
    }
   
    function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_struktur_id').val(0)        
        $('#list_kelompok_jabatan').val('')          
        $('#txt_jabatan').val('')
        $('#txt_nama').val ('')
        $('#txt_no_urut').val ('')       
        $('#uploaded_img_struktur_path').val('')
        $('#uploaded_img_struktur').html('')
        $('#file_struktur').val(null)
        load_blank_image()        
    }
 

</script>

<style>   
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }

</style>