<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5-content.css"> -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
   
  
</head>
<body>
    
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">
        <h3 class="text-header">VISI DAN MISI <span id="div_nama_unit" class="text-header" ></span> </h3>  
        <hr style="margin-top: 5px;">

        <div class="row" >
            <div class="column"  >
                <div id="div_visi" class="ck-content" style="padding-left:10px; padding-right:10px; padding-bottom:1px; padding-top:5px; vertical-align: middle;"></div>
            </div>
            <div class="column">
                <div id="div_misi" class="ck-content" style="padding-left:10px; padding-right:10px; padding-bottom:1px; padding-top:5px; vertical-align: middle;"></div>
            </div>
        </div>

        <div id="img_visi_misi"></div>

    </div>

</body>
</html>


<script type="text/javascript">

    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'      
        await fetch_data_visimisi_unit_sekolah(kode_jenjang)
    }

    function fetch_data_visimisi_unit_sekolah(kode_jenjang) {     
        fetch('<?php echo site_url('master/visi_misi/get_data_visimisi_unit_sekolah') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var data = responseData.data[0]
            console.log(data)
			if (data.length>0){
                var nama_jenjang = '';
                if(kode_jenjang=='RA'){
                    nama_jenjang = ' - RA/TK'
                }else{
                    if(kode_jenjang=='MI'){
                        nama_jenjang = ' - MI/SD'
                    }else{
                        if(kode_jenjang=='SMPIT'){
                        nama_jenjang = ' - SMPIT'
                        }
                    }
                }
                document.getElementById("div_visi").innerHTML = data[0].visi
                document.getElementById("div_misi").innerHTML = data[0].misi
                document.getElementById("div_nama_unit").innerHTML = nama_jenjang          
                if (data[0].photo_visi_path!=''){
                    $('#img_visi_misi').append("<img src='"+ data[0].photo_visi_path + "' class='img-width center img' >");
                }

                if (data[0].visi!=''){
                    document.getElementById("div_visi").style.backgroundColor= '#d3d0d0'
                }
               	
            }else{
                document.getElementById("div_visi").innerHTML = ""                
                document.getElementById("div_misi").innerHTML = ""
            }
             
		});   
    }

</script> 

<style>
   
    /* Create two equal columns that floats next to each other */
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
  
    .img-width {
        width: 550pt;       
    }
  
    .img-height {
        height: 385pt;
    }

    .img {
            /* float: left;  */
            margin: 5px;
            border: 5px solid #555;           
        }
    
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        /*width: 50%;*/
    }
    

</style>