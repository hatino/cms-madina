<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>      
</head>
<body onload="init_form()">
  
    
    <div class="header_img">   
        <img class="responsive img-banner-kecil" src="<?php echo base_url() ?>images/images_bg/header_bg_berita.jpg?'+ new Date().getTime()+'" alt="Notebook" style="width:100%;">      
        <div class="centered" style="color: white; text-align:left; "><h2 class="display-3 text-stroke fw-bold">Berita dan Informasi<h2></div>      
    </div>

    <div class="container mt-5">                          
        <div id="div_berita" align="center"></div>
        <div id="div_pagination" align="center"></div>     
        <br>
        <br>       
    </div> 
    
    
</body>
</html>

<script type="text/javascript">
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    async function init_form() {      
        var page = '<?php echo $page ;?>' 
        await fetch_data_berita(page)       
    }

    async function fetch_data_berita(page) {        
        var limit = 3
        await fetch('<?php echo site_url('berita/berita/get_data_berita') ;?>?&page='+page+'&limit='+limit+'')
        .then(function(response){
            return response.json();    
        }).then( function (responseData){                        
             var data = responseData.data[0]           
             console.log(responseData)   

            if (data.length>0){       
                var html = '';   
                var path_img = '';
                html += '<div class="row g-4" >'; 
                for (let i = 0; i < data.length; i++) {
                    var the_date = new Date(data[i].register_date)                      
                    var tgl =  ('00' + the_date.getDate()).slice(-2) + " "                       
                                 +  months[the_date.getMonth()] + " "
                                 + the_date.getFullYear()  
                                   
                    html +=' <div class="col-md-4 mb-4" style="margin-bottom: 15px;">'; 
                    html +='    <div class="card card-main shadow h-100" style="border-radius: 15px" data-id='+data[i].berita_id+' data-page='+page+'>';        
                    
                    // Pembungkus gambar untuk menjaga ukuran kotak tetap sama
                    html +='        <div class="img-wrapper">';
                    html +='        <img id="main_img_'+data[i].berita_id+'" src="'+data[i].img_path+'?'+ new Date().getTime()+'" class="my_img p-2" style="cursor: pointer; border-top-right-radius: 15px; border-radius: 15px;" >'; 
                    html +='        </div>';

                    //3 GAMBAR DETAIL
                    if(data[i].img_path_2 || data[i].img_path_3){                    
                        html +='    <div class="p-1">';
                        html +='        <div class="row g-2 justtify-content-center text-center">';
                        if(data[i].img_path){
                        html +='            <div class="col-4">';
                        html +='                <div class="img-detail-wrapper">'; // Pembungkus
                        html +='                <img src='+data[i].img_path+'?'+ new Date().getTime()+' class="img-fluid rounded" '+
                                                    'onclick="changeMainImg(event,'+data[i].berita_id+',this.src)" style="cursor:pointer;">';
                        html +='                </div>';
                        html +='            </div>';
                        }
                        if(data[i].img_path_2){
                        html +='            <div class="col-4">';
                        html +='                <div class="img-detail-wrapper">'; // Pembungkus
                        html +='                <img src='+data[i].img_path_2+'?'+ new Date().getTime()+' class="img-fluid rounded" '+
                                                    'onclick="changeMainImg(event,'+data[i].berita_id+',this.src)" style="cursor:pointer;">';
                        html +='                </div>';
                        html +='            </div>';
                        }
                        if(data[i].img_path_3){
                        html +='            <div class="col-4">';
                        html +='                <div class="img-detail-wrapper">'; // Pembungkus
                        html +='                <img src='+data[i].img_path_3+'?'+ new Date().getTime()+' class="img-fluid rounded" '+
                                                    'onclick="changeMainImg(event,'+data[i].berita_id+',this.src)" style="cursor:pointer;">';
                        html +='                </div>';
                        html +='            </div>';
                        }                       
                        html +='        </div>';
                        html +='    </div>';
                    }

                    html +='        <div class="card-body d-flex flex-column pt-2">';
                    html +='            <span class="card-text" style="font-size: 12px; text-align:left; color:grey;"><i>'+tgl+'</i></span>';
                    
                    var judul_berita = data[i].judul_berita
                    var len_judul_berita = judul_berita.length;                                   
                    html +='            <span class="card-text text-muted" style="margin-bottom:3px;"><h5 class="text-header" style="text-align:left;"><b><a style="cursor: pointer;">'+judul_berita+'</a></b></h5></span>';                      

                    var berita = data[i].deskripsi_berita
                    var len_berita = berita.length;
                    var isi_berita;
                    if(len_berita > 200){
                        isi_berita = berita.substr(0,200)+"..."
                    }else{
                        isi_berita = berita
                    }                    
                    html +='            <span class="card-text" style="margin-bottom:3px; text-align:left"><a style="cursor: pointer;">'+isi_berita+'</a></span>';   

                    html +='        </div>';
                    html +='    </div>';  
                    html +=' </div>';                     
                }
                html +=' </div>'; 
                document.getElementById("div_berita").innerHTML = html

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
                }
                document.getElementById("div_pagination").innerHTML = html    
            } 
         });   
    }

    function changeMainImg(e, id, src) {      
        e.stopPropagation(); //menghentikan click ke card diatasnya
        const mainImg = document.getElementById('main_img_'+id);       
        if (mainImg) {           
            mainImg.src = src;           
        }
    }

     $(document).on('click', '.card-main', function () {
        var berita_id = $(this).attr("data-id") 
        var page =  $(this).attr("data-page")       
        window.location.href="<?php echo site_url('berita/berita/show_berita_dtl') ; ?>?berita_id="+berita_id+"&page="+page+""   
    })

    $(document).on('click', '.page-item', async function () {
        var page = $(this).attr('id');       
        await fetch_data_berita(page)                
    })

</script>


<style>
    .header_img {
        position: relative;
        font-family: Arial;
    }

    .text-stroke{
        color: white;                 /* warna isi teks */
        -webkit-text-stroke: 1px black; /* ketebalan + warna stroke */
    }

    .centered {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .img-banner-kecil {
        width: 100%;       /* Lebar penuh mengikuti layar/container */
        height: 400px;     /* Tinggi kita buat lebih pendek/kecil */
        object-fit: cover; /* KUNCI: Gambar dipotong (crop) otomatis, tidak penyek */        
        object-position: center; /* Memastikan bagian tengah gambar yang terlihat */
    }

    h2 {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Mengunci area gambar agar ukurannya seragam di semua card */
    .img-wrapper {
        height: 200px; /* Tentukan tinggi kotak gambar */
        width: 100%;
        background-color: #f8f9fa; /* Warna latar jika gambar tidak memenuhi kotak */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
    }

    /* Mengunci tinggi gambar utama agar seragam di semua card */
    .my_img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain; /* KUNCI: Seluruh gambar terlihat, tidak terpotong */
    }
    
    /* Memastikan card selalu sejajar tingginya dalam satu baris */
    .card-main {
        height: 100%; /* Agar tinggi card sama dalam satu baris */
    }
    
    .img-detail-wrapper {
        height: 60px; /* Tinggi kotak gambar kecil */
        width: 100%;
        /*background-color: #f1f1f1;*/ /* Warna latar jika gambar kecil tidak penuh */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 8px;
        border: 1px solid #eee;
        padding: 3px;
    }

    .img-detail-wrapper img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain; /* Gambar mengecil tanpa terpotong */
        cursor: pointer;
    }
</style>