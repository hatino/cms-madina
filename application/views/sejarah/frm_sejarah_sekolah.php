<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5-content.css"> -->
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />     
</head>

<body onload="init_form()"> 
    <div class="header_img">
        <div id="img_header"></div>          
        <div class="centered" style="color: white; text-align:center; "><p><span class="text-banner fw-bold" style="white-space: nowrap"><b>Sejarah <span id="span_nama_unit"></span></b></span></p></div>  
    </div>
    <br>
    <div class="container mb-5">          
        <div class="row justify-content-center align-items-center">      
            <div id="div_sejarah"></div>
        </div> 
        <br>
        <div id="div_visimisi"></div>  
        <br>
        <div id="div_meluluskan_angkatan_ke"></div>
    </div>       
    <br>
    <br>
    <br>
    
    <div class="footer2 fixed-bottom mt-5">
      <div class="container">
        <div class="row">
            <div class="col-4 text-center">
                <span class="unit_jenjang fw-bold" data-id="TKIT" style="cursor: pointer;" title="TKIT Madina"><i class="bi bi-house-heart"></i>&nbsp;<b>TKIT</b></span>
            </div>
            <div class="col-4 text-center">
               <span class="unit_jenjang fw-bold" data-id="SDIT" style="cursor: pointer;" title="SDIT Madina"><i class="bi bi-house-check"></i>&nbsp;<b>SDIT</b></span>
            </div>
            <div class="col-4 text-center">
                <span class="unit_jenjang fw-bold" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Madina"><i class="bi bi-house-up"></i>&nbsp;<b>SMPIT</b></span>
            </div>           
		</div>
      </div>
    </div>   
    
</body>
</html>

<script type="text/javascript">

    async function init_form() {
        var html ='<img class="responsive img-width-header" src="<?php echo base_url() ?>images/images_bg/header_bg_sejarah_sekolah.jpg'+'?'+ new Date().getTime()+' alt="Notebook";">';
        document.getElementById("img_header").innerHTML = html
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'         
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;       
        await fetch_data_sejarah(kode_jenjang)   
        await fetch_data_visi_misi(kode_jenjang)    
        <?php simpan_kunjungan(); ?>
    }

    $(document).on('click','.unit_jenjang', function() {       
        var unit = $(this).attr("data-id")      
        window.location.href="<?php echo site_url('sejarah/sejarah/show_sejarah_sekolah');?>?kode_jenjang="+unit
    })
   
    function fetch_data_sejarah(kode_jenjang) {       
        fetch('<?php echo site_url('sejarah/sejarah/get_data_sejarah_sekolah');?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var html = '';
            var html2 = ''; 
            var data = responseData.data 
            console.log(data)
			if (data.length>0){                                   
                html +='   <div align="center">'; 
                html +='   <img src='+data[0].photo_sejarah_sekolah_path +'?'+ new Date().getTime()+' class="img-width img-content img">'; 
                html +='   </div>';
                html +='   <br>';                       
                html +='   <div class="ck-content">'+data[0].sejarah_sekolah+'</div>';  //0   
                html +='   <br>';                
                document.getElementById("div_sejarah").innerHTML = html      
                
                html2 +=' <div style="margin-bottom: 15px;" align="middle" >'; 
                html2 +='    <div class="card shadow" style="width:100%; border-radius: 25px">';
                html2 +='        <div class="card-body" style="background-color:rgba(166, 211, 241, 0.67); border-radius: 25px">';
                html2 +='            <div class="row" align="center">';
                html2 +='               <div class="col-md-5"><img src="<?php echo base_url() ?>images/images_ui/graduation.png" style="width: 80pt;"></div>'; 
                html2 +='               <div class="col-md-5 d-flex flex-column justify-content-center" >';
                html2 +='                   <h3 class="card-text" style="margin-bottom:3px; color:rgba(4, 67, 109, 0.67);"><b>Meluluskan Angkatan Ke : </b></h3>';               
                html2 +='                   <h1 class="card-text" style="margin-bottom:3px; color:rgba(4, 67, 109, 0.67);"><b>'+data[0].meluluskan_angkatan_ke+'</b></h1>';               
                html2 +='               </div>';
                html2 +='            </div>';
                html2 +='        </div>';
                html2 +='    </div>';  
                html2 +=' </div>'; 
                document.getElementById("div_meluluskan_angkatan_ke").innerHTML = html2
            }else{
                document.getElementById("div_sejarah").innerHTML = ""   
                document.getElementById("div_meluluskan_angkatan_ke").innerHTML = ""             
            }
		});   
    }

    function fetch_data_visi_misi(kode_jenjang) {       
        fetch('<?php echo site_url('visimisi/visi_misi/get_data_visimisi_unit_sekolah') ?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
			return response.json();    
		}).then(function (responseData) {                 
            var html = '';        
            var data = responseData.data[0]
            console.log(data)
			if (data.length>0 && (data[0].misi != '' || data[0].visi != '')){  
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
          
            }
             
		});   
    }

</script>

<style>
    .header_img {
        position: relative;
        font-family: Arial;
    }
    
    .img-width {
            width: 50%;
        }

    .img-width-header {
        width: 100%;
        height: auto; 
    }

    .text-banner{
        font-size: 60px;
    }

    /* ukuran HP */
    @media (max-width:768px){
        .img-width {
            /* width:80%; */
            /*width: 350pt;*/
            width: 100%;
            height: auto;
        }

        .img-width-header {      
            width: 100%;
            height: 160px;     
            font-size: 15px;    
        }

        .text-banner{
            font-size: 40px;
        }
    }

    /* Desktop (min-width 768px biasanya ukuran tablet ke atas) */
    /* @media (min-width: 992px) {
        .img-width {
            width: 50%;
        }

        .img-width-header {
            width: 100%;
            height: auto; 
        }
    } */

    .img {
            float: left;
            margin: 5px;
        }


    .img-content {
        border-radius: 25px;
        border: 1px solid #ddd;       
        padding: 6px;
        /* width: 400pt; */
        height: auto;
        box-shadow: 2px 2px 4px rgba(23, 25, 26, 0.4);
        margin-right: 20px
    }

    .centered {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);        
    }

    .footer2 {
        /* bottom: 0; */
        width: 100%;
        padding-top: 3px;
        padding-bottom: 35px;
        /* background-color:rgb(211, 208, 208); */
        background-color:rgb(0,0,0,0.5);
        color:white;
    }
</style>