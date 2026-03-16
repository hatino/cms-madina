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
 
    <div class="header_img">
        <img class="responsive img-banner-kecil" src="<?php echo base_url() ?>images/images_bg/header_bg_lowongan.jpg?'+ new Date().getTime()+'" alt="Notebook" style="width:100%;">      
        <div class="centered" style="color: white; text-align:center; "><p><span style="font-size: 30px; white-space: nowrap"><h2  class="display-3 fw-bold">Lowongan<h2></span></p></div>      
    </div>
 
    <div class="container mt-5">                          
        <div id="div_lowongan" align="center"></div>      
        <br>
        <br>       
    </div> 

    <!-- The Modal -->
    <div id="myModal" class="modal">
    <!-- The Close Button -->
    <span class="close">&times;</span>
    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">
    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
       
</body>
</html>

<script type="text/javascript">   
    async function init_form() { 
        await fetch_data_lowongan()
    }

    async function fetch_data_lowongan() {       
        await fetch('<?php echo site_url('lowongan/lowongan/get_data_lowongan') ;?>')
        .then(function(response){
            return response.json();    
        }).then( function (responseData){                        
             var data = responseData.data           
             console.log(responseData)   
            if (data.length>0){       
                var html = '';   
                var path_img = '';
                html += '<div class="row" >'; 
                for (let i = 0; i < data.length; i++) {  
                    html +=' <div class="col-md-4" style="margin-bottom: 15px;">'; 
                    html +='    <div class="card mr-3 shadow" style="width: 20rem; border-radius: 15px" data-id='+data[i].berita_id+'>';        
                    html +='        <img src="'+data[i].img_path+'?'+ new Date().getTime()+'" class="my_img" style="cursor: pointer; border-top-right-radius: 15px; border-top-left-radius: 15px;" >'; 
                    html +='        <div class="card-body">';                   
                                                        
                    var lowongan = data[i].deskripsi_lowongan
                    var len_lowongan = lowongan.length;
                    var isi_lowongan;
                    if(len_lowongan > 200){
                        isi_lowongan = lowongan.substr(0,200)+"..."
                    }else{
                        isi_lowongan = lowongan
                    }       

                    html +='            <span class="card-text" style="margin-bottom:3px;">'+isi_lowongan+'<br><br></span>';
                    html +='            <div class="card-text-detail" style="margin-bottom:3px; display:none;">'+lowongan+'<br><br></div>';
                    html +='            <p class="card-path" style="margin-bottom:3px; display:none;">'+data[i].img_path+'</p>';                      
                    
                    html +='        </div>';
                    html +='    </div>';  
                    html +=' </div>';                     
                }
                html +=' </div>'; 
                document.getElementById("div_lowongan").innerHTML = html
            } 
         });   
     }


     //****** [START] CREATE MODAL *******/ 
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementsByClassName("my_img");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    document.addEventListener('click', async event => {        
        const target = event.target.closest('.card');        
        if (target !== null) {                      
            var { title, path } = await onCardClick(target);           
            modal.style.display = "block";
            modalImg.src = path//this.src;
            captionText.innerHTML = title//this.alt;           
        }
    });

    const onCardClick = async card => {
        const { title, path } = await getCardInfo(card); 
        return { title, path }
    };

    const getCardInfo = card => {
        //const title = card.querySelector('.card-text');
        const title = card.querySelector('.card-text-detail');
        const path = card.querySelector('.card-path');        
        return {
            title: title.innerHTML,
            path: path.textContent
        }
    }
    //****** [END] CREATE MODAL *******/

</script>

<style>
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
        background-color: rgb(255, 255, 255); /* Fallback color */
        /*background-color: rgba(0,0,0,0.9);  Black w/ opacity */                
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
        /* max-width: 700px; */
        text-align: center;
        color: black;
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
        top: 55px;
        right: 35px;
        /* color: #f1f1f1; */
        color: #bbb;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #ff0000;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }}

    .img-banner-kecil {
        width: 100%;       /* Lebar penuh mengikuti layar/container */
        height: 400px;     /* Tinggi kita buat lebih pendek/kecil */
        object-fit: cover; /* KUNCI: Gambar dipotong (crop) otomatis, tidak penyek */        
        object-position: center; /* Memastikan bagian tengah gambar yang terlihat */
    }

</style>