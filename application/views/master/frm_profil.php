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
        <h3 class="text-header mb-1"><strong>Profil Yayasan</strong></h3>
        <hr style="margin-top: 1px;">

            <form method="post" id="simpan_form">

                <!--UNTUK STATUS EDIT (TRUE) ATAU TIDAK (FALSE) -->
                <input type="hidden" name="status_edit" id="status_edit">  	
                <table class="table table-sm">
                    <tr class="borderless-bottom">
                        <td >
                            <label for="txt_nama_yayasan" class="col-sm col-form-label col-form-label-sm">Nama Yayasan</label>
                            <div class="input-group-sm col-sm-12">
                                <input type="text" name="txt_nama_yayasan" id="txt_nama_yayasan" class="form-control">                            
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
                            <label for="txt_google_map" class="col-sm col-form-label col-form-label-sm">Lokasi (Google Map)</label>
                            <div class="input-group input-group-sm col-sm-10">
                                <textarea type="text" name="txt_google_map" id="txt_google_map" class="form-control" rows="4"></textarea>                            
                            </div>
                        </td>                                                 
                    </tr>           
                                    
                </table>
               
                <hr>
                <button type="submit" id="btnSubmit" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Submit</button>
                <!-- <button type="button" id="btnClear" class="btn btn-clear btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Clear</button>
                <button type="button" id="btnDelete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button> -->
                <br>
                <br>
                <br>
            </form>
    </div>
    
</body>
</html>


<script type="text/javascript">
   
    async function init_form() {      
        await fetch_data_profile_yayasan()
    }
       
    async function fetch_data_profile_yayasan() {
       
        var result_data = await fetch("<?php echo site_url('master/profil/get_data_profil_yayasan');?>", {method:"GET", mode: "no-cors" })           
        const result = await result_data.json()

        console.log(result)
                        
        if(result.data[0].length > 0){   
            let x = result.data[0][0] 
            $('#txt_nama_yayasan').val(x.nama)
            $('#txt_alamat').val(x.alamat)
            $('#txt_telp').val(x.telp)
            $('#txt_hotline').val(x.no_hotline)
            $('#txt_google_map').val(x.google_map)
        }
    }
   
    $(document).on('submit','#simpan_form', async function () {       
        event.preventDefault();                       
        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    
            
        var form_data= $(this).serialize();
        await fetch("<?php echo site_url('master/profil/simpan_profil_yayasan');?>",{
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
        var nama_yayasan = x['txt_nama_yayasan'].value;
        var alamat= x['txt_alamat'].value;
        var telp = x['txt_telp'].value;
        var no_hotline = x['txt_hotline'].value;
        
        if(nama_yayasan==''){
            valid = false
            $('#txt_nama_yayasan').css('border-color', '#cc0000');
        }else{
            $('#txt_nama_yayasan').css('border-color', '');
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