<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script> 

    <title>Document</title>
    
</head>
<body>
     <body onload="init_form()"></body>

    <div class="container-fluid bg-login" id="bg_image">
        <div class="word-art animated-word">Selamat Datang! <br> Di Halaman Siswa</div>
    </div>
   
    
</body>
</html>

<script type="text/javascript">
    function init_form() {
         
        const lebar = window.innerWidth;
        const tinggi = window.innerHeight;
        //const body = document.getElementsByClassName("bg-login");
      
        
        if (lebar < 768) {  // Misalnya, di bawah 768px dianggap ponsel
            // return "Ponsel: " + lebar + "px x " + tinggi + "px";           
            $('#bg_image').addClass("bg-image-style-hp")
            
        } else {             
            //return "Laptop/Desktop: " + lebar + "px x " + tinggi + "px";
            $('#bg_image').addClass("bg-image-style-komp")
        
        }

        <?php simpan_kunjungan(); ?>    
    }
</script>

<style>
        .bg-image-style-hp{
            background: url(<?php echo base_url("images/images_ui/bg_halaman_siswa.jpg");?>) no-repeat; 
            width: 100%; height: 100vh;
            background-size: 260%;         
        }

        .bg-image-style-komp{
            background: url(<?php echo base_url("images/images_ui/bg_halaman_siswa.jpg");?>) no-repeat; 
            width: 100%; height: 100vh;
            background-size: 100%;         
        }

        .word-art {
            font-family: 'Pacifico', cursive; /* Menggunakan font Pacifico, ganti sesuai keinginan */
            font-size: 48px;              /* Ukuran font */
            color: #f1c40f;             /* Warna teks (kuning) */
            text-shadow: 2px 2px 4px #34495e;  /* Efek bayangan teks (abu-abu gelap) */
            text-align: center;           /* Pusatkan teks */
            /*margin-top: 50px;*/             /* Jarak dari atas */            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }

        .animated-word {
            animation: rainbow 5s infinite; /* Animasi pelangi dengan durasi 5 detik dan berulang terus */
        }

        @keyframes rainbow {
            0% { color: #ff0000; } /* Merah */
            16.66% { color: #ff7f00; } /* Oranye */
            33.33% { color: #ffff00; } /* Kuning */
            50% { color: #00ff00; } /* Hijau */
            66.66% { color: #0000ff; } /* Biru */
            83.33% { color: #4b0082; } /* Nila */
            100% { color: #ee82ee; } /* Ungu */
        }

        .glowing-word {
             animation: glow 2s ease-in-out infinite alternate;
        }
        @keyframes glow {
            from { text-shadow: 0 0 8px rgba(255, 255, 255, 0.8); }
            to   { text-shadow: 0 0 20px rgba(255, 255, 255, 0.2); }
        }

    </style>