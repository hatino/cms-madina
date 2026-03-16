
<link href="<?php echo base_url();?>assets/css/glyphicon.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">       
<!-- Custom styles for this template -->
<link href="<?php echo base_url();?>assets/css/global.css" type="text/css" rel="stylesheet">
<script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 

<!--?php
echo form_open('auth/login');
?-->

<style type="text/css">
    .bg-login{
        background: 
        linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
        url(<?php echo base_url("images/images_ui/bg_login.jpg"). "?t=" . time();?>) no-repeat; 
        width: 100%; 
        height: 100vh; 
        background-size: cover;
        background-position: center;      
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }

</style>


<body>

    <div class="container-fluid bg-login">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <!--from start-->
                <form class="form-container" method="post" style="border-radius: 15px;" >
                    <h1 style="font-weight: 800; text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;" class="text-primary">Login</h1>
                    <br>
                    <div class="form-group">
                            <label for="username" style="color: #fcfafafd;">Username</label>
                            <input type="text" id="username" name="username" placeholder="username" class="form-control form-control-sm" id="username">
                    </div>
                            
                    <div class="form-group">
                            <label for="password" style="color: #fcfafafd;">Password</label>
                            <input type="password" id="password" name="password" placeholder="password" class="form-control form-control-sm" id="password">
                    </div>      
                    <br>
                    <div>
                        <button type="button" id="submit" name="submit" class="btn btn-primary btn-block btn-shadow">Login</button>                
                        <div id="pesan"></div>
                    </div>
                    
                </form>

                
                <!--from end-->
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12"></div>        
        </div>
    </div>



</body>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">

    var test = "<?php echo $pesan; ?>"
    
    if(test != ''){
        $('#pesan').css('color', '#cc0000')
        $('#pesan').text(test)        
    }

    $(document).on('click', '#submit', function () {       
        var form_data= $('.form-container').serialize();
        fetch("<?php echo site_url('auth/login') ;?>",{
                method: 'POST',   
                body: new URLSearchParams(form_data),
        })
        .then(response => response.json()) 
        .then(async (dataResult) => {            
            console.log(dataResult)
            if(dataResult.status==true){              
                var username = $('#username').val()                  
                // if(dataResult.data=='1'||dataResult.data=='0' ){
                //     if(dataResult.data=='0'){
                //         $('#btn_halaman_admin').attr('disabled',true)
                //     }else{
                //         $('#btn_halaman_admin').attr('disabled',false)
                //     }
                    
                //     $('#modal_konfirmasi').modal('show')
                // }else{
                    window.location.href="<?php echo site_url("dashboard/show_dashboard_admin") ?>"
                //}
                     
            }else{
                $('#pesan').css('color', '#cc0000')
                $('#pesan').text(dataResult.message)    
            }
           
        })        
       
       
    })

    $(document).on('click', '#btn_kembali', function () {
        $('#modal_konfirmasi').modal('hide')
        $('#username').val('')
        $('#password').val('')
    })

    $(document).on('keyup', '#password', function (e) {
        if(e.keyCode==13){
            $('#submit').trigger('click')
        }
    })

    $(document).on('click', '#btn_halaman_admin', async function () {        
        let res = await fetch("<?php echo site_url('auth/set_user_status') ;?>",{
                    method: 'POST',   
                    body: new URLSearchParams({status_user_login:'admin'}),
                   })
        var rs = res.json()

        window.location.href="<?php echo site_url("dashboard/show_dashboard_admin") ?>"
    })

    $(document).on('click', '#btn_halaman_tu', async function () {
        let res = await fetch("<?php echo site_url('auth/set_user_status') ;?>",{
                    method: 'POST',   
                    body: new URLSearchParams({status_user_login:'tu'}),
                   })
        var rs = res.json()

        window.location.href="<?php echo site_url("dashboard/show_dashboard_admin") ?>"
    })

    $(document).on('click', '#btn_halaman_siswa', function () {
        window.location.href="<?php echo site_url("dashboard/show_dashboard_siswa") ?>"
    })
        
</script>

<style>
    <style>
    .img-transfer-width {
        width: 185pt;
        height: 185ptt;
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
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
</style>

