<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />    
</head>

<body>
    <body onload="init_form()"></body> 
    <div class="header_img">
        <!-- <img class="responsive" src="<?php echo base_url() ?>images/images_bg/header_bg_pelajaran.jpg" alt="Notebook" style="width:100%;">       -->
        <div id="img_header"></div>
        <div class="centered" style="color: black; text-align:center; "><p><span style="white-space: nowrap"><h2 class="text-banner fw-bold"><b>Daftar Pelajaran <span id="span_nama_unit"></span></b><h2></span></p></div>      
        <!-- <div class="header-text">
            Sosial Media
        </div> -->
    </div>
    <div class="container mt-5">                 
        <div id="div_pelajaran" class="ck-content"></div>
       
        <div id="div_tbl_pelajaran"></div>
        <br>
        <br>
        <br>
        <br>
        <br>
      
    </div>

    <div class="footer2 fixed-bottom" >
      <div class="container">
        <div class="row">
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="TKIT" style="cursor: pointer;" title="TKIT Madina"><i class="bi bi-house-heart"></i>&nbsp;<b>TKIT</b></span>
            </div>
            <div class="col-4">
               <span class="unit_jenjang fw-bold" data-id="SDIT" style="cursor: pointer;" title="SDIT Madina"><i class="bi bi-house-check"></i>&nbsp;<b>SDIT</b></span>
            </div>
            <div class="col-4">
                <span class="unit_jenjang fw-bold" data-id="SMPIT" style="cursor: pointer;" title="SMPIT Madina"><i class="bi bi-house-up"></i>&nbsp;<b>SMPIT</b></span>
            </div>           
		</div>
      </div>
    </div>   

</body>
</html>

<script type="text/javascript">

    async function init_form() {
        var html ='<img class="img-width-header" src="<?php echo base_url() ?>images/images_bg/bg_pelajaran.jpg'+'?'+ new Date().getTime()+' alt="Notebook"">';   
        document.getElementById("img_header").innerHTML = html
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang   
        await fetch_data_tbl_pelajaran(kode_jenjang)
    }

    $(document).on('click','.unit_jenjang', function() {
        var unit = $(this).attr("data-id")
        window.location.href="<?php echo site_url('pelajaran/pelajaran/show_pelajaran');?>?kode_jenjang="+unit
    })

    function fetch_data_tbl_pelajaran(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('pelajaran/pelajaran/get_data_tbl_pelajaran') ;?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){  
            if (responseData.data[0].length>0){
                document.getElementById("div_pelajaran").innerHTML = responseData.data[0][0].pelajaran;
            }else{
                document.getElementById("div_pelajaran").innerHTML = ""
            }
           
            load_tbl_pelajaran(responseData);               
        });            
    }
    
    function load_tbl_pelajaran(data) {        
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-sticky" id="tbl_pelajaran">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>No</th>';
        html += '			<th>Kelas</th>';
        html += '           <th>Kelompok Pelajaran</th>';    
        html += '           <th>Pelajaran</th>';        
        html += '		</tr>';
        html += '   </thead>';      
       
        if(data.data2[0].length>0)
        {
            var kelompok_mapel_temp = '';
            var kelas_temp = '';
            html += '<tbody>';            
            for(var count = 0; count < data.data2[0].length; count++)
            {                             
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td style="max-width=30pt; text-align:center">'+data.data2[0][count].no_urut+'</td>';  //0 
                if( data.data2[0][count].kelas != kelas_temp ){
                    html += '   <td rowspan="'+data.data2[0][count].jml_kelas+'" style="text-align:center">'+data.data2[0][count].kelas+'</td>';
                }   
                if( data.data2[0][count].kelompok_mapel != kelompok_mapel_temp ){
                    html += '   <td rowspan="'+data.data2[0][count].jml+'" style="text-align:center">'+data.data2[0][count].kelompok_mapel+'</td>';
                }                
                html += '   <td style="text-align:center">'+data.data2[0][count].nama_pelajaran+'</td>';
                html += '</tr>';    
                
                kelas_temp = data.data2[0][count].kelas
                kelompok_mapel_temp = data.data2[0][count].kelompok_mapel                                                                                             
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("div_tbl_pelajaran").innerHTML = html;           
    }

</script> 

<style>

    .header_img{
        position: relative;
        width: 100%;
    }

    .header_img img{
        width:100%;
        display:block;
    }


    .img-width {
        width: 50%;       
    }

    .img-width-header {
        width: 100%;
        height: 50vh; 
        object-position: bottom;
        object-fit:cover;       
    }

    .text-banner{
        font-size: 50px;
        color:rgb(39, 77, 161)
    }

    /* ukuran HP */
    @media (max-width:768px){
        .img-width {           
            width: 100%;
            height: auto;
        }

        .img-width-header {      
            width: 100%;
            height: 160px;     
            font-size: 15px;    
        }

        .text-banner{
            font-size: 23px;
            color:rgb(39, 77, 161)
        }
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

    .footer2 {
        /* bottom: 0; */
        width: 100%;
        padding-top: 3px;
        padding-bottom: 35px;
        background-color:rgb(0, 0, 0, 0.5);
        color: white;
    }

    .header-text{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        color:black;
        font-size:50px;
        font-weight:bold;
        text-align:center;
    }
</style>