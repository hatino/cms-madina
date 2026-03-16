<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
</head>
<body onload="init_form()">

    <div class="header_img">
        <!-- <img class="responsive img-banner-kecil" src="<?php echo base_url() ?>images/images_bg/header_bg_sosmed.jpg?'+ new Date().getTime()+'" alt="Sosmed" style="width:100%;">              
        <div class="overlay-dark"></div> -->
        <div id="img_header"></div>    
        <div class="overlay-dark"></div>     
        <div class="centered" style="color: rgb(94, 9, 143); text-align:center; "><h2 class="text-banner fw-bold"><b>Media Sosial <span id="span_nama_unit"></span></b><h2></div>      
       
    </div>
    <br>
    <div class="container mt-5">        
                
        <div class="container">        
           
            <!-- TAB-->
            <!-- <ul class="nav nav-pills" id="myTab" >
                <li class="nav-item">
                    <a href="#yt" class="nav-link active" data-bs-toggle="tab" style="text-color:black;"><i class="bi bi-youtube"></i>&nbsp;Youtube</a>
                </li>
                <li class="nav-item">
                    <a href="#ig" class="nav-link" data-bs-toggle="tab" style="text-color:black;"><i class="bi bi-instagram"></i>&nbsp;Instagram</a>
                </li>       
                <li class="nav-item">
                    <a href="#fb" class="nav-link" data-bs-toggle="tab" style="text-color:black;"><i class="bi bi-facebook"></i></i>&nbsp;Facebook</a>
                </li>       
            </ul>

            <div class="tab-content">
			    <div id="yt" class="tab-pane show active">	
                    <div id="div_link_yt"></div>   
                </div>
                <div id="ig" class="tab-pane fade tab-sm">
                    <div id="div_link_ig"></div> 
                </div>
                <div id="fb" class="tab-pane fade tab-sm">
                    <div id="div_link_fb"></div> 
                </div>
            </div>	 -->

            <div class='row'>
                <div id="div_link_sosmed"></div>
            </div>

        </div>
        <br>
        <br>

    </div>
</body>
</html>

<script type="text/javascript">
    const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"];
   
    async function init_form() {        
        fetch_data_sosmed() 
        var html ='<img class="responsive img-width-header" src="<?php echo base_url() ?>images/images_bg/header_bg_sosmed.jpg'+'?'+ new Date().getTime()+' alt="Notebook">';   
        document.getElementById("img_header").innerHTML = html
        
    }

    $(document).on('click', '.btn_lihat_yt', function () {   
        const target = event.target.closest('.btn_lihat_yt'); 
        const link = target.querySelector('.link_sosmed')
        const link_sosmed = link.innerHTML    
        window.open(link_sosmed, '_blank')
        //window.location.href="<?php echo site_url('sosmed/sosmed/show_sosmed');?>?kode_sosmed=yt";
    })

    $(document).on('click', '.btn_lihat_ig', function () {   
        const target = event.target.closest('.btn_lihat_ig');    
        const link = target.querySelector('.link_sosmed')
        const link_sosmed = link.innerHTML        
        window.open(link_sosmed, '_blank')
        //window.location.href="<?php echo site_url('sosmed/sosmed/show_sosmed');?>?kode_sosmed=ig";
    })

    $(document).on('click', '.btn_lihat_fb', function (event) {   
        const target = event.target.closest('.btn_lihat_fb'); 
        const link = target.querySelector('.link_sosmed')
        const link_sosmed = link.innerHTML        
        window.open(link_sosmed, '_blank') 
        //window.location.href="<?php echo site_url('sosmed/sosmed/show_sosmed');?>?kode_sosmed=fb";
    })

    $(document).on('click', '.btn_lihat_tt', function () {    
        const target = event.target.closest('.btn_lihat_tt'); 
        const link = target.querySelector('.link_sosmed')
        const link_sosmed = link.innerHTML    
        window.open(link_sosmed, '_blank')
        //window.location.href="<?php echo site_url('sosmed/sosmed/show_sosmed');?>?kode_sosmed=ig";
    })

    $(document).on('click', '.btn', function () {       
        fetch_data_sosmed()       
    })

    async function fetch_data_sosmed() { 
        var html2 = '';                              
        await fetch('<?php echo site_url('sosmed/sosmed/get_data_sosmed_dtl') ;?>?')
        .then(function(response){                   
             return response.json();    
        }).then( function (dataResult){      
            console.log(dataResult)                  
            if(dataResult.status==true){                     
                if (dataResult.data[0].length > 0){   
                    // var kode_sosmed = '';                 
                    // for (let i = 0; i < data.length; i++) {    
                    //     if(kode_sosmed != data[i].kode_sosmed){ 
                    //         var html = '';
                    //         html += '<br>'                      
                    //         html += '<div class="row">';    
                    //     }                 
                    //     html +='  <div class="col-md-4">';                 
                    //     html +='      <div> '+data[i].link_video+'</div>'; 
                    //     html +='  </div>';
                    //     // alert(kode_sosmed)
                    //     // alert(data[i].kode_sosmed)
                    //     // if(kode_sosmed != data[i].kode_sosmed){
                    //         kode_sosmed = data[i].kode_sosmed
                    //         if(kode_sosmed == 'yt'){
                    //             $("#div_link_yt").html(html);
                    //         }
                    //         if(kode_sosmed == 'ig'){
                    //             $("#div_link_ig").html(html);
                    //         }
                    //         if(kode_sosmed == 'fb'){
                    //             $("#div_link_fb").html(html);
                    //         }                        
                    //     // }                   
                    
                    // }             
                    // html += '</div>';
                    // html +='<div style="line-height:10px"><br></div>';   

                    // $('.cls_yt').width(360);                  
                    // $(".cls_yt").height(215);  
                    // $(".cls_fb").width(360);     
                    // $(".cls_fb").height(668);             
                    
                    // var kode_sosmed = '<?php echo $kode_sosmed ;?>'              
                    // $('a[href="#'+kode_sosmed+'"]').tab('show')

                    var html = '';
                    html +='<div class=container align="center">';
                    html +='<div class="row justify-content-md-center" >'; 
                    for (let i = 0; i < dataResult.data[0].length; i++) {    
                        if(dataResult.data[0][i].kode_sosmed == 'fb'){                      
                            html +='  <div class="col-6 col-sm-2 btn_lihat_fb" align="center" border>';       
                            html +='      <img src="<?php echo base_url() ?>images/images_ui/icon_facebook.png" class="img-width" style="cursor: pointer;" >';            
                        }else if(dataResult.data[0][i].kode_sosmed == 'yt'){
                            html +='  <div class="col-6 col-sm-2 btn_lihat_yt" align="center" border>';       
                            html +='      <img src="<?php echo base_url() ?>images/images_ui/icon_youtube.png" class="img-width" style="cursor: pointer;" >';            
                        }else if(dataResult.data[0][i].kode_sosmed == 'ig') {
                            html +='  <div class="col-6 col-sm-2 btn_lihat_ig" align="center" border>';       
                            html +='      <img src="<?php echo base_url() ?>images/images_ui/icon_instagram.png" class="img-width" style="cursor: pointer;" >';            
                        }else if (dataResult.data[0][i].kode_sosmed == 'tt'){
                            html +='  <div class="col-6 col-sm-2 btn_lihat_tt" align="center" border>';       
                            html +='      <img src="<?php echo base_url() ?>images/images_ui/icon_tiktok.png" class="img-width" style="cursor: pointer;" >';            
                        }
                            html +='      <div class="deskrips text-header" style="text-align:center;"><b>'+dataResult.data[0][i].deskripsi+'</b></div>'; 
                            html +='      <div style="display:none;" class="link_sosmed">'+dataResult.data[0][i].link_video+'</div>';                       
                            html +='  </div>';
                    }                           
                    html += '</div>';   
                    html += '</div>';
                    $("#div_link_sosmed").html(html); 
                
                } 
            }
        });   
     }

</script>


<style>
    .img-width {
        width: 100%;       
    }

    .overlay-dark{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(185, 218, 248, 0.3); /* hitam transparan */
        z-index:1;
    }

    .img-width-header {
        width: 100%;
        height: 50vh; 
        object-fit:cover;
    }

    .text-banner{
        font-size: 60px;
        z-index:2; /* lebih tinggi dari overlay */        
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
            z-index:2; /* lebih tinggi dari overlay */
        }
    }

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        background-color : #257592fb;       
        color: white;
    }

    .nav-pills .nav-link.active a:hover {
        background-color : #257592fb;
        color: white;
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
        z-index: 2; /* lebih tinggi dari overlay */
    }

    .img-banner-kecil {
        width: 100%;       /* Lebar penuh mengikuti layar/container */
        /*height: 400px;*/     /* Tinggi kita buat lebih pendek/kecil */
        height: 50vh;
        object-fit: cover; /* KUNCI: Gambar dipotong (crop) otomatis, tidak penyek */        
        object-position: center; /* Memastikan bagian tengah gambar yang terlihat */
    }

    

</style>