<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">       
        <h3 class="text-header">STRUKTUR <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px;">
        <div id="div_struktur" align="center"></div>
    </div>
</body>
</html>

<script type="text/javascript">
   
    async function init_form() {   
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        var nama_jenjang = '';
        if(kode_jenjang=='RA'){
            nama_jenjang = 'RA/TK'
        }else{
            if (kode_jenjang=='MI'){
                nama_jenjang = 'MI/SD'
            }else{
                if(kode_jenjang=='SMPIT'){
                    nama_jenjang = 'SMPIT'
                }
            }
        }
        document.getElementById('span_nama_unit').innerHTML = nama_jenjang;            

        await fetch_data_struktur()       
        <?php simpan_kunjungan(); ?>
    }

    function fetch_data_struktur() {    
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'     
        fetch('<?php echo site_url('struktur/struktur/get_data_struktur') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{          
            var html ='';
            //PIMPINAN              
            var data_pim = responseData.data_pim[0]      
            console.log(data_pim)      
			if (data_pim.length>0){        
                        html += '<div class="row" >';      
                
                for (let i = 0; i < data_pim.length; i++) {
                    if(data_pim[i].kelompok_jabatan=='Pimpinan') {
                        html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                        html +='    <div class="card shadow" style="width: 17rem;">';                   
                        html +='        <img src='+data_pim[i].img_path+'>'; 
                        html +='        <div class="card-body">';
                        html +='            <p class="card-text" style="margin-bottom:3px;">'+data_pim[i].nama_jabatan+'</p>';
                        html +='            <p class="card-text" style="font-size:20px"><b>'+data_pim[i].nama+'</b></p>'
                        html +='    </div>';
                        html +='    </div>';  
                        html +=' </div>'; 
                        
                    }else{

                    }
                }	
                html +=' <hr>'; 
                html += '</div>'; 
                // document.getElementById("div_struktur").innerHTML = html  
            }

            //WALI KELAS  
            var data_wal = responseData.data_wal[0]      
            console.log(data_wal)      
			if (data_wal.length>0){        
                html += '<div class="row" >';      
                
                for (let i = 0; i < data_wal.length; i++) {
                    if(data_wal[i].kelompok_jabatan=='Wali Kelas') {
                        html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                        html +='    <div class="card shadow" style="width: 17rem;">';                   
                        html +='        <img src='+data_wal[i].img_path+'>'; 
                        html +='        <div class="card-body">';
                        html +='            <p class="card-text" style="margin-bottom:3px;">'+data_wal[i].nama_jabatan+'</p>';
                        html +='            <p class="card-text" style="font-size:20px"><b>'+data_wal[i].nama+'</b></p>'
                        html +='    </div>';
                        html +='    </div>';  
                        html +=' </div>'; 
                        
                    }else{

                    }
                }	
                html +=' <hr>'; 
                html += '</div>'; 
                
            }
             
            document.getElementById("div_struktur").innerHTML = html  
		});   
    }

</script>

<style>
    .img-width {
        width: 185pt;
        height: 185ptt;
    }



</style>