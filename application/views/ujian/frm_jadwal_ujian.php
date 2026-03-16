<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>   
    <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>   -->

    
    <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"-->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
    
</head>
<body>    
    <body onload="init_form()"></body>    
    <br>
    <form action="post" id="simpan_form">
        <div class="container mt-5">              
            <h3 class="text-header header_center">Jadwal Penilaian &nbsp;<span id="nama_mapel"></h3>            
           
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
                <tr class="borderless-bottom">
                    <td>                       
                        <label for="list_kelas" class="col-sm col-form-label col-form-label-sm">Kelas</label>                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_kelas_div"></div>
                    </td>
                <tr>
                <tr class="borderless-bottom">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Semester</label>                                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_semester_div"></div>
                    </td>
                </tr>
                <tr class="borderless-bottom">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Jenis Penilaian</label>                                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_jenis_penilaian_div"></div>
                    </td>
                </tr>
            </table>  

            <div style="line-height: 10px;"><br></div>
            <div class="tscroll">
                <div id="tbl_jadwal_ujian_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <br>
           
            <!-- The Modal Jadwal Ujian -->
            <div class="modal fade" id="modal_jadwal_ujian" role="dialog" data-bs-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered" >
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #006DCC;" >                 
                        <h5 class="modal-title text-white font-effect-emboss" style="font-size: 20px; " >Input Jadwal Penilaian</h5>                 
                    </div>
                                   
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="container">          
                                                        
                            <input type="hidden" name="txt_mapel_cls" id="txt_mapel_cls">
                            <input type="hidden" name="txt_bank_soal_id" id="txt_bank_soal_id">
                            <input type="hidden" name="txt_id" id="txt_id">
                          
                            <table class="table table-sm" style="margin-bottom: 10px;"> 
                                
                                <tr class="borderless-bottom">
                                    <td>
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
                                <tr class="borderless-bottom">
                                    <td>                        
                                        <label for="txt_tgl" class="col-sm col-form-label col-form-label-sm"><i class="bi bi-calendar3 icon"></i>&nbsp; Tanggal  </label>                                            
                                        <div class="input-group-sm col-sm">   
                                            <div class="input-group log-event" id="datetimepicker1" data-td-target-input="nearest" data-td-toggle="datetimepicker">                                        
                                                <input type="text" class="form-select" name="txt_tgl" id="txt_tgl" autocomplete="off">                                         
                                                <span class="input-group-text" data-td-target="#datetimepicker1" data-td-toggle="datetimepicker">
                                                    <span class="fa-solid fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="borderless-bottom">
                                    <td>
                                        <label class="text-primary"> Waktu Mengerjakan : <span id="div_waktu"></span></label>
                                    </td>                                     
                                </tr>
                                <tr class="borderless-bottom">
                                    <td>                        
                                        <label for="txt_jam_mulai" class="col-sm col-form-label col-form-label-sm"><i class="bi bi-clock"></i>&nbsp; Waktu Mulai (HH:MM)</label>                                            
                                        <div class="input-group-sm col-sm">          
                                            <input type="text" class="time-input form-control" name="txt_jam_mulai" id="txt_jam_mulai" placeholder="HH:MM" maxlength="5" autocomplete="off">
                                            <div id="errorMessage" class="error-message"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="borderless-bottom">
                                    <td>                        
                                        <label for="txt_jam_selesai" class="col-sm col-form-label col-form-label-sm"><i class="bi bi-clock"></i>&nbsp; Waktu Selsai (HH:MM)</label>                                            
                                        <div class="input-group-sm col-sm">          
                                            <input type="text" class="time-input form-control" name="txt_jam_selesai" id="txt_jam_selesai" placeholder="HH:MM" maxlength="5" readonly >
                                        </div>                                        
                                    </td> 
                                </tr>

                            </table>
                                    
                        </div>                    
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">   
                        <div class="container">  
                            <div class="row">
                                <div class="col-sm-6" style="display:flex; justify-content: left; align-items: left;">
                                    <button type="submit" id="btn_simpan" class="btn btn-sm btn-submit btn-shadow"><i class="bi bi-save"></i>&nbsp;Simpan</button>
                                </div>
                                <div class="col-sm-6" style="display:flex; justify-content: right; align-items: right;">
                                    <button type="button" id="btn_kembali_modal" class="btn btn-sm btn-dark btn-shadow"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
                                </div>           
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

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>     -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>


<script type="text/javascript">

     // Dapatkan referensi elemen input
    const tanggalInput = document.getElementById('txt_tgl');
    let datepickerInstance; // Untuk menyimpan instance datepicker

    // 1. Inisialisasi Datepicker (Hanya Tanggal)
    // Menggunakan objek Tempus Dominus dan menargetkan div wrapper
    datepickerInstance = new tempusDominus.TempusDominus(document.getElementById('datetimepicker1'), {
        display: {
            components: {
                decades: true,
                year: true,
                month: true,
                date: true,
                hours: false, // Matikan jam
                minutes: false, // Matikan menit
                seconds: false // Matikan detik
            }
        },
        localization: {
            locale: 'id', // Atur locale ke Bahasa Indonesia
            format: 'yyyy-MM-dd' // Atur format tampilan
        }
    });

    var user_id = '<?php echo $username ;?>'
    var status_user = '<?php echo $status_user ;?>'
    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var kelas = '<?php echo $kelas ;?>'
    var mapel = '<?php echo $mapel ;?>'  
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    var waktu_mengerjakan = 0
    var status_ekskul = '';
    
    async function init_form() {
        await load_thn_ajaran()    
        await load_jenjang_pendidikan()   
        await load_kelas() 
        await load_semester()               
        await load_jenis_penilaian()
        await load_tbl_jadwal_ujian([]) 
        <?php simpan_kunjungan(); ?>       
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
                    if(data[i].flag=="1"){                         
                        html +='    <option style="color:black" value='+data[i].group_cls+' selected>'+data[i].group_cls+'</option>'                                        
                    }else{
                        html +='    <option style="color:black" value='+data[i].group_cls+'>'+data[i].group_cls+'</option>'                                        
                    }   
                }
            }     
                html +='</select>'                
            document.getElementById('list_jenjang_div').innerHTML = html   

            if(kelas!=''){
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
            }
        })
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

    async function get_waktu_mengerjakan(id) {
        // var data = await fetch('<?php echo site_url('ujian/jadwal_ujian/get_waktu_mengerjakan') ;?>?bank_soal_id='+id+'',{method:"GET", mode:"no-cors"})
        // var get_waktu = await data.json()
        // return get_waktu     

        // var rs_waktu = await fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan') ;?>',{method:"GET", mode:"no-cors"})
        // var dataResult = await rs_waktu.json()
        // var data = dataResult.data
        var mapel = $('#txt_mapel_cls').val()
        var kelas = $('#list_kelas').val()
        var semester = $('#list_semester').val()
        var rs_waktu = await fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan_with_mapel') ;?>?mapel='+mapel
                                                                                                            +'&kelas='+kelas
                                                                                                            +'&semester='+semester+''
                                                                                                            ,{method:"GET", mode:"no-cors"})
        var dataResult = await rs_waktu.json()
        var data = dataResult.data
        return data;        
    }

    async function get_bobot_nilai_jml_soal() {
        var kelas = $('#list_kelas').val();
        var semester = $('#list_semester').val();
        var mapel = $('#txt_mapel_cls').val();
        // var rs_jml_soal = await fetch('<?php echo site_url('ujian/master/get_tbl_bobot_nilai') ; ?>?list_kelas='+kelas+'&list_semester='+semester+'')
        var rs_jml_soal = await fetch('<?php echo site_url('ujian/master/get_bobot_nilai') ; ?>?list_kelas='+kelas
                                                                                            +'&list_semester='+semester
                                                                                            +'&list_mapel='+mapel
                                                                                            +'&status_ekskul='+status_ekskul+'')
        var dataResult = await rs_jml_soal.json()
        var data = dataResult.data
        console.log(data)
        return data;             
    }

    
    $(document).on('change', '#list_thnajaran', function () {
        $('#list_thnajaran').css('color', 'black')
        $('#list_thnajaran').css('border-color', '')
        load_jenjang_pendidikan()
        load_tbl_jadwal_ujian([])
    })

    $(document).on('change', '#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')
        load_kelas()
        fetch_tbl_jadwal_ujian()
    })

    $(document).on('change', '#list_kelas', function () {
        $('#list_kelas').css('color', 'black')        
        fetch_tbl_jadwal_ujian()
    })

     $(document).on('change', '#list_semester', function () {
        $('#list_semester').css('color', 'black')
        $('#list_semester').css('border-color', '')
        load_jenis_penilaian()
        fetch_tbl_jadwal_ujian()
    })

    $(document).on('change', '#list_jenis_penilaian', function () {
        $('#list_jenis_penilaian').css('color', 'black')
        fetch_tbl_jadwal_ujian()      
    })

    $(document).on('change', '#txt_jam_mulai', function () {        
        var tgl = $('#txt_tgl').val()
        var jam = $('#txt_jam_mulai').val()      
        var tgl_temp = new Date(tgl + ' ' + jam)
        tgl_temp.setMinutes(tgl_temp.getMinutes()+waktu_mengerjakan)       
        
        var jam_selesai = tgl_temp.getHours() + ':' +tgl_temp.getMinutes()
        $('#txt_jam_selesai').val(jam_selesai)       
        
    })

    $(document).on('blur', '#txt_jam_mulai', function () {        
        var tgl = $('#txt_tgl').val()
        var jam = $('#txt_jam_mulai').val()      
        var tgl_temp = new Date(tgl + ' ' + jam)
        tgl_temp.setMinutes(tgl_temp.getMinutes()+waktu_mengerjakan)       
        
        var jam_selesai = tgl_temp.getHours() + ':' +tgl_temp.getMinutes()
        $('#txt_jam_selesai').val(jam_selesai)       
        
    })

    $(document).on('click','#btn_edit', async function (event) {
        var tbl = document.getElementById('tbl_jadwal_ujian')
        var ir = event.target.closest('tr').id

        var nama_mapel = tbl.rows[ir].cells[1].textContent
        var tgl = tbl.rows[ir].cells[3].textContent
        var jam_mulai = tbl.rows[ir].cells[4].textContent
        var jam_selesai = tbl.rows[ir].cells[5].textContent
        //6 - btn_edit
        //7 - btn_hapus
        var mapel_cls = tbl.rows[ir].cells[8].textContent
        var bank_soal_id = tbl.rows[ir].cells[9].textContent
        var id = tbl.rows[ir].cells[10].textContent
        status_ekskul = tbl.rows[ir].cells[11].textContent

        $('#txt_mapel_cls').val(mapel_cls)
        
        if(tgl==''){
            var DateTimeVal = moment(new Date()).toDate();
		    datepickerInstance.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
        }else{
             var DateTimeVal = moment(tgl).toDate();
		    datepickerInstance.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal));
        }
       
        var waktu_pg = 0
        var waktu_uraian = 0
        var rs_waktu = await get_waktu_mengerjakan(bank_soal_id)
        if(rs_waktu.length>0){           
            console.log(rs_waktu)
            waktu_pg = rs_waktu[0].soal_pg           
            waktu_uraian = rs_waktu[0].soal_uraian
            var waktu_pengerjaan  = 'PG : '+rs_waktu[0]['soal_pg']+ ', Uraian : '+rs_waktu[0]['soal_uraian']                  
            $('#txt_waktu_pengerjaan').val(waktu_pengerjaan)
        }else{
            $('#txt_waktu_pengerjaan').val('')           
        }

        var jml_soal_pg = 0
        var jml_soal_uraian = 0
        var rs_soal = await get_bobot_nilai_jml_soal()
        if(rs_soal.length>0){
            jml_soal_pg = rs_soal[0].jml_soal_pg
            jml_soal_uraian = rs_soal[0].jml_soal_uraian

            var bobot_nilai  = 'PG : '+rs_soal[0]['bobot_pg']+ ', Uraian : '+rs_soal[0]['bobot_uraian']
            var jml_soal = 'PG : '+rs_soal[0]['jml_soal_pg']+ ', Uraian : '+rs_soal[0]['jml_soal_uraian']
            $('#txt_bobot_nilai').val(bobot_nilai)
            $('#txt_jml_soal').val(jml_soal)
        }else{
            $('#bobot_nilai').val('')
            $('#txt_jml_soal').val('')
        }

        var waktu_pengerjaan_pg = waktu_pg * jml_soal_pg
        var waktu_pengerjaan_uraian = waktu_uraian * jml_soal_uraian
        waktu_mengerjakan = waktu_pengerjaan_pg + waktu_pengerjaan_uraian
              
        document.getElementById('div_waktu').innerHTML = waktu_mengerjakan + ' menit'
       
        errorMessageDiv.textContent = ''
        $('#txt_tgl').val(tgl)         
        $('#txt_jam_mulai').val(jam_mulai)
        $('#txt_jam_selesai').val(jam_selesai)       
        $('#txt_bank_soal_id').val(bank_soal_id)
        $('#txt_id').val(id)

        //get_waktu_pengerjaan()
        get_bobot_nilai_jml_soal()
       
        document.getElementById('list_mapel_div').innerHTML= '<h5 class="text-header">'+nama_mapel+'</h5>'        
        $('#modal_jadwal_ujian').modal('show')
    })

    async function get_status_mapel_pg() {    
        var kelas = $('#list_kelas').val()
        var semester = $('#list_semester').val()
        var mapel = $('#txt_mapel_cls').val()
        var rs_status_mapel_pg = await fetch('<?php echo site_url('ujian/master/get_status_mapel_pg') ;?>?list_kelas='+kelas
                                                                                            +'&list_semester='+semester
                                                                                            +'&list_mapel='+mapel+''
                                                                                            ,{method:"GET", mode: "no-cors" })
        var rs = await rs_status_mapel_pg.json() 
           
        return rs.data    
    }
      
    $(document).on('submit','#simpan_form', async function(event) {
        event.preventDefault();      
        
        var valid_data = await validasi_data_submit();           
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        var form_data= $(this).serialize();
               
        fetch('<?php echo site_url('ujian/jadwal_ujian/simpan_jadwal_ujian') ;?>',{
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
                    $('#modal_jadwal_ujian').modal('hide')
                    // input_area_clear()
                    fetch_tbl_jadwal_ujian()
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    $(document).on('click', '#btn_delete', function (event) {
        var confirm_del = confirm('Apakah Anda yakin ingin menghapus data?')
        if (confirm_del==false){
            return false
        }

        var tbl = document.getElementById('tbl_jadwal_ujian')
        var ir = event.target.closest('tr').id
        
        var mapel_cls = tbl.rows[ir].cells[8].textContent
        var bank_soal_id = tbl.rows[ir].cells[9].textContent
        var id = tbl.rows[ir].cells[10].textContent
        if(id=="null"){
            alert('Jadwal Penilaian belum diinput')
            return false
        }        
        var list_thnajaran = $('#list_thnajaran').val()
        var list_kelas = $('#list_kelas').val()
        var list_semester = $('#list_semester').val()
        var list_jenis_penilaian = $('#list_jenis_penilaian').val()

        const form_data = new FormData();
        form_data.append('list_thnajaran', list_thnajaran);
        form_data.append('list_semester', list_semester);
        form_data.append('list_kelas', list_kelas);
        form_data.append('list_jenis_penilaian', list_jenis_penilaian);
        form_data.append('mapel_cls', mapel_cls);
        form_data.append('id', id);
        
        
        fetch('<?php echo site_url('ujian/jadwal_ujian/delete_jadwal_ujian') ;?>',{
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
                    // input_area_clear()
                    fetch_tbl_jadwal_ujian()
                }                
            })
        .catch(err => {
            alert(err);
        });   
        

    })

    function validasi_data_submit(){       
        let valid=true;		
        let x = document.forms["simpan_form"];
        let tgl = x["txt_tgl"].value;
        let txt_jam_mulai = x["txt_jam_mulai"].value;
        let txt_jam_selesai = x["txt_jam_selesai"].value;
               
        if(tgl==''){
            valid=false;
            $('#txt_tgl').css('border-color', '#cc0000')            
        }else{
            $('#txt_tgl').css('border-color','')
        }
        if(txt_jam_mulai==''){
            $('#txt_jam_mulai').css('border-color', '#cc0000')
            valid=false;
        }else{
            $('#txt_jam_mulai').css('border-color', '')
        }
        if(txt_jam_selesai==''){
            $('#txt_jam_selesai').css('border-color', '#cc0000')
            valid=false;
        }else{
            $('#txt_jam_selesai').css('border-color', '')
        }
        
        return valid;
    }

    $(document).on('click', '#btn_kembali_modal', function () { 
        //input_area_clear()     
        $('#modal_jadwal_ujian').modal('hide')   
    })
    
    async function fetch_tbl_jadwal_ujian(){        
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 
        var jenis_penilaian = $('#list_jenis_penilaian').val()
                
        await fetch('<?php echo site_url('ujian/jadwal_ujian/get_tbl_jadwal_ujian');?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&semester='+semester
                                                                        +'&kelas='+kelas
                                                                        +'&jenis_penilaian='+jenis_penilaian+'')
        .then(function(response){
            return response.json();    
        }).then( async function (responseData){   
            console.log(responseData)
            await load_tbl_jadwal_ujian(responseData.data); 
        });            
    }

    function load_tbl_jadwal_ujian(data) {        
        var html = '';      
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_jadwal_ujian">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No</th>';
        html += '			<th>Mata Pelajaran</th>';
        html += '			<th>Jumlah Soal</th>';
        html += '			<th>Tanggal</th>';
        html += '			<th>Waktu Mulai</th>';
        html += '			<th>Waktu Selesai</th>'; 
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
                html += '   <td width="50pt" style="vertical-align: middle; text-align:center;">'+no+'</td>'; //0
                html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">'+data[count].deskripsi+'</td>';  //1
                if(data[count].status_soal=="0"){
                    html += '   <td width="180pt" class="text-danger" style="vertical-align: middle; text-align:center;" class="text-nowrap">'+data[count].jml_soal+'</td>';  //2                
                }else{
                    html += '   <td width="180pt" style="vertical-align: middle; text-align:center;" class="text-nowrap">'+data[count].jml_soal+'</td>';  //2                
                }                
                html += '   <td width="150pt" style="vertical-align: middle; text-align:center;">'+data[count].tgl+'</td>';//3
                html += '   <td width="150pt" style="vertical-align: middle; text-align:center;">'+data[count].jam_mulai+'</td>';//4   
                html += '   <td width="150pt" style="vertical-align: middle; text-align:center;">'+data[count].jam_selesai+'</td>';//5                                 
                html += '   <td class="fix_width_col2"><button type="button" id="btn_edit" class="btn btn-sm btn-success btn-shadow" data-id='+data[count].bank_soal_id+' title="Buat/Edit"><i class="bi bi-pencil-square"></i></button></td>';//6 
                html += '   <td class="fix_width_col2"><button type="button" id="btn_delete" class="btn btn-sm btn-danger btn-shadow" data-id='+data[count].bank_soal_id+' title="Hapus"><i class="bi bi-trash"></i></button></td>';//7 
                html += '   <td style="display:none;">'+data[count].matapel_cls+'</td>'//8
                html += '   <td style="display:none;">'+data[count].bank_soal_id+'</td>'//9
                html += '   <td style="display:none;">'+data[count].id+'</td>'//10
                html += '   <td style="display:none;">'+data[count].status_ekskul+'</td>'//11
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';
                                
        document.getElementById("tbl_jadwal_ujian_div").innerHTML = html;  
        document.getElementById("tbl_jadwal_ujian_div").style.height = "550px";       
    }
   
    // $(document).ready(function(){
    //     $('#txt_tgl').datepicker({
    //         format:"yyyy-mm-dd",
    //         // toggleActive: true,
    //         autoclose: true,            
    //         changeMonth: true,
    //         changeYear: true,
    //         todayHighlight: true
    //     })

    //     $('#txt_tgl').datepicker('setDate', new Date()); 
    // })

   
    // CUSTOME INPUT TIME//
    const customTimeInput = document.getElementsByClassName('time-input');
    const errorMessageDiv = document.getElementById('errorMessage');

    for (let i = 0; i < customTimeInput.length; i++) {
        customTimeInput[i].addEventListener('input', function(event) {
            let value = this.value;

            // Simpan posisi kursor
            let cursorPosition = this.selectionStart; 

            // Hapus semua karakter non-digit kecuali ':'         
            value = value.replace(/[^0-9:]/g, '');
            
            // Tambahkan ':' secara otomatis setelah 2 digit pertama
            if (value.length === 2 && cursorPosition === 2 && !value.includes(':')) {
                value += ':';
            }

            // Batasi panjang dan format
            if (value.length > 5) {
                value = value.substring(0, 5);
            }

            // Update nilai input
            this.value = value;

            // Kembalikan kursor ke posisi semula
            if (cursorPosition === 2 && value.length === 3 && event.inputType !== 'deleteContentBackward') {
                this.setSelectionRange(3, 3);
            } else {
                this.setSelectionRange(cursorPosition, cursorPosition);
            }

            // Validasi sederhana (bisa diperluas)
            validateTime(value);
            
            // alert(value)
        })

        customTimeInput[i].addEventListener('blur', function() {
            validateTime(this.value, true); // Validasi final saat keluar focus
        });

        function validateTime(timeString, finalCheck = false) {
            errorMessageDiv.textContent = ''; // Reset pesan error

            const regex = /^([01]\d|2[0-3]):([0-5]\d)$/; // Regex untuk HH:MM (24 jam)

            if (timeString === '') {
                if (finalCheck) {
                        errorMessageDiv.textContent = 'Waktu tidak boleh kosong.';
                }
                return;
            }

            if (!regex.test(timeString)) {
                errorMessageDiv.textContent = 'Format waktu tidak valid (HH:MM).';
                return false;
            }

            const [hours, minutes] = timeString.split(':').map(Number);

            if (hours < 0 || hours > 23 || minutes < 0 || minutes > 59) {
                errorMessageDiv.textContent = 'Jam harus antara 00-23 dan menit antara 00-59.';
                return false;
            }
            return true;
        };

    }

    
</script>

<style>
    .fix_width_col2 {
        width: 40px;
        text-align: center;
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

    .time-input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    } 
    .error-message {
        color: red;
        font-size: 0.8em;
        margin-top: 4px;
    }
    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
    

</style>