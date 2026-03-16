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
            <h3 class="text-header header_center">Input Waktu Pengerjaan</h3>            
           
            <table class="table table-sm table-bordered table-striped table-sticky" id="tbl_bank_soal">            
                <thead class="col-form-label-sm bg-secondary text-light">                                
                    <tr class="text-nowrap">    
                        <th>No</th>
                        <th>Jenis Soal</th>
                        <th>Waktu Pengerjaan (menit)/soal</th>                        
                    </tr>       		
                </thead>          

                <tbody class="col-form-label-sm">
                    <tr>  
                        <td class="col-1" style="text-align: center;">1</td>             
                        <td class="col-6" style="vertical-align: middle; text-align:center;">Soal Pilihan Ganda</td>
                        <td class="col-6" style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_pg" id="txt_pg"></td>
                    </tr>    
                    <tr>  
                        <td style="text-align: center;">2</td>             
                        <td style="vertical-align: middle;text-align:center;">Soal Uraian</td>
                        <td style="vertical-align: middle;" class="text-nowrap"><input class="form-control form-control-sm" style="text-align: center;" name="txt_uraian" id="txt_uraian"></td>
                    </tr>    
                </tbody>         
            </table>

            <button type="button" class="btn btn-sm btn-submit" id="btn_simpan">Simpan</button>
        </div>
    </form>

</body>
</html>

<script type="text/javascript">

    function init_form() {
        get_data_waktu_mengerjakan()        
    }

    function get_data_waktu_mengerjakan() {
        fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan') ;?>')
        .then(response => response.json())
        .then(dataResult => {
            var data = dataResult.data            
            if( data.length>0){
                $('#txt_pg').val(data[0].soal_pg)
                $('#txt_uraian').val(data[0].soal_uraian)
            }else{
                $('#txt_pg').val('')
                $('#txt_uraian').val('')
            }
        })
    }

    $(document).on('click', '#btn_simpan', function () {
        let valid=true;		
        let x = document.forms['simpan_form'];
        let waktu_pg = x['txt_pg'].value;
        let waktu_uraian = x['txt_uraian'].value;
        if (waktu_pg==''){
            $('#txt_pg').css('border-color', '#cc0000')
            valid=false
        }else{
            $('#txt_pg').css('border-color', '')
        }
        if (waktu_uraian==''){
            $('#txt_uraian').css('border-color', '#cc0000')
            valid=false
        }else{
             $('#txt_uraian').css('border-color', '')
        }

        if(valid==false){
            alert('Silahkan isi data yang diperlukan')
            return false
        }

        simpan_data()
    })

    function simpan_data() {
        var formData = $('#simpan_form').serialize();
        fetch('<?php echo site_url('ujian/master/simpan_waktu_mengerjakan') ;?>', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(dataResult => {
           alert(dataResult.message)
           get_data_waktu_mengerjakan()
        })
    }
</script>