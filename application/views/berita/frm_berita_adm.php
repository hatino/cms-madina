<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    
</head>
<body onload="init_form()">  
    
    <div class="container mt-5">
        <div style="line-height: 40px;"><br></div>
        <h3 class="text-header"><strong>Berita dan Informasi</strong></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">

            <input type="hidden" name="_status_edit" id="_status_edit" value=false> 
            <input type="hidden" name="_berita_id" id="_berita_id" value=0> 

            <label for="txt_judul_berita" class="col-sm col-form-label col-form-label-sm">Judul</label> 
                <div class="input-group input-group-sm">
                    <input type="text" name="txt_judul_berita" id="txt_judul_berita" class="form-control" autocomplete="off"> 
                </div>               
                <label for="txt_deskripsi_berita" class="col-sm col-form-label col-form-label-sm">Deskripsi</label> 
                <textarea type="text" name="txt_deskripsi_berita" id="txt_deskripsi_berita" class="editor form-control" autocomplete="off"></textarea>    
                
                <br>
                
                <div class="container py-4">
                    <div class="row g-4"> 

                        <!-- CARD 1 -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card group-sm">
                                <div class="card-header">Upload Photo </div>
                                <div class="card-body ">
                                    <!-- <div class="card">   -->
                                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                                        <span id="uploaded_img_berita_1"></span>							  
                                    <!-- </div> -->
                
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                                    <input type="hidden" name="img_path[]" id="uploaded_img_berita_1_path">                         
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                                    <input type="hidden" name="uploaded_img_berita_1_path_ori" id="uploaded_img_berita_1_path_ori"> 						 
                            
                                    <table>
                                        <tr>
                                            <td width="200">
                                                <button type="button" class="btn btn-info text-light btn-file btn-sm btn-shadow me-2" onclick="document.getElementById('file_berita_1').click()" style="margin-top: 5px;">
                                                    <i class="bi bi-upload"></i> Browse<input type="file" name="img[]" class="file_berita form-control" id="file_berita_1"  data-idx="1" style="display:none;">
                                                    <label for="file_berita_1" id="lbl_file_berita_1"></label>
                                                </button>	
                                                <button type="button" class="btn btn-secondary btn-sm btn-shadow" style="margin-top: 5px;" id="kosong_file_berita_1"><i class="bi bi-eraser"></i> Batal</button>				
                                            </td>
                                        </tr>	  		
                                    </table>	  	
                                
                                </div>
                                <div class="card-footer text-muted">
                                    Jenis File : jpg, jpeg, png <br>
                                    Max Size : 2 MB
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2 -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card group-sm">  
                                <div class="card-header">Upload Photo 2</div>
                                <div class="card-body">    
                                    <!-- <div class="card">   -->
                                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                                        <span id="uploaded_img_berita_2"></span>							  
                                    <!-- </div> -->
                
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                                    <input type="hidden" name="img_path[]" id="uploaded_img_berita_2_path">                         
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                                    <input type="hidden" name="uploaded_img_berita_2_path_ori" id="uploaded_img_berita_2_path_ori"> 						 
                            
                                    <table>
                                        <tr>
                                            <td width="200">
                                                <button type="button" class="btn btn-info text-light btn-file btn-sm btn-shadow me-2" onclick="document.getElementById('file_berita_2').click()" style="margin-top: 5px;">
                                                    <i class="bi bi-upload"></i> Browse<input type="file" name="img[]" class="file_berita form-control" id="file_berita_2"  data-idx="2" style="display:none;">
                                                    <label for="file_berita_2" id="lbl_file_berita_2"></label>
                                                </button>	
                                                <button type="button" class="btn btn-secondary btn-sm btn-shadow" style="margin-top: 5px;" id="kosong_file_berita_2"><i class="bi bi-eraser"></i> Batal</button>				
                                            </td>
                                        </tr>	  		
                                    </table>	  	
                                
                                </div>
                                <div class="card-footer text-muted">
                                    Jenis File : jpg, jpeg, png <br>
                                    Max Size : 2 MB
                                </div>
                            </div>                        
                        </div>

                        <!-- CARD 3 -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card group-sm">  
                                <div class="card-header">Upload Photo 3</div>
                                <div class="card-body">    
                                    <!-- <div class="card">   -->
                                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                                        <span id="uploaded_img_berita_3"></span>							  
                                    <!-- </div> -->
                
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                                    <input type="hidden" name="img_path[]" id="uploaded_img_berita_3_path"> 
                                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                                    <input type="hidden" name="uploaded_img_berita_3_ori" id="uploaded_img_berita_3_ori"> 						 
                            
                                    <table>
                                        <tr>
                                            <td width="200">
                                                <button type="button" class="btn btn-info text-light btn-file btn-sm btn-shadow me-2" onclick="document.getElementById('file_berita_3').click()" style="margin-top: 5px;">
                                                    <i class="bi bi-upload"></i> Browse<input type="file" name="img[]" class="file_berita form-control" id="file_berita_3"  data-idx="3" style="display:none;">
                                                    <label for="file_berita_3" id="lbl_file_berita_3"></label>
                                                </button>	
                                                <button type="button" class="btn btn-secondary btn-sm btn-shadow" style="margin-top: 5px;" id="kosong_file_berita_3"><i class="bi bi-eraser"></i> Batal</button>				
                                            </td>
                                        </tr>	  		
                                    </table>	  	
                                
                                </div>
                                <div class="card-footer text-muted">
                                    Jenis File : jpg, jpeg, png <br>
                                    Max Size : 2 MB
                                </div>
                            </div>                        
                        </div>

                    </div>
                </div>
                
                <br>         
                <button type="submit" id="btnSubmit" class="btn btn-submit btn-sm btn-shadow me-2"><i class="bi bi-save2"></i> Submit</button>
                <button type="button" id="btnTambah" class="btn btn-primary btn-sm btn-shadow"><i class="bi bi-file-earmark-plus"></i> Tambah</button>
                <hr id="batas">

        </form>
        
        <h5>Daftar Berita</h5>
        <!-- <div class="tscroll">
            <div id="div_tbl_berita"></div>
        </div> -->

        <div class="tscroll">
            <div id="div_tbl_berita" class="table-responsive table-height"></div>
        </div>

        <br>
        <div id="div_pagination" align="center"></div>
        <br>

    </div>
</body>
</html>
        

<script type="text/javascript">
    
    var page = 1
    async function init_form() {      
        await load_blank_image()       
        await fetch_tbl_berita(page)
    }

    function load_blank_image() {      
        const element = document.querySelectorAll('.file_berita')
        let path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';      
        for (const el of element) {
            let idx = el.getAttribute('data-idx')
            $('#uploaded_img_berita_'+idx+'').html("");	
            $('#uploaded_img_berita_'+idx+'').append("<img src='"+ path_blank_image +'?'+ new Date().getTime()+"' class='img-fluid'>");
            $('#uploaded_img_berita_'+idx+'_path').val('')
        }         
    }
    
    //document.getElementById('simpan_form').addEventListener('submit', async function simpan_form_onsubmit (e) {
    $(document).on('submit','#simpan_form', async function (e) {
        e.preventDefault();

         var status_edit = $('#_status_edit').val()
        
        let judul_berita = $('#txt_judul_berita').val();   
        if( judul_berita == false){	    
            $('#txt_judul_berita').css('border-color', '#cc0000');	         
            $('#txt_judul_berita').focus();
            alert('Silahkan isi judul');
            return false;
        }else{
            $('#txt_judul_berita').css('border-color', '');	
        }
        
        let deskripsi = $('#txt_deskripsi_berita').val();   
        //const deskripsi = editor.getData();        
        if( deskripsi == ''){	        
            $('#txt_deskripsi_berita').focus();
            alert('Silahkan isi deskripsi');
            return false;
        }    

        const formData = new FormData(this);

        const response = await fetch('<?php echo site_url('berita/berita_admin/simpan_berita') ;?>', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        
        if(result.status==true){
            alert(result.message)
            await fetch_tbl_berita(page)
            await input_area_clear()     
        }else{
             alert(result.message)
        }
        
          
    });
    
    // async function delete_file_berita(file_berita_path) {
    //     var form_data = new FormData();
    //     form_data.append("img_file_path", file_berita_path);

    //     let res = await fetch('<?php echo base_url('deletedfile.php') ;?>',{
    //                 method: 'POST',                       
    //                 body: form_data,                               
    //             })

    //     let rs = res.json()

    //     // await $.ajax(
    //     // {
    //     //     url:"<?php echo base_url()?>deletedfile.php",
    //     //     //url:"uploadfile",    
    //     //     method:"POST",
    //     //     data: form_data,
    //     //     contentType: false,
    //     //     //contentType: 'multipart/form-data',
    //     //     cache: false,
    //     //     processData: false,
    //     //     /*
    //     //     beforeSend:function(){
    //     //         $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");				    
    //     //     },   
    //     //     */
    //     //     success:function(dataResult)
    //     //     {    	
    //     //         var dataResult = JSON.parse(dataResult);
    //     //         console.log(dataResult)                
    //     //     }
    //     // });

    // }

    async function upload_file_berita(par, idx) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var berita_id = $('#_berita_id').val()
        var img_file_path_ori = $('#uploaded_img_berita_'+idx+'_path').val()
        form_data.append("file_berita", document.getElementById('file_berita_'+idx+'').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "berita"); 
        form_data.append("berita_id", berita_id);        
        form_data.append("img_file_path_ori", img_file_path_ori);
        form_data.append("idx", idx);

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
                
                $('#uploaded_img_berita_'+idx+'').html("");	
                $('#uploaded_img_berita_'+idx+'').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-fluid'>")                    
                $('#uploaded_img_berita_'+idx+'_path').val("")
                $('#uploaded_img_berita_'+idx+'_path').val(path_view);                  
            }
        });

    }

    // async function simpan_img_path(berita_id, idx) {                       
    //     //await upload_file_berita('simpan');  
    //     let img_file_path =  $('#uploaded_img_berita_'+idx+'_path').val(); 
    //     var form_data = new FormData();
    //     form_data.append("berita_id", berita_id);        
    //     form_data.append("img_file_path", img_file_path);
    //     form_data.append("idx", idx)
        
    //     let res = await fetch('<?php echo site_url('berita/berita_admin/simpan_img_path') ;?>',{
    //                 method: 'POST',   
    //                 //data:{'berita_id':berita_id, 'img_file_path':img_file_path},
    //                 body: form_data,
    //                 //headers: {'Content-Type': 'multipart/json'}                  
    //             })

    //     let rs = res.json()
        
    // }

    $(document).on('change', '.file_berita', function()
	{			
        try {   

            let el_file_berita = $(this).attr('id')
            let idx = $(this).attr('data-idx')
                        
            var name_obj =document.getElementById(el_file_berita).files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById(el_file_berita).files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById(el_file_berita).files[0]);
            var f = document.getElementById(el_file_berita).files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_berita('upload', idx)                
            }

        } catch (error) {
            alert(error)
        }
	});

    function fetch_tbl_berita(page){            
        var limit = 10
        fetch('<?php echo site_url('berita/berita_admin/get_data_tbl_berita') ;?>?&page='+page+'&limit='+limit+'')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){                        
            var data = responseData.data[0]   
            var html = '';   
            var path_img = '';
            
            var html = '';                
            html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_berita">';            
            html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
            html += '		<tr class="text-nowrap">';                                        
            html += '			<th>Judul Berita</th>';
            html += '           <th>Deskripsi Berita</th>';
            html += '           <th>Image</th>';
            html += '           <th>Image 2</th>';
            html += '           <th>Image 3</th>';
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
                    html += '   <td width="15%">'+data[count].judul_berita+'</td>';  //0                
                    html += '   <td >'+data[count].deskripsi_berita+'</td>'; //1

                    if(data[count].img_path != ''){
                    html += '   <td width="10%" style="text-align:center;"><img src='+ path_img +'?'+ new Date().getTime()+' width="100pt", height="80pt"></td>'; //2
                    }else{
                    html += '   <td width="10%" style="text-align:center;"></td>'; //2            
                    }                
                    html += '   <td style="display:none;">'+path_img+'</td>'; //3

                    if(data[count].img_path_2 != ''){
                    html += '   <td width="10%" style="text-align:center;"><img src='+ data[count].img_path_2 +'?'+ new Date().getTime()+' width="100pt", height="80pt"></td>';//4
                    }else{
                    html += '   <td width="10%" style="text-align:center;"></td>'; //4           
                    }                
                    html += '   <td style="display:none;">'+data[count].img_path_2+'</td>'; //5      
                    
                    if(data[count].img_path_3 != ''){
                    html += '   <td width="10%" style="text-align:center;"><img src='+ data[count].img_path_3 +'?'+ new Date().getTime()+' width="100pt", height="80pt"></td>';//6
                    }else{
                    html += '   <td width="10%" style="text-align:center;"></td>'; //6          
                    }                
                    html += '   <td style="display:none;">'+data[count].img_path_3+'</td>'; //7

                    html += '   <td align="center" style="cursor: pointer;"> <a href="#" id="edit_berita" data-id='+data[count].berita_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                    html += '   <td align="center" style="cursor: pointer;"> <a id="delete_berita" data-id='+data[count].berita_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                    html += '</tr>';                                                                                                   
                }
                html += '</tbody>';      
            }	
            html +='</table>';  

            document.getElementById("div_tbl_berita").innerHTML = html   
            
            const total_page = responseData.total_page
            
            html = '';
            if (total_page >1){
                html +='<ul class="pagination justify-content-center">';  
                for (let ir = 1; ir <= total_page; ir++) {      
                    if(page==ir){
                        html +=' <li class="page-item" id='+ir+'><a class="page-link" href="#btnSubmit" style="background-color:#006DCC; color:white;">'+ir+'</a></li>';    
                    }else{
                        html +=' <li class="page-item" id='+ir+'><a class="page-link" href="#btnSubmit" >'+ir+'</a></li>';    
                    }             
                }	
                html +='</ul>';  
                
            }
            document.getElementById("div_pagination").innerHTML = html                      
        
        });            
    }
        
    $(document).on('click', '.page-item', async function () {
        var page = $(this).attr('id');       
        await fetch_tbl_berita(page)                
    })

    $(document).on('click', '#btnTambah', function () {
        input_area_clear()            
        document.documentElement.scrollTop = 0;
    })

    
    $(document).on('click', '#delete_berita', function delete_berita_onclick () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var berita_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_berita")   
        var row = tbl.rows[row_index]
        
        const img_paths = [
            row.cells[3].innerHTML.trim(),
            row.cells[5].innerHTML.trim(),
            row.cells[7].innerHTML.trim()
        ]
        
        const form_data = new FormData();

        img_paths.forEach((path, idx) => {
            if(path){
                form_data.append(`data_path[${idx}]`, path)
            }
        })

        form_data.append('berita_id', berita_id)
                     
        fetch('<?php echo site_url('berita/berita_admin/delete_berita') ;?>',{
                    method: 'POST',   
                    body: form_data,
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
                        alert(dataResult.message);
                    }                   
                }else{
                    alert('Hapus data sukses');                          
                    await fetch_tbl_berita(page);
                    await input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

    async function input_area_clear() {
        $('#_status_edit').val(false)
        $('#_berita_id').val(0)        
        $('#txt_judul_berita').val('')     
        window.editor.setData("")   
        
        let path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';       
        let element = await document.querySelectorAll('.file_berita')
        element.forEach( el=>{
            idx = el.getAttribute('data-idx')          
            $('#uploaded_img_berita_'+idx+'').html('')                     
            $('#file_berita_'+idx+'').val(null)               
        
            $('#uploaded_img_berita_'+idx+'').append("<img src='"+ path_blank_image +'?'+ new Date().getTime()+"' class='img-fluid card-img-custom'>");
            $('#uploaded_img_berita_'+idx+'_path').val('')               
        })           
    }
        
    $(document).on('click', '#edit_berita', function () {       
        var berita_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_berita")
        var judul_berita =  tbl.rows[row_index].cells[0].innerHTML;    
        var deskripsi_berita = tbl.rows[row_index].cells[1].innerHTML; 
        var img_path = tbl.rows[row_index].cells[3].innerHTML;
        var img_path2 = tbl.rows[row_index].cells[5].innerHTML;
        var img_path3 = tbl.rows[row_index].cells[7].innerHTML;
                   
        $('#_status_edit').val(true)
        $('#_berita_id').val(berita_id)      
        $('#txt_judul_berita').val(judul_berita)        
        window.editor.setData(deskripsi_berita)
        
        let path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/blank_photo.jpg';  
        if(img_path!=''){
            $('#uploaded_img_berita_1_path_ori').val(img_path)
            $('#uploaded_img_berita_1').html('')
            $('#uploaded_img_berita_1').append("<img src='"+ img_path + '?'+ new Date().getTime()+"' class='img-fluid'>");        
        }else {
            $('#uploaded_img_berita_1_path_ori').val('')
            $('#uploaded_img_berita_1').html('')
            $('#uploaded_img_berita_1').append("<img src='"+ path_blank_image + '?'+ new Date().getTime()+"' class='img-fluid'>");        
        }
        
        if(img_path2!=''){
            $('#uploaded_img_berita_2_path_ori').val(img_path2)
            $('#uploaded_img_berita_2').html('')
            $('#uploaded_img_berita_2').append("<img src='"+ img_path2 + '?'+ new Date().getTime()+"' class='img-fluid'>");    
        }else{
            $('#uploaded_img_berita_2_path_ori').val('')
            $('#uploaded_img_berita_2').html('')
            $('#uploaded_img_berita_2').append("<img src='"+ path_blank_image + '?'+ new Date().getTime()+"' class='img-fluid'>");  
        }
        
        if(img_path3!=''){
            $('#uploaded_img_berita_3_path_ori').val(img_path3)
            $('#uploaded_img_berita_3').html('')
            $('#uploaded_img_berita_3').append("<img src='"+ img_path3 + '?'+ new Date().getTime()+"' class='img-fluid'>"); 
        }else{
            $('#uploaded_img_berita_3_path_ori').val('')
            $('#uploaded_img_berita_3').html('')
            $('#uploaded_img_berita_3').append("<img src='"+ path_blank_image + '?'+ new Date().getTime()+"' class='img-fluid'>");  
        }        
              
        document.documentElement.scrollTop = 0;
    })

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
        .create( document.querySelector( '#txt_deskripsi_berita' ), {
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
        min-height: 200px;    
    }
   
    .img-width {
        width: 185pt;
        height: 185ptt;
    }
   
    /* Kunci utama agar gambar tidak penyet dan tingginya seragam */
    .card-img-custom {
        height: 200px; /* Tentukan tinggi tetap yang Anda inginkan */
        object-fit: cover; /* Gambar akan terpotong rapi memenuhi area tanpa distorsi */
        width: 100%;
    }

    /* Opsional: Memastikan semua card memiliki tinggi yang sama jika teksnya berbeda panjang */
    .card {
        height: 100%;
    }
</style>
