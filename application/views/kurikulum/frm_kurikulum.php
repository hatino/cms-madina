<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />    
</head>

<body onload="init_form()">
    
    <div class="header_img">
        <div id="img_header"></div>         
        <div class="centered" style="color: white; text-align:center; "><span style="white-space: nowrap"><h2 class="text-banner fw-bold"><b>Kurikulum <span id="span_nama_unit"></span></b><h2></span></div>              
    </div>
    
    <div class="container mb-5">
        <br>
        <div id="img_kurikulum" ></div>            
        <div id="div_penjelasan" class="ck-content"></div>

       
        <br>
        <div id="div_sistem_pembelajaran" class="ck-content" ></div>       
    </div>

    <div class="footer2 fixed-bottom" >
      <div class="container">
        <div class="row">
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="TKIT" style="cursor: pointer;" title="TKIT Madina"><i class="bi bi-house-heart"></i>&nbsp;<b>TKIT</b></span>
            </div>
            <div class="col-4">
               <span class="unit_jenjang fw-bold" data-id="SDIT" style="cursor: pointer;" title="SDIT Madina"><i class="bi bi-house-check"></i>&nbsp;<b>SDIT</b></span>
            </div>
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Madina"><i class="bi bi-house-up"></i>&nbsp;<b>SMPIT</b></span>
            </div>           
		</div>
      </div>
    </div>   

</body>
</html>

<script type="text/javascript">

    async function init_form() {
        var html ='<img class="responsive img-width-header" src="<?php echo base_url() ?>images/images_bg/bg_kurikulum.jpg'+'?'+ new Date().getTime()+' alt="Notebook" style="width:100%;">';   
        document.getElementById("img_header").innerHTML = html
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang   
        await fetch_data_kurikulum(kode_jenjang)
        <?php simpan_kunjungan(); ?>
    }

    $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('kurikulum/kurikulum/show_kurikulum');?>?kode_jenjang="+unit
    })

    function fetch_data_kurikulum(kode_jenjang) {     
        fetch('<?php echo site_url('kurikulum/kurikulum/get_data_kurikulum') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var data = responseData.data[0]        
			if (data.length>0){                              
                document.getElementById("div_penjelasan").innerHTML = data[0].penjelasan
                document.getElementById("div_sistem_pembelajaran").innerHTML = data[0].sistem_pembelajaran_nilai        
                if (data[0].img_path!=''){
                    $('#img_kurikulum').append("<img src='"+ data[0].img_path + '?'+ new Date().getTime()+"' class='img-width  img-content center img' style='margin-right: 20px;' >");
                }
            }else{
                document.getElementById("div_penjelasan").innerHTML = ""                
                document.getElementById("div_sistem_pembelajaran").innerHTML = ""
            }
             
		});   
    }

</script> 


<style>    
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
            width: 100%;
            height: auto;
        }

        .img-width-header {      
            width: 100%;
            height: 160px;     
            font-size: 15px;    
        }

        .text-banner{
            font-size: 30px;
        }
    }

    /* Desktop (min-width 768px biasanya ukuran tablet ke atas) */
    /* @media (min-width: 992px) {
        .img-width {
            width: 50%;
        }
    } */

    .img {
            float: left;
            margin: 5px;
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
 
    .txt {
        text-align: justify;
        /*font-size: 25px;*/
    }

    .column {
    float: left;    
    /* padding: 5px;     */
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
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

    .footer2 {
        /* bottom: 0; */
        width: 100%;
        padding-top: 3px;
        padding-bottom: 35px;
        background-color:rgb(0, 0, 0, 0.5);
        color:white
    }
</style>