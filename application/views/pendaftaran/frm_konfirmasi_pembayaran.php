<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
</head>
<body>
    
    <body onload="init_form()"></body>

    <div id="my-header"></div>
    <br>
    <div class="container mt-5">      
        <div style="line-height: 30px;"><br></div>    
        <h3 class="text-header fw-bold">Konfirmasi Pembayaran PPDB <a id="nama_jenjang_div"></h3>        
        <h5 class="text-header"><div id="thn_ajaran_nama_div"></div></h5>
       
        <hr style="margin-top: 15px; margin-bottom: 10px;">

        <form method="post" id="simpan_form">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="150">                    
                        <label for="txt_siswa_id">No. ID Pendaftaran</label>     
                        <!-- <label for="txt_siswa_id"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                          -->
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_siswa_id" name="txt_siswa_id" readonly>
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_lengkap">Nama Lengkap</label> 
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_lengkap" name="txt_nama_lengkap" readonly>
                        </div>     
                    </td>
                </tr>               
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_ayah">Nama Ayah</label>                        
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_nama_ayah" name="txt_nama_ayah" readonly>
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_ibu">Nama Ibu</label>                        
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_nama_ibu" name="txt_nama_ibu" readonly>
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_no_telp">No. Telp/HP</label>                        
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_no_telp" name="txt_no_telp" readonly>
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_jml_pembayaran">Jumlah Pembayaran</label>     
                        <label id="lbl_jml_pembayaran" for="txt_jml_pembayaran"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                         
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_jml_pembayaran" name="txt_jml_pembayaran">
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_pemilik_rekening">Nama Pemilik Rekening</label>     
                        <label id="lbl_nama_pemilik_rekening" for="txt_nama_pemilik_rekening"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                         
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_pemilik_rekening" name="txt_nama_pemilik_rekening">
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="dt_tgl_transfer">Tanggal Transfer</label>     
                        <label id="lbl_dt_tgl_transfer" for="dt_tgl_transfer"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                         
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="dt_tgl_transfer" name="dt_tgl_transfer">
                        </div>      
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_pesan">Pesan (Jika ada)</label>                    
                        <div class="input-group-sm col-sm-8">                    
                            <textarea type="text" class="form-control" id="txt_pesan" name="txt_pesan"></textarea>
                        </div>      
                    </td>
                </tr>

            </table>

            <div class="card group-sm col-sm-3">
                        
                <div class="card-header">Upload Bukti Transfer</div>
                <div class="card-body ">

                    <!-- <div class="card">   -->
                        <!--img class="img-thumbnail" src="<?php echo base_url()?>img/img-bra.jpg" alt="Card image" style="width:100%"-->  
                        <span id="uploaded_image_konfirmasi"></span>							  
                    <!-- </div> -->

                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY -->
                    <input type="hidden" name="uploaded_image_konfirmasi_path" id="uploaded_image_konfirmasi_path">                    
                    <!--UNTUK MENYIMPAN PATH PHOTO TEMPORARY YG DARI DATABASE -->
                    <input type="hidden" name="txtpath_image_konfirmasi_ori" id="txtpath_image_konfirmasi_ori"> 						 
            
                    <table>
                        <tr>
                            <td width="200">
                                <button type="button" class="btn btn-info text-light btn-file btn-sm" onclick="document.getElementById('file_konfirmasi').click()" style="margin-top: 5px;">
                                    <i class="bi bi-upload"></i> Browse<input type="file" name="file_konfirmasi" class="form-control" id="file_konfirmasi"  data-id="test-file" style="display:none;">
                                    <label for="file_konfirmasi" id="lbl_file_konfirmasi"></label>
                                </button>	
                                <button type="button" class="btn btn-secondary btn-sm" style="margin-top: 5px;" id="kosong_file_konfirmasi"><i class="bi bi-eraser"></i> Batal</button>				
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
            <button type="submit" id="btn_submit" class="btn btn-sm btn-primary"><i class="bi bi-send-fill"></i> Kirim Konfirmasi</button>

        </form>

        <button type="button" class="transparent" onclick="topFunction()" id="myBtn" title="Go to top"></button>
        <br>
    </div>
    <br>
    <br>
    
    <!-- The Modal -->
    <div class="modal fade" id="modal_konfirmasi" role="dialog" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" padding="1px" style="background-color: #006DCC;" >
                <h5 class="modal-title text-white"  >Silahkan Isi Data yang Diperlukan</h5>            
                <!-- <button type="button" class="btn btn-danger text-light btn-sm" id="btn_close_modal"><b>X</b></button>   -->
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <h6> No. ID Pendaftaran Anda :</h6>
                    <div class="input-group-sm col-sm-8">
                        <input type="txt_siswa_id_input" name="" id="txt_siswa_id_input" class="form-control">
                    </div>
                </div>
                <div style="line-height: 15px;"><br></div>
                <div class="row">
                    <h6> Tgl Lahir Siswa :</h6>
                    <div class="input-group-sm col-sm-8">
                        <input type="text" name="dt_tgl_lahir_siswa" id="dt_tgl_lahir_siswa" class="form-select">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">                
                <button type="button" id="btn_konfirmasi_modal" class="btn btn-sm btn-primary"><i class="bi bi-check-circle-fill"></i>&nbsp;Input Konfirmasi</button>
                <button type="button" id="btn_home" class="btn btn-sm bg-navbar" style="left:5px"><i class="bi bi-back"></i>&nbsp;Kembali</button>
            </div>

        </div>
    </div>
    </div>

</body>
</html>

<script type="text/javascript">
    
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    $(document).on('click', '#btn_home', function () {
        //    window.location.href = "<?php echo base_url() .'index.php/dashboard'; ?>"    
        history.back()
    })
    
    async function init_form() {
        <?php simpan_kunjungan(); ?>
        
        path_visi = "<?php echo base_url() ?>" +'./images/images_ui/up-arrows.png';	
        $('#myBtn').append("<img src='"+ path_visi + "' width='30' height='30'>");	
      
        await input_area_clear();   

        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        var thn_ajaran_cls = "<?php echo $thn_ajaran_cls ;?>"   
       
        $('#txt_thn_ajaran_cls').val(thn_ajaran_cls)
        $('#txt_kode_jenjang').val(kode_jenjang)    
              
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/get_thn_ajaran_and_jenjang');?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()  
        var data = result.data[0]
        
        if(result.status=true && result.data[0].length > 0 ){
            // var nama_jenjang = data[0].deskripsi
            console.log(result)
            var nama_jenjang = ''
            var thn_ajaran_nama = data[0].thn_ajaran_nama
                       
            if (kode_jenjang=='RA'){
                nama_jenjang = ' - RA/TK'
            }else{
                if (kode_jenjang=='MI'){
                    nama_jenjang = ' - MI/SD'
                }else{
                    nama_jenjang = ' - '+kode_jenjang
                }
            }

            document.getElementById('nama_jenjang_div').innerHTML = nama_jenjang;            
            document.getElementById('thn_ajaran_nama_div').innerHTML = thn_ajaran_nama;            
        }

        $('#modal_konfirmasi').modal('show')
    }

    
    $(document).on('click', '#btn_konfirmasi_modal', function () {
        var siswa_id = $('#txt_siswa_id_input').val()
        var tgl = $('#dt_tgl_lahir_siswa').val()
        var valid = true

        if(siswa_id==''){           
            $('#txt_siswa_id_input').css('border-color', '#cc0000')    
            valid = false            
        }else{
            $('#txt_siswa_id_input').css('border-color', '')    
        }
        if(tgl==''){            
            $('#dt_tgl_lahir_siswa').css('border-color', '#cc0000')  
            valid = false
        }else{
            $('#dt_tgl_lahir_siswa').css('border-color', '')    
        }

        if (valid==false){
            alert('Silakan isi Data yang diperlukan')
            return false
        }

        var the_date = new Date(tgl)                      
        var tgl_lahir =  the_date.getFullYear() + "-"                  
                    +  ('00'+ (the_date.getMonth() + 1)).slice(-2) + "-"   
                    + ('00' + the_date.getDate()).slice(-2)   
        
        fetch('<?php echo site_url('pendaftaran/pendaftaran/get_data_siswa_konfirmasi') ;?>?siswa_id='+siswa_id+'&tgl_lahir='+tgl_lahir+'')
        .then(function(response) {
            return response.json();
        }).then(function (responseData) {  
            if (responseData.status==true){         
                console.log(responseData)      
                if(responseData.data.length>0){
                    load_data_calon_siswa(responseData.data[0])        
                }else{
                    alert('Data tidak ditemukan')
                }                        
            }else{
                alert(responseData.message);
                return false;
            }
                        
        }).catch(function(error) {
            alert(error)
        })     

    })

    function load_data_calon_siswa(data) {
        $('#txt_siswa_id').val(data.siswa_id)
        $('#txt_nama_lengkap').val(data.nama)       
        $('#txt_nama_ayah').val(data.nama_ayah)
        $('#txt_nama_ibu').val(data.nama_ibu)
        $('#txt_no_telp').val(data.no_hp)
        if(data.jml_pembayaran>0){
            $('#txt_jml_pembayaran').attr('readonly', true)
            $('#txt_pesan').attr('readonly', true)
            $('.btn-file').css('display', 'none')
            $('#kosong_file_konfirmasi').css('display', 'none')     
            $('#lbl_jml_pembayaran').css('display', 'none')
            $('#lbl_nama_pemilik_rekening').css('display', 'none')
            $('#lbl_dt_tgl_transfer').css('display', 'none')
        }else{
            $('#txt_jml_pembayaran').attr('readonly', false)
            $('#txt_pesan').attr('readonly', false)
            $('.btn-file').css('display', 'inline')
            $('#kosong_file_konfirmasi').css('display', 'inline')     
            $('#lbl_jml_pembayaran').css('display', 'inline')
            $('#lbl_nama_pemilik_rekening').css('display', 'inline')
            $('#lbl_dt_tgl_transfer').css('display', 'inline')
        }
        $('#txt_jml_pembayaran').val(data.jml_pembayaran)

        if(data.nama_pemilik_rekening!=''){
            $('#txt_nama_pemilik_rekening').attr('readonly', true)
        }else{
            $('#txt_nama_pemilik_rekening').attr('readonly', false)
        }
        $('#txt_nama_pemilik_rekening').val(data.nama_pemilik_rekening)    
        if(data.tgl_transfer!=''){
            $('#dt_tgl_transfer').attr('disabled', true)
        }else{
            $('#dt_tgl_transfer').attr('disabled', false)
        }
        $('#dt_tgl_transfer').datepicker('setDate', data.tgl_transfer).datepicker('fill');
        
        $('#txt_pesan').val(data.pesan)
        if(data.path_bukti_transfer!=''){   
            $('#uploaded_image_konfirmasi').html("")       		
		    $('#uploaded_image_konfirmasi').append("<img src='"+ data.path_bukti_transfer +'?'+ new Date().getTime()+ "' class='img-transfer-width'>" );	           
            $('#file').val(data.path_bukti_transfer);	
            $('#btn_submit').css('display','none')
        }else{
            load_blank_photo();
            $('#btn_submit').css('display','inline')
        }
       
        document.getElementById('nama_jenjang_div').innerHTML = ' - ' + data.group_cls;            
        document.getElementById('thn_ajaran_nama_div').innerHTML = data.thn_ajaran_nama; 

        $('#modal_konfirmasi').modal('hide')	
    }


    function input_area_clear() 
	{			
        $('#txt_siswa_id').val('')  
        $('#txt_nama_lengkap').val('')    
        $('#txt_nama_ayah').val('')
        $('#txt_nama_ibu').val('')        
        $('#txt_no_telp').val('')
        $('#txt_jml_pembayaran').val('')
        $('#txt_nama_pemilik_rekening').val('')
        $('#dt_tgl_transfer').val('')
        $('#txt_pesan').val('')
		$('#file').val('');
		$('#txtpath_image').val('');
        $('#txtpath_image_del_temp').val('');        
		$('#txtpath_image_ori').val('');

		load_blank_photo();
		//document.getElementById('list_type').style.color="gray";		
	}

    function load_blank_photo() {
		$('#uploaded_image_konfirmasi').html("<label class='text-success'></label>");      	
		var path = "<?php echo base_url() ?>" +'./images/images_ui/blank_photo.jpg';				
		$('#uploaded_image_konfirmasi').append("<img src='"+ path + "' class='img-transfer-width'>" );			
	}

    $(document).on('change', '#file_konfirmasi', async function()
	{			
        try {            
            var name_obj =document.getElementById("file_konfirmasi").files[0];       
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_konfirmasi").files[0].name;
        
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_konfirmasi").files[0]);
            var f = document.getElementById("file_konfirmasi").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                
                await upload_file_konfirmasi('upload');                
            }

        } catch (error) {
            alert(error)
        }
	});

    async function upload_file_konfirmasi(par) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }

        var siswa_id = $('#txt_siswa_id').val()       
        form_data.append("file_konfirmasi", document.getElementById('file_konfirmasi').files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "konfirmasi");
        form_data.append("siswa_id", siswa_id);
        var img_file_path_ori = $('#uploaded_image_konfirmasi_path').val()
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
                
                $('#uploaded_image_konfirmasi').html("");	
                $('#uploaded_image_konfirmasi').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-transfer-width'>")                    
                $('#uploaded_image_konfirmasi_path').val("")
                $('#uploaded_image_konfirmasi_path').val(path_view);   
            }
        });

    }


    $(document).on('click', '#kosong_file', function() {
        
        var path_file = $('#txtpath_image_del_temp').val();
               
        $.ajax({
                url:"/hapus_file_temp",
                method:"POST",                                
                data: {path_file:path_file},                
                dataType:"JSON",                    
                beforeSend:function(){
                    //$('#action_button').attr('disabled', 'disabled');
                },
                error: function (xhr, status, error) {                    
					console.log(xhr);					
                    // var err = JSON.parse(xhr.responseText);
                    // alert(err.message)					
                },
                success:function(data)
                {                                      
                    if (data.status==true){                         
						input_area_clear()						
                    }else{                    
                        alert(data.message);
                    }                   
                }
        });    
    })
   

    $(document).on('submit','#simpan_form', async function(event) {
        event.preventDefault()
      
        var valid_data = await validasi_submit();
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');           
        }

        var valid_data_2;
        var file = $('#file_konfirmasi').val();
        
        if(file == ''){
            valid_data_2 = false
            alert('Silahkan upload bukti transfer')           
        }
        if (valid_data==false|| valid_data_2== false){
            return false
        }
        
        var nama_lengkap = $('#txt_nama_lengkap').val()
        var siswa_id = $('#txt_siswa_id').val()

        var cek_data_double = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_data_konfirmasi_double') ;?>?siswa_id='+siswa_id+'&nama_lengkap='+nama_lengkap+'', {method:"GET", mode: "no-cors" })
        var result_double = await cek_data_double.json()    
        if(result_double.data[0].length>0){
            alert('Siswa ID yang dimasukkan sudah melakukan konfirmasi pembayaran, silahkan periksa kembali')
            return false
        }

        var cek_data_exists = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_data_siswa_exists') ;?>?siswa_id='+siswa_id+'&nama_lengkap='+nama_lengkap+'', {method:"GET", mode: "no-cors" })
        var result = await cek_data_exists.json()
        var data = result.data[0]        
        if(result.data.length==0){
            alert('Mohon untuk dipastikan kembali No. ID pendaftaran / Nama calon siswa yang sesuai')
            return false
        }
        
        var msg = confirm('Calon siswa : '+data[0].nama+'\n No. Pendaftaran: '+data[0].siswa_id+'\n Nama Ayah: '+data[0].nama_ayah+'\n Nama Ibu: '+data[0].nama_ibu+'\n\n jika data tsb benar silahkan klik tombol Yes/Oke')        
        if(msg==false){
            return false;
        }
                
        await upload_file_konfirmasi('simpan');

        var form_data= $(this).serialize();

        fetch('<?php echo site_url('pendaftaran/pendaftaran/simpan_konfirmasi_pendaftaran') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then(dataResult => {          
                // console.log(dataResult)     
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{       
                    alert('Kirim Konfirmasi Berhasil')
                    input_area_clear()
                }
                
            })
        .catch(err => {
            alert(err);
        });  
    });


    async function validasi_submit() {      
        let valid=true;		
        x = document.forms['simpan_form']
        var nama_lengkap = x['txt_nama_lengkap'].value;
        var siswa_id= x['txt_siswa_id'].value;
        // var email = x['txt_email'].value;
        var no_telp = x['txt_no_telp'].value;
        var jml_pembayaran = x['txt_jml_pembayaran'].value;
        var nama_rekening = x['txt_nama_pemilik_rekening'].value;
        var tgl_transfer = x['dt_tgl_transfer'].value;
        
        if(nama_lengkap==''){
            valid = false
            $('#txt_nama_lengkap').css('border-color', '#cc0000');
        }else{
            $('#txt_nama_lengkap').css('border-color', '');
        }       
        if(siswa_id==''){
            valid = false
            $('#txt_siswa_id').css('border-color', '#cc0000');
        }else{
            $('#txt_siswa_id').css('border-color', '');
        }     
        // if(email==''){
        //     valid = false
        //     $('#txt_email').css('border-color', '#cc0000');
        // }else{
        //     $('#txt_email').css('border-color', '');
        // }     
        if(no_telp==''){
            valid = false
            $('#txt_no_telp').css('border-color', '#cc0000');
        }else{
            $('#txt_no_telp').css('border-color', '');
        }     
        if(jml_pembayaran==''||jml_pembayaran==0){
            valid = false
            $('#txt_jml_pembayaran').css('border-color', '#cc0000');
        }else{
            $('#txt_jml_pembayaran').css('border-color', '');
        }     
        if(nama_rekening==''){
            valid = false
            $('#txt_nama_pemilik_rekening').css('border-color', '#cc0000');
        }else{
            $('#txt_nama_pemilik_rekening').css('border-color', '');
        }     
        if(tgl_transfer==''){
            valid = false
            $('#dt_tgl_transfer').css('border-color', '#cc0000');
        }else{
            $('#dt_tgl_transfer').css('border-color', '');
        }     
        
        return valid
    }


    $(document).on('keyup', '#txt_jml_pembayaran', function () {
        var x=$('#txt_jml_pembayaran').val();
        $('#txt_jml_pembayaran').css('border-color','')
        
        if (isNaN(x)){  
            var x = x.replace(/,(?=\d{3})/g, '')   
            var x_res = x.slice(0,-1);
            document.getElementById("txt_jml_pembayaran").value = x_res
            return false;
        }              
    })

    $(document).on('focusout', '#txt_jml_pembayaran', function () {
        
        var y = document.getElementById("txt_jml_pembayaran").value; 
        var y_num;
        y_num = parseFloat(y)
        document.getElementById("txt_jml_pembayaran").value = y_num.toLocaleString('en-US', {maximumFractionDigits: 2})       
    })

    $(function() {
        $('#dt_tgl_transfer').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');           

        $('#dt_tgl_lahir_siswa').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');           
    });

    // Get the button
    let mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

</script>

<style>
    .img-transfer-width {
        width: 185pt;
        height: 185ptt;
    }
    
    #myBtn {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        /*background-color: red;*/
        color: darkblue;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
    }

    #myBtn:hover {
        background-color: #e5e7e7;
    }

    .transparent{
        background-color: transparent;
    }

    .modal-footer {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;
    }

   
</style>