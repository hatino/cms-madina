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
        <h3 class="text-light header_center">Daftar Soal &nbsp;<span id="nama_mapel"></h3>
        <h5 class="text-header header_center"><span id="deskripsi_thnajaran"></h5>
        <h5 class="text-header header_center">Semester <?php echo $semester ;?></h5>
        <h5 class="text-header header_center">Kelas <?php echo $kelas ;?></h5>
    </div>

    <br>
    <form action="post" id="simpan_form">
        <div class="container">   
        <!-- <div class="container mt-5">            -->          
                                  
            <!-- <hr> -->
            <button type="button" id="btn_tambah" class="btn btn-sm btn-primary btn-shadow"><i class="bi bi-file-earmark-plus"></i>&nbsp;Tambah Soal</button>
            <button type="button" id="btn_kembali" class="btn btn-sm btn-dark btn-shadow" style="margin-left: 5px;"><i class="bi bi-back"></i>&nbsp;Kembali</button>   

            <div style="line-height: 15px;"><br></div>
            <div class="tscroll">
                <div id="tbl_input_soal_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <br>

            <!-- <div class="row row-col-1">
                <div class="col">
                    <div class="row">
                        <div class="col-3"><h5 >Mapel</h5></div>
                        <div class="col-1"><h5 >:</h5></div>
                        <div class="col"><h5 ><span id="nama_mapel"></h5></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><h5 >Kelas</h5></div>
                        <div class="col-1"><h5 >:</h5></div>
                        <div class="col"><h5 ><?php echo $kelas;?></h5></div>
                    </div>     
                </div>
                <div class="col">
                </div>                
            </div> -->
            
           
        </div>
    </form>

    <!-- The Modal-->
    <div class="modal fade" id="modal_tipe_soal" role="dialog" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header " style="background-color: #006DCC;;">                 
                <h5 class="modal-title text-white font-effect-emboss" style="font-size: 20px; " >Pilih Tipe Soal</h5>                 
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">          
                                                    
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="rb_pilihan" id="rb_pilihan_ganda" value="pg" checked>
                    <label class="form-check-label" for="rb_pilihan_ganda">PILIHAN GANDA</label>
                    </div>
                    <br>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="rb_pilihan" id="rb_essai" value="essai">
                    <label class="form-check-label" for="rb_essai">URAIAN</label>
                    </div>
                            
                </div>                    
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">   
                <div class="container">  
                    <div class="row">
                        <div class="col-sm-6" style="display:flex; justify-content: left; align-items: left;">
                            <button type="button" id="btn_pilih" class="btn btn-sm btn-submit"><i class="bi bi-check2-square"></i>&nbsp;Pilih</button>
                        </div>
                        <div class="col-sm-6" style="display:flex; justify-content: right; align-items: right;">
                            <button type="button" id="btn_kembali_modal" class="btn btn-sm btn-secondary"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
                        </div>           
                    </div>
                </div>                    
            </div>

        </div>
    </div>
    </div>

    <button type="button" class="transparent" onclick="topFunction()" id="myBtn" title="Pindah ke halaman atas"></button>
</body>
</html>

<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
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

<script  type="text/javascript">

    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var kelas = '<?php echo $kelas ;?>'
    var mapel = '<?php echo $mapel ;?>'  
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    var bank_soal_id = '<?php echo $bank_soal_id ;?>'
    var status_soal = '<?php echo $status_soal ;?>'
    var status_pg = '0'
   
    if(status_soal=='1'){ //soal sudah complete : sudah diinput sesuai jumlah di master
        $('#btn_tambah').css('display','none')
    }else{
         $('#btn_tambah').css('display','inline')
    }
    
    async function init_form() {         
        var nama_mapel = await get_nama_mapel(mapel)
        var deskripsi_thnajaran = await get_deskripsi_thnajaran(thnajaran)               
        document.getElementById('nama_mapel').innerHTML = nama_mapel
        document.getElementById('deskripsi_thnajaran').innerHTML = deskripsi_thnajaran
        await fetch_tbl_soal()
        await get_status_pg()        
    }
    
    async function get_status_pg() {
        var rs_status_pg = await fetch('<?php echo site_url('ujian/master/get_status_mapel_pg') ;?>?list_kelas='+kelas
                                                                                            +'&list_semester='+semester
                                                                                            +'&list_mapel='+mapel+''
                                                                                            ,{method:"GET", mode: "no-cors" })
        var rs = await rs_status_pg.json() 
        status_pg = rs.data
    }


    async function get_nama_mapel(mapel) {
        var rs_mapel = await fetch('<?php echo site_url('ujian/input_soal/get_nama_mapel') ;?>?mapel='+mapel+'',{method:"GET", mode: "no-cors" })
        var rs = await rs_mapel.json() 
        var nama_mapel = ''       
        if (rs.data.length>0){
            nama_mapel = rs.data[0].deskripsi            
        }
        return nama_mapel
    }

    async function get_deskripsi_thnajaran(thnajaran) {        
        var rs_thnajaran = await fetch('<?php echo site_url('ujian/input_soal/get_deskripsi_thnajaran') ;?>?thnajaran='+thnajaran+'',{method:"GET", mode: "no-cors" })
        var rs = await rs_thnajaran.json()        
        var deskripsi_thnajaran = ''       
        if (rs.data.length>0){
            deskripsi_thnajaran = 'Tahun Pelajaran '+rs.data[0].deskripsi            
        }
        return deskripsi_thnajaran
    }

    $(document).on('click', '#btn_tambah', function() {
        if(status_pg=="1"){
            window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal_pg')?>?thnajaran="+thnajaran
                                                                                        +"&semester="+semester
                                                                                        +"&kelas="+kelas
                                                                                        +"&mapel="+mapel
                                                                                        +"&jenis_penilaian="+jenis_penilaian
                                                                                        +"&bank_soal_id="+bank_soal_id
                                                                                        +"&soal_pg_id=0"
        }else{
            $('#modal_tipe_soal').modal('show')
        }        
    })

    $(document).on('click', '#btn_kembali_modal', function () {        
        $('#modal_tipe_soal').modal('hide')   
    })
    
    $(document).on('click', '#btn_kembali', function () {        
        //history.back()  
        window.location.href="<?php echo site_url('ujian/bank_soal/show_bank_soal')?>?thnajaran="+thnajaran
                                                                                    +"&semester="+semester
                                                                                    +"&kelas="+kelas
                                                                                    +"&mapel="+mapel
                                                                                    +"&jenis_penilaian="+jenis_penilaian
    })

    $(document).on('click', '#btn_edit', function (event) {   
        var soal_id = $(this).attr("data-id")
        var jenis_soal = $(this).attr("data-jenis")
      
        if(jenis_soal=='pg'){
            window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal_pg')?>?thnajaran="+thnajaran
                                                                                            +"&semester="+semester
                                                                                            +"&kelas="+kelas
                                                                                            +"&mapel="+mapel
                                                                                            +"&jenis_penilaian="+jenis_penilaian
                                                                                            +"&bank_soal_id="+bank_soal_id
                                                                                            +"&soal_pg_id="+soal_id+""
        }
        if(jenis_soal=='essai'){
            window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal_essai')?>?thnajaran="+thnajaran
                                                                                        +"&semester="+semester
                                                                                        +"&kelas="+kelas
                                                                                        +"&mapel="+mapel
                                                                                        +"&jenis_penilaian="+jenis_penilaian
                                                                                        +"&bank_soal_id="+bank_soal_id
                                                                                        +"&soal_essai_id="+soal_id+""
        }
         
                                                                                        
    })

    $(document).on('click', '#btn_delete', function () { 
        var soal_id = $(this).attr("data-id") 
        var jenis_soal = $(this).attr("data-jenis")

        var confirm_del = confirm('Apakah Anda yakin ingin menghapus data?')
        if (confirm_del==false){
            return false
        }

        const form_data = new FormData();

        if (jenis_soal=='pg'){
            form_data.append('soal_pg_id', soal_id);
            
            fetch('<?php echo site_url('ujian/input_soal/delete_soal_pg') ;?>',{
                        method: 'POST',   
                        body: new URLSearchParams(form_data)
                        //headers: {'Content-Type': 'multipart/form-data'},                    
                    })
            .then(response => response.json()) 
            .then( async dataResult => {
                    if (dataResult.status == false){
                        alert(dataResult.message);                   
                    }else{
                        alert(dataResult.message);               
                        fetch_tbl_soal()                                                                                   
                    }                
                })
            .catch(err => {
                alert(err);
            });   
        }
        if (jenis_soal=='essai'){
            form_data.append('soal_essai_id', soal_id);
            
            fetch('<?php echo site_url('ujian/input_soal/delete_soal_essai') ;?>',{
                        method: 'POST',   
                        body: new URLSearchParams(form_data)
                        //headers: {'Content-Type': 'multipart/form-data'},                    
                    })
            .then(response => response.json()) 
            .then( async dataResult => {
                    if (dataResult.status == false){
                        alert(dataResult.message);                   
                    }else{
                        alert(dataResult.message);               
                        fetch_tbl_soal()                                                                                   
                    }                
                })
            .catch(err => {
                alert(err);
            });   
        }
        
    })

    $(document).on('click', '#btn_pilih', function () {
        const pilihan = document.querySelector('input[name="rb_pilihan"]:checked');
        var id = pilihan.id
        
        if(id=='rb_pilihan_ganda'){
            window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal_pg')?>?thnajaran="+thnajaran
                                                                                        +"&semester="+semester
                                                                                        +"&kelas="+kelas
                                                                                        +"&mapel="+mapel
                                                                                        +"&jenis_penilaian="+jenis_penilaian
                                                                                        +"&bank_soal_id="+bank_soal_id
                                                                                        +"&soal_pg_id=0"
        }
        if(id=='rb_essai'){
            window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal_essai')?>?thnajaran="+thnajaran
                                                                                        +"&semester="+semester
                                                                                        +"&kelas="+kelas
                                                                                        +"&mapel="+mapel
                                                                                        +"&jenis_penilaian="+jenis_penilaian
                                                                                        +"&bank_soal_id="+bank_soal_id
                                                                                        +"&soal_pg_id=0"
        }
    })

    function fetch_tbl_soal() {       
        fetch('<?php echo site_url('ujian/input_soal/get_data_tbl_soal') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +"&jenis_penilaian="+jenis_penilaian+'')
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
            console.log(data)
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
                    html += '   <td class="py-0" width="50pt">'+no+'</td>';
                    html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap">'+data[count].pertanyaan+'</td>';
                    html += '   <td class="fix_width_col2"><button type="button" id="btn_edit" class="btn btn-sm btn-shadow btn-success" data-id='+data[count].id+' data-jenis='+data[count].jenis_soal+' title="Edit"><i class="bi bi-pencil-square"></i></button></td>';
                    html += '   <td class="fix_width_col2"><button type="button" id="btn_delete" class="btn btn-sm btn-shadow btn-danger" data-id='+data[count].id+' data-jenis='+data[count].jenis_soal+' title="Hapus"><i class="bi bi-trash"></i></button></td>';               
                    html += '</tr>';
                    
                    if (data[count].img_path!=null&&data[count].img_path!=''){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path + '?'+ new Date().getTime() ;  
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                if (data[count].jenis_soal=='pg'){
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" width="50pt">a</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_a+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_a){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_a + '?'+ new Date().getTime() ;                         
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >b</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_b+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_b){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_b + '?'+ new Date().getTime() ;                          
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >c</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_c+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_c){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_c + '?'+ new Date().getTime() ;                          
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }

                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" >d</td>';  
                    html += '   <td class="py-0">'+data[count].jawaban_d+'</td>';
                    html += '</tr>';
                    if (data[count].img_path_jawaban_d){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path_jawaban_d + '?'+ new Date().getTime() ;                          
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0" width="50pt"></td>';
                        html += '   <td class="py-0" colspan="2" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                     
                        html += '</tr>';
                    }
                    
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';       
                    html += '   <td class="py-0" colspan="2"><b>Kunci jawaban : '+data[count].kunci_jawaban+'</b></td>';  
                    html += '   <td class="py-0"></td>';
                    html += '</tr>';
                }
                if (data[count].jenis_soal=='essai'){
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0" ></td>';       
                    html += '   <td class="py-0" width="50pt" colspan="2"><b>Kata Kunci 1 : '+data[count].kata_kunci_1+'</b></td>';                      
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0" ></td>';       
                    html += '   <td class="py-0" width="50pt" colspan="2"><b>Kata Kunci 2 : '+data[count].kata_kunci_2+'</b></td>';                      
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

    // Get the button
    let mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    var path_arrows = "<?php echo base_url() ?>" +'./images/images_ui/up-arrows.png';	
    $('#myBtn').append("<img src='"+ path_arrows + "' width='30' height='30'>");	
    
</script>

<style>
    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
    .header_center {
        display: flex;
        justify-content: center; /* Center the content horizontally */
        align-items: center; /* Vertically align items if needed */        
    }
    .modal-header {       
        padding: 0.5rem;
        text-align: center;
        display:flex; 
        justify-content: center; 
        align-items: center;    
    }
    .fix_width_col2 {
        width: 40px;
        text-align: center;
    }
    .img-width {
        width: 200pt;
        height: 200ptt;
        border-radius: 10px;
        box-shadow: 1px 2px 5px #000000;   
        margin-bottom: 10px;
    }

    .teks-shadow {
        /* color:rgb(152, 154, 156); */
        text-shadow: 1px 1px 0px rgb(179, 175, 175); /* Efek timbul sederhana */
    }

    .gradient-over-image {
        width: 100%;
        height: 260px;
        margin: 0px auto;
        padding: 80px;
        color: white; /* Biar tulisan kelihatan */
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);

        /* --- Lapisan Background --- */
        background-image:
            /* 1. Lapisan Gradien (harus transparan agar pola di bawahnya terlihat) */
            /*linear-gradient(to right, rgba(255, 105, 180, 0.7), rgba(0, 191, 255, 0.7)),*/ /* Pink ke Biru Langit, dengan transparansi 70% */
            linear-gradient(to right, rgba(189, 133, 81, 0.7), rgba(134, 50, 10, 0.7)), /* Pink ke Biru Langit, dengan transparansi 70% */
            /* 2. Lapisan Pola Gambar (ini di bawah gradien) */
            url('https://www.transparenttextures.com/patterns/wood-pattern.png'); /* Contoh URL pola, ganti dengan milikmu */

        background-size:
            auto,          /* Gradien akan mengisi penuh area */
            100px 100px;   /* Ukuran satu unit pola gambar (sesuaikan) */

        background-repeat:
            no-repeat,     /* Gradien tidak perlu diulang */
            repeat;        /* Pola gambar akan diulang */

        /* Opsional: Mode pencampuran warna antar lapisan */
        background-blend-mode: overlay; /* Coba juga 'multiply' atau 'screen' */
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
    
    
</style>