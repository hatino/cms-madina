<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 
</head>
<body onload="init_form()">
    <br>
    <form action="post" id="simpan_form">
        <div class="container mt-5">              
            <h3 class="text-header header_center">Jumlah Soal dan Bobot Nilai Ekstrakurikuler</h3>     
        
            <table class="table table-sm">        
                    <!--Jenjang Pendidikan-->
                <tr  class="borderless-bottom" id="tr_jenjang">
                    <td width="180">                        
                        <label for="list_jenjang" class="col-sm col-form-label col-form-label-sm">Jenjang Pendidikan</label>
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_jenjang_div"></div>
                    </td>
                </tr>        
                <!-- kelas -->
                <tr class="borderless-bottom">
                    <td>                       
                        <label for="list_kelas" class="col-sm col-form-label col-form-label-sm">Kelas</label>                                        
                    </td>
                    <td>
                        <div class="input-group input-group-sm  col-sm-5" id="list_kelas_div"></div>
                    </td>
                <tr>    
                <!-- semester -->
                <tr class="borderless-bottom">
                    <td width="180">                               
                        <label for="colFormLabelSm" class="col-sm col-form-label col-form-label-sm">Semester</label>                                                        
                    </td>
                    <td>           
                        <div class="input-group input-group-sm  col-sm-5">             
                            <select name="list_semester" id="list_semester" class="form-select" style="color:gray">                            
                                <option value="" selected disabled>pilih semester</option>
                                <option value="1" style="color:black">1</option>
                                <option value="2" style="color:black">2</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="table table-sm table-bordered table-striped table-sticky" id="tbl_bank_soal">            
                <thead class="col-form-label-sm bg-secondary text-light">                                
                    <tr class="text-nowrap">    
                        <th>No</th>
                        <th>Jenis Soal</th>
                        <th>Jumlah Soal</th>        
                        <th>Boot Nilai/soal</th>                 
                    </tr>       		
                </thead>          

                <tbody class="col-form-label-sm">
                    <tr>  
                        <td class="col-1" style="text-align: center;">1</td>             
                        <td class="col-6" style="vertical-align: middle; text-align:center;">Soal Pilihan Ganda</td>
                        <td class="col-3" style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_jml_pg" id="txt_jml_pg" autocomplete="off"></td>
                        <td class="col-3" style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_bobot_pg" id="txt_bobot_pg" autocomplete="off"></td>
                    </tr>    
                    <tr>  
                        <td style="text-align: center;">2</td>             
                        <td style="vertical-align: middle;text-align:center;">Soal Uraian</td>
                        <td style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_jml_uraian" id="txt_jml_uraian" autocomplete="off"></td>
                        <td style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_bobot_uraian" id="txt_bobot_uraian" autocomplete="off"></td>
                    </tr>    
                </tbody>         
            </table>

            <button type="button" class="btn btn-sm btn-submit btn-default" id="btn_simpan">Simpan</button>
        </div>
    </form>
    
</body>
</html>

<script type="text/javascript">
    function init_form() {
        load_jenjang_pendidikan()     
        load_kelas()       
    }

    function load_jenjang_pendidikan() {
        fetch('<?php echo site_url('ujian/bank_soal/get_jenjang_pendidikan') ;?>')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
           
            var html = '';           
                html +='<select name="list_jenjang" id="list_jenjang" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih jenjang</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){                     
                    if(data[i].flag=="1"){                         
                        html +='    <option style="color:black" value='+data[i].group_cls+' selected>'+data[i].group_cls+'</option>'                                        
                    }else{
                        html +='    <option style="color:black" value='+data[i].group_cls+'>'+data[i].group_cls+'</option>'                                        
                    }   
                }
            }     
                html +='</select>'                
            document.getElementById('list_jenjang_div').innerHTML = html              
        })        
    }

    function load_kelas() {        
        var jenjang = $('#list_jenjang').val()        
        fetch('<?php echo site_url('ujian/bank_soal/get_kelas') ;?>?jenjang='+jenjang+'')
        .then(response => response.json())
        .then(responseData => {
            var data = responseData.data
            var html = '';           
                html +='<select name="list_kelas" id="list_kelas" class="form-select" style="color:gray">'  
                html +='    <option style="color:gray" value="" selected disabled>pilih kelas</option>'  
            if (data.length > 0) {
                for(var i = 0; i < data.length; i++){ 
                    html +='    <option style="color:black" value='+data[i].kelas_cls+'>'+data[i].kelas_cls+'</option>'                                                                      
                }
            }     
                html +='</select>'                
            document.getElementById('list_kelas_div').innerHTML = html            
        })
    }

    $(document).on('change','#list_jenjang', function () {
        $('#list_jenjang').css('color', 'black')
        $('#list_jenjang').css('border-color', '')
        load_kelas()
        input_area_clear()
    })

    $(document).on('change','#list_kelas', function () {
        $('#list_kelas').css('color', 'black')      
        $('#list_kelas').css('border-color', '')
        fetch_tbl_bobot_nilai_ekskul()  
    })
    
    $(document).on('change','#list_semester', function () {
        $('#list_semester').css('color', 'black')
        $('#list_semester').css('border-color', '')
        fetch_tbl_bobot_nilai_ekskul()        
    })

        $(document).on('blur','#txt_jml_pg', function () {   
        $('#txt_jml_pg').css('border-color', '')
    })

    $(document).on('blur','#txt_jml_uraian', function () {   
        $('#txt_jml_uraian').css('border-color', '')
    })

    $(document).on('blur','#txt_bobot_pg', function () {   
        $('#txt_bobot_pg').css('border-color', '')
    })

    $(document).on('blur','#txt_bobot_uraian', function () {   
        $('#txt_bobot_uraian').css('border-color', '')
    })

    function fetch_tbl_bobot_nilai_ekskul(){                
        var jenjang = $('#list_jenjang').val() 
        var semester = $('#list_semester').val() 
        var kelas = $('#list_kelas').val() 

        if (jenjang==null||semester==null||kelas==null){
            return false
        }
      
        fetch('<?php echo site_url('ujian/master/get_tbl_bobot_nilai_ekskul');?>?list_jenjang='+jenjang
                                                                        +'&list_semester='+semester
                                                                        +'&list_kelas='+kelas+'')                                                                        
        .then(function(response){
            return response.json();    
        }).then( async function (responseData){  
            var data = responseData.data
            if (data.length>0){
                $('#txt_jml_pg').val(data[0].jml_soal_pg)
                $('#txt_jml_uraian').val(data[0].jml_soal_uraian)
                $('#txt_bobot_pg').val(data[0].bobot_pg)
                $('#txt_bobot_uraian').val(data[0].bobot_uraian)
            }else{
                $('#txt_jml_pg').val('')
                $('#txt_jml_uraian').val('')
                $('#txt_bobot_pg').val('')
                $('#txt_bobot_uraian').val('')
            }
        });            
    }

    $(document).on('click', '#btn_simpan', function () {
        var valid_data = validasi_data_submit()
        if(valid_data==false){
            alert('Silahkan isi data yang diperlukan')
            return false;
        }

        var form_data = $('#simpan_form').serialize()
       
        fetch('<?php echo site_url('ujian/master/simpan_bobot_nilai_ekskul') ;?>', {
            method: "POST",
            body: new URLSearchParams(form_data) 
        })
        .then(response => response.json())
        .then(dataResult =>{
            alert(dataResult.message)
            fetch_tbl_bobot_nilai()
        })

    })

    function validasi_data_submit() {
        var valid_data = true;
        var x = document.forms['simpan_form']
        var jenjang = x['list_jenjang'].value;
        var kelas = x['list_kelas'].value;
        var semester = x['list_semester'].value;
        var jml_soal_pg = x['txt_jml_pg'].value;
        var jml_soal_uraian = x['txt_jml_uraian'].value;
        var bobot_soal_pg = x['txt_bobot_pg'].value;
        var bobot_soal_uraian = x['txt_bobot_uraian'].value;

        if (jenjang==''){
            valid_data = false;
            $('#list_jenjang').css('border-color', '#cc0000')
        }else{
            $('#list_jenjang').css('border-color', '')
        }
        if(kelas==''){
            valid_data = false;
            $('#list_kelas').css('border-color', '#cc0000')
        }else{
            $('#list_kelas').css('border-color', '')
        }
        if(semester==''){
            valid_data = false;
            $('#list_semester').css('border-color', '#cc0000')
        }else{
            $('#list_semester').css('border-color', '')
        }
        if(jml_soal_pg==''||jml_soal_pg==0){
            $('#txt_jml_pg').css('border-color', '#cc0000')
        }else{
            $('#txt_jml_pg').css('border-color','')
        }
        if(jml_soal_uraian==''||jml_soal_uraian==0){
            $('#txt_jml_uraian').css('border-color', '#cc0000')
        }else{
            $('#txt_jml_uraian').css('border-color', '')
        }
        if(bobot_soal_pg==''||bobot_soal_pg==0){
            $('#txt_bobot_pg').css('border-color','#cc0000')
        }else{
            $('#txt_bobot_pg').css('border-color','')
        }
        if(bobot_soal_uraian==''||bobot_soal_uraian==0){
            $('#txt_bobot_uraian').css('border-color', '#cc0000')
        }else{
            $('#txt_bobot_uraian').css('border-color', '')
        }

        return valid_data;
    }

    function input_area_clear() {
        $('#txt_jml_pg').val('')
        $('#txt_jml_uraian').val('')
        $('#txt_bobot_pg').val('')
        $('#txt_bobot_uraian').val('')
    }    
</script>

<style>
    .btn-default {
        box-shadow: 1px 2px 5px #000000;   
    }
</style>