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
    <form action="post" id="simpan_form">
        <div class="container mt-5">  
            <h3 class="text-header">Input Soal Pilihan Ganda</h3>
            <h5 class="text-header"><span id="nama_mapel"></h5>
            <h5 class="text-header">Kelas <?php echo $kelas ;?></h5>
            <hr>
            <button type="button" id="btn_kembali" class="btn btn-sm btn-secondary btn-default" style="margin-left: 5px;"><i class="bi bi-back"></i>&nbsp;Kembali</button>   
            
            <div style="line-height: 10px;"><br></div>

            <input type="hidden" name="txt_id" id="txt_id" value="<?php echo $soal_pg_id ;?>">             
            <input type="hidden" name="txt_thnajaran" value="<?php echo $thnajaran ;?>">
            <input type="hidden" name="txt_semester" value="<?php echo $semester ;?>">
            <input type="hidden" name="txt_kelas" value="<?php echo $kelas ;?>">
            <input type="hidden" name="txt_mapel" value="<?php echo $mapel ;?>">
            <input type="hidden" name="txt_jenis_penilaian" value="<?php echo $jenis_penilaian ;?>">
            <input type="hidden" name="txt_bank_soal_id" value="<?php echo $bank_soal_id ;?>">            
            
            <!-- <table class="table table-sm" style="margin-bottom: 10px;">                
                    <tr class="borderless-bottom" id="tr_thnajaran">
                        <td width="180">                     
                            <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Kompetensi Dasar</label>            
                        </td>            
                        <td>
                            <div class="input-group input-group-sm  col-sm-5" id="list_kd_div"></div>
                        </td>        
                    </tr>
            </table> -->

            <label for="txt_pertanyaan" class="col-sm col-form-label col-form-label-sm">Pertanyaan : </label>
            <div id="pertanyaan">
                <textarea name="txt_pertanyaan" id="txt_pertanyaan" class="editor form-control"></textarea>  
            </div>
            <br>
            
            <input type="hidden" id="uploaded_img_file_pg_path">
            <div style="border-style: solid; border-width: 1px; border-color: rgba(139, 137, 137, 0.5); padding:10px">
                <p>File image (Hanya digunakan jika diperlukan)</p>
                <div class="input-group input-group-sm">
                    <label for="file_siswa_baru" id="lbl_siswa_baru">Pilih File </label>&nbsp;&nbsp;
                    <input type="text" name="txt_pilih_file" id="txt_pilih_file" class="form-control" autocomplete="off">
                </div>
                <button type="button" class="btn btn-info text-light btn-file btn-sm btn-default" onclick="document.getElementById('file_img_soal_pg').click()" style="margin: 10px;">
                <i class="bi bi-search"></i> Browse<input type="file" name="file_img_soal_pg" class="form-control" id="file_img_soal_pg"  data-id="test-file" style="display:none;">
                <label for="file_file_img_soal_pg" id="lbl_file_img_soal_pg"></label>
                </button>	    
                <div id="img_load"></div>
                <div id="btn_hapus_img_div"></div>                   
            </div>                
            <br>
                      
            <label for="txt_jawaban_a" class="col-sm col-form-label col-form-label-sm">Jawaban A : </label>
            <div id="jawaban_a">
                <textarea name="txt_jawaban_a" id="txt_jawaban_a" class="editor form-control"></textarea> 
            </div>            
            <br>
            
            <label for="txt_jawaban_b" class="col-sm col-form-label col-form-label-sm">Jawaban B : </label>
            <div id="jawaban_b">
                <textarea name="txt_jawaban_b" id="txt_jawaban_b" class="editor form-control"></textarea> 
            </div>
            <br>

            <label for="txt_jawaban_c" class="col-sm col-form-label col-form-label-sm">Jawaban C : </label>
            <div id="jawaban_c">
            <textarea name="txt_jawaban_c" id="txt_jawaban_c" class="editor form-control"></textarea> 
            </div>
            <br>

            <label for="txt_jawaban_d" class="col-sm col-form-label col-form-label-sm">Jawaban D : </label>
            <div id="jawaban_d">
            <textarea name="txt_jawaban_d" id="txt_jawaban_d" class="editor form-control"></textarea> 
            </div>
            <br>

            <!-- <label for="txt_jawaban_e" class="col-sm col-form-label col-form-label-sm">Jawaban E : </label>
            <div id="jawaban_e">
            <textarea name="txt_jawaban_e" id="txt_jawaban_e" class="editor form-control"></textarea> 
            </div> -->
            <br>
           
            <div class="row row-col-5" style="padding: 1px;">
                <div class="col"><label for="" class="col-sm col-form-label col-form-label-sm">Kunci Jawaban : </label></div>
                <div class="col" >
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rb_jawaban" id="rb_a" value="a">
                        <label class="form-check-label" for="rb_a">A</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rb_jawaban" id="rb_b" value="b">
                        <label class="form-check-label" for="rb_b">B</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rb_jawaban" id="rb_c" value="c">
                        <label class="form-check-label" for="rb_c">C</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rb_jawaban" id="rb_d" value="d">
                        <label class="form-check-label" for="rb_d">D</label>
                    </div>
                </div>                
                <!-- <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rb_jawaban" id="rb_e" value="e">
                        <label class="form-check-label" for="rb_e">E</label>
                    </div>
                </div>      -->
            </div>
            
            <br>
            <button type="submit" id="btn_simpan" class="btn btn-sm btn-primary btn-default"><i class="bi bi-save"></i>&nbsp; Simpan</button>
            <br>
            <br>
            <br>
            <br>
        </div>
    </form>
    
</body>
</html>

<script type="text/javascript">
    var thnajaran = '<?php echo $thnajaran ;?>'
    var semester = '<?php echo $semester ;?>'
    var kelas = '<?php echo $kelas ;?>'
    var mapel = '<?php echo $mapel ;?>'  
    var jenis_penilaian = '<?php echo $jenis_penilaian ;?>' 
    var bank_soal_id = '<?php echo $bank_soal_id ;?>'    
    var soal_pg_id = '<?php echo $soal_pg_id ;?>'
    
    async function init_form() {
        //await load_kd()
        var nama_mapel = await get_nama_mapel(mapel)
        document.getElementById('nama_mapel').innerHTML = nama_mapel
        await load_data_soal_pg()
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


    $(document).on('change', '#list_kd', function () {
        $('#list_kd').css('color', 'black')
    })

    $(document).on('click', '#btn_hapus_img', async function () {
        
        await upload_file_img('hapus')
        
        let img_file_path =  await $('#uploaded_img_file_pg_path').val(); 
        var form_data = new FormData();
        form_data.append("soal_pg_id", soal_pg_id);        
        form_data.append("img_file_path", img_file_path);
        form_data.append("status_simpan",'hapus');
        
        await fetch('<?php echo site_url('ujian/input_soal/simpan_img_path_soal_pg') ;?>',{
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

    $(document).on('click', '#btn_kembali', function () {
        history.back()
    })

    async function load_data_soal_pg() {
        await fetch('<?php echo site_url('ujian/input_soal/load_data_soal_pg') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian
                                                                    +'&soal_pg_id='+soal_pg_id+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data           
            if(data.length>0){
                      
                window.editors[0].setData(data[0].pertanyaan)
                window.editors[1].setData(data[0].jawaban_a)
                window.editors[2].setData(data[0].jawaban_b)
                window.editors[3].setData(data[0].jawaban_c)
                window.editors[4].setData(data[0].jawaban_d)
                // window.editors[5].setData(data[0].jawaban_e)

                if(data[0].img_path!=null&&data[0].img_path!=''){            
                    var path_image = "<?php echo base_url() ?>" + data[0].img_path;                            
                    $('#img_load').append("<img src='"+path_image+'?'+ new Date().getTime()+"' class='img-width'>")                    
                    $('#btn_hapus_img_div').append('<button type="button" id="btn_hapus_img" class="btn btn-sm btn-danger btn-default"><i class="bi bi-trash"></i>&nbsp;Hapus Image</button>')
                    $('#uploaded_img_file_pg_path').val(path_image)
                }

                var kunci_jawaban = data[0].kunci_jawaban                                
                tbl = document.querySelectorAll('input[name="rb_jawaban"]')                
                for (let i = 0; i < tbl.length; i++) {
                     if(kunci_jawaban == tbl[i].value){
                        tbl[i].checked=true  
                     }                                      
                }
                
            }else{
                window.editors[0].setData('')
                window.editors[1].setData('')
                window.editors[2].setData('')
                window.editors[3].setData('')
                window.editors[4].setData('')
                // window.editors[5].setData('')
            }
            
        })
    }

    async function load_image() {
        await fetch('<?php echo site_url('ujian/input_soal/load_data_soal_pg') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel
                                                                    +'&jenis_penilaian='+jenis_penilaian
                                                                    +'&soal_pg_id='+soal_pg_id+'')
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
    
    async function load_kd() {
        await fetch('<?php echo site_url('ujian/input_soal/get_data_kd') ;?>?thnajaran='+thnajaran
                                                                    +'&semester='+semester
                                                                    +'&kelas='+kelas
                                                                    +'&mapel='+mapel+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_kd" id="list_kd" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kompetensi dasar</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                   
                html +='    <option style="color:black" value='+data[i].no_kd+'>'+data[i].deskripsi_kd+'</option>'                                  
                }
            }     
                html +='</select>'                
            document.getElementById('list_kd_div').innerHTML = html
        })
    }

    $(document).on('change', '#file_img_soal_pg', function()
	{			
        try {   
            var name_obj =document.getElementById("file_img_soal_pg").files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById("file_img_soal_pg").files[0].name;
                               
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById("file_img_soal_pg").files[0]);
            var f = document.getElementById("file_img_soal_pg").files[0];
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
        
        var soal_pg_id = $('#txt_id').val()
        var img_file_path_ori = $('#uploaded_img_file_pg_path').val()
        form_data.append("jenis_dokumen", "soal_pg"); 
        form_data.append("file_img_soal_pg", document.getElementById('file_img_soal_pg').files[0]);     
        form_data.append("status_simpan", status_simpan);         
        form_data.append("soal_pg_id", soal_pg_id);        
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
                $('#uploaded_img_file_pg_path').val("")
                $('#uploaded_img_file_pg_path').val(path_save);                  
            }
        });
    }
        

    $(document).on('submit','#simpan_form', async function(event) {
        event.preventDefault();      
        
        var valid_data = await validasi_data_submit(); 
        if( valid_data == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }   

        var rb_dipilih = ''
        const rb = document.querySelectorAll('input[name="rb_jawaban"]');
        for (let i = 0; i < rb.length; i++) {
            if (rb[i].checked==true){
                rb_dipilih = rb[i].value   
            }
        }
        if(rb_dipilih==''){
            alert('Kunci jawaban belum dipilih')
            return false;
        }   

        var soal_pg_id_ori  = $('#txt_id').val()
        let file_img_baru =  $('#file_img_soal_pg').val()
                                       
        var form_data= $(this).serialize();
                
        fetch('<?php echo site_url('ujian/input_soal/simpan_input_soal_pg') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then( async dataResult => {
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{                    
                    var soal_pg_id = dataResult.data_id                   
                    $('#txt_id').val(soal_pg_id)                    
                    //jika ada file img baru diupload
                    if (file_img_baru !='' ){                     
                        await simpan_img_path(soal_pg_id, 'simpan')
                    }                    
                    alert(dataResult.message);               
                    history.back()                                                                                       
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    async function simpan_img_path(soal_pg_id,act) {                       
        await upload_file_img(act);  
       
        let img_file_path =  await $('#uploaded_img_file_pg_path').val(); 
        var form_data = new FormData();
        form_data.append("soal_pg_id", soal_pg_id);        
        form_data.append("img_file_path", img_file_path);
        form_data.append("status_simpan",act);
       
        await fetch('<?php echo site_url('ujian/input_soal/simpan_img_path_soal_pg') ;?>',{
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

    function validasi_data_submit(){       
        let valid=true;		
        let x = document.forms["simpan_form"];
        let pertanyaan = x["txt_pertanyaan"].value;
        let jawaban_a = x["txt_jawaban_a"].value;
        let jawaban_b = x["txt_jawaban_b"].value;
        let jawaban_c = x["txt_jawaban_c"].value;
        let jawaban_d = x["txt_jawaban_d"].value;
        // let jawaban_e = x["txt_jawaban_e"].value;
        let kunci_jawaban = x["rb_jawaban"].value;
               
        if(pertanyaan==''){            
            $('#pertanyaan').addClass('border-select-empty')  
            valid=false;
        }else{
            $('#pertanyaan').removeClass('border-select-empty')
        }
        if(jawaban_a==''){
            $('#jawaban_a').addClass('border-select-empty')
            valid=false;
        }else{
            $('#jawaban_a').removeClass('border-select-empty')
        }
        if(jawaban_b==''){
            $('#jawaban_b').addClass('border-select-empty')
            valid=false;
        }else{
            $('#jawaban_b').removeClass('border-select-empty')
        }
        if(jawaban_c==''){
            $('#jawaban_c').addClass('border-select-empty')
            valid=false;
        }else{
            $('#jawaban_c').removeClass('border-select-empty')
        }
        if(jawaban_d==''){
            $('#jawaban_d').addClass('border-select-empty')
            valid=false;
        }else{
            $('#jawaban_d').removeClass('border-select-empty')
        }
        // if(jawaban_e==''){
        //     $('#jawaban_e').addClass('border-select-empty')
        //     valid=false;
        // }else{
        //     $('#jawaban_e').removeClass('border-select-empty')
        // }
                
        return valid;
    }

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
        Font,
        Alignment, 
        AutoLink, 
        Link,
        List,
        Superscript, Subscript, SpecialCharacters, SpecialCharactersEssentials, Underline
           
    } from 'ckeditor5';

    //import Math from '@ckeditor/ckeditor5-math/src/math'; 
   
    window.editors = {};

    document.querySelectorAll( '.editor' ).forEach( ( node, index ) => {
    ClassicEditor
        .create( node, {
            plugins: [ Table, TableToolbar, TableProperties, TableCellProperties, Essentials, 
                       Paragraph, Bold, Italic, Font, Alignment, Link, AutoLink, List, Superscript, Subscript,
                       SpecialCharacters, SpecialCharactersEssentials, Underline
            ],           
            toolbar: [
                'insertTable', 'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor' , 'alignment', 'link',
                'bulletedList', 'numberedList', 'superscript','subscript', 'specialCharacters','underline'                
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
</style>