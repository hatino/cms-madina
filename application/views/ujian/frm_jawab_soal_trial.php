<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>   
</head>
<body>
    <body onload="init_form()"></body>    

    <div class="gradient-over-image">
        <h3 class="text-light text-shadow-black"><span id="jenis_penilaian"></h3>
        <!-- <h3 class="text-light" ><span id="nama_mapel"></h3> -->       
        <h5 class="text-info text-shadow-black"><span id="deskripsi_thnajaran"></h5>
        <div class="row row-cols-1 row-cols-md-3 g-4" style="margin:5px; justify-content: center;" id="data_soal"></div>              
    </div>

    <br>
    <form action="post" id="simpan_form">
        <input type="hidden" id="jam_current">
    </form>
   
    <table class="table table-sm table-bordered table-striped table-sticky mx-auto fix-pos-table" style="width:70%; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">       
        <thead>
            <tr class="borderless-bottom">
                <td class="py-0" style="text-align:center">Jam </th>
                <td class="py-0" style="text-align:center">Jam Mulai</th>
                <td class="py-0" style="text-align:center">Jam Selesai</th>
                <td class="py-0" style="text-align:center">Jawaban / Soal</th>
            </tr>  
        </thead>        
        <tbody style="background-color: #FFFFFF">           
            <tr>
                <td class="py-0 text-danger w-25" style="text-align:center"><span id="serverTimeDisplay"></span></td>
                <td class="py-0 text-danger w-25" style="text-align:center"><span id="jam_mulai"></span></td>
                <td class="py-0 text-danger w-25" style="text-align:center"><span id="jam_selesai"></span></td>
                <td class="py-0 text-danger w-25" style="text-align:center"><span id="jml_jawab_soal"></span></td>
            </tr>
        </tbody>        
    </table>
    <img style="justify-content: center; display: flex;" class="mx-auto" src="<?php echo base_url('images/images_ui/bismillah.png') ;?>" alt="">

    <div class="container">
        <div style="line-height: 15px;"><br></div>
        <div class="tscroll">
            <div id="tbl_jawab_soal_pg_div" class="table-responsive table-height"></div>  
            <div id="tbl_jawab_soal_essai_div" class="table-responsive table-height"></div>      
        </div>
    </div>

    <!-- <button id="show_modal">Show Modal</button> -->

    
   
    <footer style="margin-top:  50px;"></footer>

    <!-- The Modal-->
    <div class="modal fade" id="modal_jawab_soal" role="dialog" data-bs-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">  

                    <div class="task-container" id="task1">
                        <div class="row">                            
                            <div class="col" style="display:flex; justify-content: center; align-items: center;">
                                <div class="checkbox-wrapper">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h4 class="text-header"><b>Silahkan mulai</b></h4>
                            </div>                            
                        </div>   

                        <br>
                        <div style="display:flex; justify-content: center; align-items: center;">
                            <button type="button" id="btn_mulai" class="btn btn-sm btn-submit"><i class="bi bi-back"></i>&nbsp;Mulai</button>   
                        </div>
                    </div>    

                    <div class="clock-container" id="task2">
                        <div class="row">                            
                            <div class="col" style="display:flex; justify-content: center; align-items: center;">                                
                                <svg class="clock-icon" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="45" stroke="#333" stroke-width="3" fill="white" />

                                    <circle cx="50" cy="50" r="3" fill="#333" />

                                    <line x1="50" y1="50" x2="50" y2="30" stroke="#333" stroke-width="4" stroke-linecap="round" class="hour-hand" />

                                    <line x1="50" y1="50" x2="50" y2="15" stroke="#333" stroke-width="3" stroke-linecap="round" class="minute-hand" />
                                </svg>                                   
                            </div>                            
                        </div>
                        <div class="row"> 
                            <div class="col" style="display:flex; justify-content: center; align-items: center;">                                
                                <h4 class="text-danger"><b>Waktu sudah habis</b></h4>
                            </div>
                        </div>
                        
                        <div style="display:flex; justify-content: center; align-items: center;">
                            <button type="button" id="btn_keluar" class="btn btn-sm btn-submit"><i class="bi bi-back"></i>&nbsp;Keluar</button>   
                        </div>
                    </div>

                </div>                    
            </div>

        </div>
    </div>
    </div>


    <!--------------- [START] SETTING JAM CLIENT DISESUAIKAN JAM SERVER ---------------->
    <script>
        <?php
            // Set zona waktu ke Waktu Indonesia Barat (WIB)
            $timezone = new DateTimeZone('Asia/Jakarta');

            // Buat objek DateTime dengan zona waktu tersebut
            $date = new DateTime('now', $timezone);

            // Dapatkan timestamp dalam detik, lalu kalikan 1000 untuk milidetik
            $serverTimestamp = $date->getTimestamp() * 1000;
        ?>

        // Ambil timestamp server saat halaman dirender
        // Contoh ini menggunakan timestamp Unix (detik sejak Epoch)
        //const serverTimestamp = <?php echo time(); ?> * 1000; // * 1000 untuk milidetik
        //const serverTimestamp = <?php echo $serverTimestamp; ?>; // * 1000 untuk milidetik
        
        // Atau jika Anda ingin format tanggal/waktu spesifik dari PHP:
        // const serverDateTimeString = "<?php echo date('Y-m-d H:i:s'); ?>";
        // const serverTimestamp = new Date(serverDateTimeString).getTime(); // Konversi ke milidetik JS

        // ----------------NEW CONCEPT-----------------
        // Timestamp dari server (ms)
        let serverNow = <?php echo $serverTimestamp; ?>;
        // Timestamp client saat halaman dimuat
        let clientNow = Date.now();
        // Selisih antara server dan client
        let offsetMillis = serverNow - clientNow;

        // Formatter WIB
        const formatter = new Intl.DateTimeFormat('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        });

        // Fungsi ambil waktu server sekarang
        function getServerTime() {
            return new Date(Date.now() + offsetMillis);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const serverTimeDisplay = document.getElementById('serverTimeDisplay');

            function updateTimer() {
                const serverTime = getServerTime();

                // Tampilkan jam server
                serverTimeDisplay.textContent = formatter.format(serverTime);

                // Simpan ke hidden input
                const jam_current = formatter.format(serverTime);
                document.getElementById('jam_current').value = jam_current;

                // --- contoh logika ---
                if (typeof jam_mulai !== "undefined" && jam_current === jam_mulai) {
                    mulai_mengerjakan();
                }

                if (typeof jam_selesai !== "undefined" && jam_current === jam_selesai) {
                    selesai_mengerjakan();
                }

                if (typeof jam_mulai !== "undefined" && typeof jam_selesai !== "undefined") {
                    if (jam_current >= jam_mulai && jam_current <= jam_selesai && status_load_soal === false) {
                        status_load_soal = true;
                        //fetch_daftar_soal_pg_db();
                        //fetch_daftar_soal_essai();
                        //fetch_jumlah_jawab_soal();
                        get_soal_pg_json()
                    }
                }
            }

            // Update tiap detik
            setInterval(updateTimer, 1000);
            updateTimer(); // panggil sekali biar langsung tampil
        });

    </script>
    <!--------------- [END] SETTING JAM CLIENT DISESUAIKAN JAM SERVER ---------------->

</body>
</html>

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


<script type="text/javascript">
   
    //============================= [START] CEK KONEKSI INTERNET =============================
    
    var status_koneksi = '';
    // Fungsi untuk memperbarui UI
    const updateStatus = (isOnline) => {
        if (isOnline) {
            //alert('Koneksi Online')
            if (status_koneksi == 'offline'){
                alert('Koneksi Kembali Online')
                status_koneksi = ''
            }            
        } else {
            alert('Koneksi Offline, Silahkan hubungi pengawas')
            return false;
        }
    };

    // Fungsi utama untuk mengecek koneksi menggunakan Fetch
    const checkConnection = async () => {
        // Gunakan URL yang dikenal stabil dan ringan untuk diakses
        const url = 'https://jsonplaceholder.typicode.com/posts/1';
        //const url = 'https://swiislamicschool.sch.id/posts/1';
        
        await fetch(url, { method: 'HEAD', cache: 'no-store' })
            .then(response => {
                updateStatus(response.ok);
            })
            .catch(() => {
                updateStatus(false);
            });
    };
    

    // Menggunakan navigator.onLine sebagai fallback awal yang cepat
    if (navigator.onLine) {
        updateStatus(true);
    } else {
        updateStatus(false);
    }

    // Memeriksa koneksi secara akurat saat halaman dimuat
    // checkConnection();

    // Mendengarkan event online/offline untuk update real-time
    window.addEventListener('online', () => {
        // Lakukan pemeriksaan yang lebih akurat setelah event online dipicu
        checkConnection();
    });

    window.addEventListener('offline', () => {
        status_koneksi = 'offline'
        updateStatus(false);
    });
    //============================= [END] CEK KONEKSI INTERNET =============================


    //==================== [START] NON-AKTIF-KAN FUNGSI COPY PAST DLL. =====================
    document.addEventListener('contextmenu', (event) => {
        event.preventDefault();
    });

    document.addEventListener('copy', event => event.preventDefault());
    document.addEventListener('cut', event => event.preventDefault());
    document.addEventListener('paste', event => event.preventDefault());

    document.addEventListener('keydown', (event) => {
        // Mengecek apakah tombol Ctrl atau Cmd (Mac) ditekan
        if (event.ctrlKey || event.metaKey) {
            // Memblokir tombol C (copy) dan X (cut)
            if (event.key === 'c' || event.key === 'x') {
                event.preventDefault();
            }            
        }        
        // Mencegah CTRL+S (Simpan Halaman)
        if (event.ctrlKey && event.key === 's') {
            e.preventDefault();
        }
        // Mencegah CTRL+U (Lihat Sumber Halaman)
        if (event.ctrlKey && event.key === 'u') {
            event.preventDefault();
        }
        // Mencegah F12 (Buka Developer Tools)
        // if (event.key === 'F12') {
        //     event.preventDefault();
        // }
    });

    document.addEventListener('keyup', function(e) {
        if (e.key === 'PrintScreen') {
            // Mencegah tindakan default
            e.preventDefault();
            alert('Screenshot tidak diizinkan');
            return false;
        }
    });
    //==================== [END] NON-AKTIF-KAN FUNGSI COPY PASTE DLL. =====================
   
    var username = '<?php echo $username ;?>'
    var status_user = '<?php echo $status_user ;?>'
    var bank_soal_id = '<?php echo $bank_soal_id ;?>'
    var jam_mulai = ''
    var jam_selesai = ''
    var status_load_soal = false
    var waktu_mengerjakan = ''
    var kelas = ''
    var semester = ''
    var mapel_cls = ''
  
    async function init_form() {
        await fetch_data_adm()
        await get_waktu_pengerjaan()
        //load_data_soal()
    }

    async function get_waktu_pengerjaan() {        
        var waktu_pg = 0
        var waktu_uraian = 0        
        var rs_waktu = await get_waktu_mengerjakan(bank_soal_id)
        if(rs_waktu.length>0){                   
            waktu_pg = rs_waktu[0].soal_pg            
            waktu_uraian = rs_waktu[0].soal_uraian                       
        }       

        var jml_soal_pg = 0
        var jml_soal_uraian = 0
        var rs_soal = await get_bobot_nilai_jml_soal()
        if(rs_soal.length>0){           
            jml_soal_pg = rs_soal[0].jml_soal_pg
            jml_soal_uraian = rs_soal[0].jml_soal_uraian
        }       

        var waktu_pengerjaan_pg = waktu_pg * jml_soal_pg
        var waktu_pengerjaan_uraian = waktu_uraian * jml_soal_uraian       
        waktu_mengerjakan = waktu_pengerjaan_pg + waktu_pengerjaan_uraian       
        document.getElementById("span_waktu_pengerjaan").innerHTML = waktu_mengerjakan
    }
    
    async function get_waktu_mengerjakan() {        
        // var rs_waktu = await fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan') ;?>',{method:"GET", mode:"no-cors"})        
        
        var rs_waktu = await fetch('<?php echo site_url('ujian/master/get_data_waktu_pengerjaan_with_mapel') ;?>?mapel='+mapel_cls
                                                                                                            +'&kelas='+kelas
                                                                                                            +'&semester='+semester+''
                                                                                                            ,{method:"GET", mode:"no-cors"})
        var dataResult = await rs_waktu.json()
        var data = dataResult.data
        return data;        
    }

    async function get_bobot_nilai_jml_soal() {                     
        //var rs_jml_soal = await fetch('<?php echo site_url('ujian/master/get_tbl_bobot_nilai') ; ?>?list_kelas='+kelas+'&list_semester='+semester+'')
        var rs_jml_soal = await fetch('<?php echo site_url('ujian/master/get_bobot_nilai') ; ?>?list_kelas='+kelas
                                                                                            +'&list_semester='+semester
                                                                                            +'&list_mapel='+mapel_cls+'')
        var dataResult = await rs_jml_soal.json()
        var data = dataResult.data
        return data;
    }

    async function fetch_data_adm() {
        await fetch('<?php echo base_url()."index.php/ujian/jawab_soal/get_data_adm" ;?>?bank_soal_id='+bank_soal_id
                                                                                  +'&status_user='+status_user
                                                                                  +'&username='+username+'')
        .then(response => response.json())
        .then( async (resultData) => {
            var data = resultData.data    
            var nama = resultData.nama
           
            if(data.length> 0){

                kelas = await data[0]['kelas_cls']
                semester = await data[0]['semester']
                mapel_cls = await data[0]['matapel_cls']

                document.getElementById('jenis_penilaian').innerHTML = data[0]['deskripsi_penilaian']                  
                document.getElementById('deskripsi_thnajaran').innerHTML = 'TAHUN PELAJARAN ' + data[0]['deskripsi_thnajaran']       
                
                var html = '';
                html += '<div class="col" style="margin:0.5px;">';
                html += '   <table class="table mx-auto text-warning text-shadow-black" style="font-size:18px" >';
                html += '       <tr class="borderless-bottom" >';
                html += '           <td class="py-0" >Mata Pelajaran</td>';
                html += '           <td class="py-0" >: '+data[0]['deskripsi']+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0"  >Kelas / Semester</td>';
                html += '           <td class="py-0" >: '+data[0]['kelas_cls']+' / '+data[0]['semester']+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0"  >Guru Kelas</td>';
                html += '           <td class="py-0" >: '+data[0]['nama_guru']+'</td>';              
                html += '       </tr>';
                html += '   </table>';
                html += '</div>';
                html += '<div class="col " style="margin:0.5px;">';
                html += '   <table class="table mx-auto text-warning text-shadow-black" style="font-size:18px">';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0 text-nowrap">Nama Siswa</td>';
                html += '           <td class="py-0 text-nowrap">: '+nama+'</td>';              
                html += '       </tr>';
                html += '       <tr class="borderless-bottom">';
                html += '           <td class="py-0 text-nowrap">Waktu Pengerjaan</td>';
                html += '           <td class="py-0 text-nowrap">: <span id="span_waktu_pengerjaan"></span> menit</td>';              
                html += '       </tr>';
                html += '   </table>';
                html += '</div>';
                
                document.getElementById('data_soal').innerHTML = html;
                var jam_mulai_temp = new Date(data[0]['jam_mulai'])
                var jam_selesai_temp = new Date(data[0]['jam_selesai'])
                jam_mulai = jam_mulai_temp.toLocaleTimeString('id-ID', formatter)               
                jam_selesai = jam_selesai_temp.toLocaleTimeString('id-ID', formatter)
                document.getElementById('jam_mulai').innerHTML = jam_mulai
                document.getElementById('jam_selesai').innerHTML = jam_selesai
            }
        })
    }
   

    //SERVER TIME
    // let offsetMillis = 0; // Offset dalam milidetik
    // const options = { 
    //             hour: '2-digit', 
    //             minute: '2-digit', 
    //             second: '2-digit', 
    //             hour12: false // Format 24 jam
    //         };

    // document.addEventListener('DOMContentLoaded', function() {
    //     const serverTimeDisplay = document.getElementById('serverTimeDisplay');
    //     // const localTimerDisplay = document.getElementById('localTimer');

    //     // Pastikan serverTimestamp sudah didefinisikan dari PHP
    //     if (typeof serverTimestamp !== 'undefined') {
    //         const localCurrentTime = new Date().getTime(); // Waktu lokal saat ini (saat JS dieksekusi)
    //         offsetMillis = serverTimestamp - localCurrentTime; // Selisih server - lokal

    //         console.log("Server Timestamp (ms):", serverTimestamp);
    //         console.log("Local Current Time (ms):", localCurrentTime);
    //         console.log("Offset (ms):", offsetMillis);
    //     } else {
    //         console.warn("serverTimestamp tidak ditemukan. Timer akan menggunakan jam lokal.");
    //     }

    //     // Fungsi untuk memperbarui timer
    //     function updateTimer() {
    //         const now = new Date(); // Objek Date lokal
            
    //         // Sesuaikan waktu lokal dengan offset server
    //         const serverAdjustedTime = new Date(now.getTime() + offsetMillis);

    //         // Tampilkan waktu server yang sudah disesuaikan
            
    //         serverTimeDisplay.textContent = serverAdjustedTime.toLocaleTimeString('id-ID', options);
    //         // localTimerDisplay.textContent = serverAdjustedTime.toLocaleTimeString('id-ID', options);   
            
    //         var jam_current = serverAdjustedTime.toLocaleTimeString('id-ID', options);
          
    //         if (jam_current==jam_mulai){
    //             mulai_mengerjakan()
    //         }

    //         if (jam_current==jam_selesai){
    //             selesai_mengerjakan()
    //         }


    //         if(jam_current >=jam_mulai && jam_current <=jam_selesai && status_load_soal==false){
    //             status_load_soal=true
    //             fetch_daftar_soal_pg()
    //             fetch_daftar_soal_essai()
    //             fetch_jumlah_jawab_soal()
    //         }

    //         $('#jam_current').val(jam_current)
            
    //     }

        
        // Perbarui timer setiap detik
        // setInterval(updateTimer, 1000);

        // // Panggil sekali saat start agar langsung terlihat
        // updateTimer();        
    
    //});

    function mulai_mengerjakan() {
        $('.clock-container').css('display','none')
        $('#modal_jawab_soal').modal('show')
        const taskContainers = document.querySelector('.task-container');
        const svgPath = taskContainers.querySelector('svg path');
        // Penting: Dapatkan panjang total garis SVG secara dinamis
        const pathLength = svgPath.getTotalLength();

        // Set properti stroke-dasharray dan stroke-dashoffset awal
        // Ini menyembunyikan garis centang pada awalnya
        svgPath.style.strokeDasharray = pathLength;
        svgPath.style.strokeDashoffset = pathLength;

        taskContainers.classList.toggle('completed')

        svgPath.style.strokeDashoffset = 0; // Menggambar garis
        // // Untuk me-restart animasi kilauan jika ada
        // const checkboxWrapper = taskContainers.querySelector('.checkbox-wrapper');
        // checkboxWrapper.classList.remove('play-shine'); // Hapus kelas pemicu
        // // void checkboxWrapper.offsetWidth; // Force reflow
        // checkboxWrapper.classList.add('play-shine'); // Tambahkan kembali    
    }

    $(document).on('click', '#btn_mulai', function () {
        $('.clock-container').css('display','none')   
        $('#modal_jawab_soal').modal('hide')
    }) 

    $(document).on('click', '#btn_keluar', function () {
        window.location.href="<?php echo site_url('dashboard/show_dashboard_ujian') ;?>";
    })

    function selesai_mengerjakan() {
        $('.task-container').css('display','none')        
        $('#modal_jawab_soal').modal('show')
    } 

    // $(document).on('click', '#show_modal', function () {
    //     $('.task-container').css('display','none')        
    //     $('#modal_jawab_soal').modal('show')
    // })

    
    function fetch_jumlah_jawab_soal() {
        fetch('<?php echo site_url('ujian/jawab_soal/get_jumlah_jawab_soal') ;?>?bank_soal_id='+bank_soal_id+'&username='+username+'')
        .then(response => response.json())
        .then(resultData => {            
            $('#jml_jawab_soal').text(resultData.data[0].jml_jawaban + ' / ' + resultData.data[0].jml_soal) 
        })
    }

    function cache_soal_pg_tojson(data){
        const payload = {          
            data: data // 'data' (objek JSON) akan dikirim langsung
        };

        fetch("<?php echo site_url('ujian/jawab_soal/cache_soal_pg_tojson'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(resultData => {
            console.log(resultData);
        })
        //.catch(err => console.error("Error:", err));
    }
    
    function cache_jawab_pg_tojson(data){
        const payload = {  
            nis: username,
            matapel_cls: mapel_cls,
            data: data // 'data' (objek JSON) akan dikirim langsung
        };

        fetch("<?php echo site_url('ujian/jawab_soal/cache_jawab_pg_tojson'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(resultData => {
            console.log(resultData);
            return resultData
        })
        //.catch(err => console.error("Error:", err));
    }

    //step 1
    async function get_soal_pg_json(){  
        var rs_soal_pg_json = await fetch('<?php echo site_url('ujian/jawab_soal/get_soal_pg_json') ; ?>?matapel='+mapel_cls+'&kelas='+kelas+'&nis='+username+'')   
        var rs = await rs_soal_pg_json.json() 
        if(rs.status==true){
            load_tbl_jawab_ujian(rs.data)// jika file json belum ada ambil data dari db dan simpan dijson
        }else(
            await get_data_soal_pg_db()            
        )
    }

    async function load_tbl_jawab_ujian(data) {
        if(data.length> 0){              
            var no=0
            var jenis_soal =''    
            var html = ''  
            html += '<table class="table table-sm table-sticky" id="tbl_input_soal">';
            html += '<tbody >';              
            html += '   <tr class="borderless-bottom">';
            html += '       <td width="50pt"><h5 class="text-primary"><b>I</b></h5></td>';
            html += '       <td colspan="3" style="min-width:30pt" class="text-nowrap"><h5 class="text-primary"><b>PILIHLAH JAWABAN YANG PALING BENAR ! </b></h5></td>';                    
            html += '   </tr>';      
            for(var count = 0; count < data.length; count++) { 
                no++
                html += '<tr id="'+ no +'" class="borderless-bottom">';                
                if(data[count]['jawaban']!='' && data[count]['jawaban']!=null){                       
                    html += '   <td class="py-0" width="50pt">'+no+'&nbsp;<i class="bi bi-circle-fill" style="color: green;"></i></td>';
                }else{
                    html += '   <td class="py-0" width="50pt">'+no+'</td>';
                }                    
                html += '   <td class="py-0" colspan="3" style="min-width:30pt" class="text-nowrap"><div class="ck-content">'+data[count].pertanyaan+'</div></td>';                    
                html += '</tr>';
                    
                if (data[count].img_path!=null && data[count].img_path!=''){
                    var image_path = "<?php echo base_url() ?>" + data[count].img_path + '?'+ new Date().getTime() ;                        
                    html += '<tr id="'+ no +'" class="borderless-bottom">';
                    html += '   <td class="py-0"></td>';   
                    html += '   <td class="py-0" colspan="3" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width"></td>';                                                             
                    html += '</tr>';
                }
                
                html += '<tr id="'+ no +'" class="borderless-bottom">';   
                html += '   <td class="py-0"></td>';      
                if(data[count]['jawaban']=='a'){
                    html += '   <td class="py-0" width="25pt"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_a" value="a" checked></td>'; 
                }else{
                    html += '   <td class="py-0" width="25pt"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_a" value="a"></td>'; 
                }                     
                html += '   <td class="py-0" width="45pt"><label class="lbl_chk" for="'+data[count]['id']+'_chk_a">a</label></td>';  
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_a"><div class="ck-content">'+data[count].jawaban_a+'</div></label></td>';
                html += '</tr>';

                html += '<tr id="'+ no +'" class="borderless-bottom">';   
                html += '   <td class="py-0"></td>';       
                if(data[count]['jawaban']=='b'){
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_b" value="b" checked></td>'; 
                }else{
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_b" value="b"></td>'; 
                }                    
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_b">b</label></td>';  
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_b"><div class="ck-content">'+data[count].jawaban_b+'</div></label></td>';
                html += '</tr>';

                html += '<tr id="'+ no +'" class="borderless-bottom">';   
                html += '   <td class="py-0"></td>';    
                if(data[count]['jawaban']=='c'){
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_c" value="c" checked></td>'; 
                }else{
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_c" value="c"></td>'; 
                }                       
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_c">c</label></td>';  
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_c"><div class="ck-content">'+data[count].jawaban_c+'</div></label></td>';
                html += '</tr>';

                html += '<tr id="'+ no +'" class="borderless-bottom">';   
                html += '   <td class="py-0"></td>';       
                if(data[count]['jawaban']=='d'){
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_d" value="d" checked></td>'; 
                }else{
                    html += '   <td class="py-0"><input class="chk_jawaban form-check-input" type="checkbox" name="chk_jawaban_'+data[count]['id']+'" data-id="'+data[count]['id']+'" id="'+data[count]['id']+'_chk_d" value="d"></td>'; 
                }                    
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_d">d</label></td>';  
                html += '   <td class="py-0"><label class="lbl_chk" for="'+data[count]['id']+'_chk_d"><div class="ck-content">'+data[count].jawaban_d+'</div></label></td>';
                html += '</tr>';
            }      

            html += '</tbody>';
            html += '</table>';       

            document.getElementById('tbl_jawab_soal_pg_div').innerHTML = html 
            MathJax.typesetPromise();
        }    
    }

    // async function fetch_daftar_soal_pg_db() {       
    //     var rs_list_soal = await fetch('<?php echo site_url('ujian/jawab_soal/get_data_soal_pg_db') ; ?>?bank_soal_id='+bank_soal_id+'')
    //     var rs_soal = await rs_list_soal.json()
    //     var data_soal = rs_soal.data        
        
    //     var matapel = data_soal[0]['matapel_cls']
    //     var kelas = data_soal[0]['kelas_cls']      
    //     await cache_soal_pg_tojson(data_soal)
        
    //     load_tbl_jawab_ujian(data)
    // }

    async function get_data_soal_pg_db() {
        var rs_list_soal = await fetch('<?php echo site_url('ujian/jawab_soal/get_data_soal_pg_db') ; ?>?bank_soal_id='+bank_soal_id+'')
        var rs_soal = await rs_list_soal.json()
        var data_soal = rs_soal.data  

        var matapel = data_soal[0]['matapel_cls']
        var kelas = data_soal[0]['kelas_cls']      
        await cache_soal_pg_tojson(data_soal)

        await get_data_jawaban_pg_db()
        
    }

    async function get_data_jawaban_pg_db() {
        var rs_list_jawab = await fetch('<?php echo site_url('ujian/jawab_soal/get_data_jawab_pg_db') ; ?>?bank_soal_id='+bank_soal_id+'&nis='+username+'')
        var rs_jawab = await rs_list_jawab.json()
        var data_jawab = rs_jawab.data 
        await cache_jawab_pg_tojson(data_jawab)               
    }

    function fetch_daftar_soal_essai() {
        fetch('<?php echo site_url('ujian/jawab_soal/get_data_soal_essai') ;?>?bank_soal_id='+bank_soal_id+'&username='+username+'')
        .then(response => response.json())
        .then(resultData => {
            var data  = resultData.data            
            if(data.length> 0){                
                var no=0
                var jenis_soal =''    
                var html = ''  
                html += '<table class="table table-sm table-sticky" id="tbl_input_soal">';
                html += '<tbody >';              
                html += '   <tr class="borderless-bottom">';
                html += '       <td class="py-0" width="50pt" style="font-size:20px"><b class="text-primary">II</b></td>';
                html += '       <td colspan="3" class="py-0" style="min-width:30pt; font-size:20px" class="text-nowrap "><b class="text-primary">JAWABLAH DENGAN BENAR !</b></td>';                    
                html += '   </tr>';      
                html += '   <tr class="borderless-bottom">';
                html += '       <td class="pt-0 pb-2" width="50pt"></td>';
                html += '       <td colspan="3" style="min-width:30pt" class="pt-0  pb-2 text-nowrap text-primary"><i>Klik tombol Simpan untuk menyimpan jawaban</i></td>';                    
                html += '   </tr>';      
                for(var count = 0; count < data.length; count++) {    
                    no++
                    html += '<tr id="'+ no +'" class="borderless-bottom">';
                    if(data[count]['jawaban']!=''){
                        html += '   <td class="py-0" width="50pt">'+no+'&nbsp;<i class="bi bi-circle-fill" style="color: green;"></i></td>';
                    }else{
                        html += '   <td class="py-0" width="50pt">'+no+'</td>';
                    }
                    html += '   <td class="py-0" colspan="3" style="min-width:30pt" class="text-nowrap"><div class="ck-content">'+data[count].pertanyaan+'</div></td>';                    
                    html += '</tr>';
                        
                    if (data[count].img_path!=null && data[count].img_path!=''){
                        var image_path = "<?php echo base_url() ?>" + data[count].img_path + '?'+ new Date().getTime() ;                        
                        html += '<tr id="'+ no +'" class="borderless-bottom">';
                        html += '   <td class="py-0"></td>';                                                   
                        html += '   <td class="py-0" style="min-width:30pt" class="text-nowrap"><img src='+image_path+' class="img-width" style="float:left;"></td>';                                     
                        html += '</tr>';
                    }

                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td class="py-0"></td>';
                    html += '   <td colspan="3" class="py-0"><label for="'+data[count]['id']+'">jawaban :</label></td>';                    
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom">';   
                    html += '   <td></td>';                    
                    html += '   <td colspan="3"><textarea class="essai_jawaban form-control" type="text" name="essai_jawaban_'+data[count]['id']+'" id="jawaban_'+data[count]['id']+'" rows="3">'+data[count]['jawaban']+'</textarea></td>';                                                                                    
                    html += '</tr>';
                    html += '<tr id="'+ no +'" class="borderless-bottom" style="border-bottom: 10px solid transparent;">';   
                    html += '   <td></td>';                    
                    html += '   <td><button type="button" class="btn btn-sm btn-primary btn_simpan" id="'+data[count]['id']+'">Simpan</button></td>';                                                                                    
                    html += '</tr>';
                }
                html += '</tbody>';
                html += '</table>';    

                document.getElementById('tbl_jawab_soal_essai_div').innerHTML = html 
                MathJax.typesetPromise();
            }
        })
    }

    $(document).on('click', '.btn_simpan', async function () {   
        
        await checkConnection();

        var soal_id = $(this).attr('id')
        var jawaban = $('#jawaban_'+soal_id).val()
        if(jawaban==''){
            alert('Silahkan isi jawaban')
            $('#jawaban_'+soal_id).focus()
            $('#jawaban_'+soal_id).css('border-color', 'red')
            return false
        }else{
            $('#jawaban_'+soal_id).css('border-color', '')
        }

        await simpan_jawaban_essai(soal_id, jawaban)
    })

    async function simpan_jawaban_essai(soal_id, jawaban) {
        var form_data = new FormData();
        form_data.append('bank_soal_id', bank_soal_id)
        form_data.append('soal_id', soal_id)
        form_data.append('nis', username)
        form_data.append('jawaban', jawaban)

        await fetch('<?php echo site_url('ujian/jawab_soal/simpan_jawaban_essai') ;?>',{
            method:"POST",
            body: new URLSearchParams(form_data)
        })
        .then(response => response.json())
        .then( async resultData =>{
            if(resultData.status==true){
                await fetch_daftar_soal_essai()
                await fetch_jumlah_jawab_soal()
            }
        })
        
    }
    

    $(document).on('click','.chk_jawaban', async function () {        
        var soal_id =  $(this).attr('data-id')
        var jawaban_id = $(this).attr('id')       
        var jawaban = $(this).attr('value')
        var status_check = $(this).is(':checked')

        await checkConnection();
                              
        //unchecked selain id yang dipilih
        const el = document.querySelectorAll('input[name="chk_jawaban_'+soal_id+'"]')
        for (let i = 0; i < el.length; i++) {
           var chk_id = el[i].id
           if(jawaban_id!=chk_id){           
                el[i].checked=false;
           }
        }
     
        var el_jawab = $('#'+jawaban_id)
        //alert(el_jawab.is(':checked'))
        
        if(el_jawab.is(':checked')==false){
            jawaban = ''            
            //await simpan_jawaban_pg(soal_id, jawaban)   
            //await simpan_jawaban_pg_kejson(soal_id, jawaban) 
            await hapus_jawaban_pg_json(soal_id, jawaban)
        }else{            
            //await simpan_jawaban_pg(soal_id, jawaban)
            await simpan_jawaban_pg_kejson(soal_id, jawaban) 
        }             
    })

    function hapus_jawaban_pg_json(soal_id, jawaban) {
        const payload = {
            kelas: kelas,
            mapel: mapel_cls,
            bank_soal_id: bank_soal_id,
            soal_id: soal_id,
            nis: username,
            jawaban: jawaban            
        };

        fetch("<?php echo site_url('ujian/jawab_soal/hapus_jawaban_pg_json'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(resultData => {
            //get_soal_pg_json()
        })
    }

    function simpan_jawaban_pg(soal_id, jawaban) {        
        const form_data = new FormData();
        form_data.append('bank_soal_id', bank_soal_id)
        form_data.append('soal_id', soal_id)
        form_data.append('nis', username)
        form_data.append('jawaban', jawaban)

        fetch('<?php echo base_url('index.php/ujian/jawab_soal/simpan_jawaban_pg') ;?>',                                                                                
                                                                                    {   method:"POST",
                                                                                        body: new URLSearchParams(form_data)
                                                                                    })
        .then(response => response.json())
        .then(resultData => {                     
            if(resultData.status==true){
                fetch_daftar_soal_pg()
                fetch_jumlah_jawab_soal()
            }else{
                alert(resultData.meesage)
            }
        })
    }

    function simpan_jawaban_pg_kejson(soal_id, jawaban) {       
        const payload = {
            kelas: kelas,
            mapel: mapel_cls,
            bank_soal_id: bank_soal_id,
            soal_id: soal_id,
            nis: username,
            jawaban: jawaban            
        };

        fetch("<?php echo site_url('ujian/jawab_soal/simpan_jawaban_pg_kejson'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(resultData => {
            console.log(resultData);
        })
        //.catch(err => console.error("Error:", err));
    }

    
    
</script>


<style>
    .gradient-over-image {
        width: 100%;
        height: 260px;
        margin: 0px auto;
        padding-top: 80px;
        color: white; /* Biar tulisan kelihatan */
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);

        /* --- Lapisan Background --- */
        background-image:
            /* 1. Lapisan Gradien (harus transparan agar pola di bawahnya terlihat) */            
            linear-gradient(to right, rgba(189, 97, 81, 0.7), rgba(175, 33, 23, 0.7)), /* Pink ke Biru Langit, dengan transparansi 70% */
            /* 2. Lapisan Pola Gambar (ini di bawah gradien) */
            url('https://www.transparenttextures.com/patterns/brick-wall-dark.png'); /* Contoh URL pola, ganti dengan milikmu */

        background-size:
            auto,          /* Gradien akan mengisi penuh area */
            100px 100px;   /* Ukuran satu unit pola gambar (sesuaikan) */

        background-repeat:
            no-repeat,     /* Gradien tidak perlu diulang */
            repeat;        /* Pola gambar akan diulang */

        /* Opsional: Mode pencampuran warna antar lapisan */
        background-blend-mode: overlay; /* Coba juga 'multiply' atau 'screen' */
    }

    .text-shadow-black {
        /* font-size: 20px; */
        /* font-weight: bold; */            
        /* text-shadow: offset-x offset-y blur-radius color; */
        text-shadow: 0 0 5px black; /* Blue glow */
                        /*0 0 20px #00f;*/ /* Tambahan glow untuk efek lebih intens */
    }

    .table th, .table td {
        text-align: left;
    }

    body {
        font-family: 'Roboto', sans-serif; /* Terapkan font Roboto */
    }

    .lbl_chk,
    .chk_jawaban{
        cursor: pointer;
    }

    .fix-pos-table{
        position: sticky; /* Membuat elemen tetap */
        top : 80px;
    }
    
    td, th {
        padding-top: 0px;   /* Kurangi jarak di atas konten sel */
        padding-bottom: 0px;  /* Kurangi jarak di bawah konten sel */
        /* Atau bisa juga padding: 2px 0; untuk padding vertikal 2px dan horizontal 0 */
    }

    .ck-content p {
        margin-top: 0;
        margin-bottom: 10px;
        /* Atau bisa juga: */
        /* margin: 0; */
    }

    .img-width {
        width: 200pt;
        height: 200ptt;
        border-radius: 10px;
        box-shadow: 1px 2px 5px #000000;   
        margin-bottom: 10px;
    }


    /**************** [START] CSS CENTANG **************/
    .task-container.completed .checkbox-wrapper svg {
        transform: scale(1); /* Tampilkan SVG centang */
    }
        
    .checkbox-wrapper {
        width: 45px; /* Ukuran kotak checkbox */
        height: 45px;
        border: 3px solid #6c757d;
        border-radius: 50%; /* Bentuk lingkaran */
        margin-right: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        background-color: #fff;
        transition: all 0.3s ease;
        position: relative; /* Untuk posisi pseudo-element jika ada */
    }

    .checkbox-wrapper svg {
        width: 35px; /* Ukuran ikon centang di dalam kotak */
        height: 35px;
        stroke: #28a745; /* Warna hijau untuk centang */
        stroke-width: 4; /* Ketebalan garis centang */
        fill: none; /* Penting: agar hanya garis yang terlihat, bukan area yang terisi */
        stroke-linecap: round; /* Ujung garis membulat */
        stroke-linejoin: round; /* Sudut garis membulat */
        transform: scale(0); /* Awalnya sembunyikan SVG */
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Animasi skala */
    }
    
    /* Styling untuk path centang */
    .checkbox-wrapper svg path {
        /* Nilai ini akan dihitung oleh JavaScript untuk memastikan animasi yang sempurna */
        stroke-dasharray: 1000;
        stroke-dashoffset: 1000;
        transition: stroke-dashoffset 0.6s cubic-bezier(0.76, 0.0, 0.24, 1.0); /* Animasi menggambar garis */
    }
    /* Status Selesai */
    .task-container.completed .checkbox-wrapper {
        border-color: #28a745; /* Border berubah menjadi hijau */
        background-color: #e9f5ed; /* Latar belakang kotak centang */
    }

    .task-container.completed .checkbox-wrapper svg path {
        stroke-dashoffset: 0; /* Animasikan garis centang agar terlihat */
    }
    /* Animasi kilauan (opsional) */
    .task-container.completed .checkbox-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(40, 167, 69, 0.5) 0%, rgba(40, 167, 69, 0) 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulse-shine 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes pulse-shine {
        0% {
            width: 0;
            height: 0;
            opacity: 0.8;
        }
        50% {
            width: 60px;
            height: 60px;
            opacity: 0.4;
        }
        100% {
            width: 100px;
            height: 100px;
            opacity: 0;
        }
    }
    /* [END] CSS CENTANG */


    /* [START] CSS CLOCK */    
        .clock-icon {
            width: 45%; /* Agar SVG mengisi kontainer */
            height: 45%;
            color: red;
            /* Terapkan animasi getar ke seluruh SVG */
            animation: vibrate 0.1s infinite alternate; /* Animasi sangat cepat dan berulang */
        }

        /* --- Keyframes untuk Animasi Getar --- */
        @keyframes vibrate {
            0% {
                transform: translate(0px, 0px) rotate(0deg);
            }
            25% {
                transform: translate(-1px, 1px) rotate(-0.5deg);
            }
            50% {
                transform: translate(1px, -1px) rotate(0.5deg);
            }
            75% {
                transform: translate(-1px, -1px) rotate(-0.25deg);
            }
            100% {
                transform: translate(0px, 0px) rotate(0deg);
            }
        }

        /* Tambahan: Animasi Jarum Jam (opsional, untuk jam bergerak) */
        .hour-hand {
            transform-origin: 50px 50px; /* Titik putar jarum jam */
            animation: rotateHour 4s linear infinite; /* Contoh rotasi, sesuaikan durasi untuk real time */
        }
        .minute-hand {
            transform-origin: 50px 50px; /* Titik putar jarum menit */
            animation: rotateMinute 2s linear infinite; /* Contoh rotasi, sesuaikan durasi untuk real time */
        }

        @keyframes rotateHour {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes rotateMinute {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    /* [END] CSS CLOCK */


</style>