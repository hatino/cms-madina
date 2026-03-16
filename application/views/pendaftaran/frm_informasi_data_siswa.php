<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
</head>
<body>

    <body onload="init_form()"></body>
    
    <!--Modal Form Informasi Data Siswa -->
    <div class="modal fade" id="modal_informasi_data_siswa" role="dialog" data-bs-backdrop="static" >
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
    function init_form() {
        $('#modal_informasi_data_siswa').modal('show')
    }

    $(document).on('click', '#btn_home', function () {
        //    window.location.href = "<?php echo base_url() .'index.php/dashboard'; ?>"    
        history.back()
    })

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
                // console.log(responseData)      
                if(responseData.data.length>0){                    
                    var kode_jenjang = responseData.data[0].group_cls                  
                    window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_siswa_detail') ; ?>?kode_jenjang="+kode_jenjang+"&siswa_id="+siswa_id+""   
                    // load_data_calon_siswa(responseData.data[0])        
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


    $(function() {
        $('#dt_tgl_lahir_siswa').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');           
    });
</script>

<style>
    .modal-footer {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;
    }

</style>