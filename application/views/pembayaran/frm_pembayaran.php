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
        <h3 class="text-header">Pembayaran Siswa</h3>
       
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
                <!-- <tr class="borderless-bottom" id="tr_kelas_by_user">
                    <td>                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kelas</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_kelas_by_user_div">
                    </td>
                </tr> -->

                <!--Tahun Ajaran-->
                <tr class="borderless-bottom" id="tr_thnajaran">
                    <td width="150">                     
                        <label for="list_thnajaran" class="col-sm col-form-label col-form-label-sm">Thn Ajaran</label>            
                    </td>            
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_thnajaran_div"></div>
                    </td>        
                </tr>
        
                <!--Jenjang Pendidikan-->
                <tr  class="borderless-bottom" id="tr_jenjang">
                    <td width="150">                        
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
                        <label for="list_subkelas" class="col-sm col-form-label col-form-label-sm">Sub Kelas</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_subkelas_div"></div>
                    </td>
                </tr>
                
                <tr class="borderless-bottom" id="tr_nama_siswa">
                    <td>                               
                        <label for="list_nama_siswa" class="col-sm col-form-label col-form-label-sm">Nama Siswa</label>            
                    </td>        
                    <td>                  
                        <div class="input-group input-group-sm  col-sm-5" id="list_nama_siswa_div">
                    </td>
                </tr>

                 <tr class="borderless-bottom" id="tr_lunas">
                    <td>                               
                        <label for="list_lunas" class="col-sm col-form-label col-form-label-sm">Lunas</label>            
                    </td>        
                    <td>                 
                        <div class="input-group input-group-sm  col-sm-5"> 
                            <select name="list_lunas" id="list_lunas" class="form-select">
                                <option value="0" selected>Belum</option>
                                <option value="1" >Sudah</option>
                                <option value="2" >Semua</option>
                            </select>
                        </div>
                    </td>
                </tr>
                 
            </table>
            
            <div style="line-height: 5px;"><br></div>
            <div class="tscroll">
                <div id="tbl_raport_div" class="table-responsive table-height"></div>       
            </div>
            <br>
            <div id="lbl_keterangan">
                <h4 style="color: green; text-align:center">Tidak ada tagihan</h4>
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
        // if (user_id=='admin'){
        if (status_admin=='1'||status_admin=='0'){
            await load_thn_ajaran()
            await load_jenjang_pendidikan()
            await load_kelas()
            await load_subkelas()
            await load_nama_siswa()            
            document.getElementById('tr_nama_siswa_by_user').style.display = 'none'
            // document.getElementById('tr_kelas_by_user').style.display = 'none'               
        }else{
            await load_nama_siswa_by_user()            
            document.getElementById('tr_thnajaran').style.display = 'none'
            document.getElementById('tr_jenjang').style.display = 'none'
            document.getElementById('tr_kelas').style.display = 'none'
            document.getElementById('tr_subkelas').style.display = 'none'
            document.getElementById('tr_nama_siswa').style.display = 'none'            
        }
         document.getElementById('tr_lunas').style.display = 'none'  
         load_tbl_pembayaran([])
    }

    $(document).on('change', '#list_thnajaran', function () {
        $('#list_thnajaran').css('color', 'black')       
        load_jenjang_pendidikan()        
    })

    $(document).on('change', '#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')        
        load_kelas()
    })

    $(document).on('change', '#list_kelas', function () {
        $('#list_kelas').css('color', 'black')                  
        load_subkelas()     
    })

    $(document).on('change', '#list_subkelas', function () {
        $('#list_subkelas').css('color', 'black')                  
        load_nama_siswa()              
    })

    $(document).on('change', '#list_nama_siswa', function () {
        $('#list_nama_siswa').css('color', 'black')        
        fetch_tbl_pembayaran()        
    })

    $(document).on('change', '#list_lunas', function () {             
        fetch_tbl_pembayaran()        
    })

    function load_nama_siswa_by_user() {  
        fetch('<?php echo site_url('pembayaran/pembayaran/get_nama_siswa_by_user') ;?>?user_id='+user_id+'')
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
            fetch_tbl_pembayaran()            
        });       
        
    }

    function load_thn_ajaran() {
        fetch('<?php echo site_url('pembayaran/pembayaran/get_thn_ajaran') ;?>')
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
        fetch('<?php echo site_url('pembayaran/pembayaran/get_jenjang_pendidikan') ;?>?thnajaran='+thnajaran+'')
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
        fetch('<?php echo site_url('pembayaran/pembayaran/get_kelas') ;?>?thnajaran='+thnajaran+'&jenjang='+jenjang+'')
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

    function load_subkelas() {
        var thnajaran = $('#list_thnajaran').val()
        var jenjang = $('#list_jenjang').val()
        var kelas = $('#list_kelas').val()
        fetch('<?php echo site_url('pembayaran/pembayaran/get_subkelas') ;?>?thnajaran='+thnajaran+'&jenjang='+jenjang+'&kelas='+kelas+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_subkelas" id="list_subkelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih subkelas</option>'  
            if (data.length > 0) {
                html +='    <option style="color:black" value="" >SEMUA</option>'  
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value="'+data[i].subkelas_cls+'">'+data[i].subkelas_cls+'</option>'                                        
                }
            }     
                html +='</select>'                
            document.getElementById('list_subkelas_div').innerHTML = html
        })
    }

    async function load_nama_siswa() {       
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val()
        var kelas = $('#list_kelas').val()
        var subkelas = $('#list_subkelas').val()       
      
        await fetch('<?php echo site_url('pembayaran/pembayaran/get_nama_siswa') ;?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&kelas='+kelas
                                                                        +'&subkelas='+subkelas+'')                                                                      
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

    async function fetch_tbl_pembayaran(){        
        var thnajaran = $('#list_thnajaran').val()       
        var jenjang = $('#list_jenjang').val()        
        var subkelas = $('#list_subkelas').val()          
        var nis = ''   
        var kelas = ''
        var lunas = $('#list_lunas').val() 
        
        //if(user_id=='admin'){
        if (status_admin=='1'||status_admin=='0'){
            nis = $('#list_nama_siswa').val()          
            kelas = $('#list_kelas').val()
            if( thnajaran==''||jenjang==''||kelas==''){
                return false
            }
        }else{            
            nis = $('#list_nama_siswa_by_user').val()
            kelas = ''
            thnajaran = ''
            subkelas = ''

            if(nis==''){
                return false
            }       
        }
       
        await fetch('<?php echo site_url('pembayaran/pembayaran/get_data_tbl_pembayaran');?>?thnajaran='+thnajaran
                                                                        +'&jenjang='+jenjang
                                                                        +'&kelas='+kelas
                                                                        +'&subkelas='+subkelas                                                                      
                                                                        +'&nis='+nis
                                                                        +'&lunas='+lunas+'')
        .then(function(response){                   
            return response.json();    
        }).then( async function (responseData){     
            console.log(responseData)      
            await load_tbl_pembayaran(responseData.data); 
        });            
    }

    async function load_tbl_pembayaran(data) {
        var html = '';               
        html += '<div>';
        html += '<table class="table table-sm table-bordered" id="tbl_daftar_calon_siswa">';            
        html += '	<thead class="col-form-label-sm text-light">';                                
        html += '		<tr class="text-nowrap" style="position: sticky; top: 0; background-color: rgba(40, 68, 47, 0.88); z-index: 2;">';    
        html += '			<th style="text-align: center;">No</th>';         
        html += '			<th style="vertical-align: middle;">Nama Pembayaran</th>';                            
        html += '			<th style="verticsal-align: middle;">Period</th>';
        html += '			<th style="verticsal-align: middle;">Tagihan</th>';
        html += '			<th style="vertical-align: middle;">Dibayar</th>';
        html += '			<th style="vertical-align: middle;">Sisa</th>';        
        html += '		</tr>';        
        html += '   </thead>';      
        
        if(data.length>0){           
            var no=0
            var total_tagihan = 0
            var total_dibayar = 0
            var total_sisa = 0
            var jenis_mapel = ''

            html += '<tbody>';         
            for(var count = 0; count < data.length; count++) {    
               
                no++      
                total_tagihan = total_tagihan + parseFloat(data[count].tagihan) 
                total_dibayar = total_dibayar + parseFloat(data[count].dibayar) 
                total_sisa = total_sisa + parseFloat(data[count].sisa) 
                var periode = formatTanggalManual(data[count].period)              

                html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
                html += '   <td width="80pt" style="text-align:center; min-width:30pt;">'+no+'</td>';                           
                html += '   <td style="text-align: left; min-width:100pt; class="text-nowrap">'+data[count].nama_pembayaran+'</td>';  //1
                html += '   <td width="150pt" style="text-align: left; min-width:80px;">'+periode+'</td>';  
                html += '   <td width="150pt" style="text-align: right; min-width:80px;">'+Math.trunc(data[count].tagihan).toLocaleString("id-ID")+'</td>';  
                html += '   <td width="150pt" style="text-align: right; min-width:80px;">'+Math.trunc(data[count].dibayar).toLocaleString("id-ID")+'</td>';
                html += '   <td width="150pt" style="text-align: right; min-width:80px;">'+Math.trunc(data[count].sisa).toLocaleString("id-ID")+'</td>';                
                html += '</tr>';
            }
            html += '<tr class = "col-form-label-sm " id="'+ count +'">';                
            html += '   <td style="vertical-align: middle; min-width:30pt"></td>';
            html += '   <td style="vertical-align: middle; min-width:30pt" class="text-nowrap">TOTAL</td>';  //1
            html += '   <td style="vertical-align: middle; min-width:40pt; text-align:center;"></td>';  
            html += '   <td style="text-align:right; min-width:40pt;">'+total_tagihan.toLocaleString("id-ID")+'</td>';
            html += '   <td style="text-align:right; min-width:30pt; ">'+total_dibayar.toLocaleString("id-ID")+'</td>';            
            html += '   <td style="text-align:right; min-width:30pt; ">'+total_sisa.toLocaleString("id-ID")+'</td>';            
            html += '</tr>';             
            html += '</tbody>';  
        }
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_raport_div").innerHTML = html;  
        if(data.length>10){
            document.getElementById("tbl_raport_div").style.height = "550px"; 
        }

        var nis = $('#list_nama_siswa').val()
        if(data.length==0 && nis!=null){           
            document.getElementById("lbl_keterangan").style.display='inline';            
        }else{
            document.getElementById("lbl_keterangan").style.display='none';
        }
              
    }
    
    function formatTanggalManual(tanggal) {
        const d = new Date(tanggal); // Buat objek Date dari input tanggal

        // Array nama bulan singkat
        const namaBulan = [
            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
        ];

        const hari = d.getDate(); // Mendapatkan tanggal (1-31)
        const bulan = namaBulan[d.getMonth()]; // Mendapatkan nama bulan dari array (0-11)
        const tahun = d.getFullYear(); // Mendapatkan tahun (4 digit)

        // Pastikan hari memiliki 2 digit (misal: 1 -> 01)
        const hariFormatted = String(hari).padStart(2, '0');

        return `${bulan} ${tahun}`;
    }

</script>

<style>
    #lbl_keterangan {
        text-align: center;
    }
</style>