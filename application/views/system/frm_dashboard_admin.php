<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script>    
</head>

<body onload="init_form()">            
  
    <div class="container-fluid p-0 ">
      <div class="bg-admin">

        <div class="konten-selamat-datang">
          <h1 class="display-3 fw-bold">Selamat Datang</h1>
          <h3>Di Halaman Admin</h3>

        </div>
        
        
        <footer class="footer bg-dark">  
          <!-- <div class="container">
              <div class="row">         
                  <h6 class="text-light" style="text-align: right; margin-top: 5px;" ><i class="bi bi-c-circle"></i> 2025 SWI Islamic School</h6>                
              </div>
          </div> -->
        </footer>
      </div>
    </div>

</body>

</html>

<script  type="text/javascript">

  async function init_form() {
    //await cek_session_exists()
  }


</script>



<style type="text/css">
    

    .bg-admin{
        background: 
        linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
        url(<?php echo base_url("images/images_ui/bg_admin.jpg"). "?t=" . time();?>) no-repeat; 
        width: 100%; 
        height: 100vh; 
        background-size: cover;
        background-position: center;      
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        /* 2. Pastikan tidak ada padding dari container-fluid */
        padding-top: 0 !important;
        padding-bottom: 0 !important;

        /* UNTUK CONTENT */
        display: flex;           /* Aktifkan mode flex */
        align-items: center;     /* Pusatkan konten secara vertikal (tengah-tengah) */
        justify-content: flex-start; /* Pastikan konten tetap di kiri */
        
        color: white;            /* Warna teks agar terlihat */
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7); /* Efek bayangan agar teks jelas */
    }

    .konten-selamat-datang {
        padding-left: 80px;      /* Memberi jarak dari pinggir kiri */
    }



</style>