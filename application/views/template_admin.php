
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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

  <input type="hidden" id="txt_submenu_temp">
  
  <!-- <div class="container-fluid" style="padding-top: 5pt;"> -->
  <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
    <!--nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4"-->
    <!-- <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top" style="background-color: #3a0e4d;"> -->
    <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top text-light">

        <!-- <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo4.png" height ="60" width="60" ><b style="color:white; font-size: 20pt; float: right; margin: 10px 0px 0px 5px;"> SWI</b></a> -->
        <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo.png" height ="60" width="60"></a><p style="line-height: 15px; text-align: center;" class="text-white"><br><b class="fs-4" >Madina</b><br><i>Islamic School</i></p>&nbsp;
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span> MENU
        </button>
       
        <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
          
          <ul class="navbar-nav mx-auto" id="menu"></ul>
                   
          <ul class="nav navbar-nav ms-auto">
                  <li class="nav-item dropdown">  
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-person-circle"></i>&nbsp<label id="div_user_id"></label>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">      
                      <li>
                        <a class="dropdown-item" href="<?php echo base_url() .'index.php/auth/logout';?>" ><i class="bi bi-box-arrow-left" ></i>&nbsp LOGOUT</a>                                                          
                      </li>
                    </ul>
                    
                  </li>                
          </ul>                      

        </div>
      </div>  
    </nav>

    <main role="main">   
      <?php echo $contents;?>
    </main>
  </div>
  </body>
</html>

  <!-- <script>
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
    })(jQuery);  -->
    
  </script>
  
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
  <!--script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script-->   

  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!--script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script--> 
  <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script  type="text/javascript">  
  var user = "<?php echo $_COOKIE['cms-mdn-user'] ; ?>"
  var status_user = 'admin'
  load_menu_admin()

  function load_menu_admin() { 
        fetch('<?php echo site_url('dashboard/get_user_halaman_admin') ;?>?user_status_login='+status_user+'')
        .then(response => response.json())
        .then(responseData => {            
            var data = responseData.data                 
            var html = '';     
            if(data.length>0){           
                html += '<li class="nav-item">';
                html += '    <a class="nav-link active" href="<?php echo base_url() .'index.php/dashboard/show_dashboard_admin'; ?>?status_user_login='+status_user+'" >';
                html += '        <span class="sr-only "></span><i class="bi bi-house"></i> Home ';
                html += '    </a>    ';
                html += '</li> ';                
                                          
                var group_id_temp = '';
                var subgroup_id_temp = '';
                var status_detail = false;
                var status_detail_subgroup = false;
                for (let i = 0; i < data.length; i++) {
                    var menu = data[i]['menu_url']
                    var menu_name = data[i]['menu_name']
                    var cari_tkit = menu_name.indexOf('tkit')
                    var cari_sdit = menu_name.indexOf('sdit')
                    var cari_smpit = menu_name.indexOf('smpit')
                    if(cari_tkit!=-1){
                      var url ="<?php echo base_url() ; ?>index.php/"+menu+"?kode_jenjang=TKIT"
                    }else if(cari_sdit!=-1){
                      var url ="<?php echo base_url() ; ?>index.php/"+menu+"?kode_jenjang=SDIT"                
                    }else if(cari_smpit!=-1){
                      var url ="<?php echo base_url() ; ?>index.php/"+menu+"?kode_jenjang=SMPIT"  
                    }else{
                      var url ="<?php echo base_url() ; ?>index.php/"+menu
                    }
                    
                    if(data[i]['group_id']=="PPDB"){                        
                        if(group_id_temp!="PPDB"){
                          html += '             </ul>';                       
                          html += '         </li>';
                          html += '    </ul>';    
                                                    
                          html += '</li>';      
                          html += '</li>';    
                        }
                        if ( subgroup_id_temp != data[i]['subgroup_id'] && group_id_temp != data[i]['group_id']){                              
                              //html += '<ul class="navbar-nav me-auto">';  
                              html += '<ul class="navbar-nav">';                         
                              html += '<li class="nav-item dropdown">';
                              html += '    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                              html += '       <i class="'+data[i]['group_icon_name']+'"></i>&nbsp'+data[i]['group_id']+'';
                              html += '    </a>';
                              html += '    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';  
                              html += '         <li tabindex="0" class="parent_menu"><a class="link_mn dropdown-item" href="#"><i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id']+'&nbsp; &raquo;</a>';
                              //html += '             <ul class="dropdown-menu submenu" id="sub_sejarah_yayasan">';
                              html += '               <ul class="dropdown-menu submenu" id="sub_' + data[i]['subgroup_id'] + '">';
                        }
                        if ( subgroup_id_temp != data[i]['subgroup_id'] && group_id_temp == data[i]['group_id']){
                              html += '             </ul>';
                              html += '         </li>';                        
                              html += '         <li tabindex="0" class="parent_menu"><a class="link_mn dropdown-item" href="#"><i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id']+'&nbsp; &raquo;</a>';
                              //html += '             <ul class="dropdown-menu submenu" id="sub_sejarah_yayasan">';
                              html += '               <ul class="dropdown-menu submenu" id="sub_' + data[i]['subgroup_id'] + '">';
                        }

                     


                            //html += '                 <li class="navbar-nav sejarah" id="sajarah_tkit">';
                            html += '                   <li class="sejarah-item" style="list-style:none;">';

                            html += '                     <a  class="link_mn dropdown-item" href="'+url+'">';
                            html += '                         <i class="'+data[i]['icon_name']+'"></i>&nbsp'+data[i]['menu_desc']+'';
                            html += '                      </a>';
                            html += '                 </li>'; 
                                  

                    }else{
                        if(group_id_temp=="PPDB"){
                            html += '               </ul>';                       
                            html += '           </li>';
                            html += '    </ul>';    
                            html += '</li>';
                            html += '</ul>';    
                        }

                        if ( data[i]['subgroup_id'] == data[i]['group_id']) {  
                            if (status_detail_subgroup==true){
                              html += '             </ul>';                       
                              html += '         </li>';
                              html += '    </ul>';    
                                                        
                              html += '</li>';      

                              //merubah dari /li ke /ul
                              // html += '</li>';    
                              html += '</ul>';

                              status_detail_subgroup = false
                            }
                                                                          
                            if ( subgroup_id_temp != data[i]['subgroup_id'] && group_id_temp != data[i]['group_id']){                                    
                                if (status_detail==true){                          
                                    html += '   </ul>';
                                    html += '</li>';
                                    html += '</ul>';
                                    status_detail = false
                                }           
                                status_detail = true
                                html += '<ul class="navbar-nav me-auto">';                         
                                html += '<li class="nav-item dropdown">';
                                html += '    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                html += '       <i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id']+'';
                                html += '    </a>';
                                html += '    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';                            
                            }
                                                    
                                html += '       <li class="navbar-nav">';
                                html += '           <a class="dropdown-item" href="'+url+'">';
                                html += '               <i class="'+data[i]['icon_name']+'"></i>&nbsp'+data[i]['menu_desc']+'';
                                html += '           </a>';
                                html += '       </li>';
                                // html += '       <li><a class="dropdown-item" href="/setting_akun"><i class="fa-solid fa-weight-scale"></i>&nbspBobot Nilai</a></li>';           
                              
                        }else if ( data[i]['subgroup_id'] != data[i]['group_id']) {  
                            if (status_detail==true){                          
                                html += '   </ul>';
                                html += '</li>';
                                html += '</ul>';
                                status_detail = false
                            }           

                            status_detail_subgroup = true                
                            if ( subgroup_id_temp != data[i]['subgroup_id'] && group_id_temp != data[i]['group_id']){                              
                              html += '<ul class="navbar-nav me-auto">';                         
                              html += '<li class="nav-item dropdown">';
                              html += '    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                              html += '       <i class="'+data[i]['group_icon_name']+'"></i>&nbsp'+data[i]['group_id']+'';
                              html += '    </a>';
                              html += '    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';  
                              html += '         <li tabindex="0" class="parent_menu"><a class="link_mn dropdown-item" href="#"><i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id']+'&nbsp; &raquo;</a>';
                              //html += '             <ul class="dropdown-menu submenu" id="sub_sejarah_yayasan">';
                              html += '               <ul class="dropdown-menu submenu" id="sub_' + data[i]['subgroup_id'] + '">';
                            }
                            if ( subgroup_id_temp != data[i]['subgroup_id'] && group_id_temp == data[i]['group_id']){
                              html += '             </ul>';
                              html += '         </li>';                        
                              html += '         <li tabindex="0" class="parent_menu"><a class="link_mn dropdown-item" href="#"><i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id']+'&nbsp; &raquo;</a>';
                              //html += '             <ul class="dropdown-menu submenu" id="sub_sejarah_yayasan">';
                              html += '               <ul class="dropdown-menu submenu" id="sub_' + data[i]['subgroup_id'] + '">';
                            }

                            //html += '                 <li class="navbar-nav sejarah" id="sajarah_tkit">';
                            html += '                   <li class="sejarah-item" style="list-style:none;">'
                            
                            html += '                     <a  class="link_mn dropdown-item" href="'+url+'">';
                            html += '                         <i class="'+data[i]['icon_name']+'"></i>&nbsp'+data[i]['menu_desc']+'';
                            html += '                      </a>';
                            html += '                 </li>'; 
                                  
                                        
                        }else{
                            // if ( status_detail = true){
                            //     html += '    </ul>'
                            //     html += '</li>';
                            //     html += '</ul>';
                            //     status_detail = false
                            // }            
                        

                            // html += '<li class="nav-item">';
                            // html += '    <a class="nav-link" href="'+url+'" >';
                            // html += '    <i class="'+data[i]['icon_name']+'"></i> '+data[i]['menu_desc'].toUpperCase()+' ';
                            // html += '    </a> ';        
                            // html += '</li> ';   
                        }
                                       
                    }
                    subgroup_id_temp = data[i]['subgroup_id']
                    group_id_temp = data[i]['group_id']
                }

                  html += '             </ul>';
                  html += '         </li>';
                  html += '     </ul>';
                  // html += '   </li>';
                  // html += '</ul>';
            }                                      
            
            document.getElementById("menu").innerHTML = html;  
        })

    }

  
    $(document).on('click', '.parent_menu', function(e){
      //$(this).next('li a').toggle();           
      e.stopPropagation();
      var target = e.target.closest('.parent_menu');       
      var target_sub = target.querySelector('.submenu')     
      var sub_id = target_sub.id        
      var test = $('#txt_submenu_temp').val();
               
      if(test == sub_id){
          $('.submenu').css('display', 'none')
          $('#txt_submenu_temp').val('')
      }else{
        //alert(sub_id)
          $('#'+test).css('display', 'none')
          $('#'+sub_id).css('display', 'block')
          $('#txt_submenu_temp').val(sub_id)
      }
     
      //e.preventDefault();             
    });   
  
 

</script>

      
<style>

/******* NAVBAR *******/
.navbar {
	/*margin:0 !important;*/
	padding-top: 0px !important;
  padding-bottom: 0px !important;
  padding-left: 10PX;
}

.navbar-brand {
  color: white;
  text-transform: uppercase;
  /*letter-spacing: 10px;*/
}

.navbar-nav > li > .dropdown-menu {background-color: rgba(10, 95, 17, 0.3);} 
/* .navbar-nav > li > .dropdown-menu { background-color :#3a0e4d; color:white; } */
.navbar-nav > li > .dropdown-menu a:hover, 
.navbar-nav > li > .dropdown-menu a:focus,
.navbar-nav > li > .dropdown-menu a:active {  
    background-color: rgb(5, 95, 32);
    /* background-color : #3a0e4d */
    color: white
}

.navbar-nav .dropdown-menu a:hover { 
    color: #FFD700 !important;
    background-color: rgba(10, 95, 17, 0.1); /* Memberi sedikit highlight background agar teks kuning terbaca */
}

/* .dropdown-menu a{
   background-color: rgba(61, 14, 55, 0.3);; color:white; 
} */


.navbar {
    font-display: text;
    background-color: rgba(10, 95, 17, 0.3);  /* R=0, G=0, B=0 (Hitam), A=0.5 (30% Alpha) */
    /* background-color :#3a0e4d; */
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
    color: #FFD700 !important; /* Warna Gold/Kuning Terang */
}


/******* MODAL *******/
.bg-modal-header {
  background-color: #0ad1c1;
}


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
	background: #036b61;    
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

/******* DROPDOWN *****/
.dropdown-menu li {
  position : relative;
}

.dropdown-menu .submenu {
  display: none;
  position: absolute;  
  left : 100px; 
  /* background-color: #3a0e4d; color:white;  */
  background-color: rgba(10, 95, 17, 0.6);; color:white;   
  border-color: white;
}

/* .dropdown-menu>li:hover>.submenu {
  display: block;
} */

.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}

.no-wrap {
    font-size: 14px;       /* sesuaikan ukuran */
    white-space: nowrap;  /* cegah turun baris */
}


/********* BUTTON *****************/
.btn-submit, .btn-submit a{   
   background-color: #036b61;
   color: white;   
}

.btn-submit:hover {
   background-color : #289e92;
   color: white;
}

.btn-clear, .btn-clear a{   
   background-color: #0dc5b3;
   color: white;   
}

.btn-clear:hover {
   background-color : #04796d;
   color: white;
}

.btn-excel, .btn-excel a{   
   background-color: #4ed63c;
   color: white;   
}

.btn-excel:hover {
   background-color : #4dad78;
   color: yellow;
}

.btn-cancel, .btn-cancel a{   
   background-color: #f1b203;
   color: white;   
}

.btn-cancel:hover {
   background-color : #e79a0b;
   color: yellow;
}

.btn-getdata, .btn-getdata a{   
   background-color: #cdec2e;
   color: green;   
}

.btn-getdata:hover {
   background-color : #bfe20c;
   color: green;
}

.btn-shadow {
    box-shadow: 1px 2px 5px #000000;   
}

.dropdown-menu>li:hover>.submenu {
  display: block;
}

.dropdown-menu > li:focus-within > .submenu {
  display: block;
}

</style>

