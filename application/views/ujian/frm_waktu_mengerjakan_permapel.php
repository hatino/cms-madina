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
            <h3 class="text-header header_center">Waktu Pengerjaan (Per Mapel)</h3>            
            
            <input type="hidden" id="txt_seq_no", name="txt_seq_no" value="0">
            <input type="hidden" id="txt_mapel", name="txt_mapel">            
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
                    <td width="180">                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Waktu Pengerjaan/soal :</label>                                                        
                    </td>
                    <td></td>
                </tr>
                <tr class="borderless-bottom">
                    <td width="120">                     
                        <label for="txt_waktu_pg" class="col-sm col-form-label col-form-label-sm">Soal Pilihan Ganda (menit)</label>
                    </td>  
                    <td>
                        <input class="form-control form-control-sm" name="txt_waktu_pg" id="txt_waktu_pg" autocomplete="off">
                    </td>
                </tr>
                <tr class="borderless-bottom">
                    <td width="120">                     
                        <label for="txt_waktu_uraian" class="col-sm col-form-label col-form-label-sm">Soal Uraian (menit)</label>
                    </td>  
                    <td>
                        <input class="form-control form-control-sm" name="txt_waktu_uraian" id="txt_waktu_uraian" autocomplete="off">
                    </td>
                </tr>
            </table>
            <button type="button" class="btn btn-sm btn-submit btn-shadow" id="btn_simpan">Simpan</button>&nbsp;
            <button type="button" class="btn btn-sm btn-warning text-light btn-shadow" id="btn_batal">Batal</button>

            <hr style="margin-top: 15px; margin-bottom: 15px">

            <div style="line-height: 5px;"><br></div>
            <div class="tscroll">
                <div id="tbl_waktu_permapel_div" class="table-responsive table-height"></div>       
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
        fetch_tbl_waktu_permapel()
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

    function get_tbl_search_mapel() {
        var cari_mapel = $('#txt_cari_mapel').val()       
        fetch('<?php echo site_url('ujian/bank_soal/get_tbl_search_mapel') ; ?>?cari_mapel='+cari_mapel+'')
        .then( response => response.json())
        .then( dataResult => {                  
            load_tbl_mapel(dataResult.data)             
        })                
    } 

    function fetch_tbl_waktu_permapel() {
        fetch('<?php echo site_url('ujian/master/get_tbl_waktu_permapel');?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data                  
            var html = '';           
                html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_waktu_permapel">';            
                html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
                html += '		<tr class="text-nowrap">';    
                html += '			<th>No</th>'; 
                html += '			<th>Jenjang</th>';     
                html += '			<th>Kelas</th>';           
                html += '			<th>Mata Pelajaran</th>';
                html += '			<th>Semester</th>';
                html += '			<th>Soal PG (menit)</th>';     
                html += '			<th>Soal Uraian (menit)</th>';               
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
                        html += '   <td width="50pt" style="vertical-align: middle; text-align:center;">'+no+'</td>';//0                        
                        html += '   <td width="100pt" style="vertical-align: middle; text-align:center;" class="text-nowrap">'+data[count].group_cls+'</td>';  //1
                        html += '   <td width="100pt" style="vertical-align: middle; text-align:center;" class="text-nowrap">'+data[count].kelas_cls+'</td>';  //2
                        html += '   <td style="vertical-align: middle; max-width:100pt;" class="text-nowrap">'+data[count].deskripsi+'</td>';  //3
                        html += '   <td width="100pt" style="vertical-align: middle; text-align:center" class="text-nowrap">'+data[count].semester+'</td>'; //4
                        html += '   <td width="40pt" style="vertical-align: middle; text-align:center" class="text-nowrap">'+data[count].soal_pg+'</td>';//5
                        html += '   <td width="40pt" style="vertical-align: middle; text-align:center" class="text-nowrap">'+data[count].soal_uraian+'</td>';//6                                  
                        html += '   <td class="fix_width_col2"><button type="button" id="btn_edit" class="btn btn-sm btn-success btn-shadow" data-seqno="'+data[count].seq_no+'" title="Edit"><i class="bi bi-pencil-square"></i></button></td>';//7
                        html += '   <td class="fix_width_col2"><button type="button" id="btn_delete" class="btn btn-sm btn-danger btn-shadow" data-seqno="'+data[count].seq_no+'" title="Hapus"><i class="bi bi-trash"></i></button></td>';//8                                         
                        html += '   <td style="display:none;">'+data[count].seq_no+'</td>';//9
                        html += '   <td style="display:none;" class="text-nowrap">'+data[count].matapel_cls+'</td>'; //10
                        html += '</tr>'; 
                    }            
                    html += '</tbody>';  
                }
                html += '</table>';
                document.getElementById('tbl_waktu_permapel_div').innerHTML = html            
        })        
    }

    function load_tbl_mapel(data) {
        console.log(data)
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
                html += '   <td width="30pt" style="text-align:right;"><a id="pilih_mapel" data-id="'+data[count].matapel_cls+'" style="cursor:pointer" title="Pilih Mapel" ><img src="'+ path_blank_image +'" class="img-width" /></a></td>'; //7 
                html += '</tr>'; 
            }            
            html += '</tbody>';  
        }
        html += '</table>';                                
        document.getElementById("tbl_mapel_div").innerHTML = html;       
    }

    function input_area_clear() {
        let x = document.forms["simpan_form"];
        x["list_jenjang"].value = '';
        x['list_jenjang'].style.color = 'gray'
        x["list_kelas"].value = '';
        x['list_kelas'].style.color = 'gray'
        x["txt_mapel"].value = '';
        x["txt_nama_mapel"].value = '';
        x["list_semester"].value = '';    
        x['list_semester'].style.color = 'gray'    
        x["txt_waktu_pg"].value = '';
        x["txt_waktu_uraian"].value = '';
        x["txt_seq_no"].value = '0';
    }

    function validasi_data_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];
        let list_jenjang = x["list_jenjang"].value;
        let list_kelas = x["list_kelas"].value;
        let kode_mapel = x["txt_mapel"].value;
        let nama_mapel = x["txt_nama_mapel"].value;
        let list_semester = x["list_semester"].value;        
        let waktu_pg = x["txt_waktu_pg"].value;
        let waktu_uraian = x["txt_waktu_uraian"].value;
                      
        if(list_jenjang==''){
            $('#list_jenjang').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_jenjang').css('border-color', '')
        }

        if(list_kelas==''){
            $('#list_kelas').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_kelas').css('border-color', '')
        }

        if(kode_mapel==''){
            $('#txt_nama_mapel').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_nama_mapel').css('border-color', '')
        }

        if(nama_mapel==''){
            $('#txt_nama_mapel').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_nama_mapel').css('border-color', '')
        }

        if(list_semester==''){
            $('#list_semester').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_semester').css('border-color', '')
        }

        if(list_semester==''){
            $('#list_semester').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#list_semester').css('border-color', '')
        }

        if(waktu_pg==''){
            $('#txt_waktu_pg').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_waktu_pg').css('border-color', '')
        }
       
        if(waktu_uraian==''){
            $('#txt_waktu_uraian').css('border-color', '#cc0000')  
            valid=false;
        }else{
            $('#txt_waktu_uraian').css('border-color', '')
        }
                
        return valid;
    }

    $(document).on('change','#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')
        $('#list_jenjang').css('border-color', '')
        load_kelas()        
    })

    $(document).on('change','#list_kelas', function () {
        $('#list_kelas').css('color', 'black')
        $('#list_kelas').css('border-color', '')             
    })

    $(document).on('change', '#list_semester', function () {
        $('#list_semester').css('color','black')
        $('#list_semester').css('border-color','')
    })

    $(document).on('click', '#btn_browse_mapel', function () {  
        get_tbl_search_mapel()        
        $('#modal_browse_mapel').modal('show')
    })

    $(document).on('click', '#btnclose_modalmapel', function () {
        $('#modal_browse_mapel').modal('hide')
    })

    $(document).on('click', '#pilih_mapel', async function (event) {
        var mapel = $(this).attr('data-id')
        var tbl = document.getElementById('tbl_mapel')
        var idx = event.target.closest('tr').id
        var nama_mapel = tbl.rows[idx].cells[2].textContent
        $('#txt_mapel').val(mapel)
        $('#txt_nama_mapel').val(nama_mapel)    
        $('#txt_nama_mapel').css('border-color', '')  
        $('#modal_browse_mapel').modal('hide')
    })    

    $(document).on('click', '#btn_cari_mapel', function () {
        get_tbl_search_mapel()
    })
    
    $(document).on('click','#btn_batal', async function () {
        input_area_clear()
    })

    $(document).on('click','#btn_simpan', async function () {
       
        var valid_data = await validasi_data_submit();    
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        // var valid_cek_data_exists  = await cek_data_exists_insert()           
        // if (valid_cek_data_exists==false){
        //     alert('Data sudah ada')
        //     return false
        // }        
       
        var form_data= await $('#simpan_form').serialize();
        const response = await fetch('<?php echo site_url('ujian/master/simpan_waktu_permapel') ;?>',{
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
            await fetch_tbl_waktu_permapel();
        }        
    })

    $(document).on('click', '#btn_edit', async function () {
        var tbl = document.getElementById('tbl_waktu_permapel')
        var idx = $(this).closest('tr').attr('id')
        var jenjang = tbl.rows[idx].cells[1].innerHTML
        var kelas = tbl.rows[idx].cells[2].innerHTML
        var matapel_des = tbl.rows[idx].cells[3].innerHTML
        var semester = tbl.rows[idx].cells[4].innerHTML
        var soal_pg = tbl.rows[idx].cells[5].innerHTML
        var soal_uraian = tbl.rows[idx].cells[6].innerHTML
        var seqno = tbl.rows[idx].cells[9].innerHTML
        var matapel_cls = tbl.rows[idx].cells[10].innerHTML

        $('#list_jenjang').val(jenjang)
        $('#list_jenjang').css('color', 'black')
        await load_kelas()
        $('#list_kelas').val(kelas)   
        $('#list_kelas').css('color', 'black')     
        $('#txt_mapel').val(matapel_cls)
        $('#txt_nama_mapel').val(matapel_des)
        $('#list_semester').val(semester)
        $('#list_semester').css('color', 'black')    
        $('#txt_waktu_pg').val(soal_pg)
        $('#txt_waktu_uraian').val(soal_uraian)
        $('#txt_seq_no').val(seqno)
    })

    $(document).on('click','#btn_delete', function (event) {    
        var confirm_del = confirm('Apakah Anda yakin ingin menghapus data?')
        if (confirm_del==false){
            return false
        }
               
        var seqno = $(this).attr('data-seqno')
        fetch('<?php echo site_url('ujian/master/delete_waktu_permapel') ;?>',{
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
                    fetch_tbl_waktu_permapel()
                }                
            })
        .catch(err => {
            alert(err);
        });   
               
       
    })

    $(document).on('blur', '#txt_waktu_pg', function () {
         $('#txt_waktu_pg').css('border-color', '') 
    })

    $(document).on('blur', '#txt_waktu_uraian', function () {
         $('#txt_waktu_uraian').css('border-color', '') 
    })

</script>

<style>
    .fix_width_col2 {
        width: 40px;
        text-align: center;
    }
    .img-width {
        width: 15pt;
        height: 15pt;
    }

    .btn-shadow {
        box-shadow: 1px 2px 5px #000000;   
    }
</style>