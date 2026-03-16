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
        <h3 class="text-header">EKSTRAKURIKULER <span id="div_nama_unit"></sapn></h3> 
        <hr style="margin-top: 5px; margin-bottom: 5px;">

        <div id="div_ektrakurikuler" align="center"></div>
    </div>
</body>
</html>

<script type="text/javascript">
       
    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'         
        var nama_jenjang = '';
        if(kode_jenjang=='RA'){
            nama_jenjang = ' - RA/TK'
        }else{
            if(kode_jenjang=='MI'){
                nama_jenjang = ' - MI/SD'
            }else{
                if(kode_jenjang=='SMPIT'){
                nama_jenjang = ' - SMPIT'
                }else{
                    nama_jenjang = ' - ' + kode_jenjang
                }
            }
        }
        document.getElementById("div_nama_unit").innerHTML = nama_jenjang  

        await fetch_data_ekstrakurikuler()       
    }


    function fetch_data_ekstrakurikuler(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('ekstrakurikuler/ekstrakurikuler/get_data_ekstrakurikuler') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){       
            var data = responseData.data[0]   
            console.log(responseData)        
			if (data.length>0){      
 
                var html = '';   
                var path_img = '';
                html += '<div class="row" >'; 
                for (let i = 0; i < data.length; i++) {
                  
                    html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                    html +='    <div class="card mr-3 shadow" style="width: 17rem;">';        
                    html +='        <img src="'+data[i].img_path+'" class="my_img" style="cursor: pointer;">'; 
                    html +='        <div class="card-body">';
                    html +='            <p class="card-text" style="margin-bottom:3px;">'+data[i].nama_ekstrakurikuler+'</p>';                   
                    html +='    </div>';
                    html +='    </div>';  
                    html +=' </div>'; 
                    
                }
                html +=' </div>'; 
                document.getElementById("div_ektrakurikuler").innerHTML = html                
            }	
                         
        });            
    }

</script>
