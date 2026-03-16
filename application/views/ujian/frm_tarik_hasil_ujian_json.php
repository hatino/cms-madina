<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body onload="init_form()">    
    <br>
    <form action="post" id="simpan_form">
        <div class="container mt-5">  
            <h3 class="text-header">Tarik Hasil Penilaian</h3>

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
                <!-- Sub kelas -->
                <tr class="borderless-bottom">
                    <td>                       
                        <label for="list_subkelas" class="col-sm col-form-label col-form-label-sm">Sub Kelas</label>                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_subkelas_div"></div>
                    </td>
                <tr>
                <!-- Semester -->
                <tr class="borderless-bottom">
                    <td>                               
                        <label for="list_semester" class="col-sm col-form-label col-form-label-sm">Semester</label>                                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_semester_div"></div>
                    </td>
                </tr>
                <!-- Jenis Penilaian -->
                <tr class="borderless-bottom">
                    <td>                               
                        <label for="list_jenis_penilaian" class="col-sm col-form-label col-form-label-sm">Jenis Penilaian</label>                                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_jenis_penilaian_div"></div>
                    </td>
                </tr>               
                <!-- Mapel -->
                <tr class="borderless-bottom">
                    <td>                               
                        <label for="list_mapel" class="col-sm col-form-label col-form-label-sm">Mata Pelajaran</label>                                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_mapel_div"></div>
                    </td>
                </tr>               
            </table>    

            <button type="button" id="btn_process_all" class="btn btn-sm btn-primary text-white btn-shadow"><i class="bi bi-gear"></i> Proses Semua Siswa</button>
            <div style="line-height: 10px;"><br></div>
            <div class="tscroll">
                <div id="tbl_bank_soal_div" class="table-responsive table-height"></div>       
            </div>

            <footer style="margin-top: 60px;"></footer>

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
    var subkelas = '<?php echo $subkelas ;?>'   
    var mapel = '<?php echo $mapel ;?>' 
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    
    async function init_form() {
        await load_thn_ajaran()
        await load_jenjang_pendidikan()
        await load_kelas()
        await load_subkelas()
        await load_semester()
        await load_jenis_penilaian()
        await load_mapel()
        await load_tbl_hasil_penilaian([])
        <?php simpan_kunjungan(); ?>
    }
   
    async function load_thn_ajaran() {
        await fetch('<?php echo site_url('ujian/bank_soal/get_thn_ajaran') ;?>')
        .then(response => response.json())
        .then( resultData => {
            var data = resultData.data
            var ta_aktif = ''
            var html = '';           
                html +='<select name="list_thnajaran" id="list_thnajaran" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih thn ajaran</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){         
                    if (thnajaran == data[i].thnajaran_cls || data[i].aktif=="1" ){    
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

    async function load_jenjang_pendidikan() {
        await fetch('<?php echo site_url('ujian/bank_soal/get_jenjang_pendidikan') ;?>?kelas='+kelas+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var flag = '';
           
            var html = '';           
                html +='<select name="list_jenjang" id="list_jenjang" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenjang</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){    
                    flag = data[i].flag                 
                    if(flag=="1"){                         
                        html +='    <option style="color:black" value='+data[i].group_cls+' selected>'+data[i].group_cls+'</option>'                                        
                    }else{
                        html +='    <option style="color:black" value='+data[i].group_cls+'>'+data[i].group_cls+'</option>'                                        
                    }   
                }
            }     
                html +='</select>'                
            document.getElementById('list_jenjang_div').innerHTML = html   

            if(flag=='1'){
                // load_kelas()
                $('#list_jenjang').css('color','black')                           
            }
        })
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
                $('#list_kelas').val(kelas)
            }
            if(subkelas!=''){
                load_subkelas()
                //$('#list_kelas').css('color','black')
            }
        })
    }

    async function load_subkelas() {
        var list_kelas = $('#list_kelas').val()    
        if (list_kelas!=undefined){
            kelas = list_kelas
        }       
        await fetch('<?php echo site_url('ujian/bank_soal/get_subkelas') ;?>?kelas='+kelas+'')
        .then(response => response.json())
        .then(responseData => {           
            var data = responseData.data
            var html = '';           
                html +='<select name="list_subkelas" id="list_subkelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih subkelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){   
                    if(subkelas==data[i].subkelas_cls){
                        html +='    <option style="color:black" value='+data[i].subkelas_cls+' selected>'+data[i].subkelas_cls+'</option>'                                        
                    }else{                 
                        html +='    <option style="color:black" value="'+data[i].subkelas_cls+'">'+data[i].subkelas_cls+'</option>'                                                                 
                    }
                }
            }     
                html +='</select>'                 
            document.getElementById('list_subkelas_div').innerHTML = html
            if(subkelas!=''){               
                $('#list_subkelas').css('color','black')    
                $('#list_subkelas').val(subkelas)           
                fetch_tbl_hasil_penilaian()           
            }
        })
    }

    async function load_semester() {
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

    async function load_jenis_penilaian() {
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

    async function load_mapel() {
        await fetch('<?php echo site_url('ujian/bank_soal/get_mapel');?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data          
            var html = '';           
                html +='<select name="list_mapel" id="list_mapel" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih mapel</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){   
                    if(mapel==data[i].matapel_cls){
                        html +='    <option style="color:black" value='+data[i].matapel_cls+' selected>'+data[i].deskripsi+'</option>'                                        
                    }else{                      
                        html +='    <option style="color:black" value='+data[i].matapel_cls+'>'+data[i].deskripsi+'</option>'    
                    }                                    
                }
            }     
                html +='</select>'                
            document.getElementById('list_mapel_div').innerHTML = html
            if(mapel!=''){
                $('#list_mapel').css('color', 'black')
                fetch_tbl_hasil_penilaian()
            }
        })
    }

    function load_tbl_hasil_penilaian(data) {        
        var html = '';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_hasil_penilaian">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No</th>';
        html += '			<th>NIS</th>';
        html += '			<th>Nama</th>';          
        html += '			<th>Status File Temporary</th>';  
        html += '			<th>Nilai</th>';  
        html += '			<th width="100px">Proses</th>';              
        html += '		</tr>';       		
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            var no=0
            html += '<tbody class="col-form-label-sm">';         
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr id="'+ no +'">';                
                html += '   <td width="40pt" style="vertical-align: middle; min-width:50pt; text-align:center;">'+no+'</td>';//0
                html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].nis+'</td>';  //1
                html += '   <td style="vertical-align: middle;" class="text-nowrap">'+data[count].nama+'</td>';//2               
                
                if(data[count].nama_file==null){                            
                    html += '   <td style="text-align:center"></td>';//3                          
                    html += '   <td style="display:none"><input name="status[]" id="status_'+count+'" value="0"></input></td>';  //4  
                }else{
                    html += '   <td style="text-align:center;" class="text-success"><b>Ada<b></td>';//3                                          
                    html += '   <td style="display:none"><input name="status[]" id="status_'+count+'" value="1"></input></td>';  //4
                }          

                if(data[count].nilai==null){
                    html += '   <td style="vertical-align: middle; min-width:100pt; text-align:center;"></td>';//5                                      
                }else{
                    html += '   <td style="vertical-align: middle; min-width:100pt; text-align:center;">'+Math.trunc(data[count].nilai)+'</td>';//5                                      
                }      
                html += '   <td style="display:none"><input name="nis[]" id="nis_'+count+'" value="'+data[count].nis+'"></input></td>';  //6                
                
                if(data[count].nama_file==null){
                    html += '   <td style="max-width:100px; text-align:center;"><button type="button" id="btn_proses_per_nis" class="btn btn-sm btn-primary btn-shadow" data-nis="'+data[count].nis+'" title="Proses" disabled><i class="bi bi-gear"></i> Proses</button></td>';//9
                }else{
                    html += '   <td style="max-width:100px; text-align:center;"><button type="button" id="btn_proses_per_nis" class="btn btn-sm btn-primary btn-shadow" data-nis="'+data[count].nis+'" title="Proses"><i class="bi bi-gear"></i> Proses</button></td>';//9
                }                
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';
                                
        document.getElementById("tbl_bank_soal_div").innerHTML = html;  
        //document.getElementById("tbl_bank_soal_div").style.height = "550px";       
    }

    function fetch_tbl_hasil_penilaian() {
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val() 
        var kelas = $('#list_kelas').val() 
        var subkelas = $('#list_subkelas').val() 
        var semester = $('#list_semester').val()         
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        var mapel = $('#list_mapel').val()
               
        fetch('<?php echo site_url('ujian/daftar_nilai/get_tbl_daftar_nilai_json');?>?thnajaran='+thnajaran                                                                       
                                                                        +'&kelas='+kelas                                                                        
                                                                        +'&semester='+semester                                                                        
                                                                        +'&jenis_penilaian='+jenis_penilaian
                                                                        +'&mapel='+mapel
                                                                        +'&jenjang='+jenjang
                                                                        +'&subkelas='+subkelas+'')
        .then(function(response){
            return response.json();    
        }).then( function (responseData){  
            console.log(responseData.data)
            load_tbl_hasil_penilaian(responseData.data); 
        });            
    }

    $(document).on('change','#list_jenjang', function () {
        $('#list_jenjang').css('color','black')     
        $('#list_jenjang').css('border-color','')  
        load_kelas()  
        load_tbl_hasil_penilaian([])
    })

    $(document).on('change','#list_kelas', function () {
        $('#list_kelas').css('color','black')  
        $('#list_kelas').css('border-color','')   
        load_subkelas()
        load_tbl_hasil_penilaian([])
    })

    $(document).on('change','#list_subkelas', function () {
        $('#list_subkelas').css('color','black')     
        $('#list_subkelas').css('border-color','')   
        load_tbl_hasil_penilaian([])    
        $('#list_mapel').val('')  
        $('#list_mapel').css('color','grey')
    })

    $(document).on('change','#list_semester', function () {
        $('#list_semester').css('color','black')   
        $('#list_semester').css('border-color','')
        load_jenis_penilaian()
        load_tbl_hasil_penilaian([])
    })

    $(document).on('change','#list_jenis_penilaian', function () {
        $('#list_jenis_penilaian').css('color','black')   
        $('#list_jenis_penilaian').css('border-color','')
        load_tbl_hasil_penilaian([])
        $('#list_mapel').val('')
        $('#list_mapel').css('color','grey')
    })

    $(document).on('change','#list_mapel', function () {
        $('#list_mapel').css('color','black')
        $('#list_mapel').css('border-color','')
        fetch_tbl_hasil_penilaian()
    })    

    $(document).on('click', '#btn_process_all', function () {
        var form_data = $('#simpan_form').serialize();
        $('body').addClass('waiting')

        fetch('<?php echo site_url('ujian/daftar_nilai/proses_hasil_ujian_json') ;?>',{
            method:"POST",
            body: new URLSearchParams(form_data)
        })
        .then(response => response.json())
        .then( async resultData =>{
            if(resultData.status==true){
                await fetch_tbl_hasil_penilaian()               
            }
            alert(resultData.message)
            $('body').removeClass('waiting')
        })                
    })

    $(document).on('click', '#btn_proses_per_nis', function () {
        //var form_data = $('#simpan_form').serialize();
        $('body').addClass('waiting')
        
        var nis = $(this).attr('data-nis')        
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val() 
        var kelas = $('#list_kelas').val() 
        var subkelas = $('#list_subkelas').val() 
        var semester = $('#list_semester').val()         
        var jenis_penilaian = $('#list_jenis_penilaian').val()
        var mapel = $('#list_mapel').val()
        
        const payload = {          
            nis:nis,
            thnajaran:thnajaran,
            jenjang:jenjang,
            kelas:kelas,
            subkelas:subkelas,
            semester:semester,
            jenis_penilaian:jenis_penilaian,
            mapel:mapel
        };
       
        fetch('<?php echo site_url('ujian/daftar_nilai/proses_hasil_ujian_json_per_nis') ;?>',{
            method:"POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then( async resultData =>{
            if(resultData.status==true){
                await fetch_tbl_hasil_penilaian()               
            }
            alert(resultData.message)
            $('body').removeClass('waiting')
        })                
    })


</script>

<style>
    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }

    body.waiting * {
        cursor: progress;
    }
</style>