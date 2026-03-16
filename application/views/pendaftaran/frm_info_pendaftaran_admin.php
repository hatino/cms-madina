<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    <div class="container mt-5">             
        
        <h3 class="text-header">INFORMASI PENDAFTARAN - <?php echo $kode_jenjang; ?></h3>
        <hr style="margin-top: 5px;">
    
        <form method="post" id="simpan_form">

            <input type="hidden" id="txt_kode_jenjang" name="txt_kode_jenjang">
            <table class="table table-sm"  style="margin-bottom:5px;">
                <tr class="borderless-top borderless-bottom">
                    <td width="140">
                        <label for="div_list_thn_ajaran" class="col-sm col-form-label col-form-label-sm">Tahun Ajaran</label> 
                    </td>
                    <td>
                        <div class="input-group-sm col-sm-8">
                        <div class="input-group input-group-sm">                    
                            <div class="input-group input-group-sm col-sm-10" name="div_list_thn_ajaran" id="div_list_thn_ajaran"></div>                                                                
                        </div> 
                        </div>  
                    </td>    
                </tr>
            </table>

            <textarea name="txt_info_pendaftaran" id="txt_info_pendaftaran" class="editor__editable_inline"></textarea>
            
            <div style="line-height: 10px;"><br></div>
            <button type="submit" id="btn_submit" class="btn btn-sm btn-submit"><i class="bi bi-save2"></i> Simpan</button>    
        </form>

    </div>
</body>
</html>


<!-- <link rel="stylesheet" href="./ckeditor/ckeditor5/ckeditor5.css"> -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />

<!-- <script type="importmap">
    {
        "imports": {
            "ckeditor5": "./ckeditor/ckeditor5/ckeditor5.js",
            "ckeditor5/": "./ckeditor/ckeditor5/"            
        }
    }
</script> -->

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
   
    ClassicEditor
        .create( document.querySelector( '#txt_info_pendaftaran' ), {
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
    .then( editor => {
        window.editor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
</script>



<script type="text/javascript">

    async function init_form() {  
        var kode_jenjang = "<?php echo $kode_jenjang; ?>" 
        $('#txt_kode_jenjang').val(kode_jenjang)        
        await load_list_thn_ajaran(kode_jenjang)
        await fetch_data_info_pendaftaran()
    }

    async function load_list_thn_ajaran(kode_jenjang) 
	{		        
		await fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_thn_ajaran_with_status_open');?>?kode_jenjang='+kode_jenjang+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                      
            var data = responseData.data[0]
			var html = '';
				html += '<select name="list_thn_ajaran" id="list_thn_ajaran" class="form-select">'  
                html += '<option value=""></option>'  
			for(var count = 0; count < data.length; count++){
                if(data[count].status_open=='1'){
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'" selected>'+data[count].thn_ajaran_nama+ '</option>';
                }else{
                    html += '   <option style="color:black" value="'+data[count].thn_ajaran_cls +'">'+data[count].thn_ajaran_nama+ '</option>';
                }				
			}							
				html += '</select>'
			document.getElementById('div_list_thn_ajaran').innerHTML = html;	
		});     	
	}  

    $(document).on('change', '#list_thn_ajaran', function () {
        fetch_data_info_pendaftaran()
    })

    function fetch_data_info_pendaftaran() {
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = "<?php echo $kode_jenjang; ?>"
        
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_info_pendaftaran');?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'').then(function(response) 
		{                   
			return response.json();    
		}).then(function (responseData) 
		{                        
            var data = responseData.data[0]   
            if (data.length>0){
                var info = data[0].info_pendaftaran
                window.editor.setData(info)                
            }else{
                window.editor.setData('')
            }
		});   
    }

    $(document).on('submit','#simpan_form', async function(event) {           
        event.preventDefault();      
        var thn_ajaran = $('#list_thn_ajaran').val()      
        var valid_data = await validasi_submit();
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }

        var form_data= $(this).serialize();          
        fetch('<?php echo site_url('pendaftaran/Pendaftaran_admin/simpan_info_pendaftaran');?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then(dataResult => {          
                // console.log(dataResult)     
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{        
                    alert('Simpan data berhasil');                   
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    function validasi_submit() {
        let valid=true;		
        let x = document.forms["simpan_form"];
        let kode_jenjang = x["txt_kode_jenjang"].value;
        let list_thn_ajaran = x["list_thn_ajaran"].value;
        let info_pendaftaran = x['txt_info_pendaftaran'].value;        
        if(kode_jenjang==''){      
            valid = false          
        }
        if(list_thn_ajaran==''){      
            valid = false
            $('#list_thn_ajaran').css('border-color', '#cc0000');	           
        }else{
            $('#list_thn_ajaran').css('border-color', '');	
        }    
        if(info_pendaftaran==''){      
            valid = false
            $('#txt_info_pendaftaran').css('border-color', '#cc0000');	           
        }else{
            $('#txt_info_pendaftaran').css('border-color', '');	
        }    
    }

</script>

<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>