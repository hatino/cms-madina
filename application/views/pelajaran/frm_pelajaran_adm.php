<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>            
    
</head>
<body>
    <body onload="init_form()"></body>     
    <div class="container mt-5">
        <div style="line-height: 35px;"><br></div>  
        
        <h3 class="text-header fw-bold mb-1">Pelajaran <span id="span_nama_unit"></span></h3>
        <hr style="margin-top: 5px; margin-bottom: 5px;">
        <button type="button" id="btn_import" class="btn-sm mb-3 btn-shadow btn-primary">Import dari www.swiislamicshcool.sch.id</button>

        <form method="post" id="simpan_form">  
            <input type="hidden" id="txt_kode_jenjang" name="txt_kode_jenjang">     
            <label for="txt_pelajaran"><h5>Deskripsi</h5></label>     
            <textarea name="txt_pelajaran" id="txt_pelajaran" class="editor form-control"></textarea>               
            <div style="line-height: 10px;"><br></div>
            <button type="submit" id="btn_submit" class="btn btn-sm btn-shadow btn-submit"><i class="bi bi-save2"></i> Simpan</button>&nbsp;
            <button type="button" id="btn_menu_upload" class="btn btn-sm btn-shadow btn-info text-light"><i class="bi bi-upload"></i> Upload Mata Pelajaran</button>    
        </form>

        <hr>
        <h5>Daftar Pelajaran</h5>
        <div id="div_tbl_pelajaran"></div>
        <br>
        <br>

    </div>
</body>
</html>   

<script type="text/javascript">
    var kode_jenjang = '<?php echo $kode_jenjang ;?>'

    async function init_form() {           
        document.getElementById('span_nama_unit').innerHTML = kode_jenjang;       
        $('#txt_kode_jenjang').val(kode_jenjang)  
        await fetch_data_tbl_pelajaran(kode_jenjang)   
    }

    document.querySelector('#btn_import').addEventListener('click', function import_pelajaran() {
        fetch('<?php echo site_url('pelajaran/pelajaran_admin/get_data_tbl_pelajaran_api') ;?>?kode_jenjang='+kode_jenjang)
        .then(response => response.json()) 
        .then( async dataResult => {            
            if(dataResult.status==true) {               
                if(dataResult.data2[0].length > 0){
                    let tbl_len = document.querySelector('#tbl_pelajaran tbody').rows.length                  
                    let hasil;
                    if(tbl_len > 0){
                        let tanya = confirm('Data sudah ada, apakah ingin ditimpa menggunakan data import?')
                        if (tanya==true){
                             hasil = await simpan_import_pelajaran(dataResult) 
                             alert(hasil.message)      
                             fetch_data_tbl_pelajaran()                        
                        }
                        return false
                    }
                    hasil = await simpan_import_pelajaran(dataResult)
                    alert(hasil.message)   
                    fetch_data_tbl_pelajaran()
                    
                }else{
                    alert('Data tidak ditemukan')
                }
            }else{
                alert('Terjadi kesalahan import data')
            }               
        })
        .catch(err => {
            alert(err);
        });    
    })
    
    async function simpan_import_pelajaran(data) {
        var json_data = JSON.stringify(data);   
        let result_data = await fetch('<?php echo site_url('pelajaran/pelajaran_admin/simpan_import_pelajaran') ;?>',{
                    method: 'POST',   
                    body: json_data,
                    //body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        let result = await result_data.json()
        return result        
    }

    $(document).on('click','#btn_menu_upload', function () {
        var kode_jenjang = '<?php echo $kode_jenjang ;?>' 
        window.location.href="<?php echo site_url('pelajaran/pelajaran_admin/show_upload_pelajaran') ; ?>?kode_jenjang="+kode_jenjang+""   
    })

    $(document).on('click', '#delete_pelajaran', function () {
        var msg = confirm("Anda yakin ingin menghapus data?");
        if(msg==false){
            return false;
        }        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'
        var row_index = $(this).closest("tr").index()+1;
        var tbl = document.getElementById("tbl_pelajaran")        
        var kelas = tbl.rows[row_index].cells[1].innerHTML;
        var pelajaran = tbl.rows[row_index].cells[3].innerHTML;
        //alert(no)
        fetch('<?php echo site_url('pelajaran/pelajaran_admin/delete_pelajaran') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams({kode_jenjang:kode_jenjang, kelas:kelas, pelajaran:pelajaran}),
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {                
                if (dataResult.status == false){                    
                    if (dataResult.message==undefined){
                        alert('koneksi terputus silahkan login ulang')
                        window.location.href="/show_login"
                    }else{
                        alert(dataResult.message);
                    }                   
                }else{                                      
                    alert(dataResult.message);                          
                    fetch_data_tbl_pelajaran();                                   
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

    function fetch_data_tbl_pelajaran(){        
        var kode_jenjang = '<?php echo $kode_jenjang ;?>'       
        fetch('<?php echo site_url('pelajaran/pelajaran_admin/get_data_tbl_pelajaran') ;?>?kode_jenjang='+kode_jenjang+'')
        .then(function(response){                   
            return response.json();    
        }).then(function (responseData){  
            load_tbl_pelajaran(responseData);               
        });            
    }
    
    function load_tbl_pelajaran(data) {  
        if(data.data[0].length > 0){
            window.editors[0].setData(data.data[0][0].pelajaran)
        }       
                
        var html = '';
        html += '<div>';
        html += '<table class="table table-sm table-bordered table-striped table-sticky" id="tbl_pelajaran">';            
        html += '	<thead class="col-form-label-sm bg-secondary text-light">';                                
        html += '		<tr class="text-nowrap">';                                        
        html += '			<th>No</th>';
        html += '			<th>Kelas</th>';
        html += '           <th>Kelompok Pelajaran</th>';    
        html += '           <th>Pelajaran</th>';        
        html += '           <th width="10%" style="text-align:center">Delete</th></tr>';
        html += '		</tr>';
        html += '   </thead>';      
        
        if(data.data2.length>0){            
            html += '<tbody>';
            for(var count = 0; count < data.data2[0].length; count++)
            {                             
                html += '<tr class = "col-form-label-sm" id="'+ count +'">';
                html += '   <td style="max-width=30pt;">'+data.data2[0][count].no_urut+'</td>';  //0 
                html += '   <td style="max-width=50pt;">'+data.data2[0][count].kelas+'</td>';
                html += '   <td style="max-width=100pt;">'+data.data2[0][count].kelompok_mapel+'</td>';
                html += '   <td>'+data.data2[0][count].nama_pelajaran+'</td>';                
                html += '   <td align="center" style="cursor: pointer;"> <a id="delete_pelajaran"><span class="bi bi-trash-fill" title="Delete" style="color:red"></span></a></td>';
                html += '</tr>';                                                                                                   
            }
            html += '</tbody>';      
            //$('#pesan').find("h6:first").text(dataResult.length + ' records');
        }                
        html += '</table>';
        html += '</div>';
                        
        document.getElementById("div_tbl_pelajaran").innerHTML = html;           
    }

    $(document).on('submit','#simpan_form', async function (event) {
        event.preventDefault();         
        pelajaran = $('#txt_pelajaran').val()
        if(pelajaran==''){
            alert('Silahkan isi sejarah');
            window.editors[0].focus();
            return false;
        }    
       
        
        var form_data= $(this).serialize();
        await fetch("<?php echo site_url('pelajaran/pelajaran_admin/simpan_pelajaran_admin');?>",{
                    method: 'POST',   
                    body: new URLSearchParams(form_data),
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
                    //tidak terjadi error                             
                    alert(dataResult.message);                                                                                 
                }
            })
        .catch(err => {
            alert(err);
        });    
    })

</script>

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

<style>
    .ck-editor__editable_inline {
        min-height: 100px;    
    }
   
    .img-width {
        width: 185pt;
        height: 185pt;
    }

</style>
            