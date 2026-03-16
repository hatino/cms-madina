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
        <img class="responsive" src="<?php echo base_url() ?>images/images_bg/header_bg_observasi.jpg" alt="Notebook" style="width:100%;">      
        <div class="centered" style="color: white; text-align:center; "><p><span style="font-size: 30px; white-space: nowrap"><h2><b>Hasil Observasi <span id="span_nama_unit"></span></b><h2></span></p></div>      
    </div>
    <div style="line-height: 10px;"><br></div>
    
    <div class="container">
        <div id="div_hasil_observasi"></div>
        <br>
        <br>
    </div>
</body>
</html>

<script type="text/javascript">

    async function init_form() {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'   
        document.getElementById("span_nama_unit").innerHTML = kode_jenjang   
        await fetch_data_hasil_observasi()
        <?php simpan_kunjungan(); ?>
    }

    function fetch_data_hasil_observasi() {    
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'     
        fetch('<?php echo site_url('pendaftaran/pendaftaran/get_data_hasil_observasi') ;?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
			return response.json();    
		}).then(function (responseData) 
		{          
            var html ='';                
            var data = responseData.data     
            console.log(data)      
			if (data.length>0){       
                var thn_ajaran_cls = '';
                
                for (let i = 0; i < data.length; i++) {
                    if(data[i].thn_ajaran_cls!=thn_ajaran_cls && thn_ajaran_cls!='' ) {
                        html +=' </tbody>'; 
                        html +=' </table>';
                        html +='<br>';
                        html +='<br>';
                    }
                    if(data[i].thn_ajaran_cls!=thn_ajaran_cls ) {
                        html += '<h4 class="text-header" style="text-align:left;" >'+data[i].thn_ajaran_nama+'</h4>';
                        html += '<hr style="margin-top:5px;">';        

                        html +=' <p class="card-text" style="margin-bottom:3px;">'+data[i].deskripsi+'</p>';   
                       
                        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_daftar_calon_siswa">';            
                        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
                        html += '		<tr class="text-nowrap">';    
                        html += '			<th>No.</th>';                                    
                        html += '			<th>Siswa ID</th>';
                        html += '			<th>Nama</th>';
                        html += '			<th>Alamat</th>';
                        html += '		</tr>';
                        html += '   </thead>';  
                        html += '<tbody>';     
                    }

                    html += '<tr class = "col-form-label-sm">';   
                    html += '   <td style="max-width:30pt">'+data[i].no_urut+'</td>';  //0   
                    html += '   <td style="min-width:30pt">'+data[i].siswa_id+'</td>';          
                    html += '   <td style="min-width:30pt">'+data[i].nama+'</td>';  //0               
                    html += '   <td>'+data[i].alamat+'</td>';
                    html += '</tr>';                      
                    
        
        // if(data.length>0)
        // {           
                    
        //     for(var count = 0; count < data.length; count++)
        //     {     
                                                                                            
        //     }
        //     html += '</tbody>';      
        //     //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        // }         
        
        // html += '</table>';
                    
                      
                   
                    
                    thn_ajaran_cls = data[i].thn_ajaran_cls;
                }
                console.log(html)
                document.getElementById("div_hasil_observasi").innerHTML = html  
            } 
            
		});   
    }
</script>

<style>
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
</style>