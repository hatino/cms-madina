<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.0/ckeditor5-content.css" />
    <script src="<?php echo base_url()?>assets/js/jquery-3.2.1.min.js"></script>      
</head>
<body>
    <body onload="init_form()"></body>
    <br>
    
    <div class="container mt-5">   
        <div class="row">
            <div class="col-sm-1" style="width: 55px;"><a href="<?php echo base_url() .'index.php/dashboard'; ?>">Home</a></div>
            <div class="col-sm-1" style="width: 0px;">&#10095;</div>
            <div class="col-sm-1" style="width: 0px;"><a onclick="go_back()" href="#">Berita</a></div>  
        </div>              
        <div id="div_berita" align="center"></div>        
        <br>
        <br>       
    </div> 
    
</body>
</html>

<script type="text/javascript">
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    async function init_form() {           
        await fetch_data_berita_dtl()
    }

    function fetch_data_berita_dtl() {
        var berita_id = '<?php echo $berita_id;?>'  
        fetch('<?php echo site_url('berita/berita/get_data_berita_dtl') ;?>?berita_id='+berita_id+'')
        .then(function(response) {                   
			return response.json();    
		}).then(function (responseData){                        
            var data = responseData.data              
			if (data.length>0){  
                var html = '';   
                var path_img = '';
                var tgl, tgl_kegiatan;               
                
                for (let i = 0; i < data.length; i++) {
                    path_img = data[i].img_path;       
                    var the_date = new Date(data[i].register_date)      
                    var tgl_berita =  ('00' + the_date.getDate()).slice(-2) + " "                       
                                 +  months[the_date.getMonth()] + " "
                                 + the_date.getFullYear()                    
                    
                    html +='   <h3 class="text-header" style="text-align:left;">'+data[i].judul_berita+'</h3>';  //0  
                    html +='   <h6 style="text-align:left; color:grey;"><i>'+tgl_berita+'</i></h6>';  //0 
                    
                    //  GAMBAR UTAMA 
                    if (path_img!=''){
                        html +='   <img id="main_img" src='+path_img+'?'+ new Date().getTime()+' class="img-width img-content" style="width:100%;">'; 
                    }
                    
                    // [START] 3 GAMBAR DETAIL                      
                    html +='    <div class="card p-2 mb-3 mt-3">';
                    html +='        <div class="row g-2">';
                    if(path_img){
                    html +='            <div class="col-4">';
                    html +='                <img src="'+path_img+'?'+ new Date().getTime()+'" class="img-fluid rounded img-dtl-width"  '+
                                                'onclick="changeMainImg(this.src)" style="cursor:pointer;">';
                    html +='            </div>';
                    }
                    if(data[i].img_path_2){
                    html +='            <div class="col-4">';
                    html +='                <img src='+data[i].img_path_2+'?'+ new Date().getTime()+' class="img-fluid rounded img-dtl-width" '+
                                                'onclick="changeMainImg(this.src)" style="cursor:pointer;">';
                    html +='            </div>';
                    }
                    if(data[i].img_path_3){
                    html +='            <div class="col-4">';
                    html +='                <img src='+data[i].img_path_3+'?'+ new Date().getTime()+' class="img-fluid rounded img-dtl-width" '+
                                                'onclick="changeMainImg(this.src)" style="cursor:pointer;">';
                    html +='            </div>';
                    }                    
                    html +='        </div>';
                    html +='    </div>';
                    // [START] 3 GAMBAR DETAIL


                    html +='   <p class="ck-content">'+data[i].deskripsi_berita+'</p>';  //0   
                    html +='   <br>';                    
                }
         
                document.getElementById("div_berita").innerHTML = html                   
                                   
             }             
		});           
    }

    function changeMainImg(src) {        
        const mainImg = document.getElementById('main_img');       
        if (mainImg) {           
            mainImg.src = src;
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    }

    function go_back() {
        var page = '<?php echo $page;?>' 
        window.location.href="<?php echo base_url() .'index.php/berita/berita/show_berita'; ?>?page="+page+""
    }
</script>

<style>
     .img-content {
        border-radius: 25px;
        border: 1px solid #ddd;       
        padding: 5px;
        /* width: 400pt; */
        height: auto;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        margin-right: 20px
    }

    a {
        color:rgb(5, 105, 50);
        text-decoration: none;
    }

    a:hover {
        color:rgb(5, 105, 50);
    }

    .img-dtl-width {
        width: 185pt;
        height: 185ptt;
    }
</style>