<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="./datepicker/dist/css/bootstrap-datepicker.min.css">     -->
    <!-- <script src="./datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
      
    
</head>
<body onload="init_form()">     
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>
        <h3 class="text-header mb-1"><strong>Tahun Ajaran</strong></h3>  
        <hr style="margin-top: 5px;">
        <br>
        <ul class="nav nav-tabs btn-sm" style="border-bottom-color: transparent">
            <li class="nav-item">
                <a href="#master" class="nav-link active" data-bs-toggle="tab">Master Thn Ajaran</a>
            </li>
            <li class="nav-item">
                <a href="#setting" class="nav-link" data-bs-toggle="tab">Setting Pendaftaran</a>
            </li>           
        </ul>
       

        <div class="tab-content">
        <br>
            <div class="tab-pane show active" id="master">
                <!--Master Thn Ajaran -->      
            
                <table class="table table-sm table-borderless" style='margin-bottom:5px'>
                    <input type="hidden" name="txt_status_edit" id="txt_status_edit" class="form-control">
                    <tr>
                        <td width ="150" >
                            <label for="txt_thn_ajaran_cls" class="col-sm col-form-label col-form-label-sm">Kode</label>
                        </td>
                        <td >
                            <div class="input-group input-group-sm col-sm-10">    
                                <input type="text" name="txt_thn_ajaran_cls" id="txt_thn_ajaran_cls" class="form-control" autocomplete="off">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Deskripsi</label>
                        </td>
                        <td>
                            <div class="input-group input-group-sm col-sm-10">
                                <input type="text" name="txt_thn_ajaran_nama" id="txt_thn_ajaran_nama" class="form-control" autocomplete="off">
                            </div>                
                        </td>
                       
                    </tr>                
                </table>

                <button type="button" id="btn_simpan_mst" class="btn btn-submit btn-shadow btn-sm"><i class="bi bi-save2"></i> Simpan</button>&nbsp;
                <button type="button" id="btn_cancel_mst" class="btn btn-cancel btn-shadow btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Batal</button>

                <hr style="margin-top: 10px; margin-bottom: 5px;">
                <div id="tbl_mst_thn_ajaran_div"></div>
            </div>            
        

            <div class="tab-pane fade" id="setting">

                <form method="post" id="simpan_form">
                    <table class="table table-borderless" style="margin-bottom: 5px;">
                        <tr>
                            <td width="150">
                                <label for="list_jenjang_div" class="col-sm col-form-label col-form-label-sm">Jenjang Pendidikan</label> 
                            </td>
                            <td>
                                <div class="input-group-sm col-sm-8">
                                <div class="input-group input-group-sm">
                                    <div class="input-group input-group-sm" name="list_jenjang_div" id="list_jenjang_div"></div>
                                </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="tscroll">
                        <div id="tbl_setting_thn_ajaran_div" class="table-responsive table-height"></div>
                    </div>
                    
                    <button type="submit" id="btn_submit" class="btn btn-sm btn-shadow btn-submit"><i class="bi bi-save2"></i> Submit</button>    
                </form>       
                      
            </div>   
           
        </div>
    
</body>
</html>


<script type="text/javascript">

    async function init_form(){
        //await cek_session_exists()
        await fetch_tbl_mst_thn_ajaran()
        await load_tbl_setting_thn_ajaran([])
        await fetch_list_jenjang()                
    }
    
    async function validasi_simpan_mst(kode, deskripsi, status_edit) {
        let valid=true;		
        if(kode=='')
        {
            valid = false;
            $('#txt_thn_ajaran_cls').css('border-color', '#cc0000');
        }else{
            $('#txt_thn_ajaran_cls').css('border-color', '');
        }
        
        if(deskripsi=='')
        {
            valid = false;
            $('#txt_thn_ajaran_nama').css('border-color', '#cc0000');
        }else{
            $('#txt_thn_ajaran_nama').css('border-color', '');
        }

        return valid
    }

    $(document).on('click','#btn_simpan_mst', async function () {
       
        var thn_ajaran_cls = $("#txt_thn_ajaran_cls").val();
        var thn_ajaran_nama = $("#txt_thn_ajaran_nama").val();      
        var status_edit = $("#txt_status_edit").val();     

        valid_data = await validasi_simpan_mst(thn_ajaran_cls, thn_ajaran_nama);        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    
        
         //cek data already exists
        if (status_edit != 'true'){
            var result = await fetch('<?php echo site_url('master/thn_ajaran/get_thn_ajaran_exists');?>?thn_ajaran_cls='+thn_ajaran_cls+'', {method:"GET", mode: "no-cors" })           
            const result_exists = await result.json()             
            if (result_exists.length > 0){               
                alert('Data suda ada')
                return false
            }            
        }
       
        fetch('<?php echo site_url('master/thn_ajaran/simpan_mst_thn_ajran');?>',{
                    method: 'POST',   
                    body: new URLSearchParams({thn_ajaran_cls:thn_ajaran_cls
                                            , thn_ajaran_nama:thn_ajaran_nama
                                            , status_edit:status_edit}),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
                console.log(dataResult);
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{                                      
                    alert('Simpan data sukses');                          
                    fetch_tbl_mst_thn_ajaran();
                    fetch_tbl_setting_thn_ajaran()
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    function fetch_tbl_mst_thn_ajaran(){       
           
        fetch('<?php echo site_url('master/thn_ajaran/get_data_tbl_thn_ajaran');?>').then(function(response){                   
            return response.json();    
        }).then(function (responseData){                
            load_tbl_mst_thn_ajaran(responseData.data[0]);               
        });            
    }

    function fetch_tbl_setting_thn_ajaran() {
        var jenjang = $('#list_jenjang').val()
        fetch('<?php echo site_url('master/thn_ajaran/get_data_tbl_setting_thn_ajaran');?>?jenjang='+jenjang+'').then(function(response){                   
            return response.json();    
        }).then(function (responseData){      
            if(jenjang==''){
                load_tbl_setting_thn_ajaran('');        
            }else{
                load_tbl_setting_thn_ajaran(responseData.data[0]);        
            }                   
        });        
    }
    
    
    function fetch_list_jenjang() {
        fetch('<?php echo site_url('master/thn_ajaran/get_data_list_jenjang');?>').then(function(response){                   
            return response.json();    
        }).then(function (responseData){    
            var data = responseData.data[0]
			var html = '';
				html += '<select name="list_jenjang" id="list_jenjang" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++)
			{
				html += '   <option style="color:black" value="'+data[count].group_cls +'">'+data[count].deskripsi+ '</option>';
			}							
				html += '</select>'
			document.getElementById('list_jenjang_div').innerHTML = html;	          
        });   
    }

    $(document).on('change', '#list_jenjang', function () {
        fetch_tbl_setting_thn_ajaran();
    })

    function load_tbl_mst_thn_ajaran(data) {          
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_mst_thn_ajaran">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Kode Thn Ajaran</th>';
        html += '           <th>Nama Thn Ajaran</th>';
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
    
        if(data.length>0)
        {
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td style="min-width:30pt">'+data[count].thn_ajaran_cls+'</td>';  //0
                html += '   <td>'+data[count].thn_ajaran_nama+'</td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_mst" data-id='+data[count].thn_ajaran_cls+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_mst" data-id='+data[count].thn_ajaran_cls+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_mst_thn_ajaran_div").innerHTML = html;           
    }

    function load_tbl_setting_thn_ajaran(data) {  
        
        var html = '';   
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_setting_thn_ajaran">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th style="min-width:60pt">Kode</th>';
        html += '           <th style="min-width:150pt">Deskripsi</th>';
        html += '           <th>Buka Pendaftaran</th>';
        html += '           <th style="min-width:100pt">Tgl Mulai Pendaftaran</th>';
        html += '           <th style="min-width:100pt">Tgl Selesai Pendaftaran</th>';
        html += '           <th>Tutup Pendaftaran</th>';
        html += '           <th style="min-width:100pt">Tgl Tutup Pendaftaran</th>';        
        html += '		</tr>';
        html += '   </thead>';              
        html += '<tbody>';  
        
        console.log(data)
        
        if(data.length>0)
        {           
            for(var count = 0; count < data.length; count++)
            {                 
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';                                               
                html += '   <td style="min-width:60pt">'+data[count].thn_ajaran_cls+'</td>';  //0   
                html += '   <td style="min-width:150pt">'+data[count].thn_ajaran_nama+'</td>';               
                

                if(data[count].status_open=='1'){
                html += '   <td width="3%" style="text-align:center"><input type="checkbox" class="chk_open" name="chk_open[]" id="chk_open_'+ count +'" value="1" checked></input></td>';
                html += '   <td align="center">';
                html += '       <div class="input-group-sm">'
                html += '           <input type="text" class="dt_mulai form-select form-select-sm" name="dt_mulai[]" id="dt_mulai_'+ count +'" value="'+data[count].tgl_mulai_pendaftaran+'" autocomplete="off"></input>';
                        
                //$('#dt_mulai_'+ count +'').datepicker('setDate', data[count].tgl_mulai_pendaftaran).datepicker('fill');
                
                html += '       </div>';
                html += '   </td>';
                html += '   <td align="center">';
                html += '       <div class="input-group-sm">'
                html += '           <input type="text" class="dt_selesai form-select form-select-sm" name="dt_selesai[]" id="dt_selesai_'+ count +'" value="'+data[count].tgl_selesai_pendaftaran+'" autocomplete="off"></input>';
                
                //$('#dt_selesai_'+ count +'').datepicker('setDate', data[count].tgl_selesai_pendaftaran).datepicker('fill');

                html += '       </div>';
                html += '   </td>';
                }else{
                html += '   <td width="3%" style="text-align:center"><input type="checkbox" class="chk_open" name="chk_open[]" id="chk_open_'+ count +'" value="0"></input></td>';
                html += '   <td>';
                html += '       <div class="input-group-sm">'
                html += '           <input type="text" class="dt_mulai form-select form-select-sm" name="dt_mulai[]" id="dt_mulai_'+ count +'" value="'+data[count].tgl_mulai_pendaftaran+'" autocomplete="off" disabled></input>';
                html += '       </div>';
                html += '   </td>';
                html += '   <td>';
                html += '       <div class="input-group-sm">'
                html += '           <input type="text" class="dt_selesai form-select form-select-sm" name="dt_selesai[]" id="dt_selesai_'+ count +'" value="'+data[count].tgl_selesai_pendaftaran+'" autocomplete="off" disabled></input>';
                html += '       </div>';
                html += '   </td>';
                }
                
                if(data[count].status_close=='1'){
                    html += '<td width="3%" style="text-align:center"><input type="checkbox" class="chk_close" name="chk_close[]" id="chk_close_'+ count +'" value="1" checked></input></td>';
                    html += '<td><input type="text" class="dt_close form-select form-select-sm" name="dt_close[]" id="dt_close_'+ count +'" value="'+data[count].tgl_close_pendaftaran+'" autocomplete="off"></input></td>';

                    //$('#dt_close_'+ count +'').datepicker('setDate', data[count].tgl_close_pendaftaran).datepicker('fill');

                }else{
                    html += '<td width="3%" style="text-align:center"><input type="checkbox" class="chk_close" name="chk_close[]" id="chk_close_'+ count +'" value="0" unchecked></input></td>';
                    html += '<td><input type="text" class="dt_close form-select form-select-sm" name="dt_close[]" id="dt_close_'+ count +'" value="'+data[count].tgl_close_pendaftaran+'" autocomplete="off" disabled></input></td>';
                }
               
                html += '   <td style="display:none"><input class="txt_thn_ajaran_cls form-control form-control-sm" name="txt_thn_ajaran_cls[]" id="txt_thn_ajaran_cls_'+ count +'" value="'+data[count].thn_ajaran_cls+'"></input></td>';
                html += '   <td style="display:none"><input class="chk_open_temp form-control form-control-sm" name="chk_open_temp[]" id="chk_open_temp_'+ count +'" value="'+data[count].status_open+'"></input></td>';
                html += '   <td style="display:none"><input class="chk_close_temp form-control form-control-sm" name="chk_close_temp[]" id="chk_close_temp_'+ count +'" value="'+data[count].status_close+'"></input></td>';
                html += '   <td style="display:none"><input class="dt_close_ori form-control form-control-sm" name="dt_close_ori[]" id="dt_close_ori_'+ count +'" value="'+data[count].tgl_close_pendaftaran+'" ></input></td>';
                html += '</tr>';                                                                                                   
            }              
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }          
        
        html += '   </tbody>';    
        html += '</table>';
        html += '</div>';

        document.getElementById("tbl_setting_thn_ajaran_div").innerHTML = html;  
        
        if(data.length > 10){        
            document.getElementById("tbl_setting_thn_ajaran_div").style.height = "550px";            
        }

        set_delivery_date();        
    }

    function set_delivery_date() {
        var tbl_rows = document.getElementById('tbl_setting_thn_ajaran').rows;
        for(var count = 0; count < tbl_rows.length -1; count++){ 

            var tgl_mulai = $('#dt_mulai_'+count+'').val()            
            $('#dt_mulai_'+ count +'').datepicker({
                format:"yyyy-mm-dd",
                //toggleActive: true,
                autoclose: true,            
                changeMonth: true,
                changeYear: true,
                todayHighlight: true
            }).datepicker('update', new Date(tgl_mulai)); 

            var tgl_selesai = $('#dt_selesai_'+count+'').val()
            $('#dt_selesai_'+ count +'').datepicker({
                format:"yyyy-mm-dd",
                //toggleActive: true,
                autoclose: true,            
                changeMonth: true,
                changeYear: true,
                todayHighlight: true
            }).datepicker('update', new Date(tgl_selesai)); 
           
            var tgl_close = $('#dt_close_'+count+'').val()
            $('#dt_close_'+ count +'').datepicker({
                format:"yyyy-mm-dd",
                //toggleActive: true,
                autoclose: true,            
                changeMonth: true,
                changeYear: true,
                todayHighlight: true
            }).datepicker('update', new Date(tgl_close)); 
        }       
    }
    

    $(document).on('click', '#delete_mst', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var thn_ajaran_cls = $(this).attr("data-id");//trade_code
        // var row_index = $(this).closest("tr").index()+1;
        
        fetch('<?php echo site_url('master/thn_ajaran/delete_mst_thn_ajran');?>',{
                    method: 'POST',   
                    body: new URLSearchParams({thn_ajaran_cls:thn_ajaran_cls}),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
                console.log(dataResult);
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{                                      
                    alert('Hapus data sukses');                          
                    fetch_tbl_mst_thn_ajaran();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })


    $(document).on('submit','#simpan_form', async function(event) 
    {        
        event.preventDefault();  

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Please complete the required data');
            return false;
        }

        //>>>>>>>>> TEXT BOX DISABLE DIRUBAH KE ENABALE <<<<<<<<<<        
        var tbl_rows = document.getElementById("tbl_setting_thn_ajaran").rows;           
        if(tbl_rows.length > 1)
        {              
            for( var i = 0 ;i < tbl_rows.length -1;i++)
            {                                   
                var chk_open = $('#chk_open_temp_'+ i +'').val();                               
                if(chk_open=='0'){
                    $('#dt_mulai_'+ i + '').attr('disabled', false);
                    $('#dt_selesai_'+ i + '').attr('disabled', false);
                }      

                var chk_close = $('#chk_close_temp_'+ i +'').val();                               
                if(chk_close=='0'){
                    $('#dt_close_'+ i + '').attr('disabled', false);                   
                }      
            }
        }

        var form_data= $(this).serialize();

        //>>>>>>>>> TEXT BOX DISABLE DIRUBAH KEMEBALI KE DISABLE <<<<<<<<<<
        if(tbl_rows.length > 1)
        {
            for( var i = 0 ;i < tbl_rows.length-1;i++)
            {
                var chk_open = $('#chk_open_temp_'+ i +'').val();                               
                if(chk_open=='0'){
                    $('#dt_mulai_'+ i + '').attr('disabled', true);
                    $('#dt_selesai_'+ i + '').attr('disabled', true);
                }      

                var chk_close = $('#chk_close_temp_'+ i +'').val();                               
                if(chk_close=='0'){
                    $('#dt_close_'+ i + '').attr('disabled', true);                   
                }               
            }
        }
      

        await fetch('<?php echo site_url('master/thn_ajaran/simpan_setting_thn_ajaran');?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then(dataResult => {               
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{                                      
                    alert(dataResult.message);
                }                
            })
        .catch(err => {
            alert(err);
        });                 
    })


    async function validasi_submit() {
        var tbl = await document.getElementById("tbl_setting_thn_ajaran")
        var irow = tbl.rows.length-1
         
        let valid=true;		
        
        for(var i = 0; i < irow; i++){
            var chk_open = $('#chk_open_temp_'+ i +'').val();
            var chk_close= $('#chk_close_temp_'+ i +'').val();
           

            if(chk_open=='1'){
                var tgl_mulai = $('#dt_mulai_'+ i + '').val()
                var tgl_selesai = $('#dt_selesai_'+ i + '').val()

                if(tgl_mulai==''){
                    valid = false
                    $('#dt_mulai_'+ i + '').css('border-color', '#cc0000');
                }else{
                    $('#dt_mulai_'+ i + '').css('border-color', '');
                }
                if(tgl_selesai==''){
                    valid = false
                    $('#dt_selesai_'+ i + '').css('border-color', '#cc0000');
                }else{
                    $('#dt_selesai_'+ i + '').css('border-color', '');
                }                
            }        
            if(chk_close=='1'){
                var tgl_close = $('#dt_close_'+ i + '').val()
               
                if(tgl_close==''){
                    valid = false
                    $('#dt_close_'+ i + '').css('border-color', '#cc0000');
                }else{
                    $('#dt_close_'+ i + '').css('border-color', '');
                }
            }
        }

        return valid
    }

    
    $(document).on('click', '#edit_mst', function () {
        var thn_ajaran_cls = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_mst_thn_ajaran")
        var thn_ajaran_nama =  tbl.rows[row_index].cells[1].innerHTML;
        
        $('#txt_thn_ajaran_cls').val(thn_ajaran_cls)
        $('#txt_thn_ajaran_cls').attr('disabled', true)
        $('#txt_thn_ajaran_nama').val (thn_ajaran_nama)
        $('#txt_status_edit').val('true')
    })
    
    $(document).on('click', '.chk_open', function () {
        var ir = $(this).closest("tr").index();        
        var checkedRows = document.getElementsByClassName('chk_open');    
        
        if(checkedRows[ir].checked==true){            
            $('#dt_mulai_'+ir+'').attr('disabled', false);  
            $('#dt_selesai_'+ir+'').attr('disabled', false);  
            $('#chk_open_temp_'+ir+'').val("1");
        }else{                                
            $('#dt_mulai_'+ir+'').val('')    
            $('#dt_selesai_'+ir+'').val('')         
            $('#dt_mulai_'+ir+'').attr('disabled', true);     
            $('#dt_selesai_'+ir+'').attr('disabled', true);        
            $('#chk_open_temp_'+ir+'').val("0");                                      
        }    
    })


    $(document).on('click', '.chk_close', function () {
        var ir = $(this).closest("tr").index();        
        var checkedRows = document.getElementsByClassName('chk_close');    
        
        if(checkedRows[ir].checked==true){    
            alert('cek')        
            $('#dt_close_'+ir+'').attr('disabled', false);  
            $('#chk_close_temp_'+ir+'').val("1");
        }else{                                
            $('#dt_close_'+ir+'').val('')         
            $('#dt_close_'+ir+'').attr('disabled', true);        
            $('#chk_close_temp_'+ir+'').val("0");                                      
        }    
    })

    $(document).on('click', '#btn_cancel_mst', function () {
        input_area_clear()
    })

    function input_area_clear() {
        $('#txt_thn_ajaran_cls').val('')
        $('#txt_thn_ajaran_nama').val('')        
        $('#txt_status_edit').val('')
        $('#txt_thn_ajaran_cls').attr('disabled', false)
    }
        

</script>
