<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
</head>
<!-- <body onload="init_form()">   -->
  <body>
         
    <!-- <br>
    <br> -->

    <!-- <div id="demo" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000"> -->
    <div id="demo" class="carousel slide">
        <!-- Carousel indicators -->
        <!-- <ol class="carousel-indicators">            
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </ol> -->
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner" id="caro_demo_inner">
           
            <div class="carousel-item active">       
                <span id="img_carousel1"></span>         
                <!-- <img src="../images/images_ui/carousel1.jpg" alt="Slide 1" class="Myimage d-block" style="width:100%"> -->
                
                <!-- <video id="videoSlide1" class="d-block w-100" autoplay loop muted playsinline style="height: 100vh; object-fit: cover;"> -->
                <!-- <video id="videoSlide1" class="d-block w-100" autoplay muted playsinline style="height: 100vh; object-fit: cover;">
                  <source src="../images/images_ui/carousel1.mp4" type="video/mp4">
                  Your browser does not support the video tag.
                </video> -->

                <div id="caption_bg_carousel1" style="display: none;">
                    <div class="carousel-caption bg-dark bg-gradient p-3 rounded" style="opacity: 0.5;"></div>
                    <!--manipulate agar text tampil di atas background-->
                    <div class="carousel-caption p-6" style="margin-top: 5px;">
                      <h1 class="text-light"><span id="caption_carousel1"></span></h1> 
                    </div>
                </div>
            </div>
            
            <div class="carousel-item">
                <span id="img_carousel2"></span>
                <!-- <img src="../images/images_ui/carousel2.jpeg?" alt="Slide 2" class="Myimage d-block w-100" style="height: 100vh; object-fit: cover;">     -->
                <div id="caption_bg_carousel2" style="display: none;">
                  <div class="carousel-caption bg-dark bg-gradient p-3 rounded" style="opacity: 0.5;"></div>  
                  <div class="carousel-caption p-6" style="margin-top: 5px;">
                    <h1 class="text-light"><span id="caption_carousel2"></span></h1>  
                  </div>                       
                </div>
            </div>
          
            <div class="carousel-item">
                <span id="img_carousel3"></span>
                <!-- <img src="../images/images_ui/carousel3.jpeg" alt="Slide 3" class="Myimage d-block w-100" style="height: 100vh; object-fit: cover;"> -->
                <div id="caption_bg_carousel3" style="display: none;">
                  <div class="carousel-caption bg-dark bg-gradient p-3 rounded " style="opacity: 0.5;" ></div>
                  <div class="carousel-caption p-6" style="margin-top: 5px;">
                      <h1 class="text-light"><span id="caption_carousel3"></span></h1> 
                  </div>
                </div>
            </div>    
           
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
    </div>    
    
    <div style="line-height: 5px;"><br></div>
      
    <div class='row'>
        <div id="running_text_1"></div>
        <div id="running_text_2"></div>
    </div>    
    
    <div style="line-height: 5px;"><br></div>
    <div class='row'>
      <div class='col-md-9 col-sm-2'>
          <div class='row'>    
            <!-- <div id="visitors"></div> -->
            <!-- <div id="open_pendaftaran"></div>              -->
            <!-- <div id="sejarah_yayasan"></div> -->
            <!-- <div id="div_sejarah_unit_sekolah"></div> -->
            <!-- <div id="brosur"></div>  -->
            <!-- <div id="kurikulum"></div> -->
            <div id="fasilitas"></div>
            <!-- <div id="daftar_pelajaran"></div> -->
            <div id="prestasi"></div>    
            
          </div>
      </div>
      
      <div id="visitors"></div>      
      <div id="open_pendaftaran"></div>  
      <div id="sejarah_yayasan"></div>    
      <div id="div_sejarah_unit_sekolah"></div>
      <div id="brosur"></div> 
      <div id="kurikulum"></div>
      <div id="daftar_pelajaran"></div>
          
      <div id="col_berita">
          <div class='row'>
            <div id="berita"></div>
          </div>
      </div>             

      <div class='row'>
        <div id="div_alamat"></div>
      </div>
      
      <div style="line-height: 5px;"><br></div>
      <div id="row_link_sosmed">
        <div class='row'>
          <div id="div_link_sosmed"></div>
        </div>     
      </div>
      
      <div class='row'></div>     
      <div id="row_lowongan">
        <div class='row'>   
          <div id="lowongan"></div>     
        </div>     
      </div>
        
    </div>
    

    <!--TESTIMONI-->             
    <span id="div_testimoni"></span>     
       
    <!-- <div class="container">        
        <div id="div_link_sosmed"></div> -->
        <!-- <div id="div_link_yt"></div>              
        <div id="div_link_ig"></div>    
        <div id="div_link_fb"></div> -->
    <!-- </div> -->
           
    <button type="button" class="transparent" onclick="topFunction()" id="myBtn" title="Pindah ke halaman atas"></button>
    
</body>

<br>
<div class="d-flex flex-column justify-align-center  bg-dark font_contact" style="padding: 30pt; border-radius: 5px;">
  <div class="row">
    <div class="col-12 col-md-4 pe-3 pb-3">
        <span class="fw-bold" style="font-family: 'Arial Narrow'; font-size: 15pt; color:white"><strong> HUBUNGI KAMI</strong></span> <br>
        <span style="color: white;">Admin : <a id="div_no_hotline"></a><br>
        <span style="color: white;">Email : <a style="color: white" href="https://mail.google.com/mail/?view=cm&fs=1&to=yayasanswi@gmail.com" target="_blank">yayasanswi@gmail.com</a><br>
    </div>
    <div class="col-12 col-md-4"></div>
    <div class="col-12 col-md-4">
        <span class="fw-bold" style="font-family: 'Arial Narrow'; font-size: 15pt; color:white"><strong> JAM OPERASIONAL SEKOLAH</strong></span> <br>                            
        <span style="color: white;">Senin-Jumat : Pukul 08.00 - 14.00 WIB</span> <br> 
        <span style="color: white;">Sabtu : Pukul 08.00 - 12.00 WIB</span>         
    </div>
  </div>

  <!-- <p>
      <span class="fw-bold" style="font-family: 'Arial Narrow'; font-size: 20pt; color:white"><strong> Hubungi Kami</strong></span> <br>
      <span style="color: white;">Untuk mendapatkan informasi yang lebih cepat, silakan menghubungi nomor admin <a id="div_no_hotline"></a><br>
      JAM OPERASIONAL SEKOLAH<br>
      Senin-Jumat : Pukul 08.00 – 14.00 WIB</span>
  </p> -->

</div>  
<br>

<!-- The Modal -->
<div id="myModal" class="modal">
<!-- The Close Button -->
<span class="close">&times;</span>
<!-- Modal Header -->
<img class="modal-header" id="head">
<!-- Modal Content (The Image) -->

<img class="modal-content" id="img01">
<!-- <div class="modal-content" id="img01"></div> -->
                   
<!-- Modal Caption (Image Text) -->
<div id="caption"></div>

</html>


<script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 

<script  type="text/javascript">
  
  const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  
  $('.Myimage').attr('src', (i, src) =>
  src + '?' + (new Date().getTime()));

  document.addEventListener('DOMContentLoaded', async function() {
    await init_form()

    const myCarouselElement = document.querySelector('#demo');
    const carouselInstance = new bootstrap.Carousel(myCarouselElement, {
        interval: false, // Mematikan timer otomatis Bootstrap
        ride: false
    });

    function playNextStep(activeSlideElement) {
        // Cek apakah di dalam slide yang aktif ada Video
        const video = activeSlideElement.querySelector('video');

        if (video) {
            // --- LOGIKA JIKA VIDEO ---
            video.currentTime = 0;
            video.play().catch(error => console.log("Autoplay dicegah browser"));
            
            // Tunggu video selesai baru pindah
            video.onended = function() {
                carouselInstance.next();
            };
        } else {
            // --- LOGIKA JIKA GAMBAR ---
            // Tunggu 5 detik lalu pindah ke slide berikutnya
            setTimeout(function() {
                // Pastikan user belum memindah slide secara manual sebelum timer habis
                carouselInstance.next();
            }, 5000); // 5000ms = 5 detik
        }
    }

    // 1. Jalankan saat pertama kali halaman dibuka
    const firstSlide = myCarouselElement.querySelector('.carousel-item.active');
    playNextStep(firstSlide);

    // 2. Jalankan setiap kali slide berpindah
    myCarouselElement.addEventListener('slid.bs.carousel', function (e) {
        // e.relatedTarget adalah elemen slide yang baru saja aktif
        playNextStep(e.relatedTarget);
    });
  });

  async function init_form() {    
      
      var path_visi = "<?php echo base_url() ?>" +'./images/images_ui/up-arrows.png';	
      $('#myBtn').append("<img src='"+ path_visi + "' width='30' height='30'>");	

      var get_data = await fetch('<?php echo site_url('master/profil/get_data_profil_yayasan') ;?>', {method:"GET", mode: "no-cors" })
      const result = await get_data.json()  
      
      if (result.data[0].length > 0){
          var no_hotline =  result.data[0][0].no_hotline        
          document.getElementById("div_no_hotline").innerHTML = no_hotline;
      }else{

      }

      await load_carousel_image()
      await fetch_carousel_text()
      await fetch_running_text()     
      await fetch_sejarah_yayasan()
      await fetch_brosur()
      await fetch_open_pendaftaran()
      // await fetch_prestasi()
      await fetch_kurikulum()
      await fetch_berita()
      await fetch_lowongan()
      await fetch_daftar_pelajaran()
      await fetch_sejarah_unit_sekolah()
      await fetch_link_sosmed()
      await fetch_alamat()
      await fetch_visitors()
      // await fetch_fasilitas()
      <?php simpan_kunjungan(); ?>

      const savedScroll = sessionStorage.getItem('last-scroll-cms-madina');      
      if (savedScroll) {
        // Berikan delay sekitar 300-500ms
        setTimeout(function() {
            window.scrollTo({
                top: parseInt(savedScroll),
                behavior: 'smooth' // Opsional: agar transisinya halus
            });
            sessionStorage.removeItem('last-scroll-cms-madina');
        }, 300); 
    }
      
  }

  setInterval(async function() {      
      await fetch_visitors()
  }, 60000);

  async function load_carousel_image() {
      //var file_carousel1 = await get_image_ext('carousel1')
      var file_carousel2 = await get_image_ext('carousel2')
      var file_carousel3 = await get_image_ext('carousel3')
                  
      var path_carousel_1 = "<?php echo base_url() ?>" +'./images/images_ui/carousel1.mp4';    
      var path_carousel_2 = "<?php echo base_url() ?>" +'./images/images_ui/'+file_carousel2;
      var path_carousel_3 = "<?php echo base_url() ?>" +'./images/images_ui/'+file_carousel3;  
   
      //$('#uploaded_img_carousel1').append("<img src='"+ path_carousel_1 +'?'+ new Date().getTime()+ "' class='img-width'>");
      //$('#uploaded_img_carousel2').append("<img src='"+ path_carousel_2 +'?'+ new Date().getTime()+ "' class='img-width'>");
      //$('#uploaded_img_carousel3').append("<img src='"+ path_carousel_3 +'?'+ new Date().getTime()+ "' class='img-width'>");
      $('#img_carousel1').append(`
        <video id="videoSlide1" class="d-block w-100" autoplay muted playsinline style="height: 100vh; object-fit: cover;">
          <source src="${path_carousel_1}?${new Date().getTime()}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      `);
     
      //$('#img_carousel1').append("<img src='"+path_carousel_1+'?'+ new Date().getTime()+"' alt='Slide 1' class='Myimage d-block' style='width:100%'>");
      $('#img_carousel2').append("<img src='"+path_carousel_2+'?'+ new Date().getTime()+"' alt='Slide 2' class='Myimage d-block' style='width:100%'>");
      $('#img_carousel3').append("<img src='"+path_carousel_3+'?'+ new Date().getTime()+"' alt='Slide 2' class='Myimage d-block' style='width:100%'>");
  }

  async function get_image_ext(file_name) {        
        var get_file_exists = await fetch('<?php echo site_url('master/profil/get_image_ext') ?>?file_name='+file_name+'',{method:"GET", mode: "no-cors" })
        var file_name_exists = await get_file_exists.text()        
        return file_name_exists
    }

  async function fetch_carousel_text() {
      $.ajax({
            type:"GET",
            url:"<?php echo site_url('master/profil/get_carousel_text') ; ?>",
            data:"",        
            success:function(resultData){            
              var data =  JSON.parse(resultData)            
              var html = '';
              var html2 = '';               
              if (data.data.length>0){
                if(data.data[0].carousel1 != ''){
                  document.getElementById("caption_bg_carousel1").style.display = "block";                  
                  $('#caption_carousel1').html(data.data[0].carousel1)
                }
                if(data.data[0].carousel2 != ''){
                  document.getElementById("caption_bg_carousel2").style.display = "block";                  
                  $('#caption_carousel2').html(data.data[0].carousel2)
                }
                if(data.data[0].carousel3 != ''){
                  document.getElementById("caption_bg_carousel3").style.display = "block";                  
                  $('#caption_carousel3').html(data.data[0].carousel3)
                }
              }

            }
      });   
  } 

  async function fetch_running_text() {    
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('master/running_text/get_data_running_text') ; ?>",
          data:"",        
          success:function(resultData){            
            var data =  JSON.parse(resultData)            
            var html = '';
            var html2 = ''; 
            if (data.data.length>0){                
                if(data.data[0].running_text_1 != ''){
                  html +='<marquee class="run_text_1" style="color:#581874ff; text-shadow: 1px 1px rgb(160, 163, 163)"><b><i>'+data.data[0].running_text_1+'</i></b></marquee>';
                  $('#running_text_1').html(html)
                }
                if(data.data[0].running_text_2 != ''){
                  html2 +='<marquee class="run_text_2 text-header" style="text-shadow: 1px 1px rgb(160, 163, 163)"><b><i>'+data.data[0].running_text_2+'</i></b></marquee>';
                  $('#running_text_2').html(html2)
                }
            }

          }
      });          
  }

  async function fetch_sejarah_yayasan() {    
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('sejarah/sejarah/get_data_sejarah_yayasan_home') ; ?>",
          data:"",        
          success:function(dataResult){            
            var dataResult =  JSON.parse(dataResult)
            var data = dataResult.data                 
            var html = '';          
            var url = "<?php echo base_url('images/images_bg/bg_sejarah_yayasan_home.jpg'); ?>";   
            if(data.length > 0){                   
              if (data[0].sejaran != '' | data[0].visi != '' | data[0].misi != ''){
                  //html +='<div style="line-height:5px"><br></div>';
                  html +='<div class="container-fluid" >';                  
                  html +='  <div class="card mb-5 card-main shadow h-100" style="border-radius: 15px;">';     
                  html +='    <div class="row align-items-center" id="btn_lihat_sejarah">';
                  html +='      <div class="col-12 col-md-6">';                                   
                  html += '         <div class="card-img" style="\
                                      height:300px;\
                                      background-image:url('+url+');\
                                      background-size:cover;\
                                      border-radius:15px;\
                                      \*border-top-left-radius:15px;*\
                                      \*border-bottom-left-radius:15px;*\
                                      background-position:left;\
                                      display:flex;\
                                      align-items:center;\
                                      justify-content:center;\
                                      text-align:center;\
                                      color:white;\
                                      font-size:50px;\
                                      font-weight:bold;">\
                                      Sejarah Yayasan\
                                    </div>';
                    
                  html +='      </div>';                  
                  
                  var sejarah = data[0].sejarah
                  var len_sejarah = sejarah.length;
                  var isi_sejarah;                 
                  if(len_sejarah > 600){
                      //isi_sejarah = sejarah.substr(0,600)+ "..."
                      isi_sejarah = truncateHTML(sejarah, 600);
                  }else{
                      isi_sejarah = sejarah
                  }       
                  
                  html +='      <div class="col-12 col-md-6 d-flex flex-column align-items-center">';
                  html +='            <h3 class="text-header" align="left" style="cursor: pointer;"><strong><u>Sejarah Yayasan</u></strong></h3>';   
                  html +='            <div class="card-text ps-3 pe-3" style="margin-bottom:3px; text-align:right"><a style="cursor: pointer;">'+isi_sejarah+'</a></div>';  
                  html +='      </div>';
                  html +='    </div>';
                  html +='  </div>';                  
                  html +='</div>';
                  html +='<br>';                     
                  //document.getElementById('sejarah_yayasan').style.backgroundColor = "rgb(214, 211, 211)"; 
                  $('#sejarah_yayasan').html(html);
              }
            }     

          }
      });          
  }

  async function fetch_berita() {    
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('berita/berita/get_data_berita_home') ; ?>",
          data:"",        
          success:function(dataResult){            
            var dataResult =  JSON.parse(dataResult)
            var data = dataResult.data       
            var html = '';          
            if(data.length > 0){         
              // html +='<hr>';
              html +='<div class="container-fluid" style="background-color: rgba(226, 223, 223, 0.3);">';
              html +='<div style="line-height:15px;"><br></div>';   
              html +='<div class="row">';
              html +='  <div class="col-6">';
              html +='    <h3 class="text-header" align="left"><strong><u>Berita</u></strong></h3>';
              html +='  </div>';
              html +='  <div class="col-6">';
              html +='    <div id="btn_lihat_berita" class="text-header" align="right"><span style="cursor: pointer;"><b>Lihat Semua <i class="bi bi-box-arrow-in-up-right"></i></b></span></div>';
              html +='  </div>';
              html +='</div>';
             
              var path_img = '';
              html += '<div class="row"  >'; 
              for (let i = 0; i < data.length; i++) {
                  var the_date = new Date(data[i].register_date)                      
                  var tgl =  ('00' + the_date.getDate()).slice(-2) + " "                       
                                +  months[the_date.getMonth()] + " "
                                + the_date.getFullYear()  
                                   
                    html +=' <div class="col-sm-3" style="margin-bottom: 15px;">'; 
                    html +='    <div class="card berita card-main shadow h-100" style="border-radius: 15px" data-id='+data[i].berita_id+'>';        
                    html +='        <div class="img-wrapper p-2">';
                    html +='        <img id="main_img_'+data[i].berita_id+'" src="'+data[i].img_path+'?'+ new Date().getTime()+'" class="my_img mx-auto d-block p-1" style="cursor: pointer; border-radius: 15px;" >'; 
                    html +='        </div>';
                    

                    html +='        <div class="card-footer"  style="background-color:white; border-bottom-left-radius: 15px; border-bottom-right-radius:15px;">';
                    html +='            <span class="card-text" style="font-size:12px; margin-bottom:3px; text-align:left; color:grey;"><i>'+tgl+'</i></span>';
                    
                    var judul_berita = data[i].judul_berita
                    var len_judul_berita = judul_berita.length;                    
                    html +='            <p class="card-text" style="margin-bottom:3px;"><h6 class="text-judul" style="text-align:left;"><a style="cursor: pointer;"><b>'+judul_berita+'</b></a></h6></p>';                      

                    var berita = data[i].deskripsi_berita
                    var len_berita = berita.length;
                    var isi_berita;
                    if(len_berita > 200){
                        //isi_berita = berita.substr(0,200)+"..."
                        //isi_berita = berita.replace(/<[^>]*>?/gm, '').substring(0,200) + "...";
                        isi_berita = truncateHTML(berita, 200);
                    }else{
                        isi_berita = berita
                    }   
                        
                    html +='            <p class="card-text" style="margin-bottom:3px; text-align:left"><a style="cursor: pointer;">'+isi_berita+'</a></p>';   

                    html +='        </div>';
                    html +='    </div>';  
                    html +=' </div>';                     
              }
              html +=' </div>';   
              html +=' <div style="line-height:50px;"><br></div>';
              html +=' </div>';                               
                            
              document.getElementById('col_berita').style.backgroundColor = "white";       
              document.getElementById('col_berita').style.borderRadius = "25px";          
              $('#berita').html(html);
            }     

          }
      });          
  }

  function truncateHTML(html, limit) {
      let div = document.createElement("div");
      div.innerHTML = html;

      let count = 0;

      function walk(node) {
          if (node.nodeType === 3) { 
              let text = node.nodeValue;

              if (count + text.length > limit) {
                  node.nodeValue = text.substring(0, limit - count) + "...";
                  return true;
              }

              count += text.length;
          }

          if (node.nodeType === 1) {
              let children = [...node.childNodes];

              for (let child of children) {
                  if (walk(child)) {
                      for (let sib of children.slice(children.indexOf(child)+1)) {
                          sib.remove();
                      }
                      return true;
                  }
              }
          }

          return false;
      }

      walk(div);

      return div.innerHTML;
  }

  function changeMainImg(e, id, src) {      
      e.stopPropagation(); //menghentikan click ke card diatasnya
      const mainImg = document.getElementById('main_img_'+id);       
      if (mainImg) {           
          mainImg.src = src;           
      }
  }
  
  async function fetch_brosur() {    
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('pendaftaran/pendaftaran/get_data_brosur_home') ; ?>",
          data:"",
          success:function(dataResult){       
              var dataResult = JSON.parse(dataResult)
              var data = dataResult.data
              var html='';             
              if(data.length > 0){                
                html +='<div class="container-fluid">';
                html +='<div style="line-height:15px;"><br></div>';   
                html +='<div class="row">';
                html +='  <div class="col-6">';
                html +='    <h3 class="text-header" align="left"><strong><u>Brosur</u></strong></h3>';
                html +='  </div>';
                html +='  <div class="col-6">';
                html +='    <div id="btn_lihat_brosur" class="text-header" align="right"><span style="cursor: pointer;"><b>Lihat Semua <i class="bi bi-box-arrow-in-up-right"></i></b></span></div>';
                html +='  </div>';
                html +='</div>';
              
                var path_img = '';
                html += '<div class="row"  >'; 
                for (let i = 0; i < data.length; i++) {
                    var the_date = new Date(data[i].register_date)                      
                    var tgl =  ('00' + the_date.getDate()).slice(-2) + " "                       
                                  +  months[the_date.getMonth()] + " "
                                  + the_date.getFullYear()  
                                    
                      html +=' <div class="col-sm-3" style="margin-bottom: 15px;">'; 
                      html +='    <div class="card item-card card-main shadow h-100" style="border-radius: 15px" data-id='+data[i].berita_id+'>';        
                      html +='        <div class="img-wrapper p-2">';
                      html +='        <img src="'+data[i].img_path+'?'+ new Date().getTime()+'" class="my_img mx-auto d-block p-1" style="cursor: pointer; border-radius: 15px;" >'; 
                      html +='        </div>';
                      html +='        <div class="card-footer"  style="background-color:white; border-bottom-left-radius: 15px; border-bottom-right-radius:15px;">';
                      html +='            <span class="card-text" style="font-size:12px; margin-bottom:3px; text-align:left; color:grey;"><i>'+tgl+'</i></span>';                     
                      html +='            <p class="card-path" style="margin-bottom:3px; display:none;">'+data[i].img_path+' </p>'; 
                      html +='            <p class="card-text-detail" style="margin-bottom:3px; text-align:left"><a style="cursor: pointer;">'+data[i].keterangan_brosur+'</a></p>';   
                      html +='        </div>';
                      html +='    </div>';  
                      html +=' </div>';                     
                }
                html +=' </div>';   
                html +=' <div style="line-height:50px;"><br></div>';
                html +=' </div>';           
                  
                $('#brosur').html(html);
              }              
          }
      });          
  }

  async function fetch_open_pendaftaran() {    
      var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_thn_ajaran_aktif_home') ; ?>', {method:"GET", mode: "no-cors" })  
      var result = await result_cek.json()          
      var data = result.data     
         
      if (data.length>0){        
        var html = '';       
        var url = "<?php echo base_url('images/images_bg/bg_pendaftaran.jpg'); ?>";                            
        //html +='<div style="line-height:5px"><br></div>';
        html +='<div class="container-fluid" >';                  
        html +='  <div class="card shake-bg shadow mb-5" style="border-radius: 15px; background-color:rgb(229, 245, 142);">';     
        html +='    <div class="row align-items-center">';
        html +='      <div class="col-12 col-md-6">';    
        html +='          <div class="card-img" style="\
                            height:300px;\
                            background-image:url('+url+');\
                            background-size:cover;\
                            border-radius:15px;\
                            \*border-top-left-radius:15px;*\
                            \*border-bottom-left-radius:15px;*\
                            background-position:left;\
                            display:flex;\
                            align-items:center;\
                            justify-content:center;\
                            text-align:center;\
                            color:rgb(68, 32, 2);\
                            font-size:50px;\
                            font-weight:bold;">\
                            Pendaftaran Siswa Baru\
                          </div>';
        html +='      </div>';                  
        html +='      <div class="col-12 col-md-6">';       
        for (let i = 0; i < data.length; i++) {                                           
          html +='      <button type="button" class="mt-2 mb-3 w-75 mx-auto btn btn_daftar btn-md btn-shadow btn-primary rounded-pill btn_daftar" data-id="'+data[i].group_cls+'" data-ta="'+data[i].thn_ajaran_cls+'" style="margin-bottom:3px; text-align:center; display:block; cursor: pointer;"><i class="bi bi-pencil-square"></i>&nbsp; Daftar '+data[i].group_cls+'</button>';            
        }
        html +='      </div>';
        html +='    </div>';
        html +='  </div>';                  
        html +='</div>';
        html +='<br>';  
        $('#open_pendaftaran').html(html);
      }              
  }
  
  async function fetch_kurikulum() {
    $.ajax({
        type:"GET",
        url:"<?php echo site_url('kurikulum/kurikulum/get_data_kurikulum_home') ; ?>",
        data:"",
        success:function(dataResult){       
            var dataResult = JSON.parse(dataResult)
            var data = dataResult.data             
            var html='';           
            if(data.length > 0){              
              var html = '';              
              var url = "<?php echo base_url('images/images_bg/bg_kurikulum.jpg'); ?>?" + new Date().getTime();                            
              html +='<div style="line-height:5px"><br></div>';
              html +='<div class="container-fluid mb-5" >';                  
              html +='  <div class="card card-main shadow h-100" style="border-radius: 15px; background-color:rgb(245, 212, 142);">';     
              html +='    <div class="row align-items-center">';             
              html +='      <div class="col-12 col-md-6">';                                   
              html += '         <div class="card-img" style="\
                                  height:300px;\
                                  background-image:linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('+url+');\
                                  background-size:cover;\
                                  border-radius:15px;\
                                  \*border-top-left-radius:15px;*\
                                  \*border-bottom-left-radius:15px;*\
                                  background-position:left;\
                                  display:flex;\
                                  align-items:center;\
                                  justify-content:center;\
                                  text-align:center;\
                                  color:white;\
                                  font-size:60px;\
                                  font-weight:bold;">\
                                  Kurikulum\
                                </div>';
              html +='      </div>';                  
              html +='      <div class="col-12 col-md-6">';       
              for (let i = 0; i < data.length; i++) {                                           
              html +='      <button type="button" class="mt-2 mb-3 w-75 mx-auto btn btn_kurikulum btn-md btn-shadow btn-dark rounded-pill btn_daftar" data-id="'+data[i].group_cls+'" data-ta="'+data[i].thn_ajaran_cls+'" style="margin-bottom:3px; text-align:center; display:block; cursor: pointer;"><i class="bi bi-journals"></i>&nbsp; Kurikulum '+data[i].group_cls+'</button>';            
              }
              html +='      </div>';
              html +='      </div>';    
              html +='    </div>';
              html +='  </div>';                  
              html +='</div>';
              html +='<br>';                     
           
              $('#kurikulum').html(html);
            }          
        }
      });         
  }

  async function fetch_lowongan() {
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('lowongan/lowongan/get_data_lowongan_home') ; ?>",
          data:"",
          success:function(dataResult){       
              var dataResult = JSON.parse(dataResult)
              var data = dataResult.data             
              var html='';             
              if(data.length > 0){
                // html +='<hr>';
                html +='<div class="container-fluid">';
                //html +='<div style="line-height:15px;"><br></div>';   
                html +='<div class="row">';
                html +='  <div class="col-6">';
                html +='    <h3 class="text-header" align="left"><strong><u>Lowongan</u></strong></h3>';
                html +='  </div>';
                html +='  <div class="col-6">';
                html +='    <div id="btn_lihat_lowongan" class="text-header" align="right"><span style="cursor: pointer;"><b>Lihat Semua <i class="bi bi-box-arrow-in-up-right"></i></b></span></div>';
                html +='  </div>';
                html +='</div>';        

                html +='<div class="row justify-content-center">';
                for (let i = 0; i < data.length; i++) {        
                    var the_date = new Date(data[i].register_date)                      
                    var tgl =  ('00' + the_date.getDate()).slice(-2) + " "                       
                                 +  months[the_date.getMonth()] + " "
                                 + the_date.getFullYear()              
                    html +=' <div class="col-sm-3" style="margin-bottom: 15px;">';    
                    html +='    <div class="card shadow h-100" style="border-radius: 15px">';                                             
                    html +='        <img src='+data[i].img_path+'?'+ new Date().getTime()+' class="card-img-top" style="cursor: pointer; border-top-right-radius: 10px; border-top-left-radius: 10px;" >'; 
                    html +='        <div class="card-body">';
                    html +='            <p class="card-path" style="margin-bottom:3px; display:none;">'+data[i].img_path+' </p>';
                    var lowongan = data[i].deskripsi_lowongan.trim()
                    var len_lowongan = lowongan.length;
                    var isi_lowongan;
                    if(len_lowongan > 100){
                        isi_lowongan = lowongan.substr(0,100)+"..."
                    }else{
                        isi_lowongan = lowongan
                    }                            
                    html +='            <p class="text-header" style="margin-bottom:3px; text-align:left;">'+isi_lowongan+'</p>';                                                                                       
                    html +='            <div class="card-text-detail" style="margin-bottom:3px; display:none;">'+lowongan+'<br><br></div>';
                    html +='            <p style="margin-bottom:3px; text-align:left; font-size:12px"><i style="color:grey;">'+tgl+'</i></p>';   
                    html +='        </div>';                    
                    html +='    </div>';                     
                    html +=' </div>';                   
                }     
                html +='</div>';    
                html +='<div style="line-height:10px"><br></div>';  
                
                // html +='</div>';              
                document.getElementById('row_lowongan').style.backgroundColor = "white"; 
                document.getElementById('row_lowongan').style.borderRadius = "25px";                    
                $('#lowongan').html(html);                
               
              }              
          }
      });          
  }
  
  async function fetch_visitors() {
    $.ajax({
      type:"GET",
      url:"<?php echo site_url('master/kontak/get_data_visitors') ; ?>",
      data:"",
      success:function(dataResult){       
          var dataResult = JSON.parse(dataResult)          
          var data = dataResult.data             
          var html='';          
          if(data.length > 0){              
            var html = '';
            html +='<div class=container-fluid>';              
            html +='<div style="line-height:5px"><br></div>';
            html +='  <div class="card mb-5 shadow-sm text-center" style="border-radius: 10px;">';      
            html +='    <div class="card-header pt-1 pb-1 justify-content-center" style="text-align:center; background-color:rgba(63, 148, 77, 0.81); color:white">';
            html +='      <h5><strong>Pengunjung</strong></h5>';
            html +='    </div>';
            html +='    <div class="card-body pt-1 pb-1">';
            html +='    <div class="row text-center justify-content-center mb-1">';
            html +='      <div class="col-sm-3 mt-1 mx-0 d-flex flex-column justify-content-center" style="text-align:center;">';            
            html +='          <div class="card card-sm">';      
            html +='              <div>Kemarin</div> <div><b>'+data[1].jml_visitor_yesterday+'</b></div>';
            html +='          </div>';
            html +='      </div>';
            html +='      <div class="col-sm-3 mt-1 mx-0 d-flex flex-column justify-content-center" style="text-align:center;">';
            html +='          <div class="card card-sm">';
            html +='              <div>Hari Ini</div><div><b>'+data[0].jml_visitor_today+'</b></div>';    
            html +='          </div>';  
            html +='      </div>';  
            html +='      <div class="col-sm-3 mt-1 mx-0 d-flex flex-column justify-content-center" style="text-align:center;">';                  
            html +='          <div class="card card-sm">';
            html +='              <div>Sedang Online</div> <div><b>'+data[3].jml_visitor_online+'</b></div>';
            html +='          </div>';  
            html +='      </div>';
            html +='      <div class="col-sm-3 mt-1 mx-0 d-flex flex-column justify-content-center" style="text-align:center;">';                  
            html +='          <div class="card card-sm">';
            html +='              <div>Total Pengunjung</div> <div><b>'+data[4].jml_visitor_total+'</b></div>';
            html +='          </div>';  
            html +='      </div>';
            html +='    </div>';
            html +='    </div>';
            
            html +='  </div>';
            html +='</div>';   
            //html +=' <div style="line-height:25px;"><br></div>';
              
            $('#visitors').html(html);
          } 
      }
    });    
  }

  async function fetch_daftar_pelajaran() {
    $.ajax({
        type:"GET",
        url:"<?php echo site_url('pelajaran/pelajaran/get_data_pelajaran_home') ; ?>",
        data:"",
        success:function(dataResult){       
            var dataResult = JSON.parse(dataResult)
            var data = dataResult.data             
            var html='';          
            if(data.length > 0){   
              var url = "<?php echo base_url('images/images_bg/bg_pelajaran.jpg'); ?>?"+new Date().getTime();                  
              html +='<div style="line-height:5px"><br></div>';
              html +='<div class="container-fluid mb-5" >';
              html +='  <div class="card card-main shadow h-100" style="border-radius: 15px; background-color:rgb(220, 244, 248);">';     
              html +='    <div class="row align-items-center">';             
              html +='      <div class="col-12 col-md-6">';                                   
              html += '         <div class="card-img" style="\
                                  height:300px;\
                                  background-image: linear-gradient(rgba(148, 224, 243, 0.3), rgba(148, 224, 243,0.3)), url('+url+');\
                                  background-size:cover;\
                                  border-radius:15px;\
                                  \*border-top-left-radius:15px;*\
                                  \*border-bottom-left-radius:15px;*\
                                  background-position:left;\
                                  display:flex;\
                                  align-items:center;\
                                  justify-content:center;\
                                  text-align:center;\
                                  color:rgb(39, 63, 168);\
                                  font-size:60px;\
                                  font-weight:bold;">\
                                  Daftar Pelajaran\
                                </div>';
              html +='      </div>';                  
              html +='      <div class="col-12 col-md-6">';       
              for (let i = 0; i < data.length; i++) {                                           
              html +='      <button type="button" class="mt-2 mb-3 w-75 mx-auto text-light btn btn_daftar_pelajaran btn-md btn-shadow btn-info rounded-pill" data-id="'+data[i].group_cls+'" data-ta="'+data[i].thn_ajaran_cls+'" style="margin-bottom:3px; text-align:center; display:block; cursor: pointer;"><i class="bi bi-journals"></i>&nbsp; Pelajaran '+data[i].group_cls+'</button>';            
              }
              html +='      </div>';
              html +='    </div>';
              html +='  </div>';                  
              html +='</div>';
              html +='<br>';               
              $('#daftar_pelajaran').html(html);
            } 
        }
      });     
  }

  async function fetch_sejarah_unit_sekolah() {
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('sejarah/sejarah/get_data_sejarah_unit_sekolah_home') ; ?>",
          data:"",
          success:function(dataResult){       
              var dataResult = JSON.parse(dataResult)
              var data = dataResult.data             
              var html='';
              if(data.length > 0){
                // html +='<br><hr>';
                html +='<div class=container-fluid style="background-color: rgba(226, 223, 223, 0.3);">';               
                html +='<h3 class="text-header pt-2" align="left"><strong><u>Sejarah</u></strong></h3>';
                html +='<div class="row row-cols-1 row-cols-md-3 g-4 mb-5" align="center" >';
                for (let i = 0; i < data.length; i++) {                          
                    html +=' <div class="col" style="margin-bottom:5px;" align="center">'; 
                    html +='    <h6 class="text-header">'+data[i].deskripsi+'</h6>';
                    html +='    <div class="card shadow btn_lihat_sejarah_unit_sekolah h-100" data-id='+data[i].group_cls+' style="border-radius: 10px;">';                   
                    html +='        <div class="img-wrapper p-2">';
                    html +='        <img src='+data[i].photo_sejarah_sekolah_path+'?'+ new Date().getTime()+' class="my_img mx-auto d-block p-1" style="cursor: pointer; border-top-right-radius: 10px; border-top-left-radius: 10px;" >'; 
                    html +='        </div>';
                    html +='        <div class="card-body pb-0">';                    
                    var sejarah_sekolah = data[i].sejarah_sekolah.trim()
                    var len_sejarah_sekolah = sejarah_sekolah.length;
                    var isi_sejarah_sekolah;
                    if(len_sejarah_sekolah > 300){
                      //isi_sejarah_sekolah = sejarah_sekolah.substr(0,200)+"..."
                      isi_sejarah_sekolah = truncateHTML(sejarah_sekolah, 300);
                    }else{
                      isi_sejarah_sekolah = sejarah_sekolah
                    }                            
                    html +='            <p class="text-header mb-0" style="text-align:left;">'+isi_sejarah_sekolah+'</p>';                                                                                       
                    html +='            <div class="card-text-detail" style="margin-bottom:1px; display:none;">'+sejarah_sekolah+'<br><br></div>';
                    // html +='            <div style="margin-bottom:3px; text-align:left; font-size:12px"><i style="color:grey;">'+tgl+'</i></div>';   
                    html +='        </div>';                    
                    html +='    </div>';                     
                    html +=' </div>';                   
                }     
                html +='</div>';    
                html +='<div style="line-height:10px"><br></div>';                                       
                html +='</div>';              
                
                $('#div_sejarah_unit_sekolah').html(html);
              }              
          }
      });          
  }

  async function fetch_link_sosmed() {      
    $.ajax({
        type:"GET",
        url:"<?php echo site_url('sosmed/sosmed/get_data_sosmed_dtl') ; ?>",
        data:"",
        success:function(dataResult){            
            var dataResult = JSON.parse(dataResult);   
            if(dataResult.status==true){
              var html = '';   
              if(dataResult.data[0].length > 0){      
                  // html +='<hr>';                 
                  html +='<div class="container-fluid pb-5" style="background-color: rgba(226, 223, 223, 0.3);">';
                  html +='<div style="line-height:15px;"><br></div>';   
                  html +='<div class="row" >';
                  html +='  <div class="col-6">';
                  html +='    <h3 class="text-header" align="left"><strong><u>Sosial Media</u></strong></h3>';
                  html +='  </div>';
                  html +='  <div class="col-6">';
                  html +='    <div id="btn_lihat_lowongan" class="text-header" align="right"><span style="cursor: pointer;"><b>Lihat Semua <i class="bi bi-box-arrow-in-up-right"></i></b></span></div>';
                  html +='  </div>';
                  html +='</div>';       

                  html +='<div class="row justify-content-center" >'; 
                  for (let i = 0; i < dataResult.data[0].length; i++) {    
                     if(dataResult.data[0][i].kode_sosmed == 'fb'){                      
                        html +='  <div class="col-6 col-sm-2 btn_lihat_fb d-flex flex-column align-items-center"  border>';       
                        html +='      <img src="../images/images_ui/icon_facebook.png" class="img-width mx-auto d-block" style="cursor: pointer;" >';            
                     }else if(dataResult.data[0][i].kode_sosmed == 'yt'){
                        html +='  <div class="col-6 col-sm-2 btn_lihat_yt d-flex flex-column align-items-center" border>';       
                        html +='      <img src="../images/images_ui/icon_youtube.png" class="img-width mx-auto d-block" style="cursor: pointer;" >';            
                     }else if(dataResult.data[0][i].kode_sosmed == 'ig') {
                        html +='  <div class="col-6 col-sm-2 btn_lihat_ig d-flex flex-column align-items-center" border>';       
                        html +='      <img src="../images/images_ui/icon_instagram.png" class="img-width mx-auto d-block" style="cursor: pointer;" >';            
                     }else if (dataResult.data[0][i].kode_sosmed == 'tt'){
                        html +='  <div class="col-6 col-sm-2 btn_lihat_tt d-flex flex-column align-items-center" border>';       
                        html +='      <img src="../images/images_ui/icon_tiktok.png" class="img-width mx-auto d-block" style="cursor: pointer;" >';            
                     }
                        html +='      <div class="deskrips text-header" style="text-align:center;"><b>'+dataResult.data[0][i].deskripsi+'</b></div>'; 
                        html +='      <div style="display:none;" class="link_sosmed">'+dataResult.data[0][i].link_video+'</div>';                       
                        html +='  </div>';
                  }                           
                  html += '</div>';   
                  html += '</div>';
                  html +=' <div style="line-height:40px;"><br></div>';
                  document.getElementById('row_link_sosmed').style.backgroundColor = "white";
                  document.getElementById('row_link_sosmed').style.borderRadius = "25px";    
                  
                  $("#div_link_sosmed").html(html); 
              }
            }
          }
    });
  }

  async function fetch_alamat() {
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('master/kontak/get_data_alamat') ; ?>",
          data:"",
          success:function(dataResult){       
              var dataResult = JSON.parse(dataResult)
              var data = dataResult.data[0]
              var html='';
              if(data.length > 0){
                var alamat = data[0].alamat
                var google_map = data[0].google_map
                
              //  html +='<hr>';
                html +='<div class="container-fluid">';
                html +='<div style="line-height:15px;"><br></div>';   
                html +='<div class="row">';
                html +='  <div class="col-6">';
                html +='    <h3 class="text-header" align="left"><strong><u>Alamat Sekolah</u></strong></h3>';
                html +='  </div>';
                html +='  <div class="col-6">';
                html +='    <div id="btn_lihat_alamat_sekolah" class="text-header" align="right"><span style="cursor: pointer;"><b>Lihat Semua <i class="bi bi-box-arrow-in-up-right"></i></b></span></div>';
                html +='  </div>';
                html +='</div>';                      
                html += '<div class="card shadow" style="width: auto; min-height: 20rem">';    
                html += '    <div id="lokasi_google_map"  width="" style="margin: 30px;">'+google_map+'</div>';      
                html += '</div>';                          
                html += '</div>';
                html += '<br>';

                document.getElementById("div_alamat").innerHTML = html;

              }         
              $("iframe").width("100%");
              $("iframe").height("300px");      
          }
      });          
  }
  
  
  // async function fetch_link_sosmed($kode_sosmed) {
  //   $.ajax({
  //         type:"GET",
  //         url:"<?php echo site_url('sosmed/sosmed/data_link_yt') ; ?>?kode_sosmed="+$kode_sosmed+"",
  //         data:"",
  //         success:function(dataResult){            
  //             var dataResult = JSON.parse(dataResult); 
  //             if(dataResult.status==true)
  //             {
  //               if(dataResult.data[0].length > 0){                  
  //                   var html = '';   
                    
  //                   if(dataResult.data[0][0].kode_sosmed == 'ig'){
  //                       html +='<br><hr>';
  //                       html +='<div class=container>';
  //                       html +='<h4 class="text-header" align="left">Instagram</h4>';
  //                   }
  //                   if(dataResult.data[0][0].kode_sosmed == 'fb'){
  //                       html +='<br><hr>';
  //                       html +='<div class=container>';
  //                       html +='<h4 class="text-header" align="left">Facebook</h4>';
  //                   }
  //                   if(dataResult.data[0][0].kode_sosmed == 'yt'){
  //                       html +='<br>';       
  //                       html +='<div class=container>';
  //                       html +='<h4 class="text-header" align="left">Youtube</h4>';               
  //                   }

  //                       html += '<div class="row">';      
  //                   for (let i = 0; i < dataResult.data[0].length; i++) {    
  //                       html +='  <div class="col-md-4">';                 
  //                       html +='      <div> '+dataResult.data[0][i].link_video+'</div>'; 
  //                       html +='  </div>';   
  //                   }             
  //                       html += '</div>';
  //                       html +='<div style="line-height:10px"><br></div>'; 
                                               
                  
  //                   if(dataResult.data[0][0].kode_sosmed == 'yt'){
  //                       html +='<button class="btn btn-sm btn-submit" id="btn_lihat_yt">Lihat Semua</button>'; 
  //                       html +='</div>';    
  //                       $("#div_link_yt").html(html);                    
  //                   }else{
  //                       if(dataResult.data[0][0].kode_sosmed == 'ig'){
  //                         html +='<button class="btn btn-sm btn-submit" id="btn_lihat_ig">Lihat Semua</button>'; 
  //                         html +='</div>';
  //                         $("#div_link_ig").html(html);
  //                       }else{
  //                           if(dataResult.data[0][0].kode_sosmed == 'fb'){
  //                             html +='<button class="btn btn-sm btn-submit" id="btn_lihat_fb">Lihat Semua</button>'; 
  //                             html +='</div>';
  //                             $("#div_link_fb").html(html);     
  //                             // $("iframe").addClass("cls_fb");                                       
  //                           }
  //                       }
  //                   }

  //                   $('.cls_yt').width(360);                  
  //                   $(".cls_yt").height(215);  
  //                   $(".cls_fb").width(360);     
  //                   $(".cls_fb").height(668);  
  //               }
  //             }              
  //         }
  //   })  
  // }

  
  $(document).on('click','.berita', function () {
    var berita_id = $(this).attr("data-id") 
    var page =  1   
    window.location.href="<?php echo site_url('berita/berita/show_berita_dtl') ; ?>?berita_id="+berita_id+"&page="+page+""   
  })

  $(document).on('click','.btn_daftar', function () {
      var jenjang = $(this).attr("data-id")
      var thn_ajaran_cls = $(this).attr("data-ta")
      window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_input_pendaftaran') ; ?>?kode_jenjang="+jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""         
  })

  $(document).on('click','.btn_kurikulum', function () {
      var jenjang = $(this).attr("data-id")     
      window.location.href="<?php echo site_url('kurikulum/kurikulum/show_kurikulum') ; ?>?kode_jenjang="+jenjang+""         
  })

  
  $(document).on('click','.btn_daftar_pelajaran', function () {
      var jenjang = $(this).attr("data-id")     
      window.location.href="<?php echo site_url('pelajaran/pelajaran/show_pelajaran') ; ?>?kode_jenjang="+jenjang+""         
  })

  $(document).on('click', '#btn_lihat_sejarah', function () {   
    window.location.href="<?php echo site_url('sejarah/sejarah/show_sejarah');?>";
  })
  
  $(document).on('click', '#btn_lihat_brosur', function () { 
    window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_brosur_pendaftaran');?>?kode_jenjang=TKIT";
  })

  $(document).on('click', '#btn_lihat_prestasi', function () { 
    window.location.href="<?php echo site_url('prestasi/prestasi/show_prestasi');?>?kode_jenjang=TKIT";
  })
  
  $(document).on('click', '#btn_lihat_lowongan', function () { 
    sessionStorage.setItem('last-scroll-cms-madina', window.scrollY);
    window.location.href="<?php echo site_url('lowongan/lowongan/show_lowongan');?>?kode_jenjang=TKIT";
  })
  
  $(document).on('click', '#btn_lihat_berita', function () { 
    window.location.href="<?php echo site_url('berita/berita/show_berita');?>?page=1";
  })
  
  $(document).on('click', '.btn_lihat_sejarah_unit_sekolah', function () { 
    var kode_jenjang = $(this).attr('data-id')
    window.location.href="<?php echo site_url('sejarah/sejarah/show_sejarah_sekolah');?>?kode_jenjang="+kode_jenjang+"";
  })
  
  $(document).on('click', '#btn_lihat_alamat_sekolah', function () { 
    var kode_jenjang = 'TKIT'
    window.location.href="<?php echo site_url('master/kontak/show_kontak');?>?kode_jenjang="+kode_jenjang+"";
  })

  $(document).on('click', '#btn_lihat_fasilitas', function () { 
    window.location.href="<?php echo site_url('fasilitas/fasilitas/show_fasilitas');?>?kode_jenjang=SDIT";
  })

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

  $(document).on('click', '#btn_info_ra', function() {
      var kode_jenjang = 'RA'
      var nama_jenjang='Raudhatul Athfal'
      //window.location.href="/show_info_pendaftaran?kode_jenjang="+kode_jenjang+"&nama_jenjang="+nama_jenjang+""
      window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_info_pendaftaran');?>?kode_jenjang="+kode_jenjang+"&nama_jenjang="+nama_jenjang;
  })

  $(document).on('click', '#btn_info_mi', function() {
      var kode_jenjang = 'MI'
      var nama_jenjang='Madrasah Ibtidaiyah'
      window.location.href="/show_info_pendaftaran?kode_jenjang="+kode_jenjang+"&nama_jenjang="+nama_jenjang+""
  })

  $(document).on('click', '#btn_info_smpit', function() {
      var kode_jenjang = 'SMPIT'
      var nama_jenjang='SMPIT'
      window.location.href="/show_info_pendaftaran?kode_jenjang="+kode_jenjang+"&nama_jenjang="+nama_jenjang+""
  })

  $(document).on('click', '#go_to_ppdb', function() {
      //var ppdb = document.getElementById("my-ppdb").offsetTop; 
      //window.scrollTo(0, ppdb);     
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
          modalImg.src = path;
          
          // $("#img01").append("<img id='img_dtl' src="+path+'?'+ new Date().getTime()+" style='margin: auto; display: block; width: 80%; max-width: 900px;'>") 
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


 
  // Get the button
  let mybutton = document.getElementById("myBtn");

  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          mybutton.style.display = "block";
      } else {
          mybutton.style.display = "none";
      }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
  }

</script>


<style>

  /* .carousel,
  .carousel-inner {
    height: 90.5vh;   
  } */

  .carousel-caption {    
    top: 50% !important;
    height: 100px;
    transform: translateY(-50%);    
  }

  .carousel img {
    position: relative;
    top: 0;
    left: 0;   
    min-width: 50vw;
    height: 91vh;    
    max-width: none;   
    object-fit:cover;
    object-position:center;
  }

  #demo_2,
  .carousel-tes-indicators {
    position: relative;
    top:50%
    left: 150%;
    z-index: 15;

    text-align: center;
    list-style: none;
  }
  
  
  .carousel-tes-inner {
     display: block;
     max-width: 100%;
     height: 25vh !important;
     position: middle;
     overflow: hidden;
  }

  /* .carousel-tes-inner {
    height: 25vh;
    position: middle;    
  } */
  
  .carousel-tes-caption {    
    top: 10% !important;
    transform: translateY(-10%);   
   
  }

  
  .p1 {
    font-family: "Helvetica", "sans-serif";
  }

  p > span {
    display: inline-block;
    margin-bottom: 0px;
    /*background-color: orange;*/
  }

    #myBtn {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        /*background-color: red;*/
        color: darkblue;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
    }

    #myBtn:hover {
        background-color: #e5e7e7;
    }

    .transparent{
        background-color: transparent;
    }

    /***** START RUNNING TEXT *****/
    .run_text_1{
        /* top: 580px; */
        /*position: absolute;        */
        font-size: xx-large;
        font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }

    .run_text_2{
        /* top: 550px;
        position: absolute;        */
        font-size: xx-large;
        font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }

    .marquee-container {
      /* overflow: hidden;
      width: 100%; */
      /* background: #222;
      color: #fff;
      padding: 10px 0; */
    }

    .marquee {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .line {
      white-space: nowrap;
      display: inline-block;
      animation: marquee 30s linear infinite;
    }

    @keyframes marquee {
      from { transform: translateX(100%); }
      to   { transform: translateX(-100%); }
    }

    /***** END RUNNING TEXT *****/


    .container_pen {
      display: flex;
      align-items: center;
      justify-content: center
    }

    /* img {
      max-width: 100%;
      max-height:100%;
    } */

    .text {
      font-size: 20px;
      padding-left: 20px;
    }
    


    /**** [START] : STYLE MODAL ****/    
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

    .#img_dtl {
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

    /**** [END] : STYLE MODAL ****/

    .img-width {
        width: 80pt;
        height: 80pt;
    }

    .card-img-top {
        flex-grow: 1;
        object-fit:contain;
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }

    .shake-bg {
        animation: shake 0.1s infinite;
        animation-duration: 5s; /* getar selama 5 detik */
        animation-iteration-count: 5;
    }

    @keyframes shake {
        0% { transform: translate(0px, 0px); }
        20% { transform: translate(-2px, 2px); }
        40% { transform: translate(2px, -2px); }
        60% { transform: translate(-2px, -2px); }
        80% { transform: translate(2px, 2px); }
        100% { transform: translate(0px, 0px); }
    }

    .zoom-loop {
        animation: zoomInOut 3s infinite;
        animation-iteration-count: 3;
    }

    @keyframes zoomInOut {
        0%   { transform: scale(0.97); }
        50%  { transform: scale(1.03); } /* zoom in */
        100% { transform: scale(1); }   /* zoom out */
    }

     /* Kunci utama agar gambar tidak penyet dan tingginya seragam */
    .card-img-custom {
        height: 100px; /* Tentukan tinggi tetap yang Anda inginkan */
        object-fit: cover; /* Gambar akan terpotong rapi memenuhi area tanpa distorsi */
        width: 60%;
    }

    /* Opsional: Memastikan semua card memiliki tinggi yang sama jika teksnya berbeda panjang */
    .card-custom {
        height: 100%;
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
        transition: filter 0.3s ease, transform 0.3s ease;
    }

    .img-wrapper2 {
        height: 250px; /* Tentukan tinggi kotak gambar */
        width: auto;
        background-color: #f8f9fa; /* Warna latar jika gambar tidak memenuhi kotak */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
        transition: filter 0.3s ease, transform 0.3s ease;
    }

    .my_img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain; /* KUNCI: Seluruh gambar terlihat, tidak terpotong */
        transition: filter 0.3s ease, transform 0.3s ease;
    }

    .font_contact {
        font-family: "Roboto", Tahoma, Geneva, Verdana, sans-serif;
    }


    /* Opsional: Gambar sedikit membesar saat hover */
    .img-wrapper:hover .my_img {
        transform: scale(1.05);
    }    

    .img-wrapper2:hover .my_img {
        transform: scale(1.05);
    }    

</style>

