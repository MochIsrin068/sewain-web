<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_title ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row"> 
    <div class="col-md-9">
      <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="row"> 
            <!-- card -->
            <?php 
            $styles=array();
            $colors = array( 'success', 'danger', 'info', 'warning', 'primary' );
            $genre_styles =  $this->m_genre->genres(  )->result();
            foreach( $genre_styles as $i=>$style )
            {
              $styles[ $style->id ] = $colors[ $i % count( $colors ) ];
            }
            foreach( $books as $item ):
            ?>
            <div class="col-md-4">
              <div class="box">
                <div class="box-header">
                  <?php
                      // $images = $file->kamar_foto;
                      $images = explode(";", $item->images );
                  ?>
                  <img class="img-responsive" src="<?php echo base_url().BOOK_PHOTO_PATH.$images[0] ?>" alt="Photo">
                </div>
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i> <?php echo $item->title?> </strong>

                  <p class="text-muted">
                      <?php echo substr(  $item->description, 0, 100 )?> 
                  </p>
                  <strong><i class="fa fa-pencil margin-r-5"></i> Genre</strong>
                  <p>
                    <?php 
                      $genres =  $this->m_genre->genres( $item->id )->result();
                      foreach( $genres as $genre ):
                    ?>  
                      <span class="label label-<?php echo $styles[ $genre->id ] ?>"><?php echo $genre->name?></span>
                    <?php 
                      endforeach;
                    ?>
                  </p>
                </div>
              </div>
            </div>
            <?php 
                endforeach;
            ?>
            <!-- card -->
          </div>
        </div>
      </div>
    </div>
  </div>
  </section>
<!-- /.content -->
</div>