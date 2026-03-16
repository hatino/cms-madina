<body onload="init_form()"></body>

<h4 class="title-color">User Setup</h4>

<table class="table table-sm table-borderless" style="margin-bottom: 5px;">
    <tr>
        <td>
            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">User ID</label>
        </td>
        <td width="100" >
            <div class="input-group input-group-sm">                
                    <input type="text" id="txtUser_id" class="form-control form-sm" />                              
            </div>
        </td>
        <td> </td>
    </tr>
   
    <tr class="borderless">    
        <td width="160">
            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Nama Lengkap</label>
        </td>
        <td width="500">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="txtUser_name">
            </div>
        </td>            
    </tr>         

    <tr class="borderless">    
        <td width="160">
            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Password</label>
        </td>
        <td width="500">
            <div class="input-group input-group-sm">
                <input type="password" class="form-control" id="txtPassword">
            </div>
        </td>            
    </tr>         

    <tr class="borderless">
        <td width ="160">
            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Status Admin</label>
        </td>
        <td >
            <div class="input-group input-group-sm">
                <select name="list_status" id="list_status" class="form-control">                     
                    <option value=''></option>";    
                    <option value='A'>Admin</option>";                            
                    <option value='N'>Non Admin</option>";                            
                </select>                    
            </div>
        </td>
    </tr>           

</table>

<button type="button" id="btnSimpan" class="btn btn-submit btn-sm"><i class="bi bi-save2"></i> Simpan</button>
<button type="button" id="btnTambah" class="btn btn-add btn-sm"><i class="bi bi-file-earmark-plus"></i> Tambah</button>

<hr style="margin-top: 5px; margin-bottom: 5px;">

<ul class="nav nav-tabs btn-sm" name="nav-tabs" style="border-bottom-color: transparent;">
    <li class="nav-item" >
        <a href="#daftar_user" class="nav-link active" data-bs-toggle="tab">Daftar User</a>
    </li>
    <li class="nav-item">
        <a href="#otoritas_user" class="nav-link" data-bs-toggle="tab">Otoritas User</a>
    </li>       
</ul>

<div class="tab-content" >
    <div id="daftar_user" class="tab-pane show active">        
        <div class="tscroll">
			<div id="tbl_daftar_user" class="tableFixHead"></div>
			<hr>			
		</div>		
    </div>

    <div id="otoritas_user" class="tab-pane fade">        
        <div class="tscroll">
			<div id="tbl_privilege_user" class="tableFixHead"></div>
			<hr>			
		</div>	
    </div>
</div>

<script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 

<script type="text/javascript">

    function init_form() {
        load_tbl_daftar_user()
    }

    function load_tbl_daftar_user() {
        
        $.ajax(
            {
                type:"POST",
                url:"load_tbl_daftar_user",
                data:"",
                success:function (html) 
                {
                    $('#tbl_daftar_user').html(html);
                }
            })
    }

    $(document).on('click','#edit_user', function() {
        var ir = $(this).closest("tr").index()+1;           
        var user_id = $(this).attr('data-id')
        var user_name = document.getElementById("table_daftar_user").rows[ir].cells[2].innerHTML;
        var password = document.getElementById("table_daftar_user").rows[ir].cells[3].innerHTML;
        var status_admin = document.getElementById("table_daftar_user").rows[ir].cells[4].innerHTML;
       
        $('#txtUser_id').val(user_id)
        $('#txtUser_id').attr('disabled',true)
        $('#txtUser_name').val(user_name)
        $('#txtPassword').val(password)
        $('#list_status').val(status_admin)

        fetch_tbl_privilege()
    })


    function fetch_tbl_privilege() {
        var user_id = $('#txtUser_id').val(); 
        fetch('get_data_tbl_privilege').then(function(response) {
            return response.json();
        }).then(function (responseData) {           
            console.log(responseData)
            // if (responseData[0]length>0){
            //     load_tbl_privilege(responseData)
            //     return true;           
            // }
                        
        }).catch(function(error) {
            alert(error)
        })    
    }

    function load_tbl_privilege(data) {       

        console.log(data)
        var html = '';    
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_privilege">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="">';  
        html += '			<th style="min-width:100px">Group</th>';      
        html += '			<th style="min-width:100px">Menu ID</th>';
        html += '			<th style="min-width:200px">Menu Name</th>';    
        html += '			<th style="min-width:80px"><input type="checkbox" id="chk_all_access"></input>&nbspAccess</th>';       
        html += '			<th style="min-width:80px"><input type="checkbox" id="chk_all_update"></input>&nbspUpdate</th>';        
        html += '   </thead>';   
            
        var group_menu = '';
        if(data.length > 0){
            html += '<tbody>';         
            for(var i = 0; i < data.length; i++)
            {                      
                html += '<tr class = "col-form-label-sm" id="'+ i +'">';    
                    
                if (group_menu != data[i].menu_group){
                    html += '<td rowspan="'+data[i].jml_menu+'">'+data[i].menu_group+'</td>'                 
                }     
                                
                html += '<td>'+data[i].menu_id+'</td>'
                html += '<td>'+data[i].menu_name+'</td>'

                var cek = data[i].allow_access ;
                if (cek == '1' ){                    
                    html += '<td style="text-align:center" width="3%"><input type="checkbox" class="chk_access" name="chk_access" id="chk_access_'+ i +'" value="1" checked></input></td>';                                                          
                }else{
                    html += '<td style="text-align:center" width="3%"><input type="checkbox" class="chk_access" name="chk_access" id="chk_access_'+ i +'" value="0" unchecked></input></td>';
                }     
                var cek2 = data[i].allow_update ;
                if (cek2 == '1' ){                    
                    html += '<td style="text-align:center" width="3%"><input type="checkbox" class="chk_update" name="chk_update" id="chk_update_'+ i +'" value="1" checked></input></td>';
                }else{
                    html += '<td style="text-align:center" width="3%"><input type="checkbox" class="chk_update" name="chk_update" id="chk_update_'+ i +'" value="0" unchecked></input></td>';
                }

                html += '<td style="display:none"><input type="text" class="chk_access_ori" name="chk_access_ori" id="chk_access_ori_'+ i +'" value="'+data[i].allow_access_ori+'"></input></td>';                                                         
                html += '<td style="display:none"><input style="display:none" type="text" class="chk_update_ori" name="chk_update_ori" id="chk_update_ori_'+ i +'" value="'+data[i].allow_update_ori+'"></input></td>';
                html += '<td style="display:none"><input style="display:none" type="text" class="chk_access_temp" name="chk_access_temp" id="chk_access_temp_'+ i +'" value="'+data[i].allow_access_temp+'"></input></td>';                                                         
                html += '<td style="display:none"><input style="display:none" type="text" class="chk_update_temp" name="chk_update_temp" id="chk_update_temp_'+ i +'" value="'+data[i].allow_update_temp+'"></input></td>';
                html += '<td style="display:none"><input style="display:none" type="text" class="txt_menu_id_ori" name="txt_menu_id_ori" id="txt_menu_id_ori_'+ i +'" value="'+data[i].menu_id+'"></input></td>';
                html += '</tr>'

                group_menu = data[i].menu_group
                
            }
        }
        html += '</table>';
        html += '</div>';        
        document.getElementById("div_tbl_privilege").innerHTML = html;       

        if(data.length > 10){        
            document.getElementById("div_tbl_privilege").style.height = "550px";            
        }       
    }

    

</script>

<style type="text/css">
    .borderless td {
    border-top-style: none;}
    /*border: none !important;
    padding: 0px !important;}*/
    
    thead th {
    background-color: #006DCC;
    color: white;
    }

</style>

