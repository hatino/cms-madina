<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand&effect=neon|outline|emboss|shadow-multiple">
    <link href="<?php echo base_url();?>assets/dist/css/bootstrap.min.css" rel="stylesheet">   
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-icons/font/bootstrap-icons.css">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    <link rel="icon" href="<?php echo base_url();?>images/images_ui/icon_swi.ico">

    <title>Penilaian Online</title>
</head>
<body>
     <body onload="init_form()"></body>
      <div class="container-fluid" id="bg_image" >
        <!-- <div class="word-art animated-word">Selamat Datang! <br> Di Halaman Siswa</div> -->

       <div style="padding: 100px 0px;">
           
            <h1 class="font-effect-outline judul" style="text-align: center;">Halaman Penilaian Online</h1>
            <h5 class="font-effect-outline" style="text-align: center ; color:rgb(219, 240, 125);">Silakan LOGIN sesuai status masing-masing</h5>
            <hr>
            <br>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button id="btn_admin" class="btn button-style-method1 font-effect-emboss btn-shadow-rad" style="background-color:rgb(240, 107, 211);"><img src="<?php echo base_url();?>images/images_ui/icon_admin.png" alt="" width='30' height='30'  style="cursor: pointer;">&nbsp;&nbsp;Admin</button>
                <button id="btn_guru" class="btn button-style-method1 font-effect-emboss btn-shadow-rad" style="background-color:rgb(82, 216, 240);"><img src="<?php echo base_url();?>images/images_ui/icon_teacher.png" alt="" width='30' height='30'  style="cursor: pointer;">&nbsp;&nbsp;Guru</button>
                <button id="btn_siswa" class="btn button-style-method1 font-effect-emboss btn-shadow-rad" style="background-color:rgb(198, 226, 37);"><img src="<?php echo base_url();?>images/images_ui/icon_student.png" alt="" width='30' height='30'  style="cursor: pointer;">&nbsp;&nbsp;Siswa</button>
            </div>
            <br>
            <div id="running_text_1"></div>
            <br>
            <button type="button" class="btn btn-md btn-primary btn-shadow-rad" style="margin: 10px auto; display: block;" id="btn_kembali"><i class="bi bi-back"></i>&nbsp;Halaman Utama</button>                      
        </div>       
    </div>

    
    
    <!-- The Modal -->
    <div class="modal fade" id="modal_login_ujian" role="dialog" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content rounded-5">

            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #006DCC;" >                 
                <h5 class="modal-title text-white font-effect-emboss" style="font-size: 30px;" >LOGIN</h5>                 
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">

                    <form class="form-container" method="post" >    
                        <input type="hidden" id="status_user_login" name="status_user_login">                 
                        <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" placeholder="username" class="form-control" id="username">
                        </div>          
                        <div style="line-height: 10px;"><br></div>              
                        
                        <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="password" class="form-control" id="password">
                        </div>      
                        <br>
                        
                        <button type="button" id="submit" name="submit" class="btn btn-success btn-shadow btn-sm" >Login</button>                
                        <div style="text-align: center;" id="pesan"></div>
                        
                    </form>                 
                </div>
                
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">                
                <button type="button" id="btn_kembali_modal" class="btn btn-sm btn-secondary btn-shadow btn-sm" style="left:5px"><i class="bi bi-back"></i>&nbsp;Kembali</button>
            </div>

        </div>
    </div>
    </div>
    
</body>
</html>

<script type="text/javascript">
    function init_form() {         
        const lebar = window.innerWidth;
        const tinggi = window.innerHeight;
        
        if (lebar < 768) {  // Misalnya, di bawah 768px dianggap ponsel
            // return "Ponsel: " + lebar + "px x " + tinggi + "px";           
            $('#bg_image').addClass("bg-image-style-hp")          
        } else {             
            //return "Laptop/Desktop: " + lebar + "px x " + tinggi + "px";
            $('#bg_image').addClass("bg-image-style-komp")                   
        }    
        const elemen = document.getElementById("bg_image");
        const baseUrl = "<?php echo base_url("images/images_ui/bg_halaman_ujian.jpg");?>";
    
        // Tambahkan timestamp dari JavaScript
        elemen.style.backgroundImage = `url(${baseUrl}?${new Date().getTime()})`; 

        fetch_running_text()
    }

    $(document).on('click','#btn_kembali', function () {
        //history.back()    
        //redirect("dashboard/show_dashboard_main")
        window.location.href="<?php echo site_url("dashboard") ?>"
    })

    $(document).on('click','#btn_admin', function () {      
        $('#pesan').text('')
        $('#modal_login_ujian').modal('show')
        $('#status_user_login').val('admin')
    })

    $(document).on('click','#btn_guru', function () {    
        $('#pesan').text('')  
        $('#modal_login_ujian').modal('show')
        $('#status_user_login').val('guru')
    })

    $(document).on('click','#btn_siswa', function () {  
        $('#pesan').text('')    
        $('#modal_login_ujian').modal('show')
        $('#status_user_login').val('siswa')
    })

    $(document).on('keyup', '#password', function (e) {
        if(e.keyCode==13){
            $('#submit').trigger('click')
        }
    })

    $(document).on('click', '#submit', function (){
        var username = $('#username').val()
        var form_data= $('.form-container').serialize();
        fetch("<?php echo site_url('auth/login_ujian') ;?>",{
                method: 'POST',   
                body: new URLSearchParams(form_data),
        })
        .then(response => response.json()) 
        .then(async (dataResult) => {                     
            var status_user_login = $('#status_user_login').val()   
            if(dataResult.status==true){                             
                if((dataResult.data=='0' || dataResult.data=='2') && status_user_login=='admin'){   
                    $('#pesan').css('margin-top','10px')    
                    $('#pesan').css('color', '#cc0000')
                    $('#pesan').text('User name/password halaman admin tidak ditemukan') 
                    return false
                }                
                if((dataResult.data=='1' || dataResult.data=='2') && status_user_login=='guru'){
                    $('#pesan').css('margin-top','10px')  
                    $('#pesan').css('color', '#cc0000')
                    $('#pesan').text('User name/password halaman guru tidak ditemukan') 
                    return false
                }
                if((dataResult.data=='0' || dataResult.data=='1') && status_user_login=='siswa'){
                    $('#pesan').css('margin-top','10px')  
                    $('#pesan').css('color', '#cc0000')
                    $('#pesan').text('User name/password halaman siswa tidak ditemukan') 
                    return false
                }
                window.location.href="<?php echo site_url("dashboard/show_dashboard_ujian") ?>?status_user_login="+status_user_login+" "                                       
                                    
            }else{
                if (status_user_login=='admin'){
                    $('#pesan').text('User name/password halaman admin tidak ditemukan') 
                }else if( status_user_login=='guru'){
                    $('#pesan').text('User name/password halaman guru tidak ditemukan') 
                }else if( status_user_login=='siswa'){
                    $('#pesan').text('User name/password halaman siswa tidak ditemukan') 
                }
                $('#pesan').css('margin-top','10px')  
                $('#pesan').css('color', '#cc0000')
                //$('#pesan').text(dataResult.message)    
            }
           
        })       
    })
   
    $(document).on('click','#btn_kembali_modal', function () {   
        $('#username').val('')
        $('#password').val('')
        $('#modal_login_ujian').modal('hide')
    })

    function fetch_running_text() {    
      $.ajax({
          type:"GET",
          url:"<?php echo site_url('ujian/running_text/get_data_running_text') ; ?>",
          data:"",        
          success:function(resultData){            
            var data =  JSON.parse(resultData)            
            var html = '';
            var html2 = ''; 
            if (data.data.length>0){
              if(data.data[0].running_text_1 != ''){               
                html +='<marquee class="run_text_1 text-header text-warning" style="text-shadow: 1px 1px rgb(160, 163, 163)"><b><i>'+data.data[0].running_text_1+'</i></b></marquee>';
                $('#running_text_1').html(html)
              }              
            }

          }
      });          
  }
   

</script>

<style>
  
    .bg-image-style-hp{
        /* background: url(<?php echo base_url("images/images_ui/bg_halaman_ujian.jpg");?>) no-repeat;  */
        width: 100%; height: 100vh;
        background-size: 260%;         
    }

    .bg-image-style-komp{
        /* background: url(<?php echo base_url("images/images_ui/bg_halaman_ujian.jpg"). '?v=' . time();?>) no-repeat;  */      
         width: 100%; height: 100vh;
        background-size: 100%;         
        background-position:bottom;  
    }
    
    .button-style-method1 {
        display: block; /* Membuat setiap tombol di baris baru */
        /* Lebar tombol */
        /* width: 300px;  */
        /* Meratakan tombol block individu ke tengah */
        margin: 5px;             
        padding: 10px 20px;
        font-size: 20px;
        cursor: pointer;            
        color: white;
        border: none;
        border-radius: 5px;
    }

    .body {
        font-family: "Quicksand", sans-serif;
        /* font-size: 30px; */
    }

    .modal-footer {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;
    }

    .modal-header {
        display: flex;
        justify-content: center; /* Center the content horizontally */
        align-items: center; /* Vertically align items if needed */
        padding: 10px;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .btn-shadow-rad {
        box-shadow: 1px 2px 5px #000000;   
        padding: 10px 20px;        
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.1s ease; /* Transisi untuk efek hover/active */
        border-radius: 15px;
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
        padding: 10px 20px;        
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.1s ease; /* Transisi untuk efek hover/active */       
    }

    .modal-content {
        border-radius: 15px; /* Sesuaikan nilai sesuai keinginan Anda */
    }

    .run_text_1{
        /* top: 580px; */
        /*position: absolute;        */
        font-size: xx-large;
        font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }
       
</style>