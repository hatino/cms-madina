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
        
        <h3 class="text-header">TESTIMONI</h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">
            <input type="hidden" name="_status_edit" id="_status_edit">
            <input type="hidden" name="_testimoni_id" id="_testimoni_id" value=0>
            <label for="txt_pemberi_testimoni" class="col-sm col-form-label col-form-label-sm">Pemberi Testimoni</label>
            <div class="input-group-sm col-sm-12">
                <input type="text" name="txt_pemberi_testimoni" id="txt_pemberi_testimoni" class="form-control">                            
            </div>	
            
            <label for="txt_testimoni" class="col-sm col-form-label col-form-label-sm">Testimoni</label>
            <textarea name="txt_testimoni" id="txt_testimoni" class="editor form-control"></textarea> 
            <br>
            <button type="submit" id="btnSubmit" class="btn btn-submit btn-sm"><i class="bi bi-save2"></i> Submit</button>
            <button type="button" id="btnTambah" class="btn btn-clear btn-sm"><i class="bi bi-file-earmark-plus"></i> Tambah</button>
            <hr>            
        </form>

        <h5>Daftar Testimoni</h5>
        <div id="div_tbl_testimoni"></div>
        <br>
        <br>
    </div>

    
</body>
</html>

<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.0/"
        }
    }
</script>

<script type="module">
    import {
        ClassicEditor,
        Table, TableCellProperties, TableProperties, TableToolbar ,        
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font
    } from 'ckeditor5';

    window.editors = {};

    document.querySelectorAll( '.editor' ).forEach( ( node, index ) => {
    ClassicEditor
        .create( node, {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, Paragraph, Bold, Italic, Font ],           
                toolbar: [
                    'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ],
                table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells',
                            'tableProperties', 'tableCellProperties'
                        ],

                        tableProperties: {
                            // The configuration of the TableProperties plugin.
                            // ...
                        },

                        tableCellProperties: {
                            // The configuration of the TableCellProperties plugin.
                            // ...
                        }
                }
        } )
        .then( newEditor => {
            window.editors[ index ] = newEditor 
        } );
    } );
       
</script>


<script type="text/javascript">

    function init_form() {
        fetch_tbl_testimoni()
    }

    function fetch_tbl_testimoni() {           
        fetch('<?php echo site_url('master/profil/get_data_tbl_testimoni') ;?>').then(function(response){                   
            return response.json();    
        }).then(function (responseData){       
            load_tbl_testimoni(responseData.data[0]);               
        });            
    }

    function load_tbl_testimoni(data) {
        var html = '';      
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_testimoni">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>Pemberi Testimoni</th>';
        html += '           <th>Testimoni</th>';
        html += '           <th width="10%" colspan="2" style="text-align:center">Edit / Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {
            html += '<tbody>';
            for(var count = 0; count < data.length; count++)
            {
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td width="30%">'+data[count].pemberi_testimoni+'</td>';
                html += '   <td>'+data[count].testimoni.trim()+'</td>';                
                html += '   <td align="center" style="cursor: pointer;"> <a id="edit_testimoni" data-id='+data[count].testimoni_id+' style="align:center"><span class="bi bi-pencil-square" title="Edit" style = "color:green;"></span></a></td>';
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_testimoni" data-id='+data[count].testimoni_id+'><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
      
                        
        document.getElementById("div_tbl_testimoni").innerHTML = html;   
    }


    $(document).on('click','#edit_testimoni', function () {
        var _testimoni_id = $(this).attr("data-id");//trade_code
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_testimoni")
        var pemberi_testimoni =  tbl.rows[row_index].cells[0].innerHTML;
        var testimoni =  tbl.rows[row_index].cells[1].innerHTML;
              
        $('#_status_edit').val(true)
        $('#_testimoni_id').val(_testimoni_id)
        $('#txt_pemberi_testimoni').val(pemberi_testimoni)     
        window.editors[0].setData(testimoni)
    })

    $(document).on('click', '#delete_testimoni', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }
        
        var testimoni_id = $(this).attr("data-id");//trade_code
        
        fetch('<?php echo site_url('master/profil/delete_testimoni') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({testimoni_id:testimoni_id}),                               
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
                    fetch_tbl_testimoni();
                    input_area_clear()                    
                }
            })
        .catch(err => {
            alert(err);
        });           
    })

    $(document).on('click','#btnTambah', function () {
        input_area_clear()
    })
   
    $(document).on('submit','#simpan_form', async function () {
        
        event.preventDefault();
        var status_edit = $('#_status_edit').val()

        var valid_data = await validasi_submit();        
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }    
       
        var form_data= $(this).serialize();

        fetch('<?php echo site_url('master/profil/simpan_testimoni') ;?>',{
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
                    var testimoni_id = dataResult.data                   
                    $('#_kegiatan_id').val(testimoni_id)                                    
                    $('#_status_edit').val(true)                                  
                    await fetch_tbl_testimoni()
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
        let pemberi_testimoni = x["txt_pemberi_testimoni"].value;
        let testimoni = x['txt_testimoni'].value;        
      
        if(pemberi_testimoni==''){      
            valid = false
            $('#txt_pemberi_testimoni').css('border-color', '#cc0000');	           
        }else{
            $('#txt_pemberi_testimoni').css('border-color', '');	
        }    
        if(testimoni==''){      
            valid = false
            $('#txt_testimoni').css('border-color', '#cc0000');	           
        }else{
            $('#txt_testimoni').css('border-color', '');	
        }    
        
        return valid
    }

    function input_area_clear() {
        $('#_status_edit').val('')
        $('#_testimoni_id').val(0)
        $('#txt_pemberi_testimoni').val('')  
        window.editors[0].setData('')
    }

</script>

<style>
    .ck-editor__editable_inline {
        min-height: 100px;    
    }
   
    

</style>