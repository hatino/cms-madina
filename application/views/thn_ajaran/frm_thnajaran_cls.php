<body onload="load_tbl()"></body>

<h4 class="title-color">Master Tahun Ajaran</h4>

<!-- TAB-->
<ul class="nav nav-tabs btn-sm" style="border-bottom-color: transparent">
    <li class="nav-item">
        <a href="#master" class="nav-link active" data-bs-toggle="tab">Master Thn Ajaran</a>
    </li>
    <li class="nav-item">
        <a href="#setting" class="nav-link" data-bs-toggle="tab">Periode Thn Ajaran</a>
    </li>           
</ul>


<div class="tab-content">
    <div class="tab-pane fade show active" id="master">
        <!--Master Thn Ajaran -->      
       
        <table class="table table-sm table-borderless" style='margin-bottom:5px'>
            <input type="hidden" name="txtStatus_Edit" id="txtStatus_Edit" class="form-control">
            <tr>
                <td width ="150" >
                    <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kode</label>
                </td>
                <td >
                    <div class="input-group input-group-sm col-sm-10">    
                        <input type="text" name="txtthnajaran_kd" id="txtthnajaran_kd" class="form-control">
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Deskripsi</label>
                </td>
                <td>
                    <div class="input-group input-group-sm col-sm-10">
                        <input type="text" name="txtthnajaran_des" id="txtthnajaran_des" class="form-control" >
                    </div>                
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" onclick="btn_simpan_click()" id="btnSimpan" class="btn btn-submit btn-sm">Simpan</button>
                    <button type="button" onclick="btn_batal_click()" id="btnBatal" class="btn btn-cancel btn-sm">Batal</button>
                </td>
            </tr>           
        </table>
        <hr style="margin-top: 5px; margin-bottom: 5px;">
        <div id="tbl_mst"></div>
    </div>

    <div class="tab-pane fade" id="setting">
   
         <table class="table table-sm table-borderless" style="margin-bottom: 5px;"> 
           
            <input type="hidden" name="txtstatus_edit_set" id="txtstatus_edit_set" class="form-control">            
            <input type="hidden" name="tgl_mulai_temp" id="tgl_mulai_temp" class="form-control">
            <tr>
                <td width ="150"><label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kode</label></td>
                <td >
                    <div class="input-group-sm col-sm-3">
                    <div class="input-group input-group-sm" id="cbo_thn_ajaran">                           

                        <!--select name="list_thnajaran_kd" id="list_thnajaran_kd" class="form-control" onchange="tampil_deskripsi()">
                            <?php
                            echo "<option value=''></option>";
                            foreach ($list_thnajarancls->result() as $s)
                            {
                                echo "<option value='$s->Description'>$s->ThnAjaranCls</option>";
                            }
                            ?>
                        </select-->

                    </div>
                    </div>
                </td>
            </tr>             
            <tr class="borderless">
                <td><label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Deskripsi</label></td>
                <td>
                    <div class="input-group input-group-sm col-sm-10">    
                        <input type="text" name="txtthnajaran_des_set" id="txtthnajaran_des_set" class="form-control">
                    </div>
                </td>                
            </tr>  
            <tr class="borderless">
                <td width ="150"><label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Tgl Mulai</label></td>
                <td>
                    <div class="input-group-sm col-sm-3">
                    <div class="input-group input-group-sm col-sm-10">
                        <input type="text" id="dtTglMulai" class="form-select datetimepicker" data-toggle="datetimepicker" data-target="#datepicker" autocomplete="off" />    
                    </div>                    
                    </div>
                </td>
            </tr>
            <tr class="borderless">
                <td width ="150"><label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Tgl Selesai</label></td>
                <td>
                    <div class="input-group-sm col-sm-3">
                    <div class="input-group input-group-sm col-sm-10">
                        <input type="text" id="dtTglSelesai" class="form-select" autocomplete="off" />                            
                    </div>                    
                    </div>
                </td>
            </tr>
            <tr class="borderless">
                <td>
                    <button type="button" onclick="btn_simpan_set_click()" id="btnSimpan_Set" class="btn btn-submit btn-sm">Simpan</button>                    
                    <button type="button" onclick="btn_batal_set_click()" id="btnBatal" class="btn btn-cancel btn-sm">Batal</button>
                </td>
            </tr>           
         </table>
        
         <hr style="margin-top: 5px; margin-bottom: 5px;">
        <div id="tbl_setting"></div>
    </div>   
</div>

<link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
<script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
   
    function load_tbl(){
        load_tbl_mst()
        load_tbl_setting()
        load_cbo_thn_ajaran()
    }

    function load_tbl_mst(){                  
        $.ajax({
            type:"POST",
            url:"load_tbl_mst",
            data:"",
            success:function(html){                
                $("#tbl_mst").html(html);
            }
        });          
    }

    function load_tbl_setting(){
        $.ajax({
            type:"POST",
            url:"load_tbl_setting",
            data:"",
            success:function(html){
                 $("#tbl_setting").html(html);
            }
        })
    }

    function load_cbo_thn_ajaran() {
        $.ajax({
            type:"POST",
            url:"load_cbo_thn_ajaran",
            data:"",
            success:function(html) {
                $("#cbo_thn_ajaran").html(html);
            }
        });
    }

    //#######################################################################################################################
    async function btn_simpan_click(){
        var mst_kode = $("#txtthnajaran_kd").val();
        var mst_deskripsi = $("#txtthnajaran_des").val();        

        valid_data = await validasi_simpan_mst(mst_kode,mst_deskripsi);        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    
        
        //cek data already exists
        var status_edit = $("#txtStatus_Edit").val();      
        if(status_edit==''){
            var result = await fetch('cek_thn_ajaran_exists?thn_ajaran_cls='+mst_kode+'', {method:"GET", mode: "no-cors" })
            const result_exists = await result.text()       
            if (result_exists >= 1){
                alert('Data sudah ada')
                return false;
            }
        }

        $("#btnSimpan").attr("disabled", "disabled");

        var status_edit = $("#txtStatus_Edit").val();

        if(status_edit=='True'){

        //###### PROSES UPDATE #######  
            
            $.ajax({
                type:"POST",
                url:"save_mst_update",
                data:{
                        mst_kode:mst_kode, 
                        mst_deskripsi:mst_deskripsi
                    },
                cache:false,
                success:function(dataResult){
                    var dataResult = JSON.parse(dataResult);   
                    if(dataResult.statusCode==200)
                    {
                        $("#btnSimpan").removeAttr("disabled");
                        $("#txtthnajaran_kd").removeAttr("disabled");                        
                        alert("Update Data Sukses !");
                        load_tbl_mst();
                        load_cbo_thn_ajaran();
                        input_area_clear();
                    }
                    else if(dataResult.statusCode==201){
                       alert("Error occured !");
                    }
                }
            });
        }
        else{
        //###### PROSES INSERT #######

            $.ajax({
            type:"POST",
            url:"save_mst_insert",
            data:{
                    mst_kode:mst_kode, 
                    mst_deskripsi:mst_deskripsi
                },
            cache: false,
            success:function(dataResult){                             
                var dataResult = JSON.parse(dataResult);                      
                    if(dataResult.statusCode==200)
                    {
               
                        $("#btnSimpan").removeAttr("disabled");
                        alert("Simpan Data Sukses !");
                        load_tbl_mst();
                        load_cbo_thn_ajaran();
                        input_area_clear();

                    }
                    else if(dataResult.statusCode==201){
                       alert("Error occured !");
                    }
                
                }
            });     

        }
    }

    function validasi_simpan_mst(mst_kode,mst_deskripsi) {
        let valid=true;		

        if(mst_kode=='')
        {
            valid = false;
            $('#txtthnajaran_kd').css('border-color', '#cc0000');
        }else{
            $('#txtthnajaran_kd').css('border-color', '');
        }
        
        if(mst_deskripsi=='')
        {
            valid = false;
            $('#txtthnajaran_des').css('border-color', '#cc0000');
        }else{
            $('#txtthnajaran_des').css('border-color', '');
        }

        return valid
                   
    } 

    
    async function btn_simpan_set_click(){
        //get list_thnajaran_kd.text
        var sel = document.getElementById('list_thnajaran_kd');
        var opt = sel.options[sel.selectedIndex];               

        var kode = opt.text;
        var deskripsi = $("#txtthnajaran_des_set").val();
        var tgl_mulai = $('#dtTglMulai').val();
        var tgl_mulai_temp = $('#tgl_mulai_temp').val();
        var tgl_selesai = $('#dtTglSelesai').val();
       
        valid_data = await validasi_simpan_setting(kode, deskripsi, tgl_mulai, tgl_selesai);        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    
        
        //cek data already exists
        var status_edit = $("#txtstatus_edit_set").val();              
        if(status_edit==''){
            var result = await fetch('cek_setting_thn_ajaran_exists?thn_ajaran_cls='+kode+'&tgl_mulai='+tgl_mulai+'', {method:"GET", mode: "no-cors" })
            const result_exists = await result.text()      
           
            if (result_exists >= 1){
                alert('Data sudah ada')
                return false;
            }
        }
      

        $("#btnSimpan").attr("disabled",true);

        var status_edit = $("#txtstatus_edit_set").val();
        
        if(status_edit=='True'){

        //###### PROSES UPDATE #######  
            
            $.ajax({
                type:"POST",
                url:"save_setting_update",
                data:{
                        kode:kode, 
                        deskripsi:deskripsi,
                        tgl_mulai:tgl_mulai,
                        tgl_mulai_temp:tgl_mulai_temp,
                        tgl_selesai:tgl_selesai
                    },
                cache:false,
                success:function(dataResult){
                    var dataResult = JSON.parse(dataResult);   
                    if(dataResult.statusCode==200)
                    {
                        $("#btnSimpan").removeAttr("disabled");
                        $("#txtthnajaran_kd").removeAttr("disabled");                        
                        alert("Update Data Sukses !");
                        load_tbl_setting();                        
                        input_area_set_clear();
                    }
                    else 
                    {
                       alert(dataResult.statusCode);
                    }
                }
            });            
            
        }

        else {          

            //###### PROSES INSERT SETTING THN AJARAN #######
            $.ajax({
            type:"POST",
            url:"save_setting_insert",
            data:{
                    kode : kode, 
                    deskripsi : deskripsi,
                    tgl_mulai : tgl_mulai,                    
                    tgl_selesai : tgl_selesai
                },
            cache: false,
            success:function(dataResult){         

               var dataResult = JSON.parse(dataResult);                
                    
                    if(dataResult.statusCode==200)
                    {
               
                        $("#btnSimpan_Set").removeAttr("disabled");
                        alert("Simpan Data Sukses !");
                        load_tbl_setting();
                        input_area_set_clear();

                    }
                    else //if(dataResult.statusCode==201)
                    {
                        alert(dataResult.statusCode);
                       //alert("Error occured !");
                    }
               
            }
            });   
           
        }
    }

    function validasi_simpan_setting(kode, deskripsi, tgl_mulai, tgl_selesai) {
        var valid = true;

        if(kode==''){
            valid=false
            $('#list_thnajaran_kd').css('border-color', '#cc0000')                              
        }else{
            $('#list_thnajaran_kd').css('border-color', '')     
        }

        if(deskripsi=='')
        {
            valid=false
            $("#txtthnajaran_des_set").css('border-color', '#cc0000')           
        }else{
            $("#txtthnajaran_des_set").css('border-color', '') 
        }

        if(tgl_mulai=='')
        {
            valid=false
            $('#dtTglMulai').css('border-color', '#cc0000')
        }else{
            $('#dtTglMulai').css('border-color', '')
        }

        if(tgl_selesai=='')
        {
            valid=false
            $('#dtTglSelesai').css('border-color', '#cc0000')    
        }else{
            $('#dtTglSelesai').css('border-color', '')    
        }

        return valid
    }
   


//#######################################################################################################################
    function btn_batal_click(){
        $("#txtthnajaran_kd").removeAttr("disabled");        
        input_area_clear();
     }

    function btn_batal_set_click() {
       $('#list_thnajaran_kd').attr("disabled",false);
       input_area_set_clear();
    }

//#######################################################################################################################
    $(document).ready(function() {
        $(document).on("click", "#hapus_mst", function() { 
            var msg = confirm("Apakah anda yakin ingin menghapus data");
            if(msg==false){
                die;
            }
            var id= $(this).attr("data-id");
            var row_index = $(this).closest("tr").index()+1;
            var x = document.getElementById("table2").rows[row_index].cells[1].innerHTML;
                        
            $.ajax({
                url: "delete_mst",
                type: "POST",
                data: {
                    thn_ajarancls: id                              
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        //$("#butsave").removeAttr("disabled");
                        //$('#fupForm').find('input:text').val('');
                        //$("#success").show();
                        //$('#success').html('Data added successfully !');     
                        alert("Hapus Data Sukses !");
                        input_area_clear();
                        load_cbo_thn_ajaran();
                        load_tbl_mst();                   
                    }
                    else if(dataResult.statusCode==201){
                       alert("Error occured !");
                    }
                    
                }
            });
        });

        $(document).on('click','#hapus_setting',function(){
            var msg=confirm('Apakah Anda yakin ingin menghapus data ?')
            if(msg==false)
            {
                return;
            }
            var row_index=$(this).closest('tr').index()+1;
            var thnajarancls = document.getElementById('table_setting').rows[row_index].cells[1].innerHTML;
            var tglmulai = document.getElementById('table_setting').rows[row_index].cells[3].innerHTML;

            $.ajax({
                type:"POST",
                url:"delete_setting",
                data:{
                    thnajarancls : thnajarancls,
                    tglmulai : tglmulai                
                },
                cache:false,
                success: function(dataResult){                    
                    var dataResult = JSON.parse(dataResult);                    
                    if(dataResult.statusCode==200){
                        alert('Hapus Data Sukses');
                        input_area_set_clear();
                        load_tbl_setting();
                    }
                    else{
                        alert(dataResult.statusCode);
                    }
                }
            });
        });

//#######################################################################################################################
        $(document).on("click", "#edit_mst", function() { 
            var id= $(this).attr("data-id");           
            var row_index = $(this).closest("tr").index()+1;
            var thn_ajaran_cls = document.getElementById("table2").rows[row_index].cells[1].innerHTML;
            var thn_ajaran_desc= document.getElementById("table2").rows[row_index].cells[2].innerHTML;

            $("#txtStatus_Edit").val('True'); 
            $("#txtthnajaran_kd").val(thn_ajaran_cls);
            $("#txtthnajaran_des").val(thn_ajaran_desc);
            $("#txtthnajaran_kd").attr("disabled", true);

        });

        $(document).on("click","#edit_setting", function(){
            var id= $(this).attr("data-id");
            var row_index = $(this).closest("tr").index()+1;
            var thn_ajaran_cls = document.getElementById("table_setting").rows[row_index].cells[1].innerHTML;
            var thn_ajaran_desc= document.getElementById("table_setting").rows[row_index].cells[2].innerHTML;
            
            var tgl_mulai= document.getElementById("table_setting").rows[row_index].cells[3].innerHTML;
            var tgl_mulai_temp = document.getElementById("table_setting").rows[row_index].cells[3].innerHTML;
            var tgl_selesai= document.getElementById("table_setting").rows[row_index].cells[4].innerHTML;
       
            $('#dtTglMulai').datepicker('setDate', tgl_mulai).datepicker('fill');
            $('#dtTglSelesai').datepicker('setDate', tgl_selesai).datepicker('fill');

            /* 
            //******** [start] To Find data of Table send to array **************
            var arr = [];

            $("#table_setting tr").each(function(item,i) {
                //console.log($(this).find('td').eq(1).text());

                arr.push($(this).find('td').eq(1).text());
            })            
            //******** [end] To Find data of table and send to array **************
            */
            
            //******** [start] To find data of dropdownlist and send to array **************
            var arrval = [];
            var arrtext = [];

            $("#list_thnajaran_kd option").each(function(){                               
                var thisOptionText=$(this).text();                
                var thisOptionValue=$(this).val();                
                //console.log(thisOptionValue);
                                                
               arrtext.push(thisOptionText);
               arrval.push(thisOptionValue);                        
            });
            //******** [end] To find data of dropdownlist and send to array **************
                       
            select_default(thn_ajaran_cls, arrval, arrtext, "list_thnajaran_kd");
            $('#list_thnajaran_kd').attr("disabled",true);
            $('#txtstatus_edit_set').val('True');
            $('#txtthnajaran_des_set').val(thn_ajaran_desc);
            //$('#dtTglMulai').val(tgl_mulai);
            //$('#dtTglSelesai').val(tgl_selesai);            
            $('#tgl_mulai_temp').val(tgl_mulai_temp);
            
        })
    })

    function select_default(my_option, all_options_val, all_options_text, dropdown_id){
 
        var temp = "";
        for(var i = 0; i < all_options_text.length; i++){
            if(my_option == all_options_text[i]){
                temp += "<option value='"+all_options_val[i]+"' selected>"+all_options_text[i]+"</option>";
            }else{
                temp += "<option value='"+all_options_val[i]+"'>"+all_options_text[i]+"</option>";
            }
        }
        document.getElementById(dropdown_id).innerHTML = temp;
 
    }
/*
    $(document).ready(function() {
    $('#butsave').on('click', function() {
        $("#butsave").attr("disabled", "disabled");
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var city = $('#city').val();
        if(name!="" && email!="" && phone!="" && city!=""){
            $.ajax({
                url: "save.php",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    city: city              
                },
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        $("#butsave").removeAttr("disabled");
                        $('#fupForm').find('input:text').val('');
                        $("#success").show();
                        $('#success').html('Data added successfully !');                        
                    }
                    else if(dataResult.statusCode==201){
                       alert("Error occured !");
                    }
                    
                }
            });
        }
        else{
            alert('Please fill all the field !');
        }
    });
});
*/    
    function input_area_clear(){
        $("#txtthnajaran_kd").val('');
        $("#txtthnajaran_des").val('');    
        $("#txtStatus_Edit").val('');    
    }

    function input_area_set_clear(){        
        $('#txtstatus_edit_set').val('');        
        $('#list_thnajaran_kd').val('');
        $('#list_thnajaran_kd').attr("disabled", false);
        $('#txtthnajaran_des_set').val('');
        $('#dtTglMulai').val('');
        $('#dtTglSelesai').val('');
        $('#tgl_mulai_temp').val('');
    }

    function tampil_deskripsi(){
        var Deksripsi = $("#list_thnajaran_kd").val();
        $("#txtthnajaran_des_set").val(Deksripsi);
    }
    
</script>

<style type="text/css">
    /* .borderless td {
    border-top-style: none;}
    /*border: none !important;
    padding: 0px !important;}*/
    
    /* thead th {
    background-color: #006DCC;
    color: white;
    } */ 

</style>


<script>
$(document).ready(function() {
    $('#dtTglMulai').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

     $('#dtTglSelesai').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    // $('#dtTglMulai').datepicker({
    //         format:"yyyy-mm-dd",
    //         //toggleActive: true,
    //         autoclose: true,            
    //         changeMonth: true,
    //         changeYear: true,
    //         todayHighlight: true
    //     }).datepicker('update', new Date());         
});
</script>






