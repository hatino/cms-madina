<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5-content.css"> -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />     
</head>

<body onload="init_form()">
    
    <div class="header_img">
        <div id="img_header"></div>                   
        <div class="centered" style="color: white; text-align:center; "><p><h2 class="display-3 fw-bold"><b>Sejarah Yayasan</b><h2></p></div>      
    </div>
    <br>

    <div class="container">  
        <div class="row">
            <div id="div_sejarah"></div>  
        </div>
        <br>
        <div id="div_visimisi"></div>  
    </div>

    <div id="div_struktur_yayasan"></div>         
    <br>
    <br>
    
</body>
</html>

<script type="text/javascript">

   async function init_form() {
        //html +='   <img src='+data[0].photo_sejarah_path +'?'+ new Date().getTime()+' class="img-width img-content img" >'; 
        html ='<img class="responsive img-width-header" src="<?php echo base_url() ?>images/images_bg/bg_sejarah_yayasan_home.jpg'+'?'+ new Date().getTime()+' alt="Notebook" style="width:100%;">';   
        document.getElementById("img_header").innerHTML = html
        await fetch_data_sejarah()
        await fetch_data_visi_misi()
        await fetch_data_struktur_yayasan()
        <?php simpan_kunjungan(); ?>
   }
   
    function fetch_data_sejarah() {       
        fetch('<?php echo site_url('sejarah/sejarah/get_data_sejarah');?>').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var html = ''; 
            var data = responseData.data[0]  
			if (data.length>0){                    
                // html +='   <h3 class="text-header" align="center"><b>Sejarah Yayasan</b></h3>';   
                html +='   <div align="center">'; 
                html +='   <img src='+data[0].photo_sejarah_path +'?'+ new Date().getTime()+' class="img-width img-content img" >'; 
                html +='   </div>';
                html +='   <br>';                       
                html +='   <div class="ck-content">'+data[0].sejarah+'</div>';  //0   
                html +='   <br>';                
                document.getElementById("div_sejarah").innerHTML = html               
            }else{
                document.getElementById("div_sejarah").innerHTML = ""                
            }
		});   
    }

    function fetch_data_visi_misi() {       
        fetch('<?php echo site_url('visimisi/visi_misi/get_data_visi_misi') ?>').then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{                 
            var html = '';        
            var data = responseData.data[0]
			if (data.length>0){  
                html +='   <div class="row justify-content-center"> ';         
                html +='        <div class="col-md-5" style="margin-bottom: 25px;" align="center"> ';
                html +='           <h3 class="text-header"><b>Visi</b></h3>';                 
                html +='           <div class="card shadow" style="width: 100%; border-radius: 25px"> ';
                html +='                <div class="card-body " style="background-color:#89CFF0; border-radius: 25px"">   ';                      
                html +='                    <div class="ck-content">'+data[0].visi+'</div>'; 
                html +='                </div>';
                html +='           </div>';
                html +='        </div> ';
                html +='        <div class="col-md-5" style="margin-bottom: 15px;" align="center"> ';  
                html +='           <h3 class="text-header"><b>Misi</b></h3>';     
                html +='           <div class="card shadow" style="width: 100%; border-radius: 25px"> ';    
                html +='                <div class="card-body"> ';
                html +='                    <div class="ck-content">'+data[0].misi+'</div>';
                html +='                </div>';
                html +='            </div>';
                html +='        </div>';
                html +='    </div>';          
                        
                document.getElementById("div_visimisi").innerHTML = html
                             	
            }else{
                document.getElementById("div_visimisi").innerHTML = "" 
            }
             
		});   
    }

    function fetch_data_struktur_yayasan() {       
        fetch('<?php echo site_url('struktur/struktur/get_data_struktur_yayasan') ?>').then(function(response){                   
			return response.json();    
		}).then(function (responseData) {                 
            var html = '';        
            var data = responseData.data    
            console.log(data)     
			if (data.length>0){                
                html +='   <br> '; 
                html +='   <div class="card" style="background-image: linear-gradient(rgb(24, 101, 163), white); width:100%; border:none"> ';  
                html +='   <div class="row" style="margin-top:20px"> ';                       
                html +='   <h3  style="color:white;" align="center"><b>Struktur Yayasan</b></h3>';
                html +='   <br>';
                html +='   <br>';  
                  
                for (let i = 0; i < data.length; i++) {              
                    html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                    html +='    <div class="card shadow" style="width: 14rem; border-radius: 15px;">';                   
                    html +='        <img src='+data[i].img_path+' style="border-top-right-radius: 15px; border-top-left-radius: 15px; border: 1px solid #ddd; padding:2px;">'; 
                    html +='        <div class="card-body">';
                    html +='            <p class="card-text" style="margin-bottom:3px;">'+data[i].jabatan+'</p>';
                    html +='            <p class="card-text" style="font-size:20px"><b>'+data[i].nama+'</b></p>'
                    html +='        </div>';
                    html +='    </div>';  
                    html +=' </div>'; 
                }
                html +='</div>'; 
                html +='</div> ';  
                html +='<br>'; 
                document.getElementById("div_struktur_yayasan").innerHTML = html;
                             	
            }else{
                document.getElementById("div_struktur_yayasan").innerHTML = "" 
            }
             
		});   
    }
    
</script>

<style>    
    .img-width {      
        width: 100%;
        height: auto;
    }

    .img-width-header {      
        width: 100%;
        height: 180px;        
    }

    /* Desktop (min-width 768px biasanya ukuran tablet ke atas) */
    @media (min-width: 992px) {
        .img-width {
            width: 50%;
            height: auto;
        }

        .img-width-header {
            width: 50%;
            height: auto; 
        }
    }    

    .img {
            float: left;
            margin: 5px;
        }
 
    .txt {
        text-align: justify;
        /*font-size: 25px;*/
    }

    .img-content {
        border-radius: 25px;
        border: 1px solid #ddd;       
        padding: 5px;
        /* width: 400pt; */
        height: auto;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        margin-right: 20px
    }

    .header_img {
    position: relative;
    font-family: Arial;
    }

    .centered {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .column {
        float: left;
        width: 50%;
        padding: 10px;
        /*height: 300px;*/ /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* .card {
        border-radius: 25px;
    } */

    .card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
}

</style>