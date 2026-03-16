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
            <h3 class="text-header header_center">Input Mapel Pilihan Ganda</h3>            
            
            <input type="hidden" id="txt_seq_no", name="txt_seq_no" value="0">
            <input type="hidden" id="list_mapel", name="list_mapel">
            <table class="table table-sm" style="margin-bottom: 10px;">
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
                <!-- <tr class="borderless-bottom" id="tr_thnajaran">
                    <td width="120">                     
                        <label for="list_mapel" class="col-sm col-form-label col-form-label-sm">Mata Pelajaran</label>
                    </td>            
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_mapel_div"></div>
                    </td>        
                </tr>  -->
                <tr class="borderless-bottom">
                    <td width="120">                     
                        <label for="txt_nama_mapel" class="col-sm col-form-label col-form-label-sm">Mata Pelajaran</label>                                        
                    </td>    
                    <td>                                                
                        <div class="input-group input-group-sm  col-sm-5">
                            <input type="text" class="form-control" id="txt_nama_mapel" value="" autocomplete="off">
                            <button type="button" id="btn_browse_mapel" class="btn btn-sm btn-info text-light btn-shadow" title="Cari Mapel" style="margin-left:3px"><i class="bi bi-search"></i></button>
                        </div>
                    </td>
                </tr>
                <tr class="borderless-bottom">
                    <td width="180">                               
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
                    <td width="120">                     
                        <label for="list_mapel" class="col-sm col-form-label col-form-label-sm">Jumlah Soal</label>
                    </td>  
                    <td>
                        <input class="form-control form-control-sm" name="txt_jml_soal" id="txt_jml_soal" autocomplete="off">
                    </td>
                </tr>
            </table>
            <button type="button" class="btn btn-sm btn-submit btn-shadow" id="btn_simpan">Simpan</button>&nbsp;
            <button type="button" class="btn btn-sm btn-warning text-light btn-shadow" id="btn_batal">Batal</button>

            <hr>

            <div style="line-height: 5px;"><br></div>
            <div class="tscroll">
                <div id="tbl_mapel_pg_div" class="table-responsive table-height"></div>       
            </div>

        </div>

        <div class="modal fade" id="modal_browse_mapel" role="dialog" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #006DCC;" >                 
                    <h5 class="modal-title text-white font-effect-emboss" style="font-size: 20px; " >Cari Mata Pelajaran</h5>                 
                    <button type="button" class="btn btn-danger text-light btn-sm" data-dismiss="modal" id="btnclose_modalmapel"><b>X</b></button>       
                </div>
            
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">
                       
                        <table class="table table-sm">                                
                            <tr class="borderless">
                                <td width ="120">
                                    <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Nama Mapel</label>
                                </td>
                                <td>
                                    <div  class="input-group input-group-sm">
                                        <input type="text" name="txt_cari_mapel" id="txt_cari_mapel" class="form-control">    
                                    </div>                    
                                </td>
                                <td>
                                    <div  class="input-group input-group-sm">
                                        <button type="button" class="btn btn-success btn-sm" id="btn_cari_mapel">Cari</button>
                                    </div>                    
                                </td>
                            </tr>			
                        </table>                            

                        <div class="tscroll" >
                            <div id="tbl_mapel_div"></div>
                        </div>                                
                    </div>                    
                </div>               
            </div>
        </div>
        </div>

    </form>
    <footer style="margin-top: 60px;"></footer>
</body>
</html>

<script type="text/javascript">
    var kelas_default = '';
    function init_form() {
        load_jenjang_pendidikan()
        load_kelas()
        load_mapel()
        fetch_tbl_mapel_pg()
    }

    function load_jenjang_pendidikan() {
        fetch('<?php echo site_url('ujian/bank_soal/get_jenjang_pendidikan') ;?>')
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
        })        
    }    

    function load_kelas() {        
        var jenjang = $('#list_jenjang').val()        
        fetch('<?php echo site_url('ujian/bank_soal/get_kelas') ;?>?jenjang='+jenjang+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_kelas" id="list_kelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){ 
                    if (kelas_default==data[i].kelas_cls){
                        html +='    <option style="color:black" value='+data[i].kelas_cls+' selected>'+data[i].kelas_cls+'</option>'      
                    }else{
                        html +='    <option style="color:black" value='+data[i].kelas_cls+'>'+data[i].kelas_cls+'</option>'      
                    }
                                                                                    
                }
            }     
                html +='</select>'                
            document.getElementById('list_kelas_div').innerHTML = html            
        })
    }

    function fetch_tbl_mapel_pg() {
        fetch('<?php echo site_url('ujian/master/get_tbl_mapel_pg');?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data                  
            var html = '';           
                html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_mapel_pg">';            
                html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
                html += '		<tr class="text-nowrap">';    
                html += '			<th>No</th>'; 
                html += '			<th>Jenjang</th>';     
                html += '			<th>Kelas</th>';           
                html += '			<th>Mata Pelajaran</th>';
                html += '			<th>Semester</th>';
                html += '			<th>Jumlah Soal</th>';                  
                html += '			<th colspan="2">Proses</th>';
                html += '			<th style="display:none;">Kode Mata Pelajaran</th>';
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
                        html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].group_cls+'</td>';  //1
                        html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].kelas_cls+'</td>';  //2
                        html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].deskripsi+'</td>';  //3
                        html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].semester+'</td>'; //4
                        html += '   <td style="vertical-align: middle;" class="text-nowrap">'+data[count].jml_soal+'</td>';//5                                    
                        html += '   <td class="fix_width_col2"><button type="button" id="btn_edit" class="btn btn-sm btn-success btn-shadow" data-seqno="'+data[count].seq_no+'" title="Edit"><i class="bi bi-pencil-square"></i></button></td>';//6
                        html += '   <td class="fix_width_col2"><button type="button" id="btn_delete" class="btn btn-sm btn-danger btn-shadow" data-seqno="'+data[count].seq_no+'" title="Hapus"><i class="bi bi-trash"></i></button></td>';//7                                               
                        html += '   <td style="display:none;">'+data[count].seq_no+'</td>';//8
                        html += '   <td style="display:none; vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].matapel_cls+'</td>'; //9
                        html += '</tr>'; 
                    }            
                    html += '</tbody>';  
                }
                html += '</table>';
                document.getElementById('tbl_mapel_pg_div').innerHTML = html            
        })        
    }

    function load_mapel() {
        fetch('<?php echo site_url('ujian/bank_soal/get_mapel');?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data          
            var html = '';           
                html +='<select name="list_mapel" id="list_mapel" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih mapel</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                      
                    html +='    <option style="color:black" value='+data[i].matapel_cls+'>'+data[i].deskripsi+'</option>'                         
                }
            }     
                html +='</select>'                
            document.getElementById('list_mapel_div').innerHTML = html            
        })
    }
    
    async function validasi_data_submit(){       
        let valid=true;		
        let x = await document.forms["simpan_form"];
        let list_jenjang = x["list_jenjang"].value;
        let list_kelas = x["list_kelas"].value;
        let list_mapel = x["list_mapel"].value;
        let nama_mapel = x["txt_nama_mapel"].value;
        let list_semester = x["list_semester"].value;        
        let txt_jml_soal = x["txt_jml_soal"].value;
                      
        if(list_jenjang==''){
            $('#list_jenjang').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_jenjang').removeClass('border-color', '')
        }
        if(list_kelas==''){
            $('#list_kelas').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_kelas').removeClass('border-color', '')
        }
        // if(list_mapel==''){
        //     $('#list_mapel').css('border-color', '#cc0000')  
        //     valid=false;
        // }else{
        //     $('#list_mapel').removeClass('border-color', '')
        // }
        if(list_mapel==''){
            $('#txt_nama_mapel').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_nama_mapel').css('border-color', '')
        }
        
        if(list_semester==''){
            $('#list_semester').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_semester').removeClass('border-color', '')
        }
         if(txt_jml_soal==''){
            $('#txt_jml_soal').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_jml_soal').removeClass('border-color', '')
        }

        return valid;
    }

    async function cek_data_exists_insert() {         
        var mapel = $('#list_mapel').val()        
        var semester = $('#list_semester').val()  
        var seqno = $('#txt_seq_no').val()       
        var kelas = $('#list_kelas').val() 
        
        var hasil_exists = await fetch('<?php echo site_url('ujian/master/cek_mapel_pg_exists_insert');?>?list_mapel='+mapel
                                                                                                +'&list_semester='+semester
                                                                                                +'&txt_seq_no='+seqno
                                                                                                +'&list_kelas='+kelas+'',                                                                                             
                                                                                                {metode:'GET',mode:"no-cors"})        
        var result = await hasil_exists.json()        
        if(result.data.length>0){
            return false
        }else{
            return true
        }        
    }

    $(document).on('click', '#btnclose_modalmapel', function () {
        $('#modal_browse_mapel').modal('hide')
    })

    $(document).on('click','#btn_edit', function (event) {
        var tbl = document.getElementById("tbl_mapel_pg")
        var idx = event.target.closest('tr').id
        var seqno = $(this).attr('data-seqno')
               
        var jenjang = tbl.rows[idx].cells[1].textContent 
        var kelas = tbl.rows[idx].cells[2].textContent 
        var nama_mapel = tbl.rows[idx].cells[3].textContent 
        var mapel = tbl.rows[idx].cells[9].textContent 
        var semester = tbl.rows[idx].cells[4].textContent       
        var jml_soal = tbl.rows[idx].cells[5].textContent     
       
        $('#list_jenjang').val(jenjang)
        kelas_default = kelas
        load_kelas()        
        $('#list_kelas').val(kelas)
        $('#list_mapel').val(mapel)
        $('#txt_nama_mapel').val(nama_mapel)
        $('#list_semester').val(semester)
        $('#txt_jml_soal').val(jml_soal)
        $('#txt_seq_no').val(seqno)

        $('#list_jenjang').css('color', 'black')    
        $('#list_kelas').css('color', 'black')   
        $('#list_mapel').css('color', 'black')     
        $('#txt_nama_mapel').css('color', 'black')       
        $('#list_semester').css('color', 'black')
        
    })

    $(document).on('click','#btn_delete', function (event) { 
    
        var confirm_del = confirm('Apakah Anda yakin ingin menghapus data?')
        if (confirm_del==false){
            return false
        }
               
        var seqno = $(this).attr('data-seqno')       
                
        fetch('<?php echo site_url('ujian/master/delete_mapel_pg') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({seqno:seqno})
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then( async dataResult => {                
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{
                    alert(dataResult.message);
                    input_area_clear()
                    fetch_tbl_mapel_pg()
                }                
            })
        .catch(err => {
            alert(err);
        });   
               
       
    })

    $(document).on('click','#btn_simpan', async function () {
       
        var valid_data = await validasi_data_submit();    
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        var valid_cek_data_exists  = await cek_data_exists_insert()           
        if (valid_cek_data_exists==false){
            alert('Data sudah ada')
            return false
        }        
       
        var form_data= await $('#simpan_form').serialize();       
        
        const response = await fetch('<?php echo site_url('ujian/master/simpan_mapel_pg') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        const dataResult = await response.json();

        if (dataResult.status === false) {
            alert(dataResult.message);
        } else {
            alert(dataResult.message);
            await input_area_clear();
            await fetch_tbl_mapel_pg();
        }
        
    })

    $(document).on('click','#btn_batal', function () {
        input_area_clear()
    })

    $(document).on('change', '#list_mapel', function () {
        $('#list_mapel').css('color','black')
        $('#list_mapel').css('border-color','')
    })

    $(document).on('change', '#list_semester', function () {
        $('#list_semester').css('color','black')
        $('#list_semester').css('border-color','')
    })

    $(document).on('change','#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')
        $('#list_jenjang').css('border-color', '')
        load_kelas()        
    })

    $(document).on('change','#list_kelas', function () {
        $('#list_kelas').css('color', 'black')
        $('#list_kelas').css('border-color', '')             
    })

    function input_area_clear() {
        kelas_default = '';
        let x = document.forms["simpan_form"];      
        x["list_jenjang"].value = "";
        x["list_kelas"].value = "";
        x["list_mapel"].value = "";
        x["txt_nama_mapel"].value = "";
        x["list_semester"].value = "";     
        x["txt_jml_soal"].value = "";   
        x["txt_seq_no"].value = "0";     

        x["list_jenjang"].style.color="gray" 
        x["list_kelas"].style.color="gray" 
        x["list_mapel"].style.color="gray"
        x["txt_nama_mapel"].style.color="gray"
        x["list_semester"].style.color="gray"

        $('#list_jenjang').css('border-color','')
        $('#list_kelas').css('border-color','')
        $('#list_mapel').css('border-color','')
        $('#txt_nama_mapel').css('border-color','')
        $('#list_semester').css('border-color','')
        $('#txt_jml_soal').css('border-color','')
    }

    $(document).on('click', '#btn_browse_mapel', function () {  
        get_tbl_search_mapel()        
        $('#modal_browse_mapel').modal('show')
    })

    $(document).on('click', '#btn_cari_mapel', function () {
        get_tbl_search_mapel()
    })

    $(document).on('click', '#pilih_mapel', async function (event) {
        var mapel = $(this).attr('data-id')
        var tbl = document.getElementById('tbl_mapel')
        var idx = event.target.closest('tr').id
        var nama_mapel = tbl.rows[idx].cells[2].textContent
        $('#list_mapel').val(mapel)
        $('#txt_nama_mapel').val(nama_mapel)    
        $('#txt_nama_mapel').css('border-color', '')  
       $('#modal_browse_mapel').modal('hide')
    })    

    function get_tbl_search_mapel() {
        var cari_mapel = $('#txt_cari_mapel').val()       
        fetch('<?php echo site_url('ujian/bank_soal/get_tbl_search_mapel') ; ?>?cari_mapel='+cari_mapel+'')
        .then( response => response.json())
        .then( dataResult => {                  
            load_tbl_mapel(dataResult.data)             
        })                
    } 

    function load_tbl_mapel(data) {        
        var html = ''
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_mapel">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">'; 
        html += '			<th>No</th>';       
        html += '			<th>Kode</th>';    
        html += '			<th>Mata Pelajaran</th>';
        html += '			<th width="30pt"></th>';
        html += '		</tr>';       		
        html += '   </thead>';      
        
        if(data.length>0) {           
            var no=0
            html += '<tbody class="col-form-label-sm">';         
            var path_blank_image = "<?php echo base_url() ?>" + 'images/images_ui/check-mark.png';
            for(var count = 0; count < data.length; count++) {     
                no++              
                html += '<tr id="'+ no +'">';                
                html += '   <td width="35pt" style="vertical-align: middle; text-align:center;">'+no+'</td>';//0                                
                html += '   <td width="30pt" style="vertical-align: middle; min-width:50pt;">'+data[count].matapel_cls+'</td>';//0                                
                html += '   <td>'+data[count].deskripsi+'</td>';//0                                
                html += '   <td width="30pt" style="display: flex; justify-content: left; align-items: left;"><a id="pilih_mapel" data-id="'+data[count].matapel_cls+'" style="cursor:pointer" title="Pilih Mapel" ><img src="'+ path_blank_image +'" class="img-width" /></a></td>'; //7 
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';                                
        document.getElementById("tbl_mapel_div").innerHTML = html;       
    }

</script>

<style>
    .fix_width_col2 {
        width: 40px;
        text-align: center;
    }
    .img-width {
        width: 20pt;
        height: 20ptt;
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
</style>