<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    <script src="<?php echo base_url()?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</head> 

<body onload="init_form()">
    
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>
        <h3 class="text-header fw-bold">Hasil Observasi PPDB - <a id="nama_jenjang_div"></a></h3>
        <hr style="margin-top: 5px;">

        <form method="post" id="simpan_form">
        <input type="hidden" id="txt_kode_jenjang" name="txt_kode_jenjang">
            <table class="table table-sm"  style="margin-bottom:5px;">
                <tr class="borderless-top borderless-bottom">
                    <td width="150">
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
                <tr class="borderless-top borderless-bottom">
                    <td width="150">
                        <label for="div_list_thn_ajaran" class="col-sm col-form-label col-form-label-sm">Tgl Pengumuman</label> 
                    </td>
                    <td>
                        <div class="input-group-sm col-sm-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="dt_tgl_pengumuman" id="dt_tgl_pengumuman" class="form-select" autocomplete="off">      
                        </div>
                    </td>
                </div>
                </tr>
            </table>

            <textarea name="txt_deskripsi" id="txt_deskripsi" class="editor__editable_inline"></textarea>
            <div style="line-height: 10px;"><br></div>
            <button type="submit" id="btn_submit" class="btn btn-sm btn-submit"><i class="bi bi-save2"></i> Simpan</button>    
        </form>
        <hr>
        <h6>DAFTAR SISWA HASIL OBSERVASI</h6>
        <div class="tscroll">
            <div id="tbl_daftar_calon_siswa_div" class="table-responsive table-height"></div>
        </div> 

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
   
    ClassicEditor
        .create( document.querySelector( '#txt_deskripsi' ), {
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
        document.getElementById('nama_jenjang_div').innerHTML = kode_jenjang;
        $('#txt_kode_jenjang').val(kode_jenjang)        
        await load_list_thn_ajaran(kode_jenjang)      
        await fetch_get_data_hasil_observasi() 
        await fetch_tbl_daftar_siswa_hasil_observasi()     
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


    function fetch_get_data_hasil_observasi() {
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"

        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_hasil_observasi_adm') ;?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'')
        .then(function(response) {
            return response.json();
        }).then(function (responseData) {                
            if (responseData.status==true){
                //load_tbl_daftar_siswa_hasil_observasi(responseData.data)
                var data = responseData.data
                if (data.length > 0){                    
                    var tgl = set_tgl_pengumuman(new Date (data[0].tgl_pengumuman))
                    $('#dt_tgl_pengumuman').val(tgl)
                    window.editor.setData(data[0].deskripsi)
                }else{
                    var tgl = set_tgl_pengumuman(new Date())
                    $('#dt_tgl_pengumuman').val(tgl)
                    window.editor.setData('')
                }      
                fetch_tbl_daftar_siswa_hasil_observasi()

            }else{
                alert(responseData.message);
                return false;
            }                        
        }).catch(function(error) {
            alert(error)
        })    
    }

    function fetch_tbl_daftar_siswa_hasil_observasi() {          
        var thn_ajaran_cls = $('#list_thn_ajaran').val()
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
              
        fetch('<?php echo site_url('pendaftaran/pendaftaran_admin/get_data_tbl_daftar_siswa_hasil_observasi_adm') ;?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'')
        .then(function(response) {
            return response.json();
        }).then(function (responseData) {            
            if (responseData.status==true){
                load_tbl_daftar_siswa_hasil_observasi(responseData.data)
                //return true;
            }else{
                alert(responseData.message);
                return false;
            }                        
        }).catch(function(error) {
            alert(error)
        })    
    }


    function load_tbl_daftar_siswa_hasil_observasi(data) {     
        //console.log(data[0].no_urut)   
        var html = '';           
    
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_daftar_calon_siswa">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';    
        html += '			<th>No.</th>';                                    
        html += '			<th>Siswa ID</th>';
        html += '			<th>Nama</th>';
        html += '			<th>Alamat</th>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.length>0)
        {           
            html += '<tbody>';         
            for(var count = 0; count < data.length; count++)
            {     
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';   
                html += '   <td style="max-width:30pt">'+data[count].no_urut+'</td>';  //0   
                html += '   <td style="min-width:30pt">'+data[count].siswa_id+'</td>';          
                html += '   <td style="min-width:30pt">'+data[count].nama+'</td>';  //0               
                html += '   <td>'+data[count].alamat+'</td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }         
        
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("tbl_daftar_calon_siswa_div").innerHTML = html;  
    }

    $(document).on('change', '#list_thn_ajaran', function () {
        fetch_get_data_hasil_observasi()
    })

    $(document).on('submit','#simpan_form', async function(event) {           
        event.preventDefault();      
        var thn_ajaran = $('#list_thn_ajaran').val()    

        var valid_data = await validasi_submit();
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }

        let deskripsi = $('#txt_deskripsi').val();   
        if( deskripsi == false){	        
            window.editor.focus();                      
            alert('Silahkan isi deskripsi');
            return false;
        }    

        var form_data= $(this).serialize();          
        fetch('<?php echo site_url('pendaftaran/Pendaftaran_admin/simpan_hasil_observasi');?>',{
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
        let list_thn_ajaran = x["list_thn_ajaran"].value;
        let tgl_pengumuman = x['dt_tgl_pengumuman'].value;          
      
        if(list_thn_ajaran==''){      
            valid = false
            $('#list_thn_ajaran').css('border-color', '#cc0000');	           
        }else{
            $('#list_thn_ajaran').css('border-color', '');	
        }    
        if(tgl_pengumuman==''){      
            valid = false
            $('#dt_tgl_pengumuman').css('border-color', '#cc0000');	           
        }else{
            $('#dt_tgl_pengumuman').css('border-color', '');	
        }    
               
        return valid
    }

    
    $('#dt_tgl_pengumuman').datepicker({
        format:"yyyy-mm-dd",
        //toggleActive: true,
        autoclose: true,            
        changeMonth: true,
        changeYear: true,
        todayHighlight: true
    }).datepicker('setDate', new Date());    

    function set_tgl_pengumuman(tgl) {
        var new_date = tgl.getFullYear() +"-"+ ("0"+(tgl.getMonth()+1)).slice(-2) +"-"+ ("0"+tgl.getDate()).slice(-2)
        return new_date
    }

</script>

<style>
    .ck-editor__editable_inline {
        min-height: 150px;
    }

    
</style>
