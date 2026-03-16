<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body>
    <body onload="init_form()"></body>    
    <br>

    <form action="post" id="simpan_form">
        <div class="container mt-5">  
            <h3 class="text-header">Bank Soal</h3>

                <table class="table table-sm" style="margin-bottom: 10px;">                
                    <tr class="borderless-bottom" id="tr_thnajaran">
                        <td width="180">                     
                            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Thn Ajaran</label>            
                        </td>            
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_thnajaran_div"></div>
                        </td>        
                    </tr>

                    <!--Jenjang Pendidikan-->
                    <tr  class="borderless-bottom" id="tr_jenjang">
                        <td width="180">                        
                            <label for="list_jenjang" class="col-sm col-form-label col-form-label-sm">Jenjang Pendidikan</label>
                        </td>
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_jenjang_div"></div>
                        </td>
                    </tr>        
                    <!-- kelas -->
                    <tr class="borderless-bottom">
                        <td>                       
                            <label for="list_kelas" class="col-sm col-form-label col-form-label-sm">Kelas</label>                                        
                        </td>
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_kelas_div"></div>
                        </td>
                    <tr>
                    <!-- Semester -->
                    <tr class="borderless-bottom">
                        <td>                               
                            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Semester</label>                                                        
                        </td>
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_semester_div"></div>
                        </td>
                    </tr>
                    <!-- Jenis Penilaian -->
                    <tr class="borderless-bottom">
                        <td>                               
                            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Jenis Penilaian</label>                                                        
                        </td>
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_jenis_penilaian_div"></div>
                        </td>
                    </tr>                   
                </table>                    

            <button type="button" id="btn_tambah" class="btn btn-sm btn-primary btn-default" style="margin-right: 10px;"><i class="bi bi-file-earmark-plus"></i>&nbsp;Tambah Bank Soal</button>
            <button type="button" id="btn_clear" class="btn btn-sm btn-warning text-light btn-default"><i class="bi bi-eraser"></i>&nbsp;Kosongkan Pilihan</button>

            <div style="line-height: 10px;"><br></div>
            <div class="tscroll">
                <div id="tbl_bank_soal_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <br>

        </div>

        <!-- The Modal Input Bank Soal -->
        <div class="modal fade" id="modal_bank_soal" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #006DCC;" >                 
                    <h5 class="modal-title text-white font-effect-emboss" style="font-size: 20px; " >Tambah Soal</h5>                 
                </div>
            
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">          
                                                     
                        <input type="hidden" name="list_mapel_ori" id="list_mapel_ori">
                        <table class="table table-sm" style="margin-bottom: 10px;"> 
                            
                            <tr class="borderless-bottom">
                                <td>                        
                                    <label for="list_mapel" class="col-sm col-form-label col-form-label-sm">Mata Pelajaran</label>                                            
                                    <div class="input-group input-group-sm  col-sm-5" id="list_mapel_div"></div>
                                </td>
                            </tr>
                            <tr class="borderless-bottom">
                                <td>                        
                                    <label for="txt_jml_soal" class="col-sm col-form-label col-form-label-sm">Jumlah Soal</label>                                            
                                    <div class="input-group-sm col-sm">          
                                        <input type="text" class="form-control" name="txt_jml_soal" id="txt_jml_soal" readonly>
                                    </div>                                                                             
                                </td> 
                            </tr>
                            <tr class="borderless-bottom">
                                <td>                        
                                    <label for="txt_waktu_pengerjaan" class="col-sm col-form-label col-form-label-sm">Waktu Pengerjaan (menit)/soal</label>                                            
                                    <div class="input-group-sm col-sm">          
                                        <input type="text" class="form-control" name="txt_waktu_pengerjaan" id="txt_waktu_pengerjaan" readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr class="borderless-bottom">
                                <td>                        
                                    <label for="txt_bobot_nilai" class="col-sm col-form-label col-form-label-sm">Bobot nilai/soal</label>                                            
                                    <div class="input-group-sm col-sm">          
                                        <input type="text" class="form-control" name="txt_bobot_nilai" id="txt_bobot_nilai" readonly>
                                    </div>
                                </td>
                            </tr>              
                        </table>

                        <!-- Kompetensi Dasar -->
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kompetensi Dasar</label>
                        <div class="input-group-sm  col-sm" id="list_kd_div"></div>                        
                        <button type="button" class="btn btn-sm btn-primary btn-default" id="btn_tambah_kd">Tambah KD</button> 

                        <div style="line-height: 3px;"><br></div>  
                        <div class="tscroll">
                            <div id="tbl_guru_div" class="table-responsive table-height"></div>       
                        </div>
                                
                    </div>                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="margin-top: 1px;">   
                    <div class="container">  
                        <div class="row">
                            <div class="col-sm-6" style="display:flex; justify-content: left; align-items: left;">
                                <button type="submit" id="btn_simpan" class="btn btn-sm btn-submit btn-default"><i class="bi bi-save"></i>&nbsp;Simpan</button>
                            </div>
                            <div class="col-sm-6" style="display:flex; justify-content: right; align-items: right;">
                                <button type="button" id="btn_kembali_modal" class="btn btn-sm btn-dark btn-default"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
                            </div>           
                        </div>
                    </div>                    
                </div>

            </div>
        </div>
        </div>

     </form>


</body>
</html>

<script type="text/javascript">
    var user_id = '<?php echo $username ;?>'
    var status_user = '<?php echo $status_user ;?>'
    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var kelas = '<?php echo $kelas ;?>'
    var mapel = '<?php echo $mapel ;?>'  
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    var jenjang = '<?php echo $jenjang ;?>'
    var list_kd_idx = 0
    var status_mapel_pg = '0';
    var status_ekskul = '';
        
    async function init_form() {        
        await load_thn_ajaran()    
        await load_jenjang_pendidikan()   
        await load_kelas() 
        await load_mapel()
        await load_semester()
        await load_jenis_penilaian()
        await fetch_tbl_bank_soal()   
        //await load_kd()
        <?php simpan_kunjungan(); ?>
    }
    
    $(document).on('change', '#list_thnajaran', function () {
        $('#list_thnajaran').css('color', 'black')
        $('#list_thnajaran').css('border-color', '')
        load_jenjang_pendidikan()
        load_tbl_bank_soal([])
    })

    $(document).on('change', '#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')
        load_kelas()
        load_tbl_bank_soal([])
    })

    $(document).on('change', '#list_semester', function () {
        $('#list_semester').css('color', 'black')
        $('#list_semester').css('border-color', '')
        load_jenis_penilaian()
        fetch_tbl_bank_soal()
    })

    $(document).on('change', '#list_kelas', function () {
        $('#list_kelas').css('color', 'black')        
        fetch_tbl_bank_soal()
    })

    $(document).on('change', '#list_mapel', async function () {
        $('#list_mapel').css('border-color','')
        var pilih_mapel = $('#list_mapel').val()       
        status_ekskul = $(this).find(':selected').data('ekskul')       
        if(pilih_mapel==null){       
             $('#list_mapel').css('color', 'grey')  
        }else{
            $('#list_mapel').css('color', 'black')  
        }
        
        await get_status_mapel_pg()
        await get_waktu_pengerjaan()
        await get_bobot_nilai_jml_soal()
        load_kd()   
        get_tbl_guru()
    })

    $(document).on('change', '#list_jenis_penilaian', function () {
        $('#list_jenis_penilaian').css('color', 'black')
        fetch_tbl_bank_soal()      
    })

    $(document).on('change', '.list_kd', function () {              
        var id = $(this).attr('id')
        $('#'+id).css('color', 'black')     
    })    
    
    async function load_kd() {
        var html = await fill_list_kd('')       
        document.getElementById('list_kd_div').innerHTML = html        
    }    

    async function load_kd_exists() {
        
        var thnajaran = $('#list_thnajaran').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var mapel = $('#list_mapel').val()
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        let response = await fetch('<?php echo site_url('ujian/bank_soal/get_data_kd_exists') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian+'')
        let responseData = await response.json()
        if(responseData.data.length==0){
            list_kd_idx = 0
            await load_kd()
        }else{
            //sebelum buka modal list_kd dihapus dulu agar tidak doubel
            var data_kd = await responseData.data        
            list_kd_idx = 0   
            for(var ir = 0; ir < data_kd.length; ir++){   
                list_kd_idx = ir;              
                var html_kd = await fill_list_kd(data_kd[ir]['no_kd'])
                await $("#list_kd_div").append(html_kd);                
            }
        }
    }

    function load_thn_ajaran() {        
        fetch('<?php echo site_url('ujian/bank_soal/get_thn_ajaran') ;?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var ta_aktif = ''
            var html = '';           
                html +='<select name="list_thnajaran" id="list_thnajaran" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih thn ajaran</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){         
                    if (thnajaran == data[i].thnajaran_cls || data[i].aktif=="1"){        
                        if(data[i].aktif=="1"){
                            ta_aktif ="1"
                        }    
                        html +='    <option style="color:black" value='+data[i].thnajaran_cls+' selected>'+data[i].thnajaran_cls+'</option>'                                  
                    }else{
                        html +='    <option style="color:black" value='+data[i].thnajaran_cls+'>'+data[i].thnajaran_cls+'</option>'                                  
                    }                    
                }
            }     
                html +='</select>'                
            document.getElementById('list_thnajaran_div').innerHTML = html
            if(thnajaran!='' || ta_aktif=="1"){
                $('#list_thnajaran').css('color','black')
            }
        })
    }

    function load_mapel() {       
        fetch('<?php echo site_url('ujian/bank_soal/get_mapel');?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data          
            var html = '';           
                html +='<select name="list_mapel" id="list_mapel" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" data-ekskul="" selected disabled>pilih mapel</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" data-ekskul='+data[i].stat_ekskul+' value='+data[i].matapel_cls+'>'+data[i].deskripsi+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_mapel_div').innerHTML = html
        })
    }
    
    function load_jenis_penilaian() {
        var semester = $('#list_semester').val()
        if(semester!=null){
            var html ='<select name="list_jenis_penilaian" id="list_jenis_penilaian" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenis penilaian</option>'  
            if(jenis_penilaian=='pts'){
                html +='    <option style="color:black" value=pts selected>PTS</option>'                                                    
            }else{
                html +='    <option style="color:black" value=pts>PTS</option>'                                                    
            }            
            if (semester == 2) {
                if(jenis_penilaian=='pas'){
                    html +='    <option style="color:black" value=pas selected>PAT</option>'
                }else{
                    html +='    <option style="color:black" value=pas>PAT</option>'
                }                                           
            }else{
                if(jenis_penilaian=='pas'){
                    html +='    <option style="color:black" value=pas selected>PAS</option>'  
                }else{
                    html +='    <option style="color:black" value=pas>PAS</option>'  
                }
            }
            html +='</select>'                

        }else{
            var html ='<select name="jenis_penilaian" id="list_jenis_penilaian" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenis penilaian</option>'  
                html +='</select>' 
        }          
        document.getElementById('list_jenis_penilaian_div').innerHTML = html  
        if(jenis_penilaian!=''){
            $('#list_jenis_penilaian').css('color', 'black')
        }
    }

    function load_semester(){
        var html = '';
            html +='<select name="list_semester" id="list_semester" class="form-select" style="color:gray">';
            html +='    <option value="" selected disabled>pilih semester</option>';
            if(semester==1){
                html +='    <option value="1" style="color:black" selected>1</option>';
            }else{
                html +='    <option value="1" style="color:black">1</option>';
            }
            if(semester==2){
                html +='    <option value="2" style="color:black" selected>2</option>';
            }else{
                html +='    <option value="2" style="color:black">2</option>';
            }
            html +='</select>';
        document.getElementById("list_semester_div").innerHTML = html
        if (semester!=''){
            $('#list_semester').css('color', 'black')
        }
    }

    async function load_kelas() {        
        var jenjang = $('#list_jenjang').val()        
        await fetch('<?php echo site_url('ujian/bank_soal/get_kelas') ;?>?jenjang='+jenjang+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_kelas" id="list_kelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                    if(kelas==data[i].kelas_cls){
                        html +='    <option style="color:black" value='+data[i].kelas_cls+' selected>'+data[i].kelas_cls+'</option>'                                        
                    }else{
                        html +='    <option style="color:black" value='+data[i].kelas_cls+'>'+data[i].kelas_cls+'</option>'                                        
                    }                
                }
            }     
                html +='</select>'                
            document.getElementById('list_kelas_div').innerHTML = html
            if(kelas!=''){
                $('#list_kelas').css('color','black')
            }
        })
    }

    async function load_jenjang_pendidikan() {        
        await fetch('<?php echo site_url('ujian/bank_soal/get_jenjang_pendidikan') ;?>?kelas='+kelas+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
           
            var html = '';           
                html +='<select name="list_jenjang" id="list_jenjang" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenjang</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                     
                    if(data[i].flag=="1"||jenjang==data[i].group_cls){                         
                        html +='    <option style="color:black" value='+data[i].group_cls+' selected>'+data[i].group_cls+'</option>'                                        
                    }else{
                        html +='    <option style="color:black" value='+data[i].group_cls+'>'+data[i].group_cls+'</option>'                                        
                    }   
                }
            }     
                html +='</select>'                
            document.getElementById('list_jenjang_div').innerHTML = html   

            if(kelas!=''||jenjang!=''){
                $('#list_jenjang').css('color','black')                           
            }
        })
    }

    async function fill_list_kd(no_kd) {
        var thnajaran = $('#list_thnajaran').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var mapel = $('#list_mapel').val()
        let response = await fetch('<?php echo site_url('ujian/input_soal/get_data_kd') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel+'')
        let responseData = await response.json()       
        
        var data = responseData.data
        var html = '<div class="input-group input-group-sm input-group-kd" id="input_group_kd_'+list_kd_idx+'" data-seq="'+list_kd_idx+'">';     
        
        if(no_kd!=''){            
            html +='    <select name="list_kd[]" id="list_kd_'+list_kd_idx+'" class="list_kd form-select"">'  
        }else{           
            html +='    <select name="list_kd[]" id="list_kd_'+list_kd_idx+'" class="list_kd form-select" style="color:gray;">'
        }                 
            html +='        <option style="color:gray" value="" selected disabled>pilih kompetensi dasar</option>'  
        if (data.length > 0) {
            for(var i = 0; i < data.length; i++){      
                if(no_kd==data[i].no_kd){
                    html +='        <option style="color:black" value='+data[i].no_kd+' selected>'+data[i].no_kd+' - '+data[i].deskripsi_kd+'</option>'                                  
                }else{
                    html +='        <option style="color:black" value='+data[i].no_kd+'>'+data[i].no_kd+' - '+data[i].deskripsi_kd+'</option>'                                  
                }   
            }
        }     
            html +='    </select>';    
            html +='    <button type="button" id="btn_delete_kd_'+list_kd_idx+'" data-id="list_kd_'+list_kd_idx+'" data-seq="'+list_kd_idx+'" class="btn btn-sm btn-danger btn-default btn_delete_kd" title="Hapus KD" style="margin-left:3px"><i class="bi bi-trash"></i></button>';
            html +='</div>';
            html +='<div style="line-height: 5px;" class="br" id="br_'+list_kd_idx+'"><br></div> ';
           
            return html;
        
    }
    
    function get_bobot_nilai_jml_soal() {
        var kelas = $('#list_kelas').val();
        var semester = $('#list_semester').val();
        var mapel = $('#list_mapel').val();
        fetch('<?php echo site_url('ujian/master/get_bobot_nilai') ; ?>?list_kelas='+kelas
                                                                +'&list_semester='+semester
                                                                +'&list_mapel='+mapel
                                                                +'&status_ekskul='+status_ekskul+'')
        .then( response => response.json())
        .then( dataResult => {
            var data = dataResult.data 
            if(data.length> 0){
                var bobot_nilai  = 'PG : '+data[0]['bobot_pg']+ ', Uraian : '+data[0]['bobot_uraian']
                var jml_soal = 'PG : '+data[0]['jml_soal_pg']+ ', Uraian : '+data[0]['jml_soal_uraian']
                $('#txt_bobot_nilai').val(bobot_nilai)
                $('#txt_jml_soal').val(jml_soal)
            }else{
                $('#bobot_nilai').val('')
                $('#txt_jml_soal').val('')
            }
        })        
    }

    function get_waktu_pengerjaan() {
        var list_mapel = $('#list_mapel').val()   
        var list_semester = $('#list_semester').val() 
        var list_kelas = $('#list_kelas').val()
        fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan_with_mapel') ; ?>?mapel='+list_mapel
                                                                                +'&kelas='+list_kelas
                                                                                +'&semester='+list_semester+'')                                                                               
        .then( response => response.json())
        .then( dataResult => {
            var data = dataResult.data
            console.log(data)
            if(data.length> 0){                
                if(status_mapel_pg=='1'){
                    var waktu_pengerjaan  = 'PG : '+data[0]['soal_pg']+ ', Uraian : 0'
                }else{
                    var waktu_pengerjaan  = 'PG : '+data[0]['soal_pg']+ ', Uraian : '+data[0]['soal_uraian']
                }                
                $('#txt_waktu_pengerjaan').val(waktu_pengerjaan)

            }else{
                $('#txt_waktu_pengerjaan').val('')
            }
        })        
    }

    function get_tbl_guru() {              
        $('#list_mapel option[value=""]').prop('disabled', false);
        var form_data = $('#simpan_form').serialize()            
        fetch('<?php echo site_url('ujian/bank_soal/get_tbl_guru') ; ?>?'+ new URLSearchParams(form_data),{
            method:'GET'
        })
        .then( response => response.json())
        .then( dataResult => {
            $('#list_mapel option[value=""]').prop('disabled', true);
            var data = dataResult.data           
            load_tbl_guru(data)             
        })        

    }

    function load_tbl_guru(data) {
        var jenjang = $('#list_jenjang').val()
        var html = '<div style="line-height: 10px;"><br></div>';
        if(jenjang=='SDIT'){
            html += '<label for="tbl_bank_soal" class="col-sm col-form-label col-form-label-sm">Guru Kelas :</label>';
        }else{
            html += '<label for="tbl_bank_soal" class="col-sm col-form-label col-form-label-sm">Guru Pelajaran :</label>';
        }
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_bank_soal">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No</th>';
        if(jenjang=='SDIT'){
            html += '			<th>Sub kelas</th>';
        }
        if(jenjang=='SMPIT'){
            html += '			<th>Kelas</th>';
        }
        html += '			<th>Nama Guru</th>';        
        html += '		</tr>';       		
        html += '   </thead>';      
        
        if(data.length>0) {           
            var no=0
            html += '<tbody class="col-form-label-sm">';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr id="'+ no +'">';                
                html += '   <td width="30pt" style="vertical-align: middle; min-width:50pt; text-align:center;">'+no+'</td>';//0
                if(jenjang=='SDIT'){
                    html += '   <td style="vertical-align: middle;" class="text-nowrap">'+data[count].subkelas_cls+'</td>';  //1
                }
                if(jenjang=='SMPIT'){
                    html += '   <td style="vertical-align: middle;" class="text-nowrap">'+data[count].kelas+'</td>';  //1
                }
                
                html += '   <td style="vertical-align: middle; text-align:center;">';
                html += '       <div class="input-group input-group-sm">';
                html += '           <input class="form-control form-control-sm" name="txt_nama[]" id="txt_nama_'+no+'" value="'+data[count].nama_guru+'">';//2                
                html += '           <input class="form-control form-control-sm" name="txt_subkelas[]" id="txt_subkelas_'+no+'" value="'+data[count].subkelas_cls+'" style="display:none;">';//2                
                html += '       <div>';
                html += '   </td>';
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';                                
        document.getElementById("tbl_guru_div").innerHTML = html;                 
    } 

    $(document).on('click', '#btn_tambah', function () {
        var list_thnajaran = $('#list_thnajaran').val()  
        var list_jenjang = $('#list_jenjang').val()
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        var status_tambah = true   
                
        if(list_thnajaran==null){
            $('#list_thnajaran').css('border-color', '#cc0000')
            status_tambah = false           
        }else{
            $('#list_thnajaran').css('border-color', '')
        }

        if(list_jenjang==null){
            $('#list_jenjang').css('border-color', '#cc0000')
            status_tambah = false
        }else{
            $('#list_jenjang').css('border-color', '')
        }
      
        if(semester==null){
            $('#list_semester').css('border-color', '#cc0000')
            status_tambah = false
        }else{
            $('#list_semester').css('border-color', '')
        }
      
        if(kelas==null){
            $('#list_kelas').css('border-color', '#cc0000')
            status_tambah = false
        }else{
            $('#list_kelas').css('border-color', '')
        }

        if(jenis_penilaian==null){
            $('#list_jenis_penilaian').css('border-color', '#cc0000')
            status_tambah = false
        }else{
            $('#list_jenis_penilaian').css('border-color', '')
        }
    
        if(status_tambah==false){
            alert('Silahkan pilih data yang diperlukan')
            return false
        }  

        // get_waktu_pengerjaan()
        // get_bobot_nilai_jml_soal()
        get_tbl_guru()
        load_kd()
           
        $('#modal_bank_soal').modal('show')  
    })

    $(document).on('click','#btn_tambah_kd', async function () { 
        var mapel = $('#list_mapel').val()       
        if(mapel==undefined){            
            alert('Silahkan isi Mata Pelajaran')
            $('#list_mapel').css('border-color', '#cc0000')
            return false
        }

        list_kd_idx = list_kd_idx + 1
        var html = await fill_list_kd('')
        $("#list_kd_div").append(html);
    })

    $(document).on('click', '#btn_clear', function () {
        window.location.href="<?php echo site_url("ujian/bank_soal/show_bank_soal") ?>"
    })

    $(document).on('click', '.btn_delete_kd', function () {
        var list_kd_id = $(this).attr("data-id")
        var seqno = $(this).attr("data-seq")
        var btn_id =  $(this).attr("id")
        document.getElementById(list_kd_id).remove();
        document.getElementById(btn_id).remove();
        document.getElementById('input_group_kd_'+seqno).remove();
    })

    $(document).on('click', '#btn_kembali_modal', function () { 
        input_area_clear()
        $('#modal_bank_soal').modal('hide')   
    })

    $(document).on('click', '#btn_buat_soal', function (event) {
        var tbl = document.getElementById('tbl_bank_soal')     
        var idx = event.target.closest('tr').id        
        var mapel = tbl.rows[idx].cells[11].textContent
        var thnajaran = $('#list_thnajaran').val()
        var kelas = $('#list_kelas').val()
        var semester = $('#list_semester').val()
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        var bank_soal_id = tbl.rows[idx].cells[12].textContent
        var status_soal = tbl.rows[idx].cells[13].textContent

        window.location.href="<?php echo site_url('ujian/input_soal/show_input_soal');?>?mapel="+mapel
                                                                +"&thnajaran="+thnajaran
                                                                +"&kelas="+kelas
                                                                +"&semester="+semester
                                                                +"&jenis_penilaian="+jenis_penilaian
                                                                +"&bank_soal_id="+bank_soal_id 
                                                                +"&status_soal="+status_soal+"" 

        
    })

    $(document).on('click', '#btn_edit', async function (event) {
        var tbl = document.getElementById('tbl_bank_soal')     
        var idx = event.target.closest('tr').id
        var bank_soal_id = $(this).attr('data-id')  

        var waktu_mengerjakan = tbl.rows[idx].cells[2].textContent
        var bobot_pg = tbl.rows[idx].cells[3].textContent       
        var bobot_essai = tbl.rows[idx].cells[4].textContent
        var bobot_nilai = tbl.rows[idx].cells[5].textContent
        var jml_soal = tbl.rows[idx].cells[6].textContent
        var no_kd = tbl.rows[idx].cells[7].textContent
        var matapel_cls = tbl.rows[idx].cells[11].textContent
                
        $('#list_mapel').val(matapel_cls)
        $('#list_mapel').css('color', 'black')
        $('#list_mapel_ori').val(matapel_cls)

        status_ekskul = $('#list_mapel').find(':selected').data('ekskul')
                
        await get_status_mapel_pg()
        await get_waktu_pengerjaan()
        await get_bobot_nilai_jml_soal()
        await load_kd_exists()         
        await get_tbl_guru()
             
        $('#modal_bank_soal').modal('show')   
    })

    async function get_status_mapel_pg() {    
        var kelas = $('#list_kelas').val()
        var semester = $('#list_semester').val()
        var mapel = $('#list_mapel').val()
        var rs_status_mapel_pg = await fetch('<?php echo site_url('ujian/master/get_status_mapel_pg') ;?>?list_kelas='+kelas
                                                                                            +'&list_semester='+semester
                                                                                            +'&list_mapel='+mapel+''
                                                                                            ,{method:"GET", mode: "no-cors" })
        var rs = await rs_status_mapel_pg.json() 
        status_mapel_pg = rs.data        
    }

    $(document).on('click', '#btn_delete', function (event) {
        var confirm_del = confirm('Apakah Anda yakin ingin menghapus data?')
        if (confirm_del==false){
            return false
        }

        var tbl = document.getElementById('tbl_bank_soal')     
        var idx = event.target.closest('tr').id          
        var bank_soal_id = $(this).attr('data-id')        
        var list_mapel = tbl.rows[idx].cells[11].textContent   
        var list_thnajaran = $('#list_thnajaran').val()
        var list_kelas = $('#list_kelas').val()
        var list_semester = $('#list_semester').val()
        var list_jenis_penilaian = $('#list_jenis_penilaian').val()

        const form_data = new FormData();
        form_data.append('list_thnajaran', list_thnajaran);
        form_data.append('list_semester', list_semester);
        form_data.append('list_kelas', list_kelas);
        form_data.append('list_mapel', list_mapel);
        form_data.append('list_jenis_penilaian', list_jenis_penilaian);
        form_data.append('bank_soal_id', bank_soal_id);
        
        fetch('<?php echo site_url('ujian/bank_soal/delete_bank_soal') ;?>',{
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
                    input_area_clear()
                    fetch_tbl_bank_soal()
                }                
            })
        .catch(err => {
            alert(err);
        });   
        

    })

    $(document).on('submit','#simpan_form', async function(event) {
        event.preventDefault();      
        
        var valid_data = await validasi_data_submit();                      
                
        //jika bukan edit, cek data exists
        var list_mapel_ori = $('#list_mapel_ori').val()
        if(list_mapel_ori==''){
            var valid_data_exists = await cek_data_exists()
        }        
        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        if(valid_data_exists == false){
            alert('Data sudah ada')
            return false;
        }
                    
        var form_data= $(this).serialize();
       
        fetch('<?php echo site_url('ujian/bank_soal/simpan_bank_soal') ;?>',{
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
                    $('#modal_bank_soal').modal('hide')
                    input_area_clear()
                    fetch_tbl_bank_soal()
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    async function cek_data_exists() {
         var thnajaran = $('#list_thnajaran').val()       
        var mapel = $('#list_mapel').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var jenis_penilaian = $('#list_jenis_penilaian').val()
       
        var hasil_exists = await fetch('<?php echo site_url('ujian/bank_soal/get_data_exists');?>?thnajaran='+thnajaran
                                                                                                +'&mapel='+mapel
                                                                                                +'&semester='+semester
                                                                                                +'&kelas='+kelas
                                                                                                +'&jenis_penilaian='+jenis_penilaian+'',
                                                                                                {metode:'GET',mode:"no-cors"})        
        var result = await hasil_exists.json()
        if(result.data.length>0){
            return false
        }else{
            return true
        }        
    }

    function validasi_data_submit(){       
        let valid=true;		
        let x = document.forms["simpan_form"];
        let list_mapel = x["list_mapel"].value;
        let txt_waktu_pengerjaan = x["txt_waktu_pengerjaan"].value;
        let txt_bobot_nilai = x["txt_bobot_nilai"].value;
        let txt_jml_soal = x["txt_jml_soal"].value;
                      
        if(list_mapel==''){
            $('#list_mapel').addClass('border-select-empty')  
            valid=false;
        }else{
            $('#list_mapel').removeClass('border-select-empty')
        }
        if(txt_waktu_pengerjaan==''||txt_waktu_pengerjaan==0){
            $('#txt_waktu_pengerjaan').css('border-color', '#cc0000')
            valid=false;
        }else{
            $('#txt_waktu_pengerjaan').css('border-color', '')
        }
        if(txt_bobot_nilai==''){
            $('#txt_bobot_nilai').css('border-color', '#cc0000')
            valid=false
        }else{
             $('#txt_bobot_nilai').css('border-color', '')
        }
        if(txt_jml_soal==''){
            $('#txt_jml_soal').css('border-color', '#cc0000')
            valid=false
        }else{
            $('#txt_jml_soal').css('border-color', '')
        }
        // if(list_kd==''||list_kd==0){
        //     $('#list_kd').css('border-color', '#cc0000')
        //     valid=false;
        // }else{
        //     $('#list_kd').css('border-color', '')
        // }

        if(status_ekskul=='0'){
            $('.list_kd').each(function (idx,el) {
                const id = $(this).attr('id');   
                var kd = $('#'+id).val()          
                if(kd==null){
                    valid=false
                    $('#'+id).css('border-color', '#cc0000')
                }
            })
        }
         
        
        return valid;
    }

    function input_area_clear() {
        let x = document.forms["simpan_form"];      
        x["list_mapel"].value = "";
        x["list_mapel_ori"].value = "";
        x["txt_waktu_pengerjaan"].value = "" ;
        x["txt_bobot_nilai"].value = "" ;
        x["txt_jml_soal"].value = "";       
        x["list_mapel"].style.color="gray"
        
        status_ekskul = ''

        $('.input-group-kd').each( function (idx2,el2) {
            const container = $(this);        
            const ini_id = $(this).attr('id')
            const seqno = $(this).attr('data-seq')
            const selectId = container.find(".list_kd").attr("id")
            const btnId = container.find(".btn_delete_kd").attr("id");   
            
            // console.log(`Input-group ke-${idx2 + 1}:`);
            // console.log(`- ID Select: ${selectId}`);
            // console.log(`- ID Button: ${btnId}`);

            document.getElementById(selectId).remove()
            document.getElementById(btnId).remove()
            document.getElementById(ini_id).remove()
            document.getElementById('br_'+seqno).remove()
        })
    }

    async function fetch_tbl_bank_soal(){        
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var jenis_penilaian = $('#list_jenis_penilaian').val()
                   
        // if(thnajaran==''||jenjang==''||semester==null||kelas==null||jenis_penilaian==null){
        //     return false;
        // }
        
        await fetch('<?php echo site_url('ujian/bank_soal/get_tbl_bank_soal');?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&semester='+semester
                                                                        +'&kelas='+kelas
                                                                        +'&jenis_penilaian='+jenis_penilaian+'')
        .then(function(response){
            return response.json();    
        }).then( async function (responseData){            
            await load_tbl_bank_soal(responseData.data); 
        });            
    }

    function load_tbl_bank_soal(data) {        
        var html = '';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_bank_soal">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No</th>';
        html += '			<th>Mata Pelajaran</th>';
        html += '			<th>Waktu Pengerjaan/menit</th>';
        html += '			<th>Bobot Nilai/soal</th>';
        html += '			<th>Jumlah Soal</th>';  
        html += '			<th>Jumlah KD</th>';        
        html += '			<th>Buat Soal</th>';
        html += '			<th colspan="2">Proses</th>';
        html += '		</tr>';       		
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            var no=0
            html += '<tbody class="col-form-label-sm">';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr id="'+ no +'">';                
                html += '   <td width="35pt" style="vertical-align: middle; min-width:35pt; text-align:center;">'+no+'</td>';//0
                html += '   <td style="vertical-align: middle; min-width:200pt;" class="text-nowrap">'+data[count].deskripsi+'</td>';  //1
                html += '   <td width="120pt" style="vertical-align: middle; text-align:center;">'+data[count].waktu_pengerjaan+'</td>';//2
                html += '   <td style="display:none;">'+data[count].bobot_pg+'</td>';//3
                html += '   <td style="display:none;">'+data[count].bobot_essai+'</td>';//4 
                html += '   <td width="120pt" style="vertical-align: middle; min-width:120pt; text-align:center;">'+data[count].bobot_nilai+'</td>';//5  
                if(data[count].status_soal=="0"){ 
                    html += '   <td width="120pt" class="text-danger" style="vertical-align: middle; min-width:120pt; text-align:center;">'+data[count].jml_soal+'</td>';//6          
                }else{
                    html += '   <td width="120pt" style="vertical-align: middle; min-width:120pt; text-align:center;">'+data[count].jml_soal+'</td>';//6          
                }                
                html += '   <td width="100pt" style="vertical-align: middle; min-width:50pt; text-align:center;">'+data[count].no_kd+'</td>';//7         
                html += '   <td class="fix_width_col" style="min-width:65pt;"><button type="button" id="btn_buat_soal" class="btn btn-sm btn-submit btn-default">Buat Soal</button></td>';//8
                html += '   <td class="fix_width_col2"><button type="button" id="btn_edit" class="btn btn-sm btn-success btn-default" data-id="'+data[count].id+'" title="Edit"><i class="bi bi-pencil-square"></i></button></td>';//9
                html += '   <td class="fix_width_col2"><button type="button" id="btn_delete" class="btn btn-sm btn-danger btn-default" data-id="'+data[count].id+'" title="Hapus"><i class="bi bi-trash"></i></button></td>';//10
                html += '   <td style="display:none;">'+data[count].matapel_cls+'</td>'//11
                html += '   <td style="display:none;">'+data[count].id+'</td>'//12
                html += '   <td style="display:none;">'+data[count].status_soal+'</td>'//13
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';
                                
        document.getElementById("tbl_bank_soal_div").innerHTML = html;  
        //document.getElementById("tbl_bank_soal_div").style.height = "550px";       
    }

</script>

<style>
    .btn-default {
        box-shadow: 1px 2px 5px #000000;   
    }

    .modal-header {       
        padding: 0.5rem;
        text-align: center;
        display:flex; 
        justify-content: center; 
        align-items: center;
    }

    .modal-footer {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        /* align-items: center; */
        /* justify-content: center; */
    }

    .border-select-empty{
        outline: none !important;
        box-shadow: none !important;
        border: 1px solid #cc0000;
    }

    .fix_width_col {
        width: 90px;
        text-align: center;
    }
    .fix_width_col2 {
        width: 40px;
        text-align: center;
    }
    
</style>