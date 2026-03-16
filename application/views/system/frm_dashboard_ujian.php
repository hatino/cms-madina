<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script>     
   
</head>
<body>
    <body onload="init_form()"></body>

    <div class="container-fluid bg-login" id="bg_image" style="padding: 100px;">
        <!-- <div class="justify-content-md-center"> -->
            
                    <div class="row row-cols-1 row-cols-md-3 g-4" style="margin:5px;" id="data_soal"></div>
              
                    <div class="row row-cols-1 row-cols-md-3 g-4" id="data_ujian"></div>
                    <div class="row row-cols-1 row-cols-md-3 g-2" style="margin-top: 10px;">
                         <div id="data_nilai"></div>
                    </div>
                   
              
        <!-- </div> -->
    </div>
        
</body>
</html>

<script type="text/javascript">
    var user_id = '<?php echo $username ;?>'
    var status_user_login = '<?php echo $status_user_login ;?>'
    // console.log(user_id)
    // console.log(status_user_login)

    function init_form() {         
        const lebar = window.innerWidth;
        const tinggi = window.innerHeight;
        //const body = document.getElementsByClassName("bg-login");
        if (lebar < 768) {  // Misalnya, di bawah 768px dianggap ponsel
            // return "Ponsel: " + lebar + "px x " + tinggi + "px";           
            $('#bg_image').addClass("bg-image-style-hp")
            // var html = "<div style='background: url('<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg?v=" . time());?>');'></div>";
            // document.getElementById("bg_image").innerHTML = html; 
          
            const elemen = document.getElementById("bg_image");
            const baseUrl = "<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg");?>";
        
            // Tambahkan timestamp dari JavaScript
            elemen.style.backgroundImage = `url(${baseUrl}?${new Date().getTime()})`;
            
        } else {             
            //return "Laptop/Desktop: " + lebar + "px x " + tinggi + "px";
            $('#bg_image').addClass("bg-image-style-komp")
            // var html = "<div style='background: url('<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg?v=" . time());?>');'></div>";
            // document.getElementById("bg_image").innerHTML = html; 
            
            const elemen = document.getElementById("bg_image");
            const baseUrl = "<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg");?>";
        
            // Tambahkan timestamp dari JavaScript
            elemen.style.backgroundImage = `url(${baseUrl}?${new Date().getTime()})`;
        
        }

        if(status_user_login=='guru'||status_user_login=='admin'){
            load_data_soal()
        }
        if(status_user_login=='siswa'){
            load_data_ujian()
            load_data_nilai()
        }
        
        <?php simpan_kunjungan(); ?>
    }    

    function load_data_soal() {
        fetch('<?php echo site_url('ujian/input_soal/get_data_soal_dashboard') ;?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data      
            console.log(data)               
            var html = '';   
            if(data.length>0) {           
                var jenis_penilaian = '';
                var jenjang = '';
                var no=0
                                    
                for(var count = 0; count < data.length; count++) {     
                    no++              
                   
                    if(jenis_penilaian!=data[count].jenis_penilaian || jenjang != data[count].group_cls){                            
                        html += '<div class="col" style="margin:5px;">';
                        html += '<div class="my-custom-card card" style="cursor: pointer;" data-modul="bank_soal" data-thnajaran="'+data[count].thnajaran_cls+'" data-jenispenilaian="'+data[count].jenis_penilaian+'" data-semester="'+data[count].semester+'" data-jenjang="'+data[count].group_cls+'" >';                   
                        html += '    <div class="d-flex flex-row">';
                        html += '        <div class="card-body">';
                        html += '           <h5 class="card-title text-light" style="text-align: center;">Bank Soal '+data[count].jenis_penilaian.toUpperCase()+' </h5>';
                        html += '           <table class="table table-sm table-bordered" id="tbl_bank_soal">';            
                        html += '	            <thead class="col-form-label-sm text-light">';                                
                        html += '		            <tr >';    
                        html += '			            <th class="col-2" style="vertical-align: middle; text-align:center;">Kelas</th>';
                        html += '			            <th class="col-4">Jumlah Soal</th>';            
                        html += '		            </tr>';       		
                        html += '               </thead>';      
                        html += '               <tbody class="col-form-label-sm">';                          
                    }
                    html += '               <tr id="'+ no +'">';
                    html += '                   <td class="col-2 text-nowrap text-light text-shadow-black" style="vertical-align: middle; text-align:center;">'+data[count].kelas_cls+'</td>';  //1
                    html += '                   <td class="col-4 text-light text-shadow-black" style="vertical-align: middle; text-align:center;" >'+data[count].jml_soal+'</td>';                    
                    html += '               </tr>'; 
                    
                    jenis_penilaian = data[count].jenis_penilaian    
                    jenjang = data[count].group_cls

                    ir_plus = count + 1
                    if(ir_plus < data.length){
                        if(jenis_penilaian!=data[ir_plus].jenis_penilaian || jenjang != data[ir_plus].group_cls){
                            html += '               </tbody>'; 
                            html += '           </table>'; 
                            html += '       </div>';
                            html += '   </div>';
                            html += '</div>';
                            html += '</div>';
                        }
                    }else{
                        html += '               </tbody>'; 
                        html += '           </table>'; 
                        html += '       </div>';
                        html += '   </div>';
                        html += '</div>';
                        html += '</div>';
                    }
                }    
            }
            
                                    
            document.getElementById("data_soal").innerHTML = html;  
        })
    }

    function load_data_ujian() {
        fetch('<?php echo site_url('ujian/jadwal_ujian/get_data_jadwal_dashboard') ;?>?user_id='+user_id+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            console.log(data)
            var html = '';      
            if(data.length>0)
            {           
                var no=0       
                for(var i = 0; i < data.length; i++) {    
                    var jam_mulai_temp = data[i]['jam_mulai']
                    var jam_mulai = jam_mulai_temp.substr(11,5)
                    var jam_selesai_temp = data[i]['jam_selesai']
                    var jam_selesai = jam_selesai_temp.substr(11,5)
                   
                    no++              
                    html += '<div class="col" style="margin:5px;">';
                    html += '<div class="my-custom-card card" style="cursor: pointer;" id="'+data[i]['bank_soal_id']+'" data-modul="jawab_soal">';                   
                    html += '    <div class="d-flex flex-row">';
                    html += '        <div class="card-body">';
                    html += '           <h3 class="text-shadow-black card-title text-warning" style="text-align: center;">'+data[i]['jenis_penilaian'].toUpperCase()+'</h3>';
                    html += '           <h5 class="text-shadow-black text-light" style="text-align: center;">'+data[i]['deskripsi']+'</h5>';
                    html += '           <h5 class="text-shadow-black text-info " style="text-align: center;">Jam : '+jam_mulai+' s.d '+jam_selesai+'</h5>';
                    html += '       </div>';
                    html += '   </div>';
                    html += '</div>';
                    html += '</div>';                    
                }
            }
           
                                    
            document.getElementById("data_ujian").innerHTML = html;  
        })
    }

    function load_data_nilai() {
        fetch('<?php echo site_url('ujian/daftar_nilai/get_data_nilai_dashboard') ;?>?user_id='+user_id+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            console.log(data)
            var html = '';      
            if(data.length>0)
            {   
                for(var i = 0; i < data.length; i++) {  
                    //html += '<div class="col">';
                    html += '<div class="my-custom-card-black card" >';                   
                    //html += '    <div class="d-flex flex-row">';
                    html += '        <div class="card-body text-center">';
                    html += '           <h5 class="text-shadow-black card-title text-warning" style="text-align: center;">Daftar Nilai</h5>';
                    html += '           <h5 class="text-shadow-black text-light" style="text-align: center;">'+data[i]['deskripsi']+' : '+data[i]['nilai'].slice(0,2)+'</h5>';
                    html += '           <button type="button" class="btn btn-sm btn-info text-white" id="btn_detail_nilai" data-modul="daftar_nilai" data-jenis_penilaian="'+data[i]['jenis_penilaian']+'" data-semester="'+data[i]['semester']+'" data-thnajaran="'+data[i]['thnajaran_cls']+'" style="cursor: pointer;">Detail</button>';
                    html += '       </div>';
                    //html += '   </div>';
                    html += '</div>';
                    //html += '</div>';                    
                }
            }                       
            document.getElementById("data_nilai").innerHTML = html;  
        })
    }
    
    $(document).on('click', '.card', function () {
        var modul = $(this).attr('data-modul')
        if(modul=='jawab_soal'){
            var id = $(this).attr("id")
            window.location.href="<?php echo site_url('ujian/jawab_soal/show_jawab_soal') ;?>?id="+id;
        }
        if(modul=='bank_soal'){
            var jenis_penilaian = $(this).attr('data-jenispenilaian')
            var thnajaran = $(this).attr('data-thnajaran')
            var semester = $(this).attr('data-semester')
            var jenjang = $(this).attr('data-jenjang')           
            window.location.href="<?php echo site_url('ujian/bank_soal/show_bank_soal') ;?>?jenis_penilaian="+jenis_penilaian
                                                                                            +"&thnajaran="+thnajaran
                                                                                            +"&semester="+semester
                                                                                            +"&jenjang="+jenjang+"";
        }               
    })

    $(document).on('click','#btn_detail_nilai', function () {
        var thnajaran = $(this).attr('data-thnajaran')
        var jenis_penilaian = $(this).attr('data-jenis_penilaian')
        var semester =  $(this).attr('data-semester')
        var params = new URLSearchParams()
        params.append('thnajaran', thnajaran)
        params.append('jenis_penilaian', jenis_penilaian)
        params.append('semester', semester)
        window.location.href="<?php echo site_url('ujian/daftar_nilai/show_daftar_nilai_siswa') ;?>?"+params.toString()
    })
   
    
</script>

<style>
        .bg-image-style-hp{
            /* background: url(<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg");?>) no-repeat;  */
            width: 100%; height: 100vh;
            background-size: 260%;    
            background-position:top center;     
        }

        .bg-image-style-komp{
            /* background: url(<?php echo base_url("images/images_ui/bg_dashboard_ujian2.jpg");?>+ new Date().getTime()) no-repeat;  */
            width: 100%; height: 100vh;
            background-size: 100%;         
            background-position:center;     
        }

        /* CSS kustom untuk mempercantik dan memberi ukuran pada card */
        .my-custom-card {
            max-width: 400px; /* Batasi lebar card agar tidak terlalu lebar */
            margin: 0px auto; /* Posisi di tengah halaman */
            /*box-shadow: 0 4px 8px rgba(0,0,0,0.1);*/ /* Tambah bayangan */
            box-shadow: 1px 2px 5px rgb(54, 53, 53);
            border-radius: 10px; /* Sudut membulat */
            overflow: hidden; /* Penting untuk gambar yang membulat */
            /* RGB untuk warna hitam, nilai alpha 0.5 (50% transparan) */
            background-color: rgba(0, 0, 0, 0.5);
            /* RGB untuk warna putih, nilai alpha 0.2 (20% transparan) */
            background-color: rgba(255, 255, 255, 0.4);
            /* Border dengan warna putih dan alpha 0.5 */
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .my-custom-card-black {
            max-width: 400px; /* Batasi lebar card agar tidak terlalu lebar */
            margin: 0px auto; /* Posisi di tengah halaman */
            /*box-shadow: 0 4px 8px rgba(0,0,0,0.1);*/ /* Tambah bayangan */
            box-shadow: 1px 2px 5px rgb(54, 53, 53);
            border-radius: 10px; /* Sudut membulat */
            overflow: hidden; /* Penting untuk gambar yang membulat */
            /* RGB untuk warna hitam, nilai alpha 0.5 (50% transparan) */
            background-color: rgba(0, 0, 0, 0.3);            
            /* Border dengan warna putih dan alpha 0.5 */
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .card-img-left {
            width: 35%; /* Atur lebar gambar relatif terhadap card */
            height: 150px; /* Atur tinggi gambar */
            object-fit: cover; /* Pastikan gambar mengisi area tanpa terdistorsi */
            border-top-left-radius: 10px; /* Sudut bulat hanya di kiri atas */
            border-bottom-left-radius: 10px; /* Sudut bulat hanya di kiri bawah */
        }

        /* Responsif: Gambar akan di atas teks di layar kecil */
        @media (max-width: 767.98px) {
            .card-img-left {
                width: 100%; /* Gambar akan mengambil lebar penuh */
                height: 200px; /* Tinggi gambar di mobile */
                border-top-left-radius: 10px;
                border-top-right-radius: 10px; /* Bulatkan sudut atas */
                border-bottom-left-radius: 0; /* Hilangkan bulatan di bawah kiri */
            }
            .my-custom-card .d-flex {
                flex-direction: column; /* Ubah flex menjadi kolom di mobile */
            }
             .my-custom-card .card-body {
                width: 100%; /* Konten card mengambil lebar penuh */
            }
        }

        .text-shadow-black {
            /* font-size: 20px; */
            /* font-weight: bold; */            
            /* text-shadow: offset-x offset-y blur-radius color; */
            text-shadow: 0 0 5px black; /* Blue glow */
                         /*0 0 20px #00f;*/ /* Tambahan glow untuk efek lebih intens */
        }

        .text-shadow-white {            
            text-shadow: 0 0 5px white; 
        }

</style>