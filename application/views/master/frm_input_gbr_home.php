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
        <h3 class="text-header"><strong>Input Gambar Utama</strong></h3>
        <hr style="margin-top: 5px;">
            <div class="row row-cols-1 row-cols-lg-3"  >

                <div class="col" style="margin-bottom: 5px; text-align: center;">
                    <div class="card" style="max-width: 350px;">                        
                        <div class="card-header text-header" >Upload Video Utama Ke-1</div>
                        <div class="card-body ">                                   
                            <span id="uploaded_img_carousel1"></span>
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                            <input type="hidden" name="uploaded_img_carousel1_path" id="uploaded_img_carousel1_path">                 
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                            <input type="hidden" name="txtpath_img_carousel1_ori" id="txtpath_img_carousel1_ori"> 						                         
                            <table>
                                <tr>
                                    <td width="200">
                                        <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('carousel1').click()" style="margin-top: 5px;">
                                            <i class="bi bi-upload"></i> Browse<input type="file" name="carousel1" class="form-control" id="carousel1"  data-id="test-file" style="display:none;">
                                            <label for="carousel1" id="lbl_carousel1"></label>
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-secondary btn-shadow btn-sm" style="margin-top: 5px;" id="kosong_carousel1"><i class="bi bi-eraser"></i> Batal</button>				
                                    </td>
                                </tr>	  		
                            </table>	 	                            
                        </div>
                        <div class="card-footer text-muted">
                            Jenis File : mp4 <br>
                            
                        </div>
                    </div>
                    
                    <div style="line-height: 5px;">
                        <br>
                    </div>
                    <label class="text-header" for="txt_carousel1" id="lbl_carousel1"  style="text-align: center;">Text Utama Ke-1 :</label>
                    <input type="text" class="form-control" id="txt_carousel1">
                    <input type="hidden" class="form-control" id="txt_carousel1_temp">
                    <div class="dashed-line"></div>
                </div>
                               

                <div class="col" style="margin-bottom: 5px;" align="center">
                    <div class="card group-sm">                        
                        <div class="card-header text-header">Upload Photo Utama Ke-2</div>
                        <div class="card-body ">
                            <span id="uploaded_img_carousel2"></span>
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                            <input type="hidden" name="uploaded_img_carousel2_path" id="uploaded_img_carousel2_path">                 
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                            <input type="hidden" name="txtpath_img_carousel2_ori" id="txtpath_img_carousel2_ori"> 						 
                    
                            <table>
                                <tr>
                                    <td width="200">
                                        <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('carousel2').click()" style="margin-top: 5px;">
                                            <i class="bi bi-upload"></i> Browse<input type="file" name="carousel2" class="form-control" id="carousel2"  data-id="test-file" style="display:none;">
                                            <label for="carousel2" id="lbl_carousel2"></label>
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-secondary btn-shadow btn-sm" style="margin-top: 5px;" id="kosong_carousel2"><i class="bi bi-eraser"></i> Batal</button>				
                                    </td>
                                </tr>	  		
                            </table>	 	
                        
                        </div>
                        <div class="card-footer text-muted">
                            Jenis File : jpg <br>
                            Max Size : 2 MB
                        </div>
                    </div>
                    <div style="line-height: 5px;">
                        <br>
                    </div>
                    <label class="text-header" for="txt_carousel2" id="lbl_carousel2"  style="text-align: left;">Text Utama Ke-2 :</label>
                    <input type="text" class="form-control" id="txt_carousel2">
                    <input type="hidden" class="form-control" id="txt_carousel2_temp">
                    <div class="dashed-line"></div>
                </div>


                <div class="col" style="margin-bottom: 5px;" align="center">
                    <div class="card group-sm">                        
                        <div class="card-header text-header">Upload Photo Utama Ke-3</div>
                        <div class="card-body ">                              
                            <span id="uploaded_img_carousel3"></span>
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                            <input type="hidden" name="uploaded_img_carousel3_path" id="uploaded_img_carousel3_path">                 
                            <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                            <input type="hidden" name="txtpath_img_carousel3_ori" id="txtpath_img_carousel3_ori"> 						 
                    
                            <table>
                                <tr>
                                    <td width="200">
                                        <button type="button" class="btn btn-info btn-shadow text-light btn-file btn-sm" onclick="document.getElementById('carousel3').click()" style="margin-top: 5px;">
                                            <i class="bi bi-upload"></i> Browse<input type="file" name="carousel3" class="form-control" id="carousel3"  data-id="test-file" style="display:none;">
                                            <label for="carousel3" id="lbl_carousel_3"></label>
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-shadow btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_carousel3"><i class="bi bi-eraser"></i> Batal</button>				
                                    </td>
                                </tr>	  		
                            </table>	 	
                        
                        </div>
                        <div class="card-footer text-muted">
                            Jenis File : jpg <br>
                            Max Size : 2 MB
                        </div>
                    </div>

                    <div style="line-height: 5px;">
                        <br>
                    </div>
                    <label class="text-header" for="txt_carousel3" id="lbl_carousel3">Text Utama Ke-3 :</label>
                    <input type="text" class="form-control" id="txt_carousel3">
                    <input type="hidden" class="form-control" id="txt_carousel3_temp">
                    <div class="dashed-line"></div>
                </div>

            </div>

        <!-- <hr> -->
        <button type="submit" id="btnSubmit" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Submit</button>                
        <br>
        <br>
        <br>
                
        
    </div>
    
</body>
</html>

<script type="text/javascript">
   
    async function init_form() {         
        await load_existing_image()
        await load_carousel_text()
    }
    
    async function load_existing_image() {
        $('#carousel1').val(null)
        $('#carousel2').val(null)
        $('#carousel3').val(null)
        $('#uploaded_img_carousel1').html('');
        $('#uploaded_img_carousel2').html('');
        $('#uploaded_img_carousel3').html('');
      
        //var file_carousel1 = await get_image_ext('carousel1')
        var file_carousel2 = await get_image_ext('carousel2')
        var file_carousel3 = await get_image_ext('carousel3')
       
        var path_carousel_1 = "<?php echo base_url() ?>" +'./images/images_ui/carousel1.mp4';   
        var path_carousel_2 = "<?php echo base_url() ?>" +'./images/images_ui/'+file_carousel2;
        var path_carousel_3 = "<?php echo base_url() ?>" +'./images/images_ui/'+file_carousel3;  
        $('#uploaded_img_carousel1').append(`
            <div class="ratio ratio-16x9">
                <video class="w-100 rounded shadow" controls>
                    <source src="${path_carousel_1}?${new Date().getTime()}" type="video/mp4">
                </video>
            </div>          
        `);
        //$('#uploaded_img_carousel1').append("<img src='"+ path_carousel_1 +'?'+ new Date().getTime()+ "' class='img-width'>");
        $('#uploaded_img_carousel2').append("<img src='"+ path_carousel_2 +'?'+ new Date().getTime()+ "' class='img-width'>");
        $('#uploaded_img_carousel3').append("<img src='"+ path_carousel_3 +'?'+ new Date().getTime()+ "' class='img-width'>");
    }

    async function get_image_ext(file_name) {        
        var get_file_exists = await fetch('<?php echo site_url('master/profil/get_image_ext') ?>?file_name='+file_name+'',{method:"GET", mode: "no-cors" })
        var file_name_exists = await get_file_exists.text()        
        return file_name_exists
    }

    function load_blank_image() {        
        var path_blank_image = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';       
        $('#uploaded_img_carousel1').append("<img src='"+ path_blank_image + new Date().getTime()+ "' class='img-width'>");
        $('#uploaded_img_carousel2').append("<img src='"+ path_blank_image + new Date().getTime()+ "' class='img-width'>");
        $('#uploaded_img_carousel3').append("<img src='"+ path_blank_image + new Date().getTime()+ "' class='img-width'>");
    }
        
    function load_carousel_text() {
        fetch('<?php echo site_url('master/profil/get_carousel_text') ?>')
        .then(response=>{return response.json()})
        .then(responseData => {
            console.log(responseData)
            if(responseData.data.length > 0){
                $('#txt_carousel1').val(responseData.data[0].carousel1)
                $('#txt_carousel1_temp').val(responseData.data[0].carousel1)
                $('#txt_carousel2').val(responseData.data[0].carousel2)
                $('#txt_carousel2_temp').val(responseData.data[0].carousel2)
                $('#txt_carousel3').val(responseData.data[0].carousel3)
                $('#txt_carousel3_temp').val(responseData.data[0].carousel3)
            }else{
                $('#txt_carousel1').val('')
                $('#txt_carousel1_temp').val('')
                $('#txt_carousel2').val('')
                $('#txt_carousel2_temp').val('')
                $('#txt_carousel3').val('')
                $('#txt_carousel3_temp').val('')
            }
            
        })
    }

    function _(element){
        return document.getElementById(element);
    }

    _('carousel1').onchange = function () {       
        element_id = $(this).attr('id')      
        file_change_video(element_id)     
    }   

    _('carousel2').onchange = function () {       
        element_id = $(this).attr('id')      
        file_change(element_id)     
    }   

    _('carousel3').onchange = function () {       
        element_id = $(this).attr('id')      
        file_change(element_id)     
    }   

    async function file_change_video(element_id) {        
        try {   
            var name_obj =document.getElementById(element_id).files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById(element_id).files[0].name;
                              
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['mp4']) == -1){
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById(element_id).files[0]);
            var f = document.getElementById(element_id).files[0];
            var fsize = f.size||f.fileSize;        
            // if(fsize > 2000000){
            //     alert("Image File Size is very big");
            //     return false;
            // }else{                
                await upload_file_carousel('upload', element_id);
            //}

        } catch (error) {
            alert(error)
        }
    }

    async function file_change(element_id) {        
        try {   
            var name_obj =document.getElementById(element_id).files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById(element_id).files[0].name;
                              
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById(element_id).files[0]);
            var f = document.getElementById(element_id).files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000){
                alert("Image File Size is very big");
                return false;
            }else{                
                await upload_file_carousel('upload', element_id);
            }

        } catch (error) {
            alert(error)
        }
    }

    async function upload_file_carousel(act, element_id) {
        var form_data = new FormData();
        var status_simpan;
        if (act=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }
                
        var el_path = $('#uploaded_img_'+element_id).val()       
        form_data.append("file_name", element_id);
        form_data.append(element_id, document.getElementById(element_id).files[0]);
        form_data.append("status_simpan", status_simpan);
        form_data.append("jenis_dokumen", "carousel");
        form_data.append("img_file_path_ori", el_path);       
                                    
        await $.ajax(
        {
            url:"<?php echo base_url()?>uploadfile_carousel.php",
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
                
                if (element_id=='carousel1'){
                    $('#uploaded_img_carousel1').html("");	
                    $('#uploaded_img_carousel1').append(`
                            <div class="ratio ratio-16x9">
                                <video class="w-100 rounded shadow" controls>
                                    <source src="${path_view}?${new Date().getTime()}" type="video/mp4">
                                </video>
                            </div>          
                        `);
                    $('#uploaded_img_carousel1').val("");
                    $('#uploaded_img_carousel1').val(path_view);    
                }else{
                    $('#uploaded_img_'+element_id).html("");	
                    $('#uploaded_img_'+element_id).append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#uploaded_img_'+element_id).val("");
                    $('#uploaded_img_'+element_id).val(path_view);    
                }                                   
            }
        });
    }

    $(document).on('click','#btnSubmit', async function () {       
        const fileInputByType = document.querySelectorAll('input[type="file"]');
        var simpan_file_flag = false;       

        fileInputByType.forEach( async (element,idx) => {            
            var el_id = element.id
            var el_val = document.getElementById(element.id).value  
            //SIMPAN TERLEBIH DAHULU FILE IMGNYA           
            if (el_val !=''){
                await upload_file_carousel('simpan',el_id);
                simpan_file_flag = true
            }              
        })

        if (simpan_file_flag == true){
            load_existing_image()
        }
       
        var simpan_text_flag =  await simpan_carousel_text()
        
        if(simpan_file_flag==true || simpan_text_flag==true){
            alert('Simpan file dan text berhasil')
        }else if (simpan_file_flag==true){
            alert('Simpan file berhasil')
        }else if (simpan_text_flag==true){
            alert('Simpan text berhasil')
        }
    })

    async function simpan_carousel_text() {
        var status_simpan_text = false

        var carousel1_text = $('#txt_carousel1').val()
        var carousel1_text_temp = $('#txt_carousel1_temp').val()
        var carousel2_text = $('#txt_carousel2').val()
        var carousel2_text_temp = $('#txt_carousel2_temp').val()
        var carousel3_text = $('#txt_carousel3').val()
        var carousel3_text_temp =$('#txt_carousel3_temp').val()

        if(carousel1_text != carousel1_text_temp){
            status_simpan_text = true
        }
        if(carousel2_text != carousel2_text_temp){
            status_simpan_text = true
        }
        if(carousel3_text != carousel3_text_temp){
            status_simpan_text = true
        }

        if(status_simpan_text==true){
            var form_data = new FormData();
            form_data.append("txt_carousel1", carousel1_text);
            form_data.append("txt_carousel1_temp", carousel1_text_temp);
            form_data.append("txt_carousel2", carousel2_text);
            form_data.append("txt_carousel2_temp", carousel2_text_temp);
            form_data.append("txt_carousel3", carousel3_text);
            form_data.append("txt_carousel3_temp", carousel3_text_temp);

            await fetch('<?php echo site_url('master/profil/simpan_carousel_text') ?>', {
                method : 'POST',
                body: new URLSearchParams(form_data),
            })
            .then(response=> {return response.json()})
            .then(async (responseData) => {               
                await load_carousel_text()
                status_simpan_text = responseData.status
            })
        }

        return status_simpan_text
    }

</script>

<style>
    .ck-editor__editable_inline {
        min-height: 100px;    
    }
   
    .img-width {
        width: 225pt;
        height: auto;
    }

    .dashed-line {
        border-top: 2px dashed #dc3545; /* Contoh: Garis putus-putus merah di bagian atas */
        margin-top: 20px;
        margin-bottom: 20px;
        height: 0; /* Penting untuk elemen yang tidak memiliki tinggi */
    }

</style>