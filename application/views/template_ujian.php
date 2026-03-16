<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo base_url();?>images/images_ui/icon_swi.ico">
    <link href="<?php echo base_url();?>assets/dist/css/bootstrap.min.css" rel="stylesheet">   
    <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-icons/font/bootstrap-icons.css">

    <title>SWI-Penilaian-Online</title>
</head>
<body>
    <!-- <body onload="init_form()"></body> -->
    <div class="container-fluid" style="padding-top: 5pt;">    
        <nav class="navbar navbar-expand-sm navbar-dark navbar-rounded shadow fixed-top" style="background-color:rgba(12, 66, 97, 0.88);">      
            
            <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>images/images_ui/logo4.png" height ="60" width="60"></a><p style="line-height: 15px; text-align: center;" class="text-white"><br><b class="fs-4" >SWI</b><br><i>Islamic School</i></p>&nbsp;
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> MENU
            </button>
        
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- <ul class="navbar-nav me-auto">
                <li class="nav-item">            
                    <a class="nav-link active" href="<?php echo base_url() .'index.php/dashboard/show_dashboard_ujian'; ?>" >
                        <span class="sr-only "></span><i class="bi bi-house"></i> HOME 
                    </a>    
                </li>            
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url() .'index.php/ujian/bank_soal/show_bank_soal'; ?>" >
                    <i class="bi bi-journals"></i> BANK SOAL
                    </a>                  
                </li>   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url() .'index.php/ujian/jadwal_ujian/show_jadwal_ujian'; ?>" >
                    <i class="bi bi-calendar-week"></i> JADWAL PENILAIAN
                    </a>                  
                </li>   
              
            </ul> -->

            <ul class="navbar-nav me-auto" id="menu"></ul>
           
            
            <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">  
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>&nbsp<label id="div_user_id"></label>
                        </a>
                    
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <div id="nav_div_right"></div>
                        <a class="dropdown-item" href="<?php echo base_url() .'index.php/auth/logout_ujian';?>" ><i class="bi bi-box-arrow-left" ></i>&nbsp LOGOUT</a>                                                          
                        </div>                    
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

  <footer class="footer bg-dark fixed-bottom">
    <div class="container">
        <div class="row no-gutters">         
            <h6 class="text-light" style="text-align: right; margin-top: 5px;" ><i class="bi bi-c-circle"></i> 2025 SWI Islamic School</h6>                
        </div>
    </div>
  </footer>
</html>

<script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>       
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>    
<script src="<?php echo base_url()?>assets/dist/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />    

<script type="text/javascript">
    var user = "<?php echo $_COOKIE['cms-swi-ujian'] ; ?>"
    var status_user = "<?php echo $_COOKIE['status-user'] ; ?>"
    
    document.getElementById('div_user_id').innerHTML = user    
    load_menu_guru()         
    
    function load_menu_guru() { 
        fetch('<?php echo site_url('dashboard/get_user_menu') ;?>?user_status_login='+status_user+'')
        .then(response => response.json())
        .then(responseData => {            
            var data = responseData.data                     
            var html = '';     
            if(data.length>0){           
                html += '<li class="nav-item">';
                html += '    <a class="nav-link active" href="<?php echo base_url() .'index.php/dashboard/show_dashboard_ujian'; ?>?status_user_login='+status_user+'" >';
                html += '        <span class="sr-only "></span><i class="bi bi-house"></i> HOME ';
                html += '    </a>    ';
                html += '</li> ';                
                                                    
                var subgroup_id_temp = '';
                var status_detail = false;
                for (let i = 0; i < data.length; i++) {
                    var menu = data[i]['menu_url']
                    var url ="<?php echo base_url() ; ?>index.php/"+menu
                    
                    if ( data[i]['subgroup_id'] != data[i]['menu_desc']) {  
                        status_detail = true                                              
                        if ( subgroup_id_temp != data[i]['subgroup_id']){    
                            html += '<ul class="navbar-nav me-auto">';                         
                            html += '<li class="nav-item dropdown">';
                            html += '    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                            html += '       <i class="'+data[i]['subgroup_icon_name']+'"></i>&nbsp'+data[i]['subgroup_id'].toUpperCase()+'';
                            html += '    </a>';
                            html += '    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';                            
                        }                            
                           
                            html += '       <li class="navbar-nav">';
                            html += '           <a class="dropdown-item" href="'+url+'">';
                            html += '               <i class="'+data[i]['icon_name']+'"></i>&nbsp'+data[i]['menu_desc'].toUpperCase()+'';
                            html += '           </a>';
                            html += '       </li>';
                            // html += '       <li><a class="dropdown-item" href="/setting_akun"><i class="fa-solid fa-weight-scale"></i>&nbspBobot Nilai</a></li>';           
                           
                                    
                    }else{
                        if ( status_detail = true){
                            html += '    </ul>'
                            html += '</li>';
                            html += '</ul>';
                            status_detail = false
                        }            
                        html += '<li class="nav-item">';
                        html += '    <a class="nav-link" href="'+url+'" >';
                        html += '    <i class="'+data[i]['icon_name']+'"></i> '+data[i]['menu_desc'].toUpperCase()+' ';
                        html += '    </a> ';        
                        html += '</li> ';   
                    }
                    subgroup_id_temp = data[i]['subgroup_id']
                }
            }                                      
         
            document.getElementById("menu").innerHTML = html;  
        })

    }
        
    

    
    
</script>

<style>
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
    .navbar-nav > li > .dropdown-menu { background-color :rgba(46, 98, 128, 1); color:white; }

    .navbar-nav > li > .dropdown-menu a:hover,
    .navbar-nav > li > .dropdown-menu a:focus,
    .navbar-nav > li > .dropdown-menu a:active {     
    background-color: rgba(63, 132, 172, 0.88);
    color: white
    }

    .dropdown-menu a{
        /* background-color:rgb(59, 126, 87);  */
        color:white; 
    }

    /* .navbar-right > .nav-link { color: lightgray;}
    .navbar-right > .nav-link:hover {color: white;} */
    /******* NAVBAR [END] *******/

    .text-header {
        color: rgba(12, 66, 97, 0.88);
        /* color: #5F84A2; */
    }


    /******* TABLE *******/
    .borderless-top td {
        border-top: none;
        /*border-bottom:none ;*/
        /*border: none !important;
        padding: 0px !important;*/
    }
    
    .borderless-bottom td {
        border-bottom: none;
    }

    .tbl_bg_color {
        background-color: rgba(12, 66, 97, 0.88);
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
        background: rgba(12, 66, 97, 0.88);   
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


    /********* BUTTON *****************/
    .btn-submit, .btn-submit a{   
        background-color: rgba(12, 66, 97, 0.88);
        color: white;   
    }

    .btn-submit:hover {
        background-color : rgba(8, 49, 73, 0.88);
        color: white;
    }

    th {
        text-align: center;
    }

    /******* DATEPICKER *****/
    .datepicker td,th{
    text-align: center;
    padding: 5px 10px;                  
    }

   
</style>