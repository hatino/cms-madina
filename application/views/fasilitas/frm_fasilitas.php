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
    <div class="container mt-5">            
        <h3 class="text-header">FASILITAS <span id="div_nama_unit"></sapn></h3> 
        <hr style="margin-top: 5px; margin-bottom: 5px;">

        <div id="div_fasilitas" align="center"></div>
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

</body>
</html>

<script type="text/javascript">
       
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
                }else{
                    nama_jenjang = ' - ' + kode_jenjang
                }
            }
        }
        document.getElementById("div_nama_unit").innerHTML = nama_jenjang  
        
        await fetch_data_fasilitas()
        //  await pagination()
    }


    function fetch_data_fasilitas(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('fasilitas/fasilitas/get_data_fasilitas') ;?>?kode_jenjang='+kode_jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){       
            var data = responseData.data[0]   
            console.log(responseData)        
			if (data.length>0){      
 
                var html = '';   
                var path_img = '';
                html += '<div class="row" >'; 
                for (let i = 0; i < data.length; i++) {
                    path_img = data[i].img_path
                  
                    html +=' <div class="col-md-3" style="margin-bottom: 15px;" align="center">'; 
                    html +='    <div class="card mr-3 shadow" style="width: 17rem;">';        
                    if(path_img!=''){                      
                      path_img = '<?php echo base_url() ;?>'+path_img
                      html +='        <img src="'+path_img+'" class="my_img" style="cursor: pointer;">'; 
                    }                    
                    html +='        <div class="card-body">';
                    html +='            <p class="card-text" style="margin-bottom:3px;">'+data[i].keterangan+'</p>';                   
                    html +='    </div>';
                    html +='    </div>';  
                    html +=' </div>'; 
                    
                }
                html +=' </div>'; 
                document.getElementById("div_fasilitas").innerHTML = html                
            }	
                         
        });            
    }


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

    // img.onclick = function(){
    //     alert('test')
    //     modal.style.display = "block";
    //     modalImg.src = this.src;
    //     captionText.innerHTML = this.alt;
    // }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('fasilitas/fasilitas/show_fasilitas');?>?kode_jenjang="+unit
    })
</script>


<style>
div.gallery {
  border: 1px solid #ccc;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

* {
  box-sizing: border-box;
}

.responsive {
  padding: 0 6px;
  float: left;
  width: 24.99999%;
}

@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}

@media only screen and (max-width: 500px) {
  .responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}


/* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

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
      padding-top: 9px;
      padding-bottom: 38px;
      background-color:rgb(211, 208, 208);
  }
</style>