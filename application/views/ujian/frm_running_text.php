<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>  
</head>
<body>

    <body onload="init_form()"></body>
    <br>

    <div class="container mt-5">        
        <h3 class="text-header"> RUNNING TEXT</h3>
        <hr style="margin-top: 5px; margin-bottom: 5px;">
        <div style="line-height: 8px;"><br></div>
       
        <form method="post" id="simpan_form">
            <label for="txt_running_text" class="col-sm col-form-label col-form-label-sm">Running Text</label>
            <div class="input-group-sm col-sm-12">
                <input type="text" name="txt_running_text_1" id="txt_running_text_1" class="form-control">                            
            </div>	
            
            <br>
            <button type="submit" id="btnSubmit" class="btn btn-submit btn-sm"><i class="bi bi-save2"></i> Simpan</button>
            <button type="button" id="btnHapus" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
        </form>

    </div>
    
</body>
</html>


<script  type="text/javascript">

    async function init_form() {        
        await fetch_data_running_text()        
    }
   
    async function fetch_data_running_text() {       
        var result_data = await fetch("<?php echo site_url('ujian/running_text/get_data_running_text');?>", {method:"GET", mode: "no-cors" })           
        const result = await result_data.json()        
        let x = result.data        
        if(x.length > 0){   
            var running_text_1  = x[0].running_text_1               
            $("#txt_running_text_1").val(running_text_1)                
        }else{
            $("#txt_running_text_1").val('')            
        }
    }

    $(document).on('click', '#btnHapus', function () {

        var hasil = confirm('Apakah anda yankin ingin menghapus data?')
        if(hasil==false){
            return false
        }

        fetch('<?php echo site_url('ujian/running_text/hapus_running_text') ;?>',{
                    method: 'POST'     
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
                    alert(dataResult.message);    
                    fetch_data_running_text()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });   
    })

    $(document).on('submit','#simpan_form', async function (event) {
        
        event.preventDefault();
             
        let x = document.forms["simpan_form"];       
        let running_text_1 = x["txt_running_text_1"].value;
        
        if( running_text_1 == '' ){
            $('#txt_running_text_1').css('border-color', '#cc0000');            
            alert('Silahkan isi running text');
            return false;
        }else{
            $('#txt_running_text_1').css('border-color', '');            	
        }
       
        var form_data= $(this).serialize();

        fetch('<?php echo site_url('ujian/running_text/simpan_running_text') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data),                               
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
                    alert(dataResult.message);    
                    //fetch_data_profile_yayasan()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    
</script>