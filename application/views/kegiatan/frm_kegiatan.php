<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>      
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">            
        <h3 class="text-header">KEGIATAN <span id="div_nama_unit"></sapn></h3> 
        <hr style="margin-top: 5px; margin-bottom: 5px;">

        <!-- <div class="row">
            <div class="col-md-9 ">
              
                <h5 id="div_thn_ajaran_nama" class="text-header"></h5>
               
                <div id="div_info_pendaftaran" class="ck-content"></div>
            </div>
           
        </div> -->   
        <div id="div_kegiatan" align="center"></div>
        <div id="div_pagination" align="center"></div>
      
       
    </div> 
    
</body>
</html>

<script type="text/javascript">
    const limit = 2
    const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
    
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
                }
            }
        }
        document.getElementById("div_nama_unit").innerHTML = nama_jenjang  

        var page = 1
        await fetch_data_kegiatan(page)
        <?php simpan_kunjungan(); ?>
        //  await pagination()
    }

    function fetch_data_kegiatan(page) {   
         
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'           
        fetch('<?php echo site_url('kegiatan/kegiatan/get_data_kegiatan') ;?>?kode_jenjang='+kode_jenjang+'&page='+page+'&limit='+limit+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var data = responseData.data[0]   
            console.log(responseData)        
			if (data.length>0){      
 
                var html = '';   
                var path_img = '';
                var tgl, tgl_kegiatan;

                html +='<ul class="content">';   
                for (let i = 0; i < data.length; i++) {
                    path_img = data[i].img_path;       
                    tgl = new Date(data[i].tgl_kegiatan)                   
                    tgl_kegiatan = tgl.getDay() + ' ' + months[tgl.getMonth()] +' ' + tgl.getFullYear() 
                   
                    html +=' <li>';                    
                    html +='   <img src='+path_img+' class="img-width img-content">'; 
                    html +='   <br>'; 
                    html +='   <br>'; 
                    html +='   <h6 style="color:grey;"><i>'+tgl_kegiatan+'</i></h6>';  //0  
                    html +='   <p>'+data[i].deskripsi+'</p>';  //0   
                    html +='   <br>'; 
                    html +=' </li>';  
                }	
                html +='</ul>';  

                document.getElementById("div_kegiatan").innerHTML = html   
                
                 const total_page = responseData.total_page
                html = '';
                if (total_page >1){
                    html +='<ul class="pagination justify-content-center">';  
                    for (let ir = 1; ir <= total_page; ir++) {      
                        if(page==ir){
                            html +=' <li class="page-item" id='+ir+'><a class="page-link" href="#" style="background-color:#006DCC; color:white;">'+ir+'</a></li>';    
                        }else{
                            html +=' <li class="page-item" id='+ir+'><a class="page-link" href="#" >'+ir+'</a></li>';    
                        }                           
                        
                    }	
                    html +='</ul>';  
                    html +='   <br>';
                    html +='   <br>';
                }
                document.getElementById("div_pagination").innerHTML = html   
                   
             }

            // pagination()
             
		});   
    }

    $(document).on('click', '.page-item', function () {
        var page = $(this).attr('id');
        //alert(page)
        fetch_data_kegiatan(page)        
    })

</script>

<style>
body {
  font-family: Arial, sans-serif;
}


.content {
  display: grid;
  gap: 20px;
  margin: 0;
  list-style: none;
  padding: 20px;
}
    
/* .img-width {
    width: 650pt;
    height: 185ptt;
} */


.img-content {
  border-radius: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 650pt;
  height: 185ptt;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
}

/* img {
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
} */

</style>