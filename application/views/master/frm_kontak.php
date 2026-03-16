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
        <br>    
        <h2 class="text-header fw-bold"> Kontak - <span id="span_nama_unit"></span></h2>
        <hr style="margin-top: 5px; margin-bottom: 5px;">
        <div style="line-height: 8px;"><br></div>
                       
        <div id="div_alamat"></div>      

        <div class="container mt-3">                
            <div id="div_hotline"></div>
        </div>      
        <br>
        <br>
        <br> 
        <br>
        <br>
    </div>

    <div class="footer2 fixed-bottom" >
      <div class="container">
        <div class="row">
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="TKIT" style="cursor: pointer;" title="TKIT Bunaya Kreatifa"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;<b>TKIT</b></span>
            </div>
            <div class="col-4">
               <span class="unit_jenjang fw-bold" data-id="SDIT" style="cursor: pointer;" title="SDIT Wirausaha Indoensia"><i class="bi bi-house-check"></i>&nbsp;&nbsp;<b>SDIT</b></span>
            </div>
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Wirausaha Indoensia"><i class="bi bi-house-up"></i>&nbsp;&nbsp;<b>SMPIT</b></span>
            </div>           
		</div>
      </div>
    </div> 
    
</body>
</html>


<script  type="text/javascript">

    async function init_form() {     
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang      
        await fetch_data_alamat_yayasan(kode_jenjang)
        await fetch_data_hotline_unit(kode_jenjang)
    }

    $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('master/kontak/show_kontak');?>?kode_jenjang="+unit
    })

    async function fetch_data_alamat_yayasan(kode_jenjang) {
       
        var result_data = await fetch("<?php echo site_url('master/kontak/get_data_alamat_unit_sekolah');?>?kode_jenjang="+kode_jenjang+"", {method:"GET", mode: "no-cors" })           
        const result = await result_data.json()
        
        let x = result.data   
        var html =''; 
        console.log(x)
        if(x.length > 0){   
            var alamat = x[0].alamat
            var google_map = x[0].google_map
            html += '<h4>Alamat Sekolah :</h4>';
            html += '<div class="card shadow" style="width: auto; min-height: 20rem">';    
            html += '    <div id="lokasi_google_map"  width="" style="margin: 30px;">'+google_map+'</div>';      
            html += '</div>';
            html += '<div class="card-footer text-center">';
            html += '   <br><div id="div_alamat">'+alamat+'</div><br>';
            html += '</div>';
            html += '<br>';

            document.getElementById("div_alamat").innerHTML = html;
        // document.getElementById("lokasi_google_map").innerHTML = google_map;   
            
          
        }
        $("iframe").width("100%");
        $("iframe").height("300px");   
    
       

    }

    async function fetch_data_hotline_unit(kode_jenjang) {
       
       var result_data = await fetch("<?php echo site_url('master/kontak/get_data_kontak_unit');?>?kode_jenjang="+kode_jenjang+"", {method:"GET", mode: "no-cors" })           
       const result = await result_data.json()
      
       let x = result.data[0]            
       var html = '';
       var path_img = "<?php echo base_url() ?>" +'./images/images_ui/wa-image.png';   
       if(x.length > 0){   
        for (let i = 0; i < x.length; i++) {
            html +='<h4>Hotline :</h4>';      
            html +='<div class="card" style="box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.5); height:4rem; cursor: pointer;" >';
            html +='    <div class="card-body d-flex align-items-center justify-content-center">';
            html +='        <span data-id='+ x[i].no_hotline +' class="hot_line"><h5><img src='+ path_img +' height ="40" width="40" >&nbsp;' + x[i].no_hotline + ' ' + x[i].nama_petugas +'</h5></span>';
            html +='    </div>';
            html +='</div> <div style="line-height: 5px;"><br></div>';            
        }
        //    var alamat = x[0].alamat
            document.getElementById("div_hotline").innerHTML = html;
       }
   }

   $(document).on('click', '.hot_line', function () {
        var no_hotline = $(this).attr('data-id')

        // 1. Menghilangkan karakter selain angka
	    let formatted = no_hotline.replace(/\D/g, '');

        // 2. Menghilankan angka 0 di depan (prefix)
        if (formatted.startsWith('0')) {
            formatted = '+62' + formatted.substr(1);
        }
       
        var telp_no = "https://wa.me/"+formatted  
        // wondow.location.href="https://wa.me/"+formatted  
        // alert(telp_no)     
        window.location.href = telp_no
   })

</script>

<style>
     .footer2 {
        /* bottom: 0; */
        width: 100%;
        padding-top: 3px;
        padding-bottom: 33px;
        background-color:rgb(0, 0, 0, 0.5);
        color:white;
    }
</style>