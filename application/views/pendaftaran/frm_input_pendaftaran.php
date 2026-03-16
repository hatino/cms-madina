<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
    
</head>
<body onload="init_form()">
    
    <div id="my-header"></div> 
    <div class="container mt-5">          
        <div style="line-height: 40px;"><br></div>  
        <h3 class="text-header fw-bold">Formulir Pendaftaran Siswa Baru <a id="nama_jenjang_div"></a></h3>
        
        <h5 class="text-header"><div id="thn_ajaran_nama_div"></div></h5>
       
        <div style="line-height: 15px;"><br></div>
                                
        <!-- <button type="button"  id="btn_open_modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_siswa_id">
            Open modal
        </button> -->

        <form method="post" id="simpan_form">
            <h5>A.	JENIS PENDAFTARAN</h5>            
            <hr style="margin-top: 8px; margin-bottom: 8px;">
            <label id="lbl_jenis_pendaftaran" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label>

            <input type="hidden" id="txt_siswa_id" name="txt_siswa_id">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="200px">
                        <input type="checkbox" id="chk_siswa_baru" name="chk_siswa_baru" class="checkbox form-check-input chk_jenis_pendaftaran">
                        <label for="chk_siswa_baru">&nbsp Siswa Baru</label>  
                        <input type="hidden" id="chk_siswa_baru_temp" name="chk_siswa_baru_temp">                    
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="chk_siswa_pindahan" name="chk_siswa_pindahan" class="checkbox form-check-input chk_jenis_pendaftaran">
                        <label for="chk_siswa_pindahan">&nbsp Siswa Pindahan </label>  
                        <input type="hidden" id="chk_siswa_pindahan_temp" name="chk_siswa_pindahan_temp">
                    </td>
                </tr>
                <tr>
                    <td width="50pt">Kelas</td>
                </tr>
                <tr>
                    <td>
                        <div class="row justify-content-md-left">
                        <div class="input-group-sm col-sm-12">                    
                            <input type="text" class="form-control" id="txt_kelas" name="txt_kelas" readonly>                           
                        </div>  
                        </div>
                    </td>
                   <td><div class="input-group-sm col-sm-2" id="kelas_tk_div"></div></td>
                </tr>
                <tr>
                    <td width="150"><label for="">NISN</label></td>                
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nisn" name="txt_nisn">
                        </div>                     
                    </td>
                </tr>
            
            </table>
                    

            <h5>B. IDENTITAS CALON SISWA</h5>
            <hr style="margin-top: 8px;">

            <input type="hidden" id="txt_thn_ajaran_cls" name="txt_thn_ajaran_cls">
            <input type="hidden" id="txt_kode_jenjang" name="txt_kode_jenjang">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_lengkap">Nama Lengkap</label>
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_lengkap" name="txt_nama_lengkap">
                        </div>               
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_panggilan">Nama Panggilan</label>
                        <div class="input-group-sm col-sm-8">                  
                            <input type="text" class="form-control" id="txt_nama_panggilan" name="txt_nama_panggilan">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_tempat_lahir">Tempat Lahir</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_tempat_lahir" name="txt_tempat_lahir">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="dt_tgl_lahir">Tanggal Lahir</label>                        
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-select" id="dt_tgl_lahir" name="dt_tgl_lahir">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="list_jenis_kelamin">Jenis Kelamin</label>  
                        <div class="input-group-sm col-sm-4">                    
                            <select class="form-select" id="list_jenis_kelamin" name="list_jenis_kelamin">   
                                <option value='' ></option>                                                         
                                <option value='L' >Laki-laki</option>
                                <option value='P' >Perempuan</option>                           
                            </select>  
                        </div>
                        </div>
                    </td>
                </tr>                
                <tr>
                    <td width="150">                    
                        <label for="list_anak_ke">Anak ke-</label>   
                        <div class="input-group-sm col-sm-8">                    
                            <select class="form-select" id="list_anak_ke" name="list_anak_ke" >   
                                <option value='' ></option>                                                        
                                <option value='1' >1</option>
                                <option value='2' >2</option>
                                <option value='3' >3</option>
                                <option value='4' >4</option>
                                <option value='5' >5</option>
                                <option value='6' >6</option>  
                                <option value='7' >7</option>   
                                <option value='8' >8</option>   
                                <option value='9' >9</option>                           
                            </select>  
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="list_jml_saudara">Jumlah Saudara Kandung</label>                                  
                        <div class="input-group-sm col-sm-8">                    
                            <select class="form-select" id="list_jml_saudara" name="list_jml_saudara" >   
                                <option value='' ></option>                                                        
                                <option value='1' >1</option>
                                <option value='2' >2</option>
                                <option value='3' >3</option>
                                <option value='4' >4</option>
                                <option value='5' >5</option>
                                <option value='6' >6</option>  
                                <option value='7' >7</option>   
                                <option value='8' >8</option>   
                                <option value='9' >9</option>                           
                            </select>  
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_golongan_darah">Golongan Darah</label>   
                        <!-- <label for="txt_tempat_lahir"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                -->
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_golongan_darah" name="txt_golongan_darah">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_no_hp">Nomor Handphone</label>   
                        <label for="txt_no_hp"><i style="color:rgb(39, 150, 131); font-size: 10pt;">&nbsp(satu nomor utk grup WhatsApp sekolah)</i></label>               
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_no_hp" name="txt_no_hp">
                        </div>                    
                    </td>
                </tr>         
                <tr>
                    <td width="150">                    
                        <label for="txt_alamat_rumah">Alamat Rumah</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <textarea type="text" class="form-control" id="txt_alamat_rumah" name="txt_alamat_rumah"></textarea>
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_sekolah_asal">Nama Sekolah Asal</label> 
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_sekolah_asal" name="txt_nama_sekolah_asal">
                        </div>                    
                    </td>
                </tr>      
                <tr>
                    <td width="150">                    
                        <label for="txt_alamat_sekolah_asal">Alamat Sekolah Asal</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <textarea type="text" class="form-control" id="txt_alamat_sekolah_asal" name="txt_alamat_sekolah_asal"></textarea>
                        </div>                    
                    </td>
                </tr>
                
            </table>   

            <h5>C.	KARAKTERISTIK CALON SISWA</h5>
            <hr style="margin-top: 8px;margin-bottom: 8px;">
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="150">                    
                        <label for="txt_berat_badan">Berat Badan (kg)</label>                        
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_berat_badan" name="txt_berat_badan">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_tinggi_badan">Tinggi Badan (cm)</label>
                        <div class="input-group-sm col-sm-4">                    
                            <input type="text" class="form-control" id="txt_tinggi_badan" name="txt_tinggi_badan">
                        </div>                    
                    </td>
                </tr>             
                <tr>
                    <td width="150">                    
                        <label for="">Sifat</label>    
                        <div style="line-height: 0px;"><br></div>
                        <label id="lbl_sifat" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label>                   
                    </td>    
                </tr>     
                <tr>                                 
                    <td>
                        <input type="checkbox" id="chk_sifat_pendiam" name="chk_sifat_pendiam" class="checkbox form-check-input chk_sifat">
                        <label for="chk_sifat_pendiam">&nbsp; Pendiam</label>  
                        <input type="hidden" id="chk_sifat_pendiam_temp" name="chk_sifat_pendiam_temp">
                    </td>  
                </tr>                
                <tr>
                    <td>
                        <input type="checkbox" id="chk_sifat_aktif" name="chk_sifat_aktif" class="checkbox form-check-input chk_sifat">
                        <label for="chk_sifat_aktif">&nbsp Aktif</label>  
                        <input type="hidden" id="chk_sifat_aktif_temp" name="chk_sifat_aktif_temp">
                    </td>  
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="chk_sifat_sangat_aktif" name="chk_sifat_sangat_aktif" class="checkbox form-check-input chk_sifat">
                        <label for="chk_sifat_sangat_aktif">&nbsp Sangat Aktif</label>  
                        <input type="hidden" id="chk_sifat_sangat_aktif_temp" name="chk_sifat_sangat_aktif_temp">
                    </td>  
                </tr>                                 
                <tr>
                    <td width="150">                    
                        <label for="">Apakah anak inklusi?</label>  
                        <div style="line-height: 0px;"><br></div>
                        <label id="lbl_anak_inklusi" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label>                  
                    </td>                           
                </tr>      
                <tr>
                    <td>
                        <input type="checkbox" id="chk_status_ya_anak_inklusi" name="chk_status_ya_anak_inklusi" class="checkbox form-check-input chk_status_inklusi">
                        <label for="chk_status_ya_anak_inklusi">&nbsp Ya</label>  
                        <input type="hidden" id="chk_status_ya_anak_inklusi_temp" name="chk_status_ya_anak_inklusi_temp">
                    </td>  
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="chk_status_tdk_anak_inklusi" name="chk_status_tdk_anak_inklusi" class="checkbox form-check-input chk_status_inklusi">
                        <label for="chk_status_tdk_anak_inklusi">&nbsp Tidak</label>  
                        <input type="hidden" id="chk_status_tdk_anak_inklusi_temp" name="chk_status_tdk_anak_inklusi_temp">
                    </td>  
                </tr>    
                
                <tr>
                    <td width="150">                    
                        <label for="">Jika ya, apakah siap membayar biaya inklusi setiap bulan selain SPP?</label>  
                        <div style="line-height: 0px;"><br></div>
                        <label id="lbl_membayar_biaya_inklusi" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label>                  
                    </td>                           
                </tr>      
                <tr>
                    <td>
                        <input type="checkbox" id="chk_status_ya_membayar_biaya_inklusi" name="chk_status_ya_membayar_biaya_inklusi" class="checkbox form-check-input chk_membayar_biaya_inklusi">
                        <label for="chk_status_ya_membayar_biaya_inklusi">&nbsp Ya</label>  
                        <input type="hidden" id="chk_status_ya_membayar_biaya_inklusi_temp" name="chk_status_ya_membayar_biaya_inklusi_temp">
                    </td>  
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="chk_status_tdk_membayar_biaya_inklusi" name="chk_status_tdk_membayar_biaya_inklusi" class="checkbox form-check-input chk_membayar_biaya_inklusi">
                        <label for="chk_status_tdk_membayar_biaya_inklusi">&nbsp Tidak</label>  
                        <input type="hidden" id="chk_status_tdk_membayar_biaya_inklusi_temp" name="chk_status_tdk_membayar_biaya_inklusi_temp">
                    </td>  
                </tr>    
                
            </table>
                            
            <h5>E. ORANG TUA / WALI MURID</h5>
            <hr style="margin-top: 5px; margin-bottom: 5px;">
            <h6><i>DATA AYAH</i></h6>
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_ayah_kandung">Nama Ayah</label>  
                        <!-- <label for="txt_nama_ayah_kandung"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                             -->
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_ayah_kandung" name="txt_nama_ayah_kandung">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_tempat_lahir_ayah">Tempat Lahir</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_tempat_lahir_ayah" name="txt_tempat_lahir_ayah">
                        </div>                    
                    </td>
                </tr>               
                <tr>
                    <td width="150">                    
                        <label for="dt_tgl_lahir_ayah">Tanggal Lahir</label>                        
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-select" id="dt_tgl_lahir_ayah" name="dt_tgl_lahir_ayah">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="list_agama_ayah">Agama</label>          
                        <!-- <label for="list_agama"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>      -->
                        <div class="input-group-sm col-sm-8">                    
                            <select class="form-select" id="list_agama_ayah" name="list_agama_ayah">   
                                <option value='' ></option>                                                        
                                <option value='Islam' >Islam</option>                                        
                            </select>  
                        </div>                    
                    </td>
                </tr>               
                <tr>
                    <td width="150">                    
                        <label for="list_pendidikan_ayah">Pendidikan Terakhir</label>  
                        <!-- <label for="list_pendidikan_ayah"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                             -->
                        <div class="input-group-sm col-sm-4">
                            <select name="list_pendidikan_ayah" id="list_pendidikan_ayah" class="form-select">   
                                <option value='' ></option>                                                        
                                <option value='D1' >D1</option>
                                <option value='D2' >D2</option>  
                                <option value='D3' >D3</option>  
                                <option value='S1' >S1</option>  
                                <option value='S2' >S2</option>  
                                <option value='S3' >S3</option> 
                                <option value='SD/Sederajat' >SD/Sederajat</option>
                                <option value='SMP/Sederajat' >SMP/Sederajat</option>
                                <option value='SMA/Sederajat' >SMA/Sederajat</option>
                            </select>  
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_pekerjaan_ayah">Pekerjaan</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_pekerjaan_ayah" name="txt_pekerjaan_ayah">
                        </div>                    
                    </td>
                </tr>        
            </table>
            
            <h6><i>DATA IBU</i></h6>            
            <table class="table table-sm table-borderless">
                <tr>
                    <td width="150">                    
                        <label for="txt_nama_ibu_kandung">Nama Ibu</label>  
                        <!-- <label for="txt_nama_ibu_kandung"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                             -->
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_nama_ibu_kandung" name="txt_nama_ibu_kandung">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_tempat_lahir_ibu">Tempat Lahir</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_tempat_lahir_ibu" name="txt_tempat_lahir_ibu">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="dt_tgl_lahir_ibu">Tanggal Lahir</label>                        
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-select" id="dt_tgl_lahir_ibu" name="dt_tgl_lahir_ibu">
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="list_agama_ibu">Agama</label>          
                        <!-- <label for="list_agama"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>      -->
                        <div class="input-group-sm col-sm-8">                    
                            <select class="form-select" id="list_agama_ibu" name="list_agama_ibu">   
                                <option value='' ></option>                                                        
                                <option value='Islam' >Islam</option>                                        
                            </select>  
                        </div>                    
                    </td>
                </tr>               
                <tr>
                    <td width="150">                    
                        <label for="list_pendidikan_ibu">Pendidikan Terakhir</label>  
                        <!-- <label for="list_pendidikan_ayah"><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                             -->
                        <div class="input-group-sm col-sm-4">
                            <select name="list_pendidikan_ibu" id="list_pendidikan_ibu" class="form-select">   
                                <option value='' ></option>                                                        
                                <option value='D1' >D1</option>
                                <option value='D2' >D2</option>  
                                <option value='D3' >D3</option>  
                                <option value='S1' >S1</option>  
                                <option value='S2' >S2</option>  
                                <option value='S3' >S3</option> 
                                <option value='SD/Sederajat' >SD/Sederajat</option>
                                <option value='SMP/Sederajat' >SMP/Sederajat</option>
                                <option value='SMA/Sederajat' >SMA/Sederajat</option>
                            </select>  
                        </div>                    
                    </td>
                </tr>
                <tr>
                    <td width="150">                    
                        <label for="txt_pekerjaan_ibu">Pekerjaan</label>                           
                        <div class="input-group-sm col-sm-8">                    
                            <input type="text" class="form-control" id="txt_pekerjaan_ibu" name="txt_pekerjaan_ibu">
                        </div>                    
                    </td>
                </tr>        
            </table>
            
            <h5>F. DOKUMEN PERSYARATAN</h5>
            <hr style="margin-top: 5px; margin-bottom: 5px;">
            
            <input type="hidden" id="uploaded_file_photo_siswa" name="uploaded_file_photo_siswa" class="uploaded_file">
            <input type="hidden" id="uploaded_file_ktp_ayah" name="uploaded_file_ktp_ayah" class="uploaded_file">
            <input type="hidden" id="uploaded_file_ktp_ibu" name="uploaded_file_ktp_ibu" class="uploaded_file">
            <input type="hidden" id="uploaded_file_kk" name="uploaded_file_kk" class="uploaded_file">
            <input type="hidden" id="uploaded_file_akta_kelahiran" name="uploaded_file_akta_kelahiran" class="uploaded_file">
            <table class="table table-borderless">                
                    <td>         
                        <label for="file_photo_siswa">Poto Siswa</label>&nbsp;     
                        <label id="lbl_warning_file_photo_siswa" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (file harus diisi)</i></label>         
                        <div class="input-group input-group-sm">                           
                            <label class="input-group-text" for="file_photo_siswa" role="button">pilih file </label>
                            <label for="file_photo_siswa" class="form-control" id="lbl_file_photo_siswa" role="button"></label>
                            <input type="file" class="d-none dokumen_persyaratan" id="file_photo_siswa" name="images[]" multiple accept="image/*">
                        </div> 
                    </td>                   
                </tr>                
                <tr>
                    <td><label for="file_ktp_ayah">KTP Ayah</label>&nbsp;
                        <label id="lbl_warning_file_ktp_ayah" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (file harus diisi)</i></label>                 
                        <div class="input-group input-group-sm">                           
                            <label class="input-group-text" for="file_ktp_ayah" role="button">pilih file </label>
                            <label for="file_ktp_ayah" class="form-control" id="lbl_file_ktp_ayah" role="button"></label>
                            <input type="file" class="d-none dokumen_persyaratan" id="file_ktp_ayah" name="images[]" multiple accept="image/*">
                            <div style="line-height: 5px;"><br></div>
                        </div>
                    </td>
                </tr>              
                <tr>
                    <td>        
                        <label for="file_ktp_ibu">KTP Ibu</label>&nbsp;
                        <label id="lbl_warning_file_ktp_ibu" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (file harus diisi)</i></label>                             
                        <div class="input-group input-group-sm">                           
                            <label class="input-group-text" for="file_ktp_ibu" role="button">pilih file </label>
                            <label for="file_ktp_ibu" class="form-control" id="lbl_file_ktp_ibu" role="button"></label>
                            <input type="file" class="d-none dokumen_persyaratan" id="file_ktp_ibu" name="images[]" multiple accept="image/*">
                            <div style="line-height: 5px;"><br></div>
                        </div>
                    </td>
                </tr>               
                <tr>                   
                    <td>   
                        <label for="file_kk">Kartu Keluarga</label>&nbsp;
                        <label id="lbl_warning_file_kk" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (file harus diisi)</i></label>                                               
                        <div class="input-group input-group-sm">                           
                            <label class="input-group-text" for="file_kk" role="button">pilih file </label>
                            <label for="file_kk" class="form-control" id="lbl_file_kk" role="button"></label>
                            <input type="file" class="d-none dokumen_persyaratan" id="file_kk" name="images[]" multiple accept="image/*">
                            <div style="line-height: 5px;"><br></div>
                        </div>
                    </td>
                </tr>             
                <tr>                   
                    <td>     
                        <label for="file_akta_kelahiran">Akta Kelahiran</label> 
                        <label id="lbl_warning_file_akta_kelahiran" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (file harus diisi)</i></label>                                                                
                        <div class="input-group input-group-sm">                           
                            <label class="input-group-text" for="file_akta_kelahiran" role="button">pilih file </label>
                            <label for="file_akta_kelahiran" class="form-control" id="lbl_file_akta_kelahiran" role="button"></label>
                            <input type="file" class="d-none dokumen_persyaratan" id="file_akta_kelahiran" name="images[]" multiple accept="image/*">
                        </div>
                    </td>
                </tr>
            </table>
            <br>

            <h6>Pernyataan Keabsahan Data (dicentrang) : 
                <!-- <label for=""><i style="color:rgb(228, 45, 45); font-size: 10pt;">&nbsp(harus diisi)</i></label>                             -->
            </h6>            
            <hr style="margin-top: 5px; margin-bottom: 5px;">
            <label id="lbl_pernyataan" style="display: none; color:red; font-size: 10pt;"><i>Silahkan pilih (data harus diisi)</i></label>
            <table class="table table-sm table-borderless">
                <tr>                                 
                    <td>
                        <input type="checkbox" id="chk_setuju" name="chk_setuju" class="checkbox form-check-input">
                        <label for="chk_setuju">&nbsp Ya Setuju</label> 
                        <input type="hidden" id="chk_setuju_temp" name="chk_setuju_temp" class="checkbox form-check-input">
                            <div class="row">
                                <div class="col">                                    
                                Demikian formulir pendaftaran ini kami isi dengan sebenarnya. Kami telah memahami dan menyetujui seluruh ketentuan pendaftaran                                                
                                <br>(Jika formulir di atas telah diisi, tekan tombol 'Kirim Formulir')                        
                                </div>                           
                            </div>                           
                    </td>     
                </tr>
            </table>

            <button type="submit" id="btn_submit" class="btn btn-sm btn-primary"><i class="bi bi-send-fill"></i> Kirim Formulir</button>
            
            <br>
            <br>

        </form>

        <button type="button" class="transparent" onclick="topFunction()" id="myBtn" title="Go to top"></button>
        <br><br>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="modal_siswa_id" role="dialog" data-bs-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" padding="2px">
                <h4 class="modal-title">Informasi Penting</h4>            
                <button type="button" class="btn btn-danger text-light btn-sm btn_close" id="btn_close_modal"><b>X</b></button>  
            </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <b> No. ID Anda : <h5 id="span_siswa_id" class="text-primary"></h5></b><br>
                Mohon disimpan No. ID Anda karena akan digunakan saat konfirmasi pembayaran nanti <br><br>
                <b class="text-primary"><i class="bi bi-check2-circle"></i> Simpan data berhasil</b> <br><br>
                <b class="text-success">Silahkan melanjutkan proses berikutnya : KONFIRMASI PEMBAYARAN </b>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="btn_ok_modal" class="btn btn-sm btn-primary btn_close">OK</button>
            </div>

        </div>
    </div>
    </div>

</body>
</html>

<script type="text/javascript">   
    <?php simpan_kunjungan(); ?>
   
    $(document).on('click', '.btn_close', function () {
        $('#modal_siswa_id').modal('hide')      
    })
    
    $('.dokumen_persyaratan').change(function(e) {
        var element = e.target.closest('.dokumen_persyaratan')
        var element_id = element.id
        let fileName = (e.target.files.length > 0) ? e.target.files[0].name : 'file tidak ditemukan';
        $('#lbl_'+element_id).text(fileName);
    });
    
    async function init_form() {       
        path_visi = "<?php echo base_url() ?>" +'./images/images_ui/up-arrows.png';	
        $('#myBtn').append("<img src='"+ path_visi + "' width='30' height='30'>");	

        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        var thn_ajaran_cls = "<?php echo $thn_ajaran_cls ;?>"  
        if(kode_jenjang=='TKIT'){ 
            document.getElementById("kelas_tk_div").innerHTML = "TKA / TKB"
        }
                       
        $('#txt_thn_ajaran_cls').val(thn_ajaran_cls)
        $('#txt_kode_jenjang').val(kode_jenjang)
        
        var result_cek = await fetch('<?php echo site_url('pendaftaran/pendaftaran/get_thn_ajaran_and_jenjang');?>?kode_jenjang='+kode_jenjang+'&thn_ajaran_cls='+thn_ajaran_cls+'', {method:"GET", mode: "no-cors" })  
        var result = await result_cek.json()  
        var data = result.data[0]
       
        if(result.status=true){            
            var thn_ajaran_nama = data[0].thn_ajaran_nama    
            var nama_jenjang = data[0].deskripsi        
            document.getElementById('nama_jenjang_div').innerHTML = nama_jenjang;           
            document.getElementById('thn_ajaran_nama_div').innerHTML = thn_ajaran_nama;	            
        }
    }
    
    $(document).on('click', '.chk_jenis_pendaftaran', function () {
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        const jenis_pendaftaran = event.target.closest('.chk_jenis_pendaftaran'); 
        let jenis_pendaftarans_class = document.getElementsByClassName('chk_jenis_pendaftaran');
        var jenis_pendaftaran_id = jenis_pendaftaran.id   
        for (let jenis_pendaftaran_class of jenis_pendaftarans_class){
            if(jenis_pendaftaran_id != jenis_pendaftaran_class.id){
                jenis_pendaftaran_class.checked = false
            }            
            var vjenis_pendaftaran_id = '';
            if (jenis_pendaftaran_id == 'chk_siswa_baru'){
                vjenis_pendaftaran_id = document.getElementById(jenis_pendaftaran_id)
                if (vjenis_pendaftaran_id.checked == true){     
                    if(kode_jenjang=='TKIT'){  
                        $('#txt_kelas').val('')
                        $('#txt_kelas').attr('readonly',false)
                    }             
                    if(kode_jenjang=='SDIT'){
                        $('#txt_kelas').val('I')  
                        $('#txt_kelas').attr('readonly',true)
                    }     
                    if(kode_jenjang=='SMPIT'){
                        $('#txt_kelas').val('VII')
                        $('#txt_kelas').attr('readonly',true)
                    }
                }else{
                    if(kode_jenjang=='TKIT'){  
                        $('#txt_kelas').val('')
                        $('#txt_kelas').attr('readonly',true)
                    }             
                    if(kode_jenjang=='SDIT'){
                        $('#txt_kelas').val('')  
                        $('#txt_kelas').attr('readonly',true)
                    }     
                    if(kode_jenjang=='SMPIT'){
                        $('#txt_kelas').val('')
                        $('#txt_kelas').attr('readonly',true)
                    }
                }
            }
            if (jenis_pendaftaran_id == 'chk_siswa_pindahan'){
                vjenis_pendaftaran_id = document.getElementById(jenis_pendaftaran_id)
                if (vjenis_pendaftaran_id.checked == true){
                    $('#txt_kelas').val('')  
                    $('#txt_kelas').attr('readonly',false)
                }else{
                    $('#txt_kelas').val('') 
                    $('#txt_kelas').attr('readonly',true)
                }
            }
        }    
    });
   
    $(document).on('click', '.chk_sifat', function () {    
        const sifat = event.target.closest('.chk_sifat');        
        let sifats_class = document.getElementsByClassName('chk_sifat');
        var sifat_id = sifat.id       
        for (let sifat_class of sifats_class){
            if(sifat_id != sifat_class.id){
                sifat_class.checked = false
            }            
        }       
    });
      
    $(document).on('click', '.chk_status_inklusi', function () {   
        const this_target = event.target.closest('.chk_status_inklusi');        
        let targets = document.getElementsByClassName('chk_status_inklusi');
        var target_id = this_target.id
        for (let target of targets){
            if(target_id != target.id){
                target.checked = false
            }            
        }       
    });
 
    $(document).on('click', '.chk_membayar_biaya_inklusi', function () {       
        const this_target = event.target.closest('.chk_membayar_biaya_inklusi');        
        let targets = document.getElementsByClassName('chk_membayar_biaya_inklusi');
        var target_id = this_target.id   
        var chk_this_target = document.getElementById(target_id)        
        for (let target of targets){
            if(target_id != target.id){
                target.checked = false
            }            
        }       
    });    

    async function upload_file_dokumen(par, element_id) {
        var form_data = new FormData();
        var status_simpan;
        if (par=='upload'){
            status_simpan = 'false';
        }else{
            status_simpan = 'true';
        }
      
        var siswa_id = $('#txt_siswa_id').val()       
        var file_path_ori = $('#uploaded_'+element_id).val()   
        form_data.append('file_name', document.getElementById(element_id).files[0]);     
        form_data.append("status_simpan", status_simpan); 
        form_data.append("jenis_dokumen", "dokumen_persyaratan"); 
        form_data.append("siswa_id", siswa_id);
        form_data.append("element_id", element_id);
        form_data.append("file_path_ori", file_path_ori);

        await $.ajax(
        {
            url:"<?php echo base_url()?>upload_dokumen.php",
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
                console.log(dataResult)
                var path_view = dataResult.path_view;
                var path_save = dataResult.path_save;
                var element_id = dataResult.element_id;
                if(element_id=="file_photo_siswa"){
                    $('#uploaded_file_photo_siswa').val(path_save); 
                }
                if(element_id=="file_ktp_ayah"){
                    $('#uploaded_file_ktp_ayah').val(path_save); 
                }
                if(element_id=="file_ktp_ibu"){
                    $('#uploaded_file_ktp_ibu').val(path_save); 
                }    
                if(element_id=="file_kk"){
                    $('#uploaded_file_kk').val(path_save); 
                }    
                if(element_id=="file_akta_kelahiran"){
                    $('#uploaded_file_akta_kelahiran').val(path_save); 
                }       
            }
        });
    }
    
    $(document).on('change', '.dokumen_persyaratan', function(e)	{			
        try {   
            var element = e.target.closest('.dokumen_persyaratan')
            var element_id = element.id
            var name_obj =document.getElementById(element_id).files[0];
            //var name_obj =$('#file').val();
            var name = document.getElementById(element_id).files[0].name;
                   
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg','pdf']) == -1) 
            {
                alert("Invalid Image File");
                return false;
            }

            var oFReader = new FileReader();       
            oFReader.readAsDataURL(document.getElementById(element_id).files[0]);
            var f = document.getElementById(element_id).files[0];
            var fsize = f.size||f.fileSize;        
            if(fsize > 2000000)
            {
                alert("Image File Size is very big");
                return false;
            }
            else
            {                   
                upload_file_dokumen('upload', element_id)                
            }

        } catch (error) {
            alert(error)
        }
	});

    $(document).on('submit','#simpan_form', async function(event) {

        var thn_ajaran = $('#txt_thn_ajaran_cls').val()       
        event.preventDefault();      
        var valid_data = await validasi_data_submit();
        var valid_file = await validasi_file_submit();
              
        if( valid_data == false || valid_file == false){	        
            alert('Silahkan isi data yang diperlukan');
            return false;
        }      
     
        var kelas = $('#txt_kelas').is('[readonly]')       
        if(kelas==true){
            $('#txt_kelas').attr('readonly', false) 
        }
       
        var form_data= $(this).serialize();
           
        if(kelas==true){
            $('#txt_kelas').attr('readonly', true) 
        }
     
        fetch('<?php echo site_url('pendaftaran/pendaftaran/simpan_input_pendaftaran') ;?>',{
                    method: 'POST',   
                    body: new URLSearchParams(form_data)
                    //headers: {'Content-Type': 'multipart/form-data'},                    
                })
        .then(response => response.json()) 
        .then( async dataResult => {          
                console.log(dataResult) 
                if (dataResult.status == false){
                    alert(dataResult.message);                   
                }else{
                    var siswa_id = dataResult.data_id   
                    $('#txt_siswa_id').val(siswa_id)
                    var element_id;                 
                    var dokumen = document.getElementsByClassName('dokumen_persyaratan')   
                    var value = '';
                    for (let i = 0; i < dokumen.length; i++) {
                        element_id = dokumen[i].id;    
                        value = document.getElementById(element_id).value;
                        if(value!=''){
                            await upload_file_dokumen('simpan', element_id)
                        }
                    }

                    await simpan_file_path(siswa_id)                            
                    document.getElementById("span_siswa_id").innerHTML = siswa_id                   
                    $('#modal_siswa_id').modal('show')
                    input_area_clear()
                }                
            })
        .catch(err => {
            alert(err);
        });   
    });

    async function simpan_file_path(siswa_id) {                        
        let file_photo_siswa =  $('#uploaded_file_photo_siswa').val();
        let file_ktp_ayah =  $('#uploaded_file_ktp_ayah').val();
        let file_ktp_ibu =  $('#uploaded_file_ktp_ibu').val();
        let file_kk =  $('#uploaded_file_kk').val();
        let file_akta_kelahiran =  $('#uploaded_file_akta_kelahiran').val();

        var form_data = new FormData();
        form_data.append("siswa_id", siswa_id);        
        form_data.append("file_photo_siswa", file_photo_siswa);
        form_data.append("file_ktp_ayah", file_ktp_ayah);
        form_data.append("file_ktp_ibu", file_ktp_ibu);
        form_data.append("file_kk", file_kk);
        form_data.append("file_akta_kelahiran", file_akta_kelahiran);

        await fetch('<?php echo site_url('pendaftaran/pendaftaran/simpan_file_path') ;?>',{
                    method: 'POST',   
                    //data:{'berita_id':berita_id, 'img_file_path':img_file_path},
                    body: form_data,
                    //headers: {'Content-Type': 'multipart/json'}                  
                })
        .then(response => response.json()) 
        .then(dataResult => {
            //alert('Simpan data sukses');        
            //console.log(dataResult.data);      
            })
        .catch(err => {
            alert(err);
        });           
    }

    function validasi_file_submit() {
        let valid_file=true;	

        let file_photo_siswa =  $('#file_photo_siswa').val();            
        if (file_photo_siswa == ''){
            valid_file = false            
            $('#lbl_warning_file_photo_siswa').css('display', 'inline')            
        }else{
            $('#lbl_warning_file_photo_siswa').css('display', 'none')            
        }
        let file_ktp_ayah =  $('#file_ktp_ayah').val();            
        if (file_ktp_ayah == ''){
            valid_file = false            
            $('#lbl_warning_file_ktp_ayah').css('display', 'inline')            
        }else{
            $('#lbl_warning_file_ktp_ayah').css('display', 'none')
            // await upload_file_berita('simpan')
        }
        let file_ktp_ibu =  $('#file_ktp_ibu').val();            
        if (file_ktp_ibu == ''){
            valid_file = false            
            $('#lbl_warning_file_ktp_ibu').css('display', 'inline')            
        }else{
            $('#lbl_warning_file_ktp_ibu').css('display', 'none')
            // await upload_file_berita('simpan')
        }
        let file_kk =  $('#file_kk').val();            
        if (file_kk == ''){
            valid_file = false            
            $('#lbl_warning_file_kk').css('display', 'inline')            
        }else{
            $('#lbl_warning_file_kk').css('display', 'none')
            // await upload_file_berita('simpan')
        }
        let file_akta_kelahiran =  $('#file_akta_kelahiran').val();            
        if (file_akta_kelahiran == ''){
            valid_file = false            
            $('#lbl_warning_file_akta_kelahiran').css('display', 'inline')            
        }else{
            $('#lbl_warning_file_akta_kelahiran').css('display', 'none')
            // await upload_file_berita('simpan')
        }

        return valid_file;
    }

    function validasi_data_submit() 
    {       
        var kode_jenjang = "<?php echo $kode_jenjang ;?>"
        let valid=true;		
        let x = document.forms["simpan_form"];

        //JENIS PENDAFTARAN
        let chk_siswa_baru = document.getElementById('chk_siswa_baru');
        if(chk_siswa_baru.checked==true){  
            $('#chk_siswa_baru_temp').val(true)             
        }
        let chk_siswa_pindahan = document.getElementById('chk_siswa_pindahan');
        if(chk_siswa_pindahan.checked==true){      
            $('#chk_siswa_pindahan_temp').val(true)             
        }//page
        let kelas = x["txt_kelas"].value;
        let nisn = x["txt_nisn"].value;

        if (chk_siswa_baru.checked==false && chk_siswa_pindahan.checked==false){
            $('#lbl_jenis_pendaftaran').css('display', 'inline')
        }else{			
            $('#lbl_jenis_pendaftaran').css('display', 'none')  
        }      

        if (kode_jenjang=='TKIT'){
            if(kelas ==''){
                $('#txt_kelas').css('border-color', '#cc0000');
            }else{
                $('#txt_kelas').css('border-color', '');	
            }
        }else{            
            if (chk_siswa_pindahan.checked==true && kelas ==''){
                $('#txt_kelas').css('border-color', '#cc0000');				
            }else{			
                $('#txt_kelas').css('border-color', '');	
            }
        }        
        
        //IDENTITAS CALON SISWA
        let nama_lengkap = x["txt_nama_lengkap"].value;
        let nama_panggilan = x["txt_nama_panggilan"].value;       
        let tempat_lahir = x["txt_tempat_lahir"].value;
        let tgl_lahir = x["dt_tgl_lahir"].value;
        let jenis_kelamin = x["list_jenis_kelamin"].value;
        let anak_ke = x["list_anak_ke"].value;
        let jml_saudara = x["list_jml_saudara"].value;
        let golongan_darah = x["txt_golongan_darah"].value;
        let no_hp = x["txt_no_hp"].value;
        let alamat_rumah = x["txt_alamat_rumah"].value;
        let nama_sekolah_asal = x["txt_nama_sekolah_asal"].value;
        let alamat_sekolah_asal = x["txt_alamat_sekolah_asal"].value;
        
        if(nama_lengkap==''){
            $('#txt_nama_lengkap').css('border-color', '#cc0000');				
        }else{			
            $('#txt_nama_lengkap').css('border-color', '');	
        }
        if(nama_panggilan==''){
            $('#txt_nama_panggilan').css('border-color', '#cc0000');				
        }else{			
            $('#txt_nama_panggilan').css('border-color', '');	
        }
        if(tempat_lahir==''){
            $('#txt_tempat_lahir').css('border-color', '#cc0000');				
        }else{			
            $('#txt_tempat_lahir').css('border-color', '');	
        }        
        if(tgl_lahir==''){
            $('#dt_tgl_lahir').css('border-color', '#cc0000');				
        }else{			
            $('#dt_tgl_lahir').css('border-color', '');	
        }
        if(jenis_kelamin==''){
            $('#list_jenis_kelamin').css('border-color', '#cc0000');				
        }else{			
            $('#list_jenis_kelamin').css('border-color', '');	
        }
        if(anak_ke==''){
            $('#list_anak_ke').css('border-color', '#cc0000');				
        }else{			
            $('#list_anak_ke').css('border-color', '');	
        }
        if(jml_saudara==''){
            $('#list_jml_saudara').css('border-color', '#cc0000');				
        }else{			
            $('#list_jml_saudara').css('border-color', '');	
        }
        if(golongan_darah==''){
            $('#txt_golongan_darah').css('border-color', '#cc0000');				
        }else{			
            $('#txt_golongan_darah').css('border-color', '');	
        }
        if(no_hp==''){
            $('#txt_no_hp').css('border-color', '#cc0000');				
        }else{			
            $('#txt_no_hp').css('border-color', '');	
        }
        if(alamat_rumah==''){
            $('#txt_alamat_rumah').css('border-color', '#cc0000');				
        }else{			
            $('#txt_alamat_rumah').css('border-color', '');	
        }
        if(nama_sekolah_asal==''){
            $('#txt_nama_sekolah_asal').css('border-color', '#cc0000');				
        }else{			
            $('#txt_nama_sekolah_asal').css('border-color', '');	
        }
        if(alamat_sekolah_asal==''){
            $('#txt_alamat_sekolah_asal').css('border-color', '#cc0000');				
        }else{			
            $('#txt_alamat_sekolah_asal').css('border-color', '');	
        }        
       
        //KARAKTERISTIK CALON SISWA
        let berat_badan = x["txt_berat_badan"].value;
        let tinggi_badan = x["txt_tinggi_badan"].value;
        let chk_sifat_pendiam = document.getElementById('chk_sifat_pendiam');
        if(chk_sifat_pendiam.checked==true){      
            $('#chk_sifat_pendiam_temp').val(true)             
        }
        let chk_sifat_aktif = document.getElementById('chk_sifat_aktif');
        if(chk_sifat_aktif.checked==true){      
            $('#chk_sifat_aktif_temp').val(true)             
        }
        let chk_sifat_sangat_aktif = document.getElementById('chk_sifat_sangat_aktif');
        if(chk_sifat_sangat_aktif.checked==true){      
            $('#chk_sifat_sangat_aktif_temp').val(true)             
        }
        let chk_status_ya_anak_inklusi = document.getElementById('chk_status_ya_anak_inklusi');
        if(chk_status_ya_anak_inklusi.checked==true){      
            $('#chk_status_ya_anak_inklusi_temp').val(true)             
        }
        let chk_status_tdk_anak_inklusi = document.getElementById('chk_status_tdk_anak_inklusi');
        if(chk_status_tdk_anak_inklusi.checked==true){      
            $('#chk_status_tdk_anak_inklusi_temp').val(true)             
        }
        let chk_status_ya_membayar_biaya_inklusi = document.getElementById('chk_status_ya_membayar_biaya_inklusi');
        if(chk_status_ya_membayar_biaya_inklusi.checked==true){
            $('#chk_status_ya_membayar_biaya_inklusi_temp').val(true)             
        }
        let chk_status_tdk_membayar_biaya_inklusi = document.getElementById('chk_status_tdk_membayar_biaya_inklusi');
        if(chk_status_tdk_membayar_biaya_inklusi.checked==true){      
            $('#chk_status_tdk_membayar_biaya_inklusi_temp').val(true)             
        }

        if(berat_badan==''){
            $('#txt_berat_badan').css('border-color', '#cc0000');				
        }else{			
            $('#txt_berat_badan').css('border-color', '');	
        }        
        if(tinggi_badan==''){
            $('#txt_tinggi_badan').css('border-color', '#cc0000');				
        }else{			
            $('#txt_tinggi_badan').css('border-color', '');	
        }              
        if(chk_sifat_pendiam.checked==false && chk_sifat_aktif.checked==false && chk_sifat_sangat_aktif.checked==false ){            				            
            $('#lbl_sifat').css('display', 'inline')
        }else{			
            $('#lbl_sifat').css('display', 'none')  
        }  
        if(chk_status_ya_anak_inklusi.checked==false && chk_status_tdk_anak_inklusi.checked==false){
            $('#lbl_anak_inklusi').css('display', 'inline')
        }else{			
            $('#lbl_anak_inklusi').css('display', 'none')  
        }  
        if(chk_status_ya_membayar_biaya_inklusi.checked==false && chk_status_tdk_membayar_biaya_inklusi.checked==false){
            $('#lbl_membayar_biaya_inklusi').css('display', 'inline')
        }else{			
            $('#lbl_membayar_biaya_inklusi').css('display', 'none')  
        }  
        
        //DATA AYAH KANDUNG
        let nama_ayah_kandung = x["txt_nama_ayah_kandung"].value; 
        let tempat_lahir_ayah = x['txt_tempat_lahir_ayah'].value; 
        let tgl_lahir_ayah = x['dt_tgl_lahir_ayah'].value;
        let agama_ayah = x['list_agama_ayah'].value;
        let pendidikan_ayah = x["list_pendidikan_ayah"].value; 
        let pekerjaan_ayah = x["txt_pekerjaan_ayah"].value; 
        if(nama_ayah_kandung==''){
            $('#txt_nama_ayah_kandung').css('border-color', '#cc0000');				
        }else{			
            $('#txt_nama_ayah_kandung').css('border-color', '');	
        }
        if(tempat_lahir_ayah==''){
            $('#txt_tempat_lahir_ayah').css('border-color', '#cc0000');				
        }else{			
            $('#txt_tempat_lahir_ayah').css('border-color', '');	
        }
        if(tgl_lahir_ayah==''){
            $('#dt_tgl_lahir_ayah').css('border-color', '#cc0000');				
        }else{			
            $('#dt_tgl_lahir_ayah').css('border-color', '');	
        }
        if(agama_ayah==''){
            $('#list_agama_ayah').css('border-color', '#cc0000');				
        }else{			
            $('#list_agama_ayah').css('border-color', '');	
        }    
        if(pendidikan_ayah==''){
            $('#list_pendidikan_ayah').css('border-color', '#cc0000');				
        }else{			
            $('#list_pendidikan_ayah').css('border-color', '');	
        }    
        if(pekerjaan_ayah==''){
            $('#txt_pekerjaan_ayah').css('border-color', '#cc0000');				
        }else{			
            $('#txt_pekerjaan_ayah').css('border-color', '');	
        }

        //DATA IBU KANDUNG
        let nama_ibu_kandung = x["txt_nama_ibu_kandung"].value; 
        let tempat_lahir_ibu = x["txt_tempat_lahir_ibu"].value; 
        let tgl_lahir_ibu = x["dt_tgl_lahir_ibu"].value;
        let agama_ibu = x["list_agama_ibu"].value;
        let pendidikan_ibu = x["list_pendidikan_ibu"].value; 
        let pekerjaan_ibu = x["txt_pekerjaan_ibu"].value;   
        
        if(nama_ibu_kandung==''){
            $('#txt_nama_ibu_kandung').css('border-color', '#cc0000');				
        }else{			
            $('#txt_nama_ibu_kandung').css('border-color', '');	
        }
        if(tempat_lahir_ibu==''){
            $('#txt_tempat_lahir_ibu').css('border-color', '#cc0000');				
        }else{			
            $('#txt_tempat_lahir_ibu').css('border-color', '');	
        }
        if(tgl_lahir_ibu==''){
            $('#dt_tgl_lahir_ibu').css('border-color', '#cc0000');				
        }else{			
            $('#dt_tgl_lahir_ibu').css('border-color', '');	
        }
        if(agama_ibu==''){
            $('#list_agama_ibu').css('border-color', '#cc0000');				
        }else{			
            $('#list_agama_ibu').css('border-color', '');	
        }
        if(pendidikan_ibu==''){
            valid = false;
            $('#list_pendidikan_ibu').css('border-color', '#cc0000');				
        }else{			
            $('#list_pendidikan_ibu').css('border-color', '');	
        }
        if(pekerjaan_ibu==''){
            valid = false;
            $('#txt_pekerjaan_ibu').css('border-color', '#cc0000');				
        }else{			
            $('#txt_pekerjaan_ibu').css('border-color', '');	
        }
       
        //PERNYATAAN SETUJU
        let chk_setuju = document.getElementById('chk_setuju');    
        if(chk_setuju.checked==true){
            $('#chk_setuju_temp').val(true)
            $('#lbl_pernyataan').css('display', 'none')
        }else{
            valid = false;
            $('#chk_setuju_temp').val(false)
            $('#lbl_pernyataan').css('display', 'inline')            
        }

        return valid;
    }

    function input_area_clear() {       
        //JENIS PENDAFTARAN
        document.getElementById('chk_siswa_baru').checked=false;       
        $('#chk_siswa_baru_temp').val(false) 
        document.getElementById('chk_siswa_pindahan').checked=false;           
        $('#chk_siswa_pindahan_temp').val(false)    
        $('#txt_kelas').val('');
        $('#txt_kelas').css('readonly',true);
        $('#txt_nisn').val('');

        //IDENTITAS CALON SISWA
        $('#txt_nama_lengkap').val('')
        $('#txt_nama_panggilan').val('')
        $('#txt_tempat_lahir').val('')
        $('#dt_tgl_lahir').val('')
        $('#list_jenis_kelamin').val('')
        $('#list_anak_ke').val('')
        $('#list_jml_saudara').val('')
        $('#txt_golongan_darah').val('')
        $('#txt_no_hp').val('')
        $('#txt_alamat_rumah').val('')
        $('#txt_nama_sekolah_asal').val('')
        $('#txt_alamat_sekolah_asal').val('')

        //KAREKTERISTIK CALON SISWA        
        $('#txt_berat_badan').val('')
        $('#txt_tinggi_badan').val('')
        document.getElementById("chk_sifat_pendiam").checked=false        
        $('#chk_sifat_pendiam_temp').val(false)
        document.getElementById("chk_sifat_aktif").checked=false        
        $('#chk_sifat_aktif_temp').val(false)
        document.getElementById("chk_sifat_sangat_aktif").checked=false       
        $('#chk_sifat_sangat_aktif_temp').val(false)
        document.getElementById("chk_status_ya_anak_inklusi").checked=false      
        $('#chk_status_ya_anak_inklusi_temp').val(false)
        document.getElementById("chk_status_tdk_anak_inklusi").checked=false        
        $('#chk_status_tdk_anak_inklusi_temp').val(false)
        document.getElementById("chk_status_ya_membayar_biaya_inklusi").checked=false        
        $('#chk_status_ya_membayar_biaya_inklusi_temp').val(false)
        document.getElementById("chk_status_tdk_membayar_biaya_inklusi").checked=false
        $('#chk_status_tdk_membayar_biaya_inklusi_temp').val(false)
                     
        //DATA AYAH KANDUNG
        $('#txt_nama_ayah_kandung').val('')
        $('#txt_tempat_lahir_ayah').val('')
        $('#dt_tgl_lahir_ayah').val('')
        $('#list_agama_ayah').val('')
        $('#list_pendidikan_ayah').val('')
        $('#txt_pekerjaan_ayah').val('')
       
        //DATA IBU KANDUNG
        $('#txt_nama_ibu_kandung').val('')
        $('#txt_tempat_lahir_ibu').val('')
        $('#dt_tgl_lahir_ibu').val('')
        $('#list_agama_ibu').val('')
        $('#list_pendidikan_ibu').val('')
        $('#txt_pekerjaan_ibu').val('')
       
        //DOKUMEN PERSYARATAN
        $('#uploaded_file_photo_siswa').val('')
        $('#uploaded_file_ktp_ayah').val('')
        $('#uploaded_file_ktp_ibu').val('')
        $('#uploaded_file_kk').val('')
        $('#uploaded_file_akta_kelahiran').val('')
        $('#file_photo_siswa').val(null)       
        $('#file_ktp_ayah').val(null)
        $('#file_ktp_ibu').val(null)
        $('#file_kk').val(null)
        $('#file_file_akta_kelahiran').val(null)
        $('#lbl_file_photo_siswa').text('')
        $('#lbl_file_ktp_ayah').text('')
        $('#lbl_file_ktp_ibu').text('')
        $('#lbl_file_kk').text('')
        $('#lbl_file_akta_kelahiran').text('')

        //PERNYATAAN SETUJU
        document.getElementById('chk_setuju').checked=false        
        $('#chk_setuju_temp').val(false)
    }

    function goto_header() {
        var header = document.getElementById("my-header").offsetTop; 
        window.scrollTo(0, header);                
    }

    $(function() {
        $('#dt_tgl_lahir').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');      

        $('#dt_tgl_lahir_ayah').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');      

        $('#dt_tgl_lahir_ibu').datepicker({
            format:"dd-M-yyyy",
            //toggleActive: true,
            autoclose: true,            
            changeMonth: true,
            changeYear: true,
            todayHighlight: true
        }).datepicker('update', '');   
        
    });


    // Get the button
    let mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>


<style>
    #myBtn {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        /*background-color: red;*/
        color: darkblue;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
    }

    #myBtn:hover {
        background-color: #e5e7e7;
    }

    .transparent{
        background-color: transparent;
    }

    #file_photo_siswa {
        border: 1px solid red;
    }

    .modal-footer {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;
    }

</style>