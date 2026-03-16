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
    <div class="header_img">
        <img class="responsive" src="<?php echo base_url() ?>images/images_bg/header_bg_prestasi.jpg" alt="Notebook" style="width:100%;">      
        <div class="centered" style="color: white; text-align:center; "><p><span style="font-size: 30px; white-space: nowrap"><h2><b>Prestasi <span id="span_nama_unit"></span></b><h2></span></p></div>      
    </div>
    <br>
    <div class="container">
      
        <div id="div_button_tahun" align="center"></div>
        
        <div id="div_prestasi" align="center"></div>

        <br>
        <br>

        <div class="footer2 fixed-bottom" >
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <span class="unit_jenjang" data-id="TKIT" style="cursor: pointer;" title="TKIT Bunaya Kreatifa"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;<b>TKIT</b></span>
                </div>
                <div class="col-4">
                <span class="unit_jenjang" data-id="SDIT" style="cursor: pointer;" title="SDIT Wirausaha Indoensia"><i class="bi bi-house-check"></i>&nbsp;&nbsp;<b>SDIT</b></span>
                </div>
                <div class="col-4">
                    <span class="unit_jenjang" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Wirausaha Indoensia"><i class="bi bi-house-up"></i>&nbsp;&nbsp;<b>SMPIT</b></span>
                </div>           
            </div>
        </div>
        </div>   
        
        <!-- The Modal -->
        <div id="myModal" class="modal">
        <!-- The Close Button -->
        <span class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>


    </div>

</body>
</html>

<script type="text/javascript">    
    const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
    var first_year = '';

    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'         
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang  
        var curr_year = (new Date()).getFullYear()
        var tahun = curr_year      
        await fetch_data_prestasi(tahun)
        await fetch_data_prestasi(first_year)
        <?php simpan_kunjungan(); ?>
    }

    async function fetch_data_prestasi(tahun) {            
         var kode_jenjang = '<?php echo $kode_jenjang ;?>'           
         await fetch('<?php echo site_url('prestasi/prestasi/get_data_prestasi') ;?>?kode_jenjang='+kode_jenjang+'&tahun='+tahun+'').then(function(response) 
         {                   
             return response.json();    
         }).then( function (responseData) 
         {                        
            var data = responseData.data[0]   
            var data_tahun = responseData.data_tahun[0]   
            console.log(responseData)        
            if (data_tahun.length>0){
                 var html = '';                 
                 for (let i = 0; i < data_tahun.length; i++) {      
                    if (i==0){
                        first_year = data_tahun[i].tahun                        
                    }        
                    if (tahun == data_tahun[i].tahun){
                        html +=' <button type="button" class="btn btn-aktif btn-sm " data-id='+data_tahun[i].tahun+'>'+data_tahun[i].tahun; 
                    }else{
                        html +=' <button type="button" class="btn btn-submit btn-sm" data-id='+data_tahun[i].tahun+'>'+data_tahun[i].tahun; 
                    }
                    html +=' </button>'; 
                 }	
                 html +='<hr style="margin-top: 5px;">'; 
                document.getElementById("div_button_tahun").innerHTML = html   
            }
                
            if (data.length>0){       
                var html = '';   
                var path_img = '';
                html += '<div class="row" >'; 
                for (let i = 0; i < data.length; i++) {
                    var the_date = new Date(data[i].tgl_prestasi)                      
                    var tgl =  ('00' + the_date.getDate()).slice(-2) + "-"                       
                                +  months[the_date.getMonth()] + "-"
                                + the_date.getFullYear()  
                 
                    html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                    html +='    <div class="card mr-3 shadow" style="width: 17rem; border-radius: 15px" data-id='+data[i].prestasi_id+'>';        
                    html +='        <img src="'+data[i].img_path+'?'+ new Date().getTime()+'" class="my_img" style="cursor: pointer; border-top-right-radius: 15px; border-top-left-radius: 15px;" >';                    
                    html +='        <div class="card-footer">';
                    html +='            <h5 class="text-header" style="margin-bottom:3px;"><b>'+data[i].nama_siswa+'</b></h5>'; 
                    html +='            <p style="margin-bottom:3px;">Juara '+data[i].peringkat+'</p>'; 
                    html +='            <p style="margin-bottom:3px;">'+data[i].jenis_prestasi+'</p>';    
                    html +='            <p style="margin-bottom:3px;">'+data[i].tingkat_lomba+'</p>';    
                    html +='            <p style="margin-bottom:3px;"><i style="color:grey; font-size:12px;">'+tgl+'</i></p>';                    
                    html +='    </div>';
                    html +='    </div>';  
                    html +=' </div>'; 
                    
                }
                html +=' </div>'; 
                html +=' <br>'; 
                html +=' <br>'; 
                document.getElementById("div_prestasi").innerHTML = html                
            }	                                         
              
         });   
     }

     $(document).on('click', '.card', function () {
        var id = $(this).attr("data-id")       
     })

     $(document).on('click', '.btn', function () {
        var tahun = $(this).attr("data-id")
        fetch_data_prestasi(tahun)       
     })

     $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('prestasi/prestasi/show_prestasi');?>?kode_jenjang="+unit
    })

    //****** CREATE MODAL *******/ 
    var modal = document.getElementById("myModal");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementsByClassName("my_img");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    $(document).on('click','.my_img', function () {       
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    })

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>

<style>
    .btn-aktif {
        background-color : #257592fb;       
        color: white;
    }

    .btn-aktif:hover {
        background-color : #257592fb;
        color: white;
    }



    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 900px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
    }

    @keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
    position: absolute;
    top: 45px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    }

    .close:hover,
    .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
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
        padding-top: 9px;
        padding-bottom: 38px;
        background-color:rgb(211, 208, 208);
    }

</style>