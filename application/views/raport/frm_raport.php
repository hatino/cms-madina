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
    <div class="container mt-5">  
        <h3 class="text-header">Raport Siswa</h3>
       
        <form action="post" id="simpan_form">

            <table class="table table-sm" style="margin-bottom: 10px;">
                <!--nama siswa by user-->
                <tr class="borderless-bottom" id="tr_nama_siswa_by_user">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Nama Siswa</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_nama_siswa_by_user_div">
                    </td>
                </tr>

                <!--kelas by user-->
                <tr class="borderless-bottom" id="tr_kelas_by_user">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kelas</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_kelas_by_user_div">
                    </td>
                </tr>

                <!--Tahun Ajaran-->
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

                <tr class="borderless-bottom" id="tr_kelas">
                    <td width="80">                        
                        <label for="list_kelas" class="col-sm col-form-label col-form-label-sm">Kelas</label>
                    </td>
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_kelas_div"></div>
                    </td>
                </tr>

                <tr class="borderless-bottom" id="tr_subkelas">
                    <td>             
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Sub Kelas</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_subkelas_div"></div>
                    </td>
                </tr>

                <tr class="borderless-bottom">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Semester</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5">
                            <select name="list_semester" id="list_semester" class="form-select" style="color:gray">                     
                                <option value="" selected disabled>pilih semester</option>
                                <option value="1" style="color:black">1</option> 
                                <option value="2" style="color:black">2</option> 
                            </select>                    
                        </div>
                    </td>
                </tr>

                <tr class="borderless-bottom">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Jenis Penilaian</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_jenis_penilaian_div">
                    </td>
                </tr>

                <tr class="borderless-bottom" id="tr_nama_siswa">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Nama Siswa</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_nama_siswa_div">
                    </td>
                </tr>

                 

            </table>
            
            <div style="line-height: 5px;"><br></div>
            <div class="tscroll">
                <div id="tbl_raport_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <br>
            <br>
        </form>
    </div>
    
</body>
</html>

<script type="text/javascript">    
    var user_id = '<?php echo $username ;?>'
    var status_admin = '<?php echo $status_admin ;?>'
      
    async function init_form() {
       
        if (status_admin=='1'||status_admin=='0'){
            await load_thn_ajaran()
            await load_jenjang_pendidikan()
            await load_kelas('')
            await load_subkelas('')            
            await load_nama_siswa()                   
            document.getElementById('tr_nama_siswa_by_user').style.display = 'none'   
            document.getElementById('tr_kelas_by_user').style.display = 'none'   
        }else{            
            await load_nama_siswa_by_user()
            await load_kelas_by_user()
            document.getElementById('tr_thnajaran').style.display = 'none'
            document.getElementById('tr_jenjang').style.display = 'none'
            document.getElementById('tr_kelas').style.display = 'none'
            document.getElementById('tr_subkelas').style.display = 'none'
            document.getElementById('tr_nama_siswa').style.display = 'none'
        }
        await load_jenis_penilaian('')
        await load_tbl_raport_pts([])
    }

    $(document).on('change', '#list_thnajaran', function () {
        $('#list_thnajaran').css('color', 'black')       
        load_jenjang_pendidikan()
        load_tbl_raport_pts([])
    })

    $(document).on('change', '#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')        
        load_kelas()
        load_tbl_raport_pts([])
    })

    $(document).on('change', '#list_kelas', function () {
        $('#list_kelas').css('color', 'black')                  
        load_subkelas()     
        load_tbl_raport_pts([])        
    })

    $(document).on('change', '#list_kelas_by_user', function () {
        $('#list_kelas_by_user').css('color', 'black')
        fetch_tbl_raport()  
    })

    $(document).on('change', '#list_subkelas', function () {       
        $('#list_subkelas').css('color', 'black')        
    })
    
    $(document).on('change', '#list_semester', function () {
        $('#list_semester').css('color', 'black')  
        load_jenis_penilaian()    
    })

    $(document).on('change', '#list_jenis_penilaian', async function () {  
        $('#list_jenis_penilaian').css('color', 'black')  
        await load_nama_siswa()
        await fetch_tbl_raport()
    })

    $(document).on('change', '#list_nama_siswa', function () {  
        $('#list_nama_siswa').css('color', 'black')  
        fetch_tbl_raport()
    })

    function load_thn_ajaran() {
        fetch('<?php echo site_url('raport/raport/get_thn_ajaran') ;?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_thnajaran" id="list_thnajaran" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih thn ajaran</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){
                    // if(data[i].aktif=="1"){
                    //     html +='    <option style="color:black" value='+data[i].thnajaran_cls+' selected>'+data[i].thnajaran_cls+'</option>'
                    // }else{
                        html +='    <option style="color:black" value='+data[i].thnajaran_cls+'>'+data[i].thnajaran_cls+'</option>'
                    // }                    
                }
            }     
                html +='</select>'                
            document.getElementById('list_thnajaran_div').innerHTML = html
        })
    }

    function load_jenjang_pendidikan() {
        var thnajaran = $('#list_thnajaran').val()       
        fetch('<?php echo site_url('raport/raport/get_jenjang_pendidikan') ;?>?thnajaran='+thnajaran+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_jenjang" id="list_jenjang" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenjang</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                    html +='    <option style="color:black" value='+data[i].group_cls+'>'+data[i].group_cls+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_jenjang_div').innerHTML = html   
        })
    }

    function load_kelas() {
        var thnajaran = $('#list_thnajaran').val()
        var jenjang = $('#list_jenjang').val()
        fetch('<?php echo site_url('raport/raport/get_kelas') ;?>?thnajaran='+thnajaran+'&jenjang='+jenjang+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_kelas" id="list_kelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value='+data[i].kelas_cls+'>'+data[i].kelas_cls+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_kelas_div').innerHTML = html
        })
    }

    function load_kelas_by_user() {
        var nis = user_id
        fetch('<?php echo site_url('raport/raport/get_kelas_by_user') ;?>?nis='+nis+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data           
            var html = '';           
                html +='<select name="list_kelas_by_user" id="list_kelas_by_user" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value='+data[i].kelas_cls+'>'+data[i].kelas_cls+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_kelas_by_user_div').innerHTML = html
        })
    }

    function load_subkelas() {
        var thnajaran = $('#list_thnajaran').val()
        var jenjang = $('#list_jenjang').val()
        var kelas = $('#list_kelas').val()
        fetch('<?php echo site_url('raport/raport/get_subkelas') ;?>?thnajaran='+thnajaran+'&jenjang='+jenjang+'&kelas='+kelas+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_subkelas" id="list_subkelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih subkelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value="'+data[i].subkelas_cls+'">'+data[i].subkelas_cls+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_subkelas_div').innerHTML = html
        })
    }

    function load_jenis_penilaian() {
        var semester = $('#list_semester').val()               
        var html = '';           
            html +='<select name="list_jenis_penilaian" id="list_jenis_penilaian" class="form-select" style="color:gray">'  
            html +='    <option style="color:gray" value="" selected disabled>pilih subkelas</option>'  
        if (semester=1) {                         
            html +='    <option style="color:black" value="PTS">PTS</option>'                                        
            html +='    <option style="color:black" value="PAS">PAS</option>'                                        
        }else if (semester=2) {
            html +='    <option style="color:black" value="PTS">PTS</option>'                                        
            html +='    <option style="color:black" value="PAT">PAT</option>' 
        } 
            html +='</select>'                
        document.getElementById('list_jenis_penilaian_div').innerHTML = html       
    }

    async function load_nama_siswa() {       
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val()
        var kelas = $('#list_kelas').val()
        var subkelas = $('#list_subkelas').val()       
        var semester = $('#list_semester').val()
        var jenis_penilaian = $('#list_jenis_penilaian').val()

        await fetch('<?php echo site_url('raport/raport/get_nama_siswa') ;?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&kelas='+kelas
                                                                        +'&subkelas='+subkelas
                                                                        +'&semester='+semester
                                                                        +'&jenis_penilaian='+jenis_penilaian+'')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){ 
            var data = responseData.data
            var html = '';           
                html +='<select name="list_nama_siswa" id="list_nama_siswa" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih nama siswa</option>'                
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value="'+data[i].nis+'">'+data[i].nama+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_nama_siswa_div').innerHTML = html         
        });       
        
    }

    function load_nama_siswa_by_user() {      
        fetch('<?php echo site_url('raport/raport/get_nama_siswa_by_user') ;?>?user_id='+user_id+'')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){            
            var data = responseData.data           
            var html = '';           
                html +='<select name="list_nama_siswa_by_user" id="list_nama_siswa_by_user" class="form-select">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih nama siswa</option>'                
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){     
                   if(user_id==data[i].nis){
                        html +='    <option style="color:black" value="'+data[i].nis+'" selected>'+data[i].nama+'</option>' 
                   }else{
                        html +='    <option style="color:black" value="'+data[i].nis+'">'+data[i].nama+'</option>' 
                   }       
                                                      
                }
            }     
                html +='</select>'                
            document.getElementById('list_nama_siswa_by_user_div').innerHTML = html         
        });       
        
    }

    async function fetch_tbl_raport(){        
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val()        
        var subkelas = $('#list_subkelas').val()       
        var semester = $('#list_semester').val()
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        var nis = ''   
        var kelas = ''            
        if(user_id=='admin'){
            nis = $('#list_nama_siswa').val()          
            kelas = $('#list_kelas').val()
            if( thnajaran==''||jenjang==''||kelas==''||subkelas==''||semester==''||jenis_penilaian==''||nis==''){
                return false
            }
        }else{
            
            nis = $('#list_nama_siswa_by_user').val()
            kelas = $('#list_kelas_by_user').val()
            if( kelas==''||semester==''||jenis_penilaian==''||nis==''){
                return false
            }

        }
        
        await fetch('<?php echo site_url('raport/raport/get_data_tbl_raport');?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&kelas='+kelas
                                                                        +'&subkelas='+subkelas
                                                                        +'&semester='+semester
                                                                        +'&jenis_penilaian='+jenis_penilaian
                                                                        +'&nis='+nis+'')
        .then(function(response){                   
            return response.json();    
        }).then( async function (responseData){
            console.log(responseData)           
            if (jenis_penilaian=='PTS'){
                await load_tbl_raport_pts(responseData.data); 
            }else{
                await load_tbl_raport_pas(responseData.data); 
            }
                          
        });            
    }

    function load_tbl_raport_pts(data) {        
        var html = '';               
        html += '<div>';
        html += '<table class="table table-sm table-bordered" id="tbl_daftar_calon_siswa">';            
        html += '	<thead class="col-form-label-sm text-light">';                                
        html += '		<tr class="text-nowrap" style="position: sticky; top: 0; background-color: rgba(40, 68, 47, 0.88); z-index: 2;">';    
        html += '			<th rowspan="3" style="vertical-align: middle;">NO</th>';         
        html += '			<th rowspan="3" style="vertical-align: middle;">JENIS MAPEL</th>';                            
        html += '			<th rowspan="3" style="vertical-align: middle;">MATA PELAJARAN</th>';
        html += '			<th colspan="4" >ASPEK PENGETAHUAN</th>';
        html += '		</tr>';
        html += '		<tr class="text-nowrap" style="position: sticky; top: 30px; background-color: rgba(40, 68, 47, 0.88); z-index: 1;">';    
        html += '			<th colspan="4">NILAI HASIL BELAJAR</th>';
        html += '		</tr>';
        html += '		<tr class="text-nowrap" style="position: sticky; top: 60px; background-color: rgba(40, 68, 47, 0.88); z-index: 0;">';    
        html += '			<th>KKM</th>';
        html += '			<th>NA</th>';
        html += '			<th>Predikat</th>';
        html += '			<th>Keterangan</th>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            var no=0
            var jenis_mapel = ''

            html += '<tbody>';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+no+'</td>'; 
                if (jenis_mapel != data[count].muatan_mapel) {
                    html += '   <td style="vertical-align: middle; max-width:30pt" rowspan="'+data[count].jml_baris+'">Mata Pelajaran '+data[count].muatan_mapel+'</td>';  
                }                
                html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">'+data[count].deskripsi+'</td>';  //1
                html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;">'+Math.trunc(data[count].kkm)+'</td>';  
                html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;">'+Math.trunc(data[count].nilai)+'</td>';
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[count].predikat+'</td>';
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;" class="text-nowrap">'+data[count].keterangan+'</td>';
                html += '</tr>'; 
                
                jenis_mapel = data[count].muatan_mapel
            }
            html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
            html += '   <td style="vertical-align: middle; min-width:30pt"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">TOTAL</td>';  //1
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';  
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[0].total_nilai+'</td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;" class="text-nowrap"></td>';
            html += '</tr>'; 
            html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
            html += '   <td style="vertical-align: middle; min-width:30pt"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">RATA-RATA</td>';  //1
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';  
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[0].rerata_nilai+'</td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;" class="text-nowrap"></td>';
            html += '</tr>'; 
            html += '</tbody>';  
        }
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_raport_div").innerHTML = html;  
        document.getElementById("tbl_raport_div").style.height = "550px";       
    }

    function load_tbl_raport_pas(data) {        
        var html = '';               
        html += '<div>';
        html += '<table class="table table-sm table-bordered" id="tbl_daftar_calon_siswa">';            
        html += '	<thead class="col-form-label-sm tbl_bg_color text-light ">';                                
        html += '		<tr class="text-nowrap" style="position: sticky; top: 0; background-color: rgba(40, 68, 47, 0.88); z-index: 2;">';    
        html += '			<th rowspan="2" style="vertical-align: middle;">No</th>';         
        html += '			<th rowspan="2" style="vertical-align: middle;">Jenis Mapel</th>';                            
        html += '			<th rowspan="2" style="vertical-align: middle;">Mata Pelajaran</th>';
        html += '			<th rowspan="2" style="vertical-align: middle;">KKM</th>';
        html += '			<th colspan="3" >Pengetahuan</th>';
        html += '			<th colspan="3" >Keterampilan</th>';
        html += '		</tr>';      
        html += '		<tr class="text-nowrap table-sticky" style="position: sticky; top: 30px; background-color: rgba(40, 68, 47, 0.88); z-index: 1;">';    
        html += '			<th rowspan="2">Nilai</th>';
        html += '			<th>Predikat</th>';
        html += '			<th>Deskripsi</th>';        
        html += '			<th>Nilai</th>';
        html += '			<th>Predikat</th>';
        html += '			<th>Deskripsi</th>';      
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            var no=0
            var jenis_mapel = ''

            html += '<tbody>';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+no+'</td>'; 
                if (jenis_mapel != data[count].muatan_mapel) {
                    html += '   <td style="vertical-align: middle; max-width:30pt" rowspan="'+data[count].jml_baris+'">Mata Pelajaran '+data[count].muatan_mapel+'</td>';  
                }                
                html += '   <td style="vertical-align: middle; min-width:160pt" >'+data[count].nama_mapel+'</td>';  //1
                html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;">'+Math.trunc(data[count].kkm)+'</td>';  
                html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;">'+Math.trunc(data[count].nilai)+'</td>';
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[count].predikat+'</td>';
                html += '   <td style="vertical-align: middle; min-width:250pt; text-align:left;">'+data[count].deskripsi+'</td>';
                html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;">'+Math.trunc(data[count].nilai_ket)+'</td>';
                html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[count].predikat_ket+'</td>';
                html += '   <td style="vertical-align: middle; min-width:250pt; text-align:left;">'+data[count].deskripsi_ket+'</td>';
                html += '</tr>'; 
                
                jenis_mapel = data[count].muatan_mapel
            }
            html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
            html += '   <td style="vertical-align: middle; min-width:30pt"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">TOTAL</td>';  //1
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';  
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[0].total_nilai+'</td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;" class="text-nowrap"></td>';
            html += '</tr>'; 
             html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
            html += '   <td style="vertical-align: middle; min-width:30pt"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">RATA-RATA</td>';  //1
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';  
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;">'+data[0].rerata_nilai+'</td>';
            html += '   <td style="vertical-align: middle; min-width:30pt; text-align:center;" class="text-nowrap"></td>';
            html += '</tr>'; 
            html += '</tbody>';  
        }
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_raport_div").innerHTML = html;  

    }
    


</script>

<style>
/******** FIX TABLE ******/
.table-sticky thead tr th {
  /* Important */  
  position: sticky;
  z-index: 2;
  top: 2;
}
  
.table-sticky>thead>tr>th,
.table-sticky>thead>tr>td {
	background:rgba(40, 68, 47, 0.88);    
	color: #fff;
	top: 0px;
	position: sticky;
}

</style>