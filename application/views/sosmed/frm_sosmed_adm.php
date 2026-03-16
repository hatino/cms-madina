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
        
        <h3 class="text-header"><strong>Sosial Media</strong></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">
            <input type="hidden" name="_status_edit" id="_status_edit">
            <input type="hidden" name="_sosmed_id" id="_sosmed_id" value=0>

            <label for="list_sosmed_div" class="col-sm col-form-label col-form-label-sm">Nama Sosial Media</label> 
            <div class="input-group input-group-sm"> 
                <select name="list_sosmed" id="list_sosmed" class="form-select"> 
                    <option value=""></option> 			
                    <option value="yt">Youtube</option>';
                    <option value="ig">Instagram</option>';
                    <option value="fb">Facebook</option>';
                    <option value="tt">TikTok</option>';
                </select>
            </div>          

            <label for="txt_deskripsi" class="col-sm col-form-label col-form-label-sm">Deskripsi</label>
            <div class="input-group-sm col-sm-12">
                <input type="text" name="txt_deskripsi" id="txt_deskripsi" class="form-control">                            
            </div>	
            
            <label for="txt_link_video" class="col-sm col-form-label col-form-label-sm">Link Konten</label>
            <div class="input-group-sm col-sm-12">
                <textarea name="txt_link_video" id="txt_link_video" class="form-control" type="url" rows="4"></textarea> 
            </div>
           
            <br>
            <button type="submit" id="btnSubmit" class="btn btn-submit btn-sm"><i class="bi bi-save2"></i> Submit</button>
            <button type="button" id="btnTambah" class="btn btn-clear btn-sm"><i class="bi bi-file-earmark-plus"></i> Tambah</button>
            <hr>
           
            <div id="div_tbl_sosmed"></div>
            
        </form>
    </div>
    
</body>
</html>

<script type="text/javascript">

    function init_form() {
        fetch_sosmed()
    }
    
    function fetch_sosmed() {           
        var list_sosmed = $('#list_sosmed').val()        
        fetch('<?php echo site_url('sosmed/sosmed_admin/get_data_sosmed') ;?>?list_sosmed='+list_sosmed+'').then(function(response){                   
            return response.json();
        }).then(function (responseData){
            console.log(responseData)
            load_sosmed(responseData.data[0]);
        });            
    }

    $(document).on('click','#edit_sosmed', function () {
        var sosmed_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_sosmed")
        var deskripsi =  tbl.rows[row_index].cells[0].innerHTML;
        var link_video =  tbl.rows[row_index].cells[1].innerHTML;
                 
        $('#_status_edit').val(true)
        $('#_sosmed_id').val(sosmed_id)
        $('#txt_deskripsi').val(deskripsi)  
        $('#txt_link_video').val(link_video)
    })

    $(document).on('click','#btnTambah', function () {       
        input_area_clear()
    })

    function input_area_clear() {
        $('#_status_edit').val('')
        $('#_sosmed_id').val(0)
        $('#txt_deskripsi').val('')  
        $('#txt_link_video').val('')          
    }

    $(document).on('change', '#list_sosmed', function () {
        input_area_clear()
        fetch_sosmed()    
    })

    $(document).on('click', '#delete_sosmed', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var sosmed_id = $(this).attr("data-id");//trade_code
        
        fetch('<?php echo site_url('sosmed/sosmed_admin/delete_sosmed') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({sosmed_id:sosmed_id}),                               
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
                    fetch_sosmed();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

    $(document).on('submit','#simpan_form', async function () {
        
        event.preventDefault();
        var status_edit = $('#_status_edit').val()

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    

        var list_sosmed = $('#list_sosmed').val()
        if (list_sosmed == 'yt'){
            $('iframe').addClass('cls_yt')
        }else{
            if (list_sosmed == 'ig'){
                $('iframe').addClass('cls_ig')
            }else{
                if (list_sosmed == 'fb'){
                     $('iframe').addClass('cls_fb')
                }     
            }       
        }
       
        var form_data= $(this).serialize();

        fetch('<?php echo site_url('sosmed/sosmed_admin/simpan_sosmed') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data),                               
                })
        .then(response => response.json()) 
        .then(async (dataResult) => {               
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{       
                    var sosmed_id = dataResult.data                   
                    $('#_sosmed_id').val(sosmed_id)                                    
                    $('#_status_edit').val(true)                                  
                    await fetch_sosmed()
                    alert('Simpan data sukses');    
                    //fetch_data_profile_yayasan()                                                             
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    function validasi_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];
        let list_sosmed = x["list_sosmed"].value;       
        let deskripsi = x["txt_deskripsi"].value;
        let link_video = x['txt_link_video'].value;        
      
        if(list_sosmed==''){      
            valid = false
            $('#list_sosmed').css('border-color', '#cc0000');	           
        }else{
            $('#list_sosmed').css('border-color', '');	
        }    
        if(deskripsi==''){      
            valid = false
            $('#txt_deskripsi').css('border-color', '#cc0000');	           
        }else{
            $('#txt_deskripsi').css('border-color', '');	
        }    
        if(link_video==''){      
            valid = false
            $('#txt_link_video').css('border-color', '#cc0000');	           
        }else{
            $('#txt_link_video').css('border-color', '');	
        }    
        
        return valid
    }
    
    function load_sosmed(data) {
        var html = '';      
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_sosmed">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Deskripsi</th>';
        html += '           <th>Link Konten</th>';
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td >'+data[count].deskripsi+'</td>';
                html += '   <td width="50px">'+data[count].link_video+'</td>';                
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_sosmed" data-id='+data[count].sosmed_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_sosmed" data-id='+data[count].sosmed_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
                        
        document.getElementById("div_tbl_sosmed").innerHTML = html;   
    }

</script>