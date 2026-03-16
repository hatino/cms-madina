
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->
    <link rel="icon" href="<?php echo base_url();?>images/images_ui/icon_swi.ico">

    <title>SWI-Siswa</title>

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
  
  <div class="container-fluid" style="padding-top: 5pt;">
    <!--nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4"-->
    <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top" style="background-color:rgba(40, 68, 47, 0.88);">
      
        <!-- <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo4.png" height ="60" width="60" ><b style="color:white; font-size: 20pt; float: right; margin: 10px 0px 0px 5px;"> SWI</b></a> -->
        <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo4.png" height ="60" width="60"></a><p style="line-height: 15px; text-align: center;" class="text-white"><br><b class="fs-4" >SWI</b><br><i>Islamic School</i></p>&nbsp;
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span> MENU
        </button>
       
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">            
                  <a class="nav-link active" href="<?php echo base_url() .'index.php/dashboard/show_dashboard_siswa'; ?>" >
                      <span class="sr-only "></span><i class="bi bi-house"></i> HOME 
                  </a>    
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() .'index.php/raport/raport/show_biodata_siswa'; ?>" >
                  <i class="bi bi-person-fill"></i> BIODATA SISWA
                </a>                  
            </li>    -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() .'index.php/raport/raport/show_raport'; ?>" >
                  <i class="bi bi-journal-bookmark-fill"></i> RAPORT
                </a>                  
            </li>   
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() .'index.php/pembayaran/pembayaran/show_pembayaran'; ?>" >
                  <i class="bi bi-receipt"></i> PEMBAYARAN
                </a>                  
            </li>   
          </ul>
        
          <ul class="nav navbar-nav navbar-right">
                  <li class="nav-item">  
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-person-circle"></i>&nbsp<label id="div_user_id"></label>
                    </a>
                    <!-- <a class="nav-link" href="/logout"><i class="bi bi-box-arrow-left" ></i>&nbsp Logout</a> -->
                    <!--ul class="dropdown-menu end-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-journals"></i>&nbsp Purchase Monitoring</a></li>   
                    </ul-->

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <div id="nav_div_right"></div>
                      <a class="dropdown-item" href="<?php echo base_url() .'index.php/auth/logout';?>" ><i class="bi bi-box-arrow-left" ></i>&nbsp LOGOUT</a>                                                          
                    </div>
                    
                  </li>                
          </ul>

            <!--form class="form-inline mt-2 mt-md-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form-->
        </div>
      </div>  
    </nav>

    <main role="main">   
      <?php echo $contents;?>
    </main>
  </div>
  </body>

  <footer class="footer bg-dark fixed-bottom">
    <div class="container">
        <div class="row no-gutters">         
            <h6 class="text-light" style="text-align: right; margin-top: 5px;" ><i class="bi bi-c-circle"></i> 2025 SWI Islamic School</h6>                
        </div>
    </div>
  </footer>
  
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
  
  $(document).ready(function(){
    $('.parent_menu').on("click", function(e){
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
          $('#'+test).css('display', 'none')
          $('#'+sub_id).css('display', 'block')
          $('#txt_submenu_temp').val(sub_id)
      }
     
      //e.preventDefault();             
    });   
  });
  

</script>

      
<style>

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

.navbar-brand:hover {color: white;}

.navbar-nav > li > .nav-link  { color: lightgray;}
.navbar-nav > li > .nav-link:hover  { color: white;}
.navbar-nav > li > .dropdown-menu { background-color :rgb(59, 126, 87); color:white; }

.navbar-nav > li > .dropdown-menu a:hover,
.navbar-nav > li > .dropdown-menu a:focus,
.navbar-nav > li > .dropdown-menu a:active {     
   background-color: rgb(55, 168, 102);
   color: white
}

.dropdown-menu a{
   background-color:rgb(59, 126, 87); color:white; 
   }

.navbar-right > .nav-link { color: lightgray;}
.navbar-right > .nav-link:hover {color: white;}



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

.tbl_bg_color {
 background-color: rgba(40, 68, 47, 0.88);
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
 /* background: rgb(131, 73, 131);     */
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


/********* BUTTON *****************/
.btn-submit, .btn-submit a{   
   background-color: #81409c;
   color: white;   
}

.btn-submit:hover {
   background-color : #671a88;
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

.text-header {
 color: rgba(40, 68, 47, 0.88);
 /* color: #5F84A2; */
}

.dropdown-menu li {
  position : relative;
}

.dropdown-menu .submenu {
  display: none;
  position: absolute;
  /* left : 100%; */
  left : 40px;
  /* top:-7px; */
  background-color: rgb(59, 126, 87); color:white; 
  border-color: white;
}

.dropdown-menu>li:hover>.submenu {
  display: block;
}

</style>


