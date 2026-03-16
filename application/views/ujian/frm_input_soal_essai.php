<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body style="margin-inline-end: 20px;">
    <body onload="init_form()"></body>    
    <br>
    <form action="post" id="simpan_form">
        <div class="container mt-5">  
            <h3 class="text-header">Input Soal Uraian</h3>
            <h5 class="text-header"><span id="nama_mapel"></h5>
            <hr>
            <button type="button" id="btn_kembali" class="btn btn-sm btn-dark btn-default" style="margin-left: 5px;"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
            
            <div style="line-height: 10px;"><br></div>

            <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $soal_essai_id ;?>">
            <input type="hidden" name="txt_thnajaran" value="<?php echo $thnajaran ;?>">
            <input type="hidden" name="txt_semester" value="<?php echo $semester ;?>">
            <input type="hidden" name="txt_kelas" value="<?php echo $kelas ;?>">
            <input type="hidden" name="txt_mapel" value="<?php echo $mapel ;?>">
            <input type="hidden" name="txt_jenis_penilaian" value="<?php echo $jenis_penilaian ;?>">
            <input type="hidden" name="txt_bank_soal_id" value="<?php echo $bank_soal_id ;?>">        
            
            <label for="txt_pertanyaan" class="col-sm col-form-label col-form-label-sm">Pertanyaan : </label>
            <div id="pertanyaan">
                <textarea name="txt_pertanyaan" id="txt_pertanyaan" class="editor form-control"></textarea>  
            </div>
            <div id="preview_pertanyaan" class="preview_mathjax"></div>
            <br>
            
            <input type="hidden" id="uploaded_img_file_essai_path">
            <div style="border-style: solid; border-width: 1px; border-color: rgba(139, 137, 137, 0.5); padding:10px">
                <p>File image (Hanya digunakan jika diperlukan)</p>
                <div class="input-group input-group-sm">
                    <label for="file_siswa_baru" id="lbl_siswa_baru">Pilih File </label>&nbsp;&nbsp;
                    <input type="text" name="txt_pilih_file" id="txt_pilih_file" class="form-control" autocomplete="off">
                </div>
                <button type="button" class="btn btn-info text-light btn-file btn-sm btn-default" onclick="document.getElementById('file_img_soal_essai').click()" style="margin: 10px;">
                <i class="bi bi-search"></i> Browse<input type="file" name="file_img_soal_essai" class="form-control" id="file_img_soal_essai"  data-id="test-file" style="display:none;">
                <label for="file_file_img_soal_essai" id="lbl_file_img_soal_essai"></label>
                </button>	
                <div id="img_load"></div>
                <div id="btn_hapus_img_div"></div>                 
            </div>                
            <br>

            <h5 for="">Kunci Jawaban</h5>
            <label for="">Kata Kunci 1</label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="txt_kata_kunci_1" name="txt_kata_kunci_1">
            </div>
            <label for="">Kata Kunci 2</label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="txt_kata_kunci_2" name="txt_kata_kunci_2">
            </div>

            <br>
            <button type="submit" id="btn_simpan" class="btn btn-sm btn-primary btn-default">Simpan</button>
            <footer style="margin-top: 80px;"></footer>
</body>
</html>

<script type="text/javascript">
    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var kelas = '<?php echo $kelas ;?>'
    var mapel = '<?php echo $mapel ;?>'  
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    var bank_soal_id = '<?php echo $bank_soal_id ;?>'    
    var soal_essai_id = '<?php echo $soal_essai_id ;?>'
        
    async function init_form() {
        //await load_kd()
        var nama_mapel = await get_nama_mapel(mapel)
        document.getElementById('nama_mapel').innerHTML = nama_mapel
        await load_data_soal_essai()
        <?php simpan_kunjungan(); ?>
    }

    async function get_nama_mapel(mapel) {
        var rs_mapel = await fetch('<?php echo site_url('ujian/input_soal/get_nama_mapel') ;?>?mapel='+mapel+'',{method:"GET", mode: "no-cors" })
        var rs = await rs_mapel.json() 
        var nama_mapel = ''       
        if (rs.data.length>0){
            nama_mapel = rs.data[0].deskripsi            
        }
        return nama_mapel
    }

    $(document).on('click', '#btn_kembali', function () {
        history.back()
    })

    $(document).on('change', '#file_img_soal_essai', function()
	{			
        try {   
            var name_obj =document.getElementById("file_img_soal_essai").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_img_soal_essai").files[0].name;
                               
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_img_soal_essai").files[0]);
            var f = document.getElementById("file_img_soal_essai").files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {            
                $('#txt_pilih_file').val(name)       
                upload_file_img('upload')                
            }

        } catch (error) {
            alert(error)
        }
	});

    $(document).on('click', '#btn_hapus_img', async function () {
        
        await upload_file_img('hapus')
        
        let img_file_path =  await $('#uploaded_img_file_essai_path').val(); 
        var form_data = new FormData();
        form_data.append("soal_essai_id", soal_essai_id);        
        form_data.append("img_file_path", img_file_path);
        form_data.append("status_simpan",'hapus');
        
        await fetch('<?php echo site_url('ujian/input_soal/simpan_img_path_soal_essai') ;?>',{
                    method: 'POST',
                    body: form_data,                                     
                })
        .then(response => response.json()) 
        .then(async dataResult => {              
                console.log(dataResult.message);      
                await load_image()
            })
        .catch(err => {
            alert(err);
        });   
    })

    async function load_image() {
        await fetch('<?php echo site_url('ujian/input_soal/load_data_soal_essai') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian
                                                                    +'&soal_essai_id='+soal_essai_id+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data   
            if(data.length>0){                
                if(data[0].img_path!=null&&data[0].img_path!=''){            
                    var path_image = "<?php echo base_url() ?>" + data[0].img_path;                            
                    $('#img_load').append("<img src='"+path_image+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#btn_hapus_img_div').append('<button type="button" id="btn_hapus_img" class="btn btn-sm btn-danger btn-default"><i class="bi bi-trash"></i>&nbsp;Hapus Image</button>')
                    $('#uploaded_img_file_pg_path').val(path_image)
                }else{
                    $('#img_load').html("");
                    $('#btn_hapus_img_div').html("");
                    $('#uploaded_img_file_pg_path').val("")
                }
            }            
        })
    }

    $(document).on('submit','#simpan_form', async function(event) {
        event.preventDefault();      
               
        var valid_data = await validasi_data_submit(); 
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        var soal_essai_id_ori  = $('#txt_id').val()
        let file_img_baru =  $('#file_img_soal_essai').val()
                                     
        var form_data= $(this).serialize();
                        
        fetch('<?php echo site_url('ujian/input_soal/simpan_input_soal_essai') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then( async dataResult => {
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{                    
                    var soal_essai_id = dataResult.data_id  
                    $('#txt_id').val(soal_essai_id)
                    
                    //jika bukan edit data dan ada file img baru diupload
                    if (file_img_baru !='' ){                     
                        await simpan_img_path(soal_essai_id, 'simpan')
                    }
                    
                    alert(dataResult.message);  
                    history.back()                                                           
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    async function simpan_img_path(soal_essai_id, act) {                       
        await upload_file_img(act);  
       
        let img_file_path =  await $('#uploaded_img_file_essai_path').val(); 
        var form_data = new FormData();
        form_data.append("soal_essai_id", soal_essai_id);        
        form_data.append("img_file_path", img_file_path);
        form_data.append("status_simpan",act);
       
        await fetch('<?php echo site_url('ujian/input_soal/simpan_img_path_soal_essai') ;?>',{
                    method: 'POST',   
                    body: form_data,                                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
            console.log(dataResult.data);      
            })
        .catch(err => {
            alert(err);
        });           
    }

    async function upload_file_img(act) {
        var form_data = new FormData();
        var status_simpan;
        if (act=='upload'){
            status_simpan = 'false';
        }
        if(act=='simpan'){
            status_simpan = 'true';
        }
        if(act=='hapus'){
            status_simpan = 'hapus';
        }
        
        var soal_essai_id = $('#txt_id').val()
        var img_file_path_ori = $('#uploaded_img_file_essai_path').val()
        form_data.append("jenis_dokumen", "soal_essai"); 
        form_data.append("file_img_soal_essai", document.getElementById('file_img_soal_essai').files[0]);     
        form_data.append("status_simpan", status_simpan);         
        form_data.append("soal_essai_id", soal_essai_id);        
        form_data.append("img_file_path_ori", img_file_path_ori);

        await $.ajax(
        {
            url:"<?php echo base_url()?>upload_img_soal.php",
            //url:"uploadfile",    
            method:"POST",
            data: form_data,
            contentType: false,
            //contentType: 'multipart/form-data',
            cache: false,
            processData: false,
            /*
            beforeSend:function(){
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");				    
            },   
            */
            success:function(dataResult)
            {    	
                var dataResult = JSON.parse(dataResult);
                var path_view = dataResult.path_view;
                var path_save = dataResult.path_save;
               
                // $('#uploaded_img_berita').html("");	
                // $('#uploaded_img_berita').append("<img src='"+path_view+'?'+ new Date().getTime()+"' class='img-width'>")                    
                $('#uploaded_img_file_essai_path').val("")
                $('#uploaded_img_file_essai_path').val(path_save);                  
            }
        });
    }

    async function load_data_soal_essai() {
        await fetch('<?php echo site_url('ujian/input_soal/load_data_soal_essai') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian
                                                                    +'&soal_essai_id='+soal_essai_id+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data           
            if(data.length>0){                         
                window.editors[0].setData(data[0].pertanyaan)
                $('#txt_kata_kunci_1').val(data[0].kata_kunci_1)
                $('#txt_kata_kunci_2').val(data[0].kata_kunci_2)    
                
                if(data[0].img_path!=null&&data[0].img_path!=''){            
                    var path_image = "<?php echo base_url() ?>" + data[0].img_path;                            
                    $('#img_load').append("<img src='"+path_image+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#btn_hapus_img_div').append('<button type="button" id="btn_hapus_img" class="btn btn-sm btn-danger btn-default"><i class="bi bi-trash"></i>&nbsp;Hapus Image</button>')
                    $('#uploaded_img_file_essai_path').val(path_image)
                }

            }else{
                window.editors[0].setData('')
                $('#txt_kata_kunci_1').val('')
                $('#txt_kata_kunci_2').val('')
            }            
        })
    }


    function validasi_data_submit(){       
        let valid=true;		
        let x = document.forms["simpan_form"];
        let pertanyaan = x["txt_pertanyaan"].value;
        let kata_kunci_1 = x["txt_kata_kunci_1"].value;
        let kata_kunci_2 = x["txt_kata_kunci_2"].value;
                      
        if(pertanyaan==''){            
            $('#pertanyaan').addClass('border-select-empty')  
            valid=false;
        }else{
            $('#pertanyaan').removeClass('border-select-empty')
        }
        if(kata_kunci_1==''){
            valid=false;
            $('#txt_kata_kunci_1').css('border-color','#cc0000')
        }else{
            $('#txt_kata_kunci_1').css('border-color','')            
        }
        if(kata_kunci_2==''){
            valid=false;
            $('#txt_kata_kunci_2').css('border-color','#cc0000')
        }else{
            $('#txt_kata_kunci_2').css('border-color','')            
        }

        return valid;
    }

</script>


<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5.css" />

<script>
window.MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\\(', '\\)']],   // inline pakai $...$ atau \(...\)
    displayMath: [['$$', '$$'], ['\\[', '\\]']] // block pakai $$...$$
  },
  svg: { fontCache: 'global' }
};
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

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
        Font,
        Alignment, 
        AutoLink, 
        Link,
        List        
    } from 'ckeditor5';

    window.editors = {};

    document.querySelectorAll( '.editor' ).forEach( ( node, index ) => {
    ClassicEditor
        .create( node, {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, 
                       Paragraph, Bold, Italic, Font, Alignment, Link, AutoLink, List                     
            ],           
            toolbar: [
                'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor' , 'alignment', 'link',
                'bulletedList', 'numberedList'
            ],
            alignment : ['left', 'right', 'center', 'justify'],
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
            },
            link: {
                    // Automatically add target="_blank" and rel="noopener noreferrer" to all external links.
                    addTargetToExternalLinks: true,

                    // Let the users control the "download" attribute of each link.
                    decorators: [
                        {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'download'
                            }
                        }
                    ]
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            }
        } )
        .then( newEditor => {
            window.editors[ index ] = newEditor            
            if(mapel.toLowerCase()=='mat'){   
                //Jika ini editor pertanyaan, pasang listener update preview
                if (node.id === 'txt_pertanyaan') {
                    newEditor.model.document.on('change:data', () => {    
                        document.querySelector('#preview_pertanyaan').innerHTML = newEditor.getData();
                        MathJax.typesetPromise(); // render latex                    
                    });
                }                          
            }

        } );
    } );           
       
</script>

<style>
    .btn-default {
        box-shadow: 1px 2px 5px #000000;   
    }

    .ck-editor__editable_inline {
        min-height: 80px;    
    }

    .border-select-empty{
        outline: none !important;
        box-shadow: none !important;
        border: 1px solid #cc0000;
    }

    .img-width {
        width: 200pt;
        height: 200ptt;
        border-radius: 10px;
        box-shadow: 1px 2px 5px rgb(126, 125, 125);   
        margin-bottom: 10px;
    }

    .preview_mathjax{
        color: #28a560ff;
        font-size: 0.8em;
        margin: 0;
    }
</style>