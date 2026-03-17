
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="google" content="notranslate">

    <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->
    <link rel="icon" href="<?php echo base_url();?>images/images_ui/madinah_ico.ico">
     
    
    <title>SIT Madina</title>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/navbar-static/"> -->

    <link href="<?php echo base_url();?>assets/css/glyphicon.css" rel="stylesheet">
   
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/bootstrap.min.css" rel="stylesheet">       
    <!-- Custom styles for this template -->
    <!--link href="navbar-top.css" rel="stylesheet"-->
    <!-- Datepicker -->
    <!--link href="<?php echo base_url();?>assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"-->

    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"-->    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-icons/font/bootstrap-icons.css">
    
           
  </head>

  <body>
  
  <div class="container-fluid" style="padding-top: 0px; padding-left: 0px; padding-right: 0px;">
    <!--nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4"-->
    <!-- <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top" style="background-color: #006DCC;"> -->
    <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top text-light">
    
      <!-- <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo4.png" height ="60" width="60" ><b style="color:white; font-size: 20pt; float: right; margin: 10px 0px 0px 5px;"> SWI</b></a> -->
      <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo.png" height ="60" width="60"></a><p style="line-height: 15px; text-align: center;" class="text-white no-wrap me-3"><br><b class="fs-4" >Madina</b><br><i>Islamic School</i></p>&nbsp;
      
      <button  class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span> MENU
      </button>
      
      <input type="hidden" id="txt_submenu_temp">
      <!-- <div class="collapse navbar-collapse" id="navbarCollapse"> -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
        <ul class="navbar-nav mx-auto">
                <li class="nav-item no-wrap">            
                      <a class="nav-link active" href="<?php echo base_url() .'index.php/dashboard'; ?>" >
                          <span class="sr-only "></span><i class="bi bi-house"></i> Home
                      </a>                           
                </li>          

                <ul class="navbar-nav">      
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="bi bi-bank"></i>&nbsp;Sejarah
                    </a>                  
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">           
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/sejarah/sejarah/show_sejarah'; ?>"><i class="bi bi-bank2"></i>&nbsp;&nbsp;Yayasan</a></li>
                        
                        <li class="parent_menu"><a class="link_mn dropdown-item" href="#"><i class="bi bi-bank"></i>&nbsp;&nbsp;Sekolah&nbsp; &raquo;</a>
                          <ul class="dropdown-menu submenu" id="sub_sejarah_sekolah">
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/sejarah/sejarah/show_sejarah_sekolah'; ?>?kode_jenjang=TKIT"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/sejarah/sejarah/show_sejarah_sekolah'; ?>?kode_jenjang=SDIT"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/sejarah/sejarah/show_sejarah_sekolah'; ?>?kode_jenjang=SMPIT"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>
                          </ul>
                        </li>         

                    </ul>
                  </li>    
                </ul>    

                <ul class="navbar-nav">      
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-journals"></i> Kurikulum
                    </a>                  
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">           
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/kurikulum/kurikulum/show_kurikulum'; ?>?kode_jenjang=TKIT"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/kurikulum/kurikulum/show_kurikulum'; ?>?kode_jenjang=SDIT"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/kurikulum/kurikulum/show_kurikulum'; ?>?kode_jenjang=SMPIT"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>      
                    </ul>
                  </li>    
                </ul>    

                <ul class="navbar-nav">      
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-people-fill"></i> PPDB
                    </a>                  
                    <ul class="dropdown-menu">  
                         
                        <li class="parent_menu"><a class="link_mn dropdown-item" href="#" ><i class="bi bi-pencil-square"></i>&nbsp;&nbsp;Form Pendaftaran&nbsp; &raquo;</a> <!---->
                          <ul class="dropdown-menu submenu" id="sub_ppdb_form_pendaftaran">
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="pendaftaran_ra" onclick="form_pendaftaran('TKIT')" href="#"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="pendaftaran_mi" onclick="form_pendaftaran('SDIT')" href="#"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="pendaftaran_smpit" onclick="form_pendaftaran('SMPIT')" href="#"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>
                          </ul>
                        </li>  
                      
                        <li><a class="link_mn dropdown-item" onclick="form_konfirmasi('')" href="#" ><i class="bi bi-check-circle"></i>&nbsp;&nbsp;Konfirmasi Pembayaran&nbsp;</a>                         
                        </li>    

                        <li><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pendaftaran/pendaftaran/show_informasi_data_siswa'; ?>" ><i class="bi bi-person-lines-fill"></i>&nbsp;&nbsp;Informasi Data Siswa&nbsp;</a></li>

                        <li class="parent_menu"><a class="link_mn dropdown-item" href="#" ><i class="bi bi-list-columns-reverse"></i>&nbsp;&nbsp;Hasil Observasi&nbsp; &raquo;</a>
                          <ul class="dropdown-menu submenu" id="sub_ppdb_hasil_observasi">
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="konfirmasi_ra" onclick="form_observasi('TKIT')" href="#"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="konfirmasi_mi" onclick="form_observasi('SDIT')" href="#"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" id="konfirmasi_smpit" onclick="form_observasi('SMPIT')" href="#"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>
                          </ul>
                        </li>    

                        <li class="parent_menu">
                          <a class="link_mn dropdown-item" href="#"><i class="bi bi-megaphone-fill"></i>&nbsp;&nbsp;Brosur PPDB&nbsp; &raquo;</a> 
                          <ul class="dropdown-menu submenu" id="sub_ppdb_brosur">
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pendaftaran/pendaftaran/show_brosur_pendaftaran' ; ?>?kode_jenjang=TKIT"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pendaftaran/pendaftaran/show_brosur_pendaftaran' ; ?>?kode_jenjang=SDIT"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                              <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pendaftaran/pendaftaran/show_brosur_pendaftaran' ; ?>?kode_jenjang=SMPIT"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>
                          </ul>
                        </li>  
                        
                    </ul>
                  </li>    
                </ul> 

                <ul class="navbar-nav">      
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-journal-richtext"></i> Pelajaran
                    </a>                  
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">           
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pelajaran/pelajaran/show_pelajaran'; ?>?kode_jenjang=TKIT"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pelajaran/pelajaran/show_pelajaran'; ?>?kode_jenjang=SDIT"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/pelajaran/pelajaran/show_pelajaran'; ?>?kode_jenjang=SMPIT"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>      
                    </ul>
                  </li>    
                </ul>    
               
                <ul class="navbar-nav">      
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-globe"></i> Berita dan Informasi
                    </a>                  
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">           
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/berita/berita/show_berita'; ?>?page=1"><i class="bi bi-globe-americas"></i>&nbsp;&nbsp;Berita dan Informasi</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/lowongan/lowongan/show_lowongan'; ?>"><i class="bi bi-person-workspace"></i>&nbsp;&nbsp;Lowongan</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/sosmed/sosmed/show_sosmed'; ?>?kode_sosmed=yt"><i class="bi bi-collection-play"></i>&nbsp;&nbsp;Sosial Media</a></li>      
                    </ul>
                  </li>    
                </ul>    
               
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-telephone"></i>&nbspKontak
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">           
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/master/kontak/show_kontak'; ?>?kode_jenjang=TKIT"><i class="bi bi-house-heart"></i>&nbsp;&nbsp;TKIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/master/kontak/show_kontak'; ?>?kode_jenjang=SDIT"><i class="bi bi-house-check"></i>&nbsp;&nbsp;SDIT Madina</a></li>
                        <li class="navbar-nav"><a class="link_mn dropdown-item" href="<?php echo base_url() .'index.php/master/kontak/show_kontak'; ?>?kode_jenjang=SMPIT"><i class="bi bi-house-up"></i>&nbsp;&nbsp;SMPIT Madina</a></li>      
                  </ul>
                </li>
         
        </ul>
               
        <ul class="navbar-nav ms-auto"> 
            <li class="nav-item dropdown">  
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <span id="div_user_id" class="ms-2"></span> 
                </a>                
                <ul class="dropdown-menu dropdown-menu-end">                      
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url() .'index.php/auth/login';?>">
                            <i class="bi bi-box-arrow-in-right"></i>&nbsp; Login
                        </a>
                    </li>                  
                </ul>        
            </li>                
        </ul>

        <!--form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form-->
      </div>
      
    </nav>

    
    <!-- <main role="main" class="container">   -->
      <?php echo $contents;?>
    <!-- </main> -->
    
  </div>

  

  <div id="div_no_wa"></div>
  <!-- <a href="https://wa.me/+6287884814460" title="Chat with us on WhatsApp" style="margin: 0 0 20px 0 !important;
      height: 52px; min-width: 52px; padding: 10px 0px 0px 10px; position: fixed !important; bottom: 10px; right: 20px; z-index: 999999999 !important; background-color: #00E785;
      box-shadow: 4px 5px 10px rgba(0, 0, 0, 0.4); border-radius: 100px" >
    <svg width="42" height="42" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1024_354)"><path d="M23.8759 4.06939C21.4959 1.68839 18.3316 0.253548 14.9723 0.0320463C11.613 -0.189455 8.28774 0.817483 5.61565 2.86535C2.94357 4.91323 1.10682 7.86244 0.447451 11.1638C-0.21192 14.4652 0.351026 17.8937 2.03146 20.8109L0.0625 28.0004L7.42006 26.0712C9.45505 27.1794 11.7353 27.7601 14.0524 27.7602H14.0583C16.8029 27.7599 19.4859 26.946 21.768 25.4212C24.0502 23.8965 25.829 21.7294 26.8798 19.1939C27.9305 16.6583 28.206 13.8682 27.6713 11.1761C27.1367 8.48406 25.8159 6.01095 23.8759 4.06939ZM14.0583 25.4169H14.0538C11.988 25.417 9.96008 24.8617 8.1825 23.8091L7.7611 23.5593L3.3945 24.704L4.56014 20.448L4.28546 20.0117C2.92594 17.8454 2.32491 15.2886 2.57684 12.7434C2.82877 10.1982 3.91938 7.80894 5.67722 5.95113C7.43506 4.09332 9.76045 2.87235 12.2878 2.48017C14.8152 2.08799 17.4013 2.54684 19.6395 3.78457C21.8776 5.02231 23.641 6.96875 24.6524 9.3179C25.6638 11.6671 25.8659 14.2857 25.2268 16.7622C24.5877 19.2387 23.1438 21.4326 21.122 22.999C19.1001 24.5655 16.6151 25.4156 14.0575 25.4157L14.0583 25.4169Z" fill="#E0E0E0"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.6291 7.98363C10.3723 7.41271 10.1019 7.40123 9.85771 7.39143C9.65779 7.38275 9.42903 7.38331 9.20083 7.38331C9.0271 7.3879 8.8562 7.42837 8.69887 7.5022C8.54154 7.57602 8.40119 7.68159 8.28663 7.81227C7.899 8.17929 7.59209 8.62305 7.38547 9.11526C7.17884 9.60747 7.07704 10.1373 7.08655 10.6711C7.08655 12.3578 8.31519 13.9877 8.48655 14.2164C8.65791 14.4452 10.8581 18.0169 14.3425 19.3908C17.2382 20.5327 17.8276 20.3056 18.4562 20.2485C19.0848 20.1913 20.4843 19.4194 20.7701 18.6189C21.056 17.8183 21.0557 17.1323 20.9701 16.989C20.8844 16.8456 20.6559 16.7605 20.3129 16.5889C19.9699 16.4172 18.2849 15.5879 17.9704 15.4736C17.656 15.3594 17.4275 15.3023 17.199 15.6455C16.9705 15.9888 16.3139 16.7602 16.1137 16.9895C15.9135 17.2189 15.7136 17.2471 15.3709 17.0758C14.3603 16.6729 13.4275 16.0972 12.6143 15.3745C11.8648 14.6818 11.2221 13.8819 10.7072 13.0007C10.5073 12.6579 10.6857 12.472 10.8579 12.3007C11.0119 12.1472 11.2006 11.9005 11.3722 11.7003C11.5129 11.5271 11.6282 11.3346 11.7147 11.1289C11.7603 11.0343 11.7817 10.9299 11.7768 10.825C11.7719 10.7201 11.7409 10.6182 11.6867 10.5283C11.6001 10.3566 10.9337 8.66151 10.6291 7.98363Z" fill="white"></path><path d="M23.7628 4.02445C21.4107 1.66917 18.2825 0.249336 14.9611 0.0294866C11.6397 -0.190363 8.35161 0.804769 5.70953 2.82947C3.06745 4.85417 1.25154 7.77034 0.600156 11.0346C-0.051233 14.299 0.506321 17.6888 2.16894 20.5724L0.222656 27.6808L7.49566 25.7737C9.50727 26.8692 11.7613 27.4432 14.0519 27.4434H14.0577C16.7711 27.4436 19.4235 26.6392 21.6798 25.1321C23.936 23.6249 25.6947 21.4825 26.7335 18.9759C27.7722 16.4693 28.0444 13.711 27.5157 11.0497C26.9869 8.38835 25.6809 5.94358 23.7628 4.02445ZM14.0577 25.1269H14.0547C12.0125 25.1271 10.0078 24.5782 8.25054 23.5377L7.8339 23.2907L3.51686 24.4222L4.66906 20.2143L4.39774 19.7831C3.05387 17.6415 2.4598 15.1141 2.70892 12.598C2.95804 10.082 4.03622 7.72013 5.77398 5.88366C7.51173 4.04719 9.81051 2.84028 12.3089 2.45266C14.8074 2.06505 17.3638 2.5187 19.5763 3.74232C21.7888 4.96593 23.5319 6.89011 24.5317 9.21238C25.5314 11.5346 25.7311 14.1233 25.0993 16.5714C24.4675 19.0195 23.0401 21.1883 21.0414 22.7367C19.0427 24.2851 16.5861 25.1254 14.0577 25.1255V25.1269Z" fill="white"></path></g><defs><clipPath id="clip0_1024_354"><rect width="27.8748" height="28" fill="white" transform="translate(0.0625)"></rect></clipPath></defs></svg>    
  </a> -->
  
  <?php 
      include 'conn.php';    

      $query="SELECT no_hotline
              FROM profil_yayasan ";

      $list_data = mysqli_query($conn, $query);
      $row_num = mysqli_num_rows($list_data);
      $no_hotline_formatted = '';
      
      if ($row_num==0){
        $no_hotline = '';
      }else{
        while ($data=mysqli_fetch_assoc($list_data)) 
        {
          $no_hotline = $data['no_hotline'];
        }
          
         if(str_starts_with($no_hotline, '0')){
           $no_temp = substr($no_hotline,1);
           $no_hotline_formatted = $no_temp;
         } 
      }
         
  ?>

  <?php
    $pesan = "Assalaamu ‘alaikum wr wb.

    Admin saya mau tanya mengenai pendaftaran di SIT SWI
    1. Kapan mulai pendaftaran?
    2. Berapa uang pangkalnya?

    Terima kasih 🙏🏻";
  ?>

  <!-- <a href="https://wa.me/6281519040960" target="_blank"  title="Silahkan Chat kepada kami untuk informasi lengkap" style="margin: 0 0 20px 0 !important;  -->
  <a href="https://wa.me/62<?php echo $no_hotline_formatted ;?>?text=<?php echo urlencode($pesan); ?>" target="_blank"  title="Silahkan Chat kepada kami untuk informasi lengkap" style="margin: 0 0 20px 0 !important;    
      height: 52px; min-width: 52px; padding: 10px 0px 0px 10px; position: fixed !important; bottom: 10px; right: 20px; z-index: 999999999 !important; background-color: #00E785;
      box-shadow: 4px 5px 10px rgba(0, 0, 0, 0.4); border-radius: 100px" >
    <svg width="42" height="42" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1024_354)"><path d="M23.8759 4.06939C21.4959 1.68839 18.3316 0.253548 14.9723 0.0320463C11.613 -0.189455 8.28774 0.817483 5.61565 2.86535C2.94357 4.91323 1.10682 7.86244 0.447451 11.1638C-0.21192 14.4652 0.351026 17.8937 2.03146 20.8109L0.0625 28.0004L7.42006 26.0712C9.45505 27.1794 11.7353 27.7601 14.0524 27.7602H14.0583C16.8029 27.7599 19.4859 26.946 21.768 25.4212C24.0502 23.8965 25.829 21.7294 26.8798 19.1939C27.9305 16.6583 28.206 13.8682 27.6713 11.1761C27.1367 8.48406 25.8159 6.01095 23.8759 4.06939ZM14.0583 25.4169H14.0538C11.988 25.417 9.96008 24.8617 8.1825 23.8091L7.7611 23.5593L3.3945 24.704L4.56014 20.448L4.28546 20.0117C2.92594 17.8454 2.32491 15.2886 2.57684 12.7434C2.82877 10.1982 3.91938 7.80894 5.67722 5.95113C7.43506 4.09332 9.76045 2.87235 12.2878 2.48017C14.8152 2.08799 17.4013 2.54684 19.6395 3.78457C21.8776 5.02231 23.641 6.96875 24.6524 9.3179C25.6638 11.6671 25.8659 14.2857 25.2268 16.7622C24.5877 19.2387 23.1438 21.4326 21.122 22.999C19.1001 24.5655 16.6151 25.4156 14.0575 25.4157L14.0583 25.4169Z" fill="#E0E0E0"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.6291 7.98363C10.3723 7.41271 10.1019 7.40123 9.85771 7.39143C9.65779 7.38275 9.42903 7.38331 9.20083 7.38331C9.0271 7.3879 8.8562 7.42837 8.69887 7.5022C8.54154 7.57602 8.40119 7.68159 8.28663 7.81227C7.899 8.17929 7.59209 8.62305 7.38547 9.11526C7.17884 9.60747 7.07704 10.1373 7.08655 10.6711C7.08655 12.3578 8.31519 13.9877 8.48655 14.2164C8.65791 14.4452 10.8581 18.0169 14.3425 19.3908C17.2382 20.5327 17.8276 20.3056 18.4562 20.2485C19.0848 20.1913 20.4843 19.4194 20.7701 18.6189C21.056 17.8183 21.0557 17.1323 20.9701 16.989C20.8844 16.8456 20.6559 16.7605 20.3129 16.5889C19.9699 16.4172 18.2849 15.5879 17.9704 15.4736C17.656 15.3594 17.4275 15.3023 17.199 15.6455C16.9705 15.9888 16.3139 16.7602 16.1137 16.9895C15.9135 17.2189 15.7136 17.2471 15.3709 17.0758C14.3603 16.6729 13.4275 16.0972 12.6143 15.3745C11.8648 14.6818 11.2221 13.8819 10.7072 13.0007C10.5073 12.6579 10.6857 12.472 10.8579 12.3007C11.0119 12.1472 11.2006 11.9005 11.3722 11.7003C11.5129 11.5271 11.6282 11.3346 11.7147 11.1289C11.7603 11.0343 11.7817 10.9299 11.7768 10.825C11.7719 10.7201 11.7409 10.6182 11.6867 10.5283C11.6001 10.3566 10.9337 8.66151 10.6291 7.98363Z" fill="white"></path><path d="M23.7628 4.02445C21.4107 1.66917 18.2825 0.249336 14.9611 0.0294866C11.6397 -0.190363 8.35161 0.804769 5.70953 2.82947C3.06745 4.85417 1.25154 7.77034 0.600156 11.0346C-0.051233 14.299 0.506321 17.6888 2.16894 20.5724L0.222656 27.6808L7.49566 25.7737C9.50727 26.8692 11.7613 27.4432 14.0519 27.4434H14.0577C16.7711 27.4436 19.4235 26.6392 21.6798 25.1321C23.936 23.6249 25.6947 21.4825 26.7335 18.9759C27.7722 16.4693 28.0444 13.711 27.5157 11.0497C26.9869 8.38835 25.6809 5.94358 23.7628 4.02445ZM14.0577 25.1269H14.0547C12.0125 25.1271 10.0078 24.5782 8.25054 23.5377L7.8339 23.2907L3.51686 24.4222L4.66906 20.2143L4.39774 19.7831C3.05387 17.6415 2.4598 15.1141 2.70892 12.598C2.95804 10.082 4.03622 7.72013 5.77398 5.88366C7.51173 4.04719 9.81051 2.84028 12.3089 2.45266C14.8074 2.06505 17.3638 2.5187 19.5763 3.74232C21.7888 4.96593 23.5319 6.89011 24.5317 9.21238C25.5314 11.5346 25.7311 14.1233 25.0993 16.5714C24.4675 19.0195 23.0401 21.1883 21.0414 22.7367C19.0427 24.2851 16.5861 25.1254 14.0577 25.1255V25.1269Z" fill="white"></path></g><defs><clipPath id="clip0_1024_354"><rect width="27.8748" height="28" fill="white" transform="translate(0.0625)"></rect></clipPath></defs></svg>    
  </a>

  
  </body>

  <footer class="footer fixed-bottom" style="background-color: #036b61;">
    <div class="container">
        <div class="row no-gutters">         
            <h6 class="text-light" style="text-align: right; margin-top: 5px;" ><i class="bi bi-c-circle"></i> 2026 SIT Madina</h6>                
        </div>
    </div>
  </footer>
</html>

 <!-- Bootstrap core JavaScript
  ================================================== -->
  <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->

  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>       
  <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>       
  
  <!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->
  <!--script>window.jQuery || document.write('<script src="<?php echo base_url()?>assets/js/vendor/jquery-slim.min.js"><\/script>')</script-->
  <!--script src="<?php echo base_url()?>assets/js/vendor/popper.min.js"></script-->
  <script src="<?php echo base_url()?>assets/dist/js/bootstrap.min.js"></script>
  <!-- <script src="<?php echo base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>   

  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!--script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script--> 
  <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>



<script>

  (function ($) {

    var previousScroll = 20;
        // scroll functions
        $(window).scroll(function(e) {
          //alert('test');
            // add/remove class to navbar when scrolling to hide/show
            var scroll = $(window).scrollTop();
            if (scroll >= previousScroll) {
                $('.navbar').addClass("navbar-hide");
            
            }else if (scroll < previousScroll) {
                $('.navbar').removeClass("navbar-hide");
            }
            previousScroll = scroll;
        
        });                    
    })(jQuery); 
    
  </script>



<script  type="text/javascript">      

    $(document).ready(function(){
      $('.parent_menu').on("click", function(e){
        //$(this).next('li a').toggle();       
        e.stopPropagation();
        //e.preventDefault();       
        var target = e.target.closest('.parent_menu');        
        var target_sub = target.querySelector('.submenu')        
        var sub_id = target_sub.id    

        var test = $('#txt_submenu_temp').val();
                
        if(test == sub_id){
            $('.submenu').css('display', 'none')
            $('#txt_submenu_temp').val('')
        }else{
            $('#'+test).css('display', 'none')
            $('#'+sub_id).css('display', 'block')
            $('#txt_submenu_temp').val(sub_id)
        }

      });
    });


     // FORM PENDAFTARAN//
    async function form_pendaftaran(kode_jenjang) {      
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_thn_ajaran_aktif_ui') ; ?>?kode_jenjang='+kode_jenjang+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()          
        var data = result.data[0]
        var thn_ajaran_cls = data[0].thn_ajaran_cls
        if(thn_ajaran_cls==null){
          return false
        }      
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_input_pendaftaran') ; ?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""   
    }


    // KONFIRMASI PEMBAYARAN//
    async function form_konfirmasi(kode_jenjang) {           
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_thn_ajaran_aktif_ui') ;?>?kode_jenjang='+kode_jenjang+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json() 
        var data = result.data[0]
        // var thn_ajaran_cls = data[0].thn_ajaran_cls
        var thn_ajaran_cls = ''
        // if(thn_ajaran_cls==null){
        //   return false
        // }      
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_konfirmasi_pembayaran') ;?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""
    }

    // OBSERVASI//
    async function form_observasi(kode_jenjang) {    
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/cek_thn_ajaran_aktif_ui') ;?>?kode_jenjang='+kode_jenjang+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json() 
        var data = result.data[0]
        var thn_ajaran_cls = data[0].thn_ajaran_cls
        if(thn_ajaran_cls==null){
          return false
        }      
        window.location.href="<?php echo site_url('pendaftaran/pendaftaran/show_hasil_observasi') ;?>?kode_jenjang="+kode_jenjang+"&thn_ajaran_cls="+thn_ajaran_cls+""
    }

    
</script>
  
 
      
<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
 /* .navbar-custom {
  height: 35px;   
} */

.navbar {
	/*margin:0 !important;*/
	padding-top: 0px !important;
  padding-bottom: 0px !important;
  padding-left: 10PX;
}

/******* NAVBAR *******/
.navbar-brand {
  color: white;
  text-transform: uppercase;
  /*letter-spacing: 10px;*/
}

/* .navbar-brand:hover {color: white;} */

/* .navbar-nav > li > .nav-link  { color: lightgray;} */
/* .navbar-nav > li > .nav-link:hover  { color: white;} */
/* .navbar-nav > li > .dropdown-menu { background-color :#006DCC; color:white; } */
.navbar-nav > li > .dropdown-menu {background-color: rgba(0, 0, 0, 0.3); backdrop-filter: blur(1px)}
.navbar-nav > li > .dropdown-menu a:hover, 
.navbar-nav > li > .dropdown-menu a:focus,
.navbar-nav > li > .dropdown-menu a:active { 
    /*background-color: #9b0885;*/
    background-color: #313233; */
    /* color: white
}

.navbar-nav .dropdown-menu a:hover { 
    color: #FFD700 !important;
    background-color: rgba(255, 255, 255, 0.1); /* Memberi sedikit highlight background agar teks kuning terbaca */
}


/* .navbar-right > .nav-link { color: lightgray;} */
/* .navbar-right > .nav-link:hover {color: white;} */



/******* MODAL *******/
.bg-modal-header {
  background-color: #0ad1c1;
}


/******* NAVBAR *******/
.text-header {
  /*color: #571773;*/
  color: #036b61;
}


/******* TABLE *******/
.borderless-top td {
		border-top: none;
		/*border-bottom:none ;*/
		/*border: none !important;
		padding: 0px !important;*/}
	
.borderless-bottom td {
  border-bottom: none;}

.tbl_bg_color thead {
  background-color: #3a0e4d;
}

.btn-bg-color-purple {
  background-color: purple;    
  color : white;  
}


/******** FIX TABLE ******/
.table-sticky thead tr th {
  /* Important */  
  position: sticky;
  z-index: 1;
  top: 0;
}
  
.table-sticky>thead>tr>th,
.table-sticky>thead>tr>td {
	background: #009688;    
	color: #fff;
	top: 0px;
	position: sticky;
}

.table-height {
	/*height: 350px;*/
	display: block;
    overflow: auto;
    /*overflow-x:hidden;*/
	/*width: 100%;*/
}

table {
	border-collapse: collapse;
	border-spacing: 0;
}

.table-bordered>thead>tr>th,
.table-bordered>tbody>tr>th,
.table-bordered>thead>tr>td,
.table-bordered>tbody>tr>td {
	border: 1px solid #ddd;
}

/******* DATEPICKER *****/
.datepicker td,th{
    text-align: center;
    padding: 5px 10px;                  
}

.dropdown-menu li {
  position : relative;
}

.dropdown-menu .submenu {
  display: none;
  position: absolute;
  left : 40px;
}

.dropdown-menu .submenu {
  display: none;
  position: absolute;
  left : 100px;  
  background-color: rgba(0, 0, 0, 0.3); color:white;   
  border-color: white;
}

.dropdown-menu>li:hover>.submenu {
  display: block;
}

.no-wrap {
    font-size: 14px;       /* sesuaikan ukuran */
    white-space: nowrap;  /* cegah turun baris */
}

.navbar {
    font-display: text;
    background-color: rgba(0, 0, 0, 0.3); /* R=0, G=0, B=0 (Hitam), A=0.5 (30% Alpha) */
    backdrop-filter: blur(1px); /* Opsional: Efek blur kaca yang lagi tren */
}


/* Keadaan normal: Teks Putih Terang */
nav.navbar a {
    color: #FFFFFF !important;
    opacity: 1;
    text-decoration: none;
    /* font-weight: bold; */
    transition: color 0.3s ease; /* Transisi halus saat berubah warna */
}

/* Keadaan saat kursor di atas menu (Hover): Kuning */
nav.navbar a:hover {
    color: #b3ff00 !important; /* Warna Gold/Kuning Terang */
}

.text-judul {
  color: rgba(7, 62, 146, 0.93);
}
</style>