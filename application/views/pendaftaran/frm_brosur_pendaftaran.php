<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script>     
</head>
<body>
    <body onload="init_form()"></body>
   
    <div class="header_img">
        <div id="img_header"></div>  
        <!-- <img class="responsive" src="<?php echo base_url() ?>images/images_bg/header_bg_brocur.jpg" alt="Notebook" style="width:100%;">       -->
        <div class="centered" style="color: white; text-align:center; "><p><span style="font-size: 30px; white-space: nowrap"><h2 class="display-3 fw-bold"><b>Brosur <span id="nama_jenjang_div"></span></b><h2></span></p></div>      
    </div>
    <br>
    <div class="container">
        <div id="div_brosur" align="center"></div>
        <br>
        <br>
        <br>
        <br>
    </div>

    <div class="footer2 fixed-bottom" >
      <div class="container">
        <div class="row">
            <div class="col-4">
                <span class="unit_jenjang" data-id="TKIT" style="cursor: pointer;" title="TKIT Madina"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;<b>TKIT</b></span>
            </div>
            <div class="col-4">
               <span class="unit_jenjang" data-id="SDIT" style="cursor: pointer;" title="SDIT Madina"><i class="bi bi-house-check"></i>&nbsp;&nbsp;<b>SDIT</b></span>
            </div>
            <div class="col-4">
                <span class="unit_jenjang" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Madina"><i class="bi bi-house-up"></i>&nbsp;&nbsp;<b>SMPIT</b></span>
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

</body>



</html>

<script type="text/javascript">
    
    async function init_form() {
        html ='<img class="responsive" src="<?php echo base_url() ?>images/images_bg/header_bg_brocur.jpg'+'?'+ new Date().getTime()+' alt="Notebook" style="width:100%;">';   
        document.getElementById("img_header").innerHTML = html

        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        document.getElementById("nama_jenjang_div").innerHTML = kode_jenjang   
        await fetch_data_brosur()
        <?php simpan_kunjungan(); ?>
    }

    function fetch_data_brosur() {    
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'     
        fetch('<?php echo site_url('pendaftaran/pendaftaran/get_data_brosur') ;?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{          
            var html ='';                
            var data = responseData.data     
            console.log(data)      
			if (data.length>0){       
                var thn_ajaran_cls = '';
                
                for (let i = 0; i < data.length; i++) {
                    if(data[i].thn_ajaran_cls!=thn_ajaran_cls ) {
                        html += '<h4 class="text-header" style="text-align:left;" >'+data[i].thn_ajaran_nama+'</h4>';
                        html += '<hr style="margin-top:5px;">';
                        html += '<div class="row" >';
                    }
                        html +=' <div class="col-md-4" style="margin-bottom: 15px;" align="center">'; 
                        html +='    <div class="card shadow" style="border-radius: 25px;">';                   
                        html +='        <img src='+data[i].img_path+' class="img-width my_img" style="cursor: pointer; border-top-right-radius: 25px; border-top-left-radius: 25px;" >'; 
                        html +='        <div class="card-body">';
                        html +='            <p class="card-path" style="margin-bottom:3px; display:none;">'+data[i].img_path+' </p>';
                        html +='            <p class="card-text" style="margin-bottom:3px;">'+data[i].keterangan_brosur+'</p>';
                        html +='        </div>';
                        html +='    </div>';  
                        html +=' </div>'; 
                      
                    thn_ajaran_cls = data[i].thn_ajaran_cls;
                    if(data[i].thn_ajaran_cls!=thn_ajaran_cls) {
                        html +=' </div>'; 
                    }
                }
                document.getElementById("div_brosur").innerHTML = html  
            } 
            
		});   
    }

    $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_brosur_pendaftaran');?>?kode_jenjang="+unit
    })

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

    const onCardClick = card => {
        const { title, path } = getCardInfo(card); 
        return { title, path }
    };

    const getCardInfo = card => {
        const title = card.querySelector('.card-text');
        const path = card.querySelector('.card-path');        
        return {
            title: title.textContent,
            path: path.textContent
        }
    }
    //****** [END] CREATE MODAL *******/

</script>

<style>
    .responsive{
        width: 100%;
        height: 120pt;
    }   

    .img-width {
        width: 100%;
        height: auto;
    }

    /* Desktop (min-width 768px biasanya ukuran tablet ke atas) */
    @media (min-width: 992px) {
        .responsive {
            width: 50%;
            height:auto;
        }

        /* .img-width {
            width: 100%;
        } */
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

    .footer2 {
        /* bottom: 0; */
        width: 100%;
        padding-top: 3px;
        padding-bottom: 33px;
        background-color:rgb(0, 0, 0,0.5);
        color: white;
    }
</style>