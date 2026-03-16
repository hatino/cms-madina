<!--ul>
    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><?php echo anchor('thn_ajaran/show_mst_thnajaran','Tahun Ajaran');?></li>
                <li><?php echo anchor('kelas/show_kelas','Kelas');?></li>                
              </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kesiswaan <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><?php echo anchor('siswa/show_mst_siswa','Daftar Siswa') ?></li>
          <li><?php echo anchor('siswa/show_kelas_siswa','Kelas Siswa') ?></li>          
        </ul>
    </li>
</ul-->

<style type="text/css">

.carousel-item,
.carousel-inner,
.carousel-inner img {
  height: 100%;
  width: auto;
}

.carousel-item {
  text-align: center;
}

.carousel {
  height: 500px;
}

</style>

<br>

<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for carousel items -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img  class="d-block w-100"  src="<?php echo base_url() ?>img/carousel_0.jpg" alt="First Slide">            

            <div class="carousel-caption d-none d-md-block">
                <h5 class='text-success'>Tahfidz Information System</h5>
                <!--p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p-->
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?php echo base_url() ?>img/carousel_1.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5 class='text-success'>Tahfidz Information System</h5>
                <!--p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p-->
            </div>
        </div>

        <div class="carousel-item">
            <!--img src="images/slide2.png" alt="Second Slide"-->
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
            </div>
        </div>
        <div class="carousel-item">
            <!--img src="images/slide3.png" alt="Third Slide"-->
            <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
            </div>
        </div>
    </div>

    <!-- Carousel controls -->
    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<script src="<?php echo base_url()?>assets/cdnjs/jquery-3.1.1.min.js"></script> 
