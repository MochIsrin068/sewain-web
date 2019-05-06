

<!-- Full Width Column -->
<div class="content-wrapper " >
    <div class="container">
      <!-- Content Header (Page header) -->
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
                          $_genres =  $this->m_genre->genres( $item->id )->result();
                          foreach( $_genres as $genre ):
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
        <div class="col-md-3">
          <!-- search -->
          <div class="box">
            <div class="box-header">
              <div class="">
                <form action="" method="get">
                  <div class="box-tools ">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" name="search" placeholder="Judul Buku">
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div>
                  <?php echo form_close();?>
              </div>
            </div>
          </div>
          <!-- search -->
          <!-- filter -->
          <div class="box">
            <div class="box-header">
                <h5>Genre</h5>
            </div>
            <div class="box-body">
              <?php echo form_open();?>
              <div class="row"> 
                <?php 
                  function set_checked( array $data_id, $target_id  )
                  {
                    foreach( $data_id as $id ){
                      if($target_id ==  $id ) return "checked";
                    }
                    return "";
                  }

                  foreach( $genres as $i=>$genre ):
                ?>  
                <div class="col-md-6">
                    <input type="checkbox" name="genre_ids[]" value="<?php echo $genre->id ?>" <?php echo set_checked(  $genre_ids, $genre->id  ) ?> id="basic_checkbox_<?php echo $i ?>">
                    <label for="basic_checkbox_<?php echo $i ?>"><?php echo $genre->name ?> </label>
                </div>
                <?php 
                    endforeach;
                ?>
              </div>
              <button class="btn btn-primary btn-block" type="submit">
                  Filter
              </button>
              <?php echo form_close(); ?>
            </div>
          </div>
          <!-- filter -->
        </div>
      </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
</div>

 