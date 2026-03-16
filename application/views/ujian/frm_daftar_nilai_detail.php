<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body>
    <body onload="init_form()"></body>    
    
    <div class="gradient-over-image">
        <!-- <h3 class="text-light">Daftar Nilai Detail</h3> -->
        <h3 class="text-light text-shadow-black"><span id="jenis_penilaian"></h3>
        <!-- <h3 class="text-light" ><span id="nama_mapel"></h3> -->       
        <h5 class="text-info text-shadow-black"><span id="deskripsi_thnajaran"></h5>
        <div class="row row-cols-1 row-cols-md-3 g-4" style="margin:5px; justify-content: center;" id="data_soal"></div>              
    </div>
    <br>
    <table class="table table-sm table-bordered table-sticky mx-auto fix-pos-table" style="width:70%; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">       
        <thead>
            <tr class="borderless-bottom">
                <td class="py-0" style="text-align:center">Jenis Soal</th>
                <td class="py-0" style="text-align:center">Jawaban Benar </th>
                <td class="py-0" style="text-align:center">Bobot Nilai/Soal</th>
                <td class="py-0" style="text-align:center">Nilai</th>                
            </tr>  
        </thead>        
        <tbody style="background-color: #FFFFFF">           
            <tr>
                <td class="py-0" style="text-align:center">Soal PG</th>
                <td class="py-0 text-primary w-25" style="text-align:center"><span id="jawaban_benar_pg"></span></td>
                <td class="py-0 text-primary w-25" style="text-align:center"><span id="bobot_nilai_pg"></span></td>
                <td rowspan="2" class="py-0 text-primary w-25" style="text-align:center; vertical-align:middle"><span id="nilai"></span></td>                
            </tr>
            <tr>
                <td class="py-0" style="text-align:center">Soal Uraian</th>
                <td class="py-0 text-primary w-25" style="text-align:center"><span id="jawaban_benar_uraian"></span></td>
                <td class="py-0 text-primary w-25" style="text-align:center"><span id="bobot_nilai_uraian"></span></td>                             
            </tr>
        </tbody>        
    </table>    

    <form action="post" id="simpan_form">
        <!-- <div class="container mt-5">  
            <table class="table table-sm" style="margin-bottom: 10px;">                
            </table>
        </div> -->

        <br>
        <div class="container">
            <button type="button" id="btn_kembali" class="btn btn-sm btn-dark btn-shadow" style="margin-left: 5px;"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
            
            <div style="line-height: 15px;"><br></div>
            <div class="tscroll">
                <div id="tbl_input_soal_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <br>
        </div>
    </form>
    
</body>
</html>

<script>
window.MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\\(', '\\)']],   // inline pakai $...$ atau \(...\)
    displayMath: [['$$', '$$'], ['\\[', '\\]']] // block pakai $$...$$
  },
  svg: { fontCache: 'global' }
};
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<script type="text/javascript">
    var user_id = '<?php echo $username ;?>'
    var status_user = '<?php echo $status_user ;?>'
    var nis = '<?php echo $nis ;?>'
    var bank_soal_id = '<?php echo $bank_soal_id ;?>'
    var thnajaran ,semester, kelas, subkelas, mapel, jenis_penilaian;
  
    async function init_form() {
        await fetch_data_bank_soal()
        await fetch_data_adm()        
        await fetch_tbl_soal()
        await fetch_nilai_siswa()
    }

    $(document).on('click', '#btn_kembali', function () {       
        window.location.href="<?php echo site_url('ujian/daftar_nilai/show_daftar_nilai') ;?>?thnajaran="+thnajaran
                                                                                    +"&semester="+semester
                                                                                    +"&kelas="+kelas
                                                                                    +"&subkelas="+subkelas
                                                                                    +"&mapel="+mapel
                                                                                    +"&jenis_penilaian="+jenis_penilaian+""                                                    
                                                                        
    })

    async function fetch_data_bank_soal() {
        var rs_bank_soal = await fetch('<?php echo site_url('ujian/bank_soal/get_data_bank_soal') ;?>?bank_soal_id='+bank_soal_id+'')
        var rs = await rs_bank_soal.json()
        if (rs.data.length>0 ){
            var data = rs.data[0]
            thnajaran = data['thnajaran_cls']
            semester = data['semester']
            kelas = data['kelas_cls']
            mapel = data['matapel_cls']
            jenis_penilaian = data['jenis_penilaian']
        }
    }

    async function fetch_nilai_siswa() {
        var rs_bank_soal = await fetch('<?php echo site_url('ujian/daftar_nilai/get_nilai_siswa') ;?>?bank_soal_id='+bank_soal_id+'&nis='+nis+'')
        var rs = await rs_bank_soal.json()  
        var data  = rs.data[0]          
        if(rs.data.length > 0){
            $('#jawaban_benar_pg').text(data['jawab_benar_pg']+"/"+data['jml_soal_pg']) 
            $('#jawaban_benar_uraian').text(data['jawab_benar_essai']+"/"+data['jml_soal_essai'])
            $('#bobot_nilai_pg').text(data['bobot_nilai_pg'])
            $('#bobot_nilai_uraian').text(data['bobot_nilai_essai'])
            $('#nilai').text(data['nilai'])
            subkelas = data['subkelas_cls']
        }else{
            subkelas = ''
        }
    }

    async function fetch_data_adm() {
        await fetch('<?php echo base_url()."index.php/ujian/jawab_soal/get_data_adm" ;?>?bank_soal_id='+bank_soal_id
                                                                                  +'&status_user='+status_user
                                                                                  +'&username='+nis+'')
        .then(response => response.json())
        .then( async (resultData) => {           
            var data = resultData.data    
            var nama = resultData.nama
           
            if(data.length> 0){

                kelas = await data[0]['kelas_cls']
                semester = await data[0]['semester']

                document.getElementById('jenis_penilaian').innerHTML = data[0]['deskripsi_penilaian']                  
                document.getElementById('deskripsi_thnajaran').innerHTML = 'TAHUN PELAJARAN ' + data[0]['deskripsi_thnajaran']       
                
                var html = '';
                html += '<div class="col" style="margin:0.5px;">';
                html += '   <table class="table mx-auto text-warning text-shadow-black" style="font-size:18px" >';
                html += '       <tr class="borderless-bottom" >';
                html += '           <td class="py-0" >Mata Pelajaran</td>';
                html += '           <td class="py-0" >: '+data[0]['deskripsi']+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0"  >Kelas / Semester</td>';
                html += '           <td class="py-0" >: '+data[0]['kelas_cls']+' / '+data[0]['semester']+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0"  >Guru Kelas</td>';
                html += '           <td class="py-0" >: '+data[0]['nama_guru']+'</td>';              
                html += '       </tr>';
                html += '   </table>';
                html += '</div>';
                html += '<div class="col " style="margin:0.5px;">';
                html += '   <table class="table mx-auto text-warning text-shadow-black" style="font-size:18px">';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0 text-nowrap">Nama Siswa</td>';
                html += '           <td class="py-0 text-nowrap">: '+nama+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0 text-nowrap">Waktu Pengerjaan</td>';
                html += '           <td class="py-0 text-nowrap">: <span id="span_waktu_pengerjaan"></span> menit</td>';              
                html += '       </tr>';
                html += '   </table>';
                html += '</div>';
                
                document.getElementById('data_soal').innerHTML = html;                
            }
        })
    }

    function fetch_tbl_soal() {       
        fetch('<?php echo site_url('ujian/daftar_nilai/get_data_soal') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian
                                                                    +'&nis='+nis+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data  
            load_tbl_soal(data)         
        })
    }

    function load_tbl_soal(data) {
        var html = '';             
        if(data.length>0)
        {           
            var no=0
            var jenis_soal =''      
            for(var count = 0; count < data.length; count++) {     
                no++                     
                html += '<table class="table table-sm table-sticky" id="tbl_input_soal">';
                html += '<tbody >';
               
                if(jenis_soal!=data[count].jenis_soal){   
                    no=1                
                    if (data[count].jenis_soal=='pg'){    
                        html += '<tr class="borderless-bottom"><td></td></tr>';                    
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0 width="50pt"><b class="text-primary teks-shadow">I</b></td>';
                        html += '   <td class="py-0 " colspan="2" style="min-width:30pt" class="text-nowrap"><b class="text-primary teks-shadow">SOAL PILIHAN GANDA</b></td>';                                        
                        html += '   <td colspan="2"></td>';
                        html += '</tr>';
                        html += '<tr class="borderless-bottom"><td></td></tr>';                       
                    }
                    if (data[count].jenis_soal=='essai'){
                        html += '<tr class="borderless-bottom"><td></td></tr>';     
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"><b class="text-primary teks-shadow">II</b></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><b class="text-primary teks-shadow">SOAL URAIAN</b></td>';                                        
                        html += '</tr>';
                        html += '<tr class="borderless-bottom"><td></td></tr>';      
                    }
                }
               
                
                    html += '<tr id="'+ no +'" class="borderless-bottom">';
                    html += '   <td class="py-0" width="30pt">'+no+'</td>';
                    html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap">'+data[count].pertanyaan+'</td>';
                    html += '</tr>';                    
                    if (data[count].img_path!=null&&data[count].img_path!=''){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                if (data[count].jenis_soal=='pg'){
                    //JAWABAN A
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" width="30pt">a</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_a+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_a){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_a + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    //JAWABAN B
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >b</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_b+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_b){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_b + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    //JAWABAN C
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >c</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_c+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_c){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_c + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    //JAWABAN D
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >d</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_d+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_d){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_d + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" width="30pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    
                    if(data[count].nilai_bobot>0){
                        html += '   <td class="py-0" colspan="2"><b>Jawaban</b> : '+data[count].jawaban+' &nbsp;<i class="bi bi-circle-fill" style="color: green;"></td>';  
                        
                    }else{
                        html += '   <td class="py-0" colspan="2"><b>Jawaban</b> : '+data[count].jawaban+' &nbsp;<i class="bi bi-circle-fill" style="color: red;"></td>';                          
                    }
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" colspan="2"><b>Kunci jawaban</b> : '+data[count].kunci_jawaban+'</td>';  
                    html += '   <td class="py-0"></td>';
                    html += '</tr>';
                }
                if (data[count].jenis_soal=='essai'){
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0" ></td>';    
                    if(data[count].nilai_bobot>0){   
                    html += '   <td class="py-0"><b>Jawaban</b> : '+data[count].jawaban+' &nbsp;<i class="bi bi-circle-fill" style="color: green;"></td>';                      
                    }else{
                    html += '   <td class="py-0"><b>Jawaban</b> : '+data[count].jawaban+' &nbsp;<i class="bi bi-circle-fill" style="color: red;"></td>';                      
                    }
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0" ></td>';       
                    html += '   <td class="py-0" width="50pt" colspan="2"><b>Kata Kunci 1</b> : '+data[count].kata_kunci_1+'</td>';                      
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0" ></td>';  
                    html += '   <td class="py-0" width="50pt" colspan="2"><b>Kata Kunci 2</b> : '+data[count].kata_kunci_2+'</td>';                      
                    html += '</tr>';
                }
                
                jenis_soal = data[count].jenis_soal;
                
                
                html += '</tbody>';
                html += '</table>';                 
            }            
           
        }       
                                
        document.getElementById("tbl_input_soal_div").innerHTML = html;
        MathJax.typesetPromise();
    }

</script>

<style>
     .gradient-over-image {
        background-color: #004f8c;
        width: 100%;
        height: 260px;
        margin: 0px auto;
        padding-top: 80px;
        color: white; /* Biar tulisan kelihatan */
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);

        /* --- Lapisan Background --- */
        background-image:
            /* 1. Lapisan Gradien (harus transparan agar pola di bawahnya terlihat) */            
            /*linear-gradient(to right, rgba(189, 97, 81, 0.7), rgba(175, 33, 23, 0.7)),*/ /* Pink ke Biru Langit, dengan transparansi 70% */
            /* 2. Lapisan Pola Gambar (ini di bawah gradien) */
            url('http://www.transparenttextures.com/patterns/clean-textile.png'); /* Contoh URL pola, ganti dengan milikmu */

        background-size:
            auto,          /* Gradien akan mengisi penuh area */
            100px 100px;   /* Ukuran satu unit pola gambar (sesuaikan) */

        background-repeat:
            /*no-repeat,*/     /* Gradien tidak perlu diulang */
            repeat;        /* Pola gambar akan diulang */

        /* Opsional: Mode pencampuran warna antar lapisan */
        background-blend-mode: overlay; /* Coba juga 'multiply' atau 'screen' */
    }

    .table th, .table td {
        text-align: left;
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }

    .img-width {
        width: 200pt;
        height: 200ptt;
        border-radius: 10px;
        box-shadow: 1px 2px 5px #000000;   
        margin-bottom: 10px;
    }
    
</style>