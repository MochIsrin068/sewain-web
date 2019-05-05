<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_title ?>
  </h1>
</section>
<!-- alert  -->
<?php
    if($this->session->flashdata('alert')){
        echo $this->session->flashdata('alert');
    }
?>
<!-- alert  -->
<!-- Main content -->
<section class="content">

  <div class="row"> 
    <div class="col-md-9">
      <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
          <?php echo form_open_multipart();?>

            <?php 
              echo form_input($id);
            ?>

            <?php echo form_label( lang( $title["label"]));?>
            <?php echo form_input($title);?>

            <?php echo form_label( lang( $description["label"]));?>
            <?php echo form_textarea($description);?>

            <?php echo form_label( lang( $language["label"]));?>
            <?php echo form_input($language);?>

            <?php echo form_label( lang( $author["label"]));?>
            <?php echo form_input($author);?>

            <?php echo form_label( lang( $page_count["label"]));?>
            <?php echo form_input($page_count);?>

            <?php echo form_label( lang( $publisher["label"]));?>
            <?php echo form_input($publisher);?>

            <?php echo form_label( lang( $price["label"]));?>
            <?php echo form_input($price);?>

            <?php echo form_label( lang( $category_id["label"]));?>
            <?php echo form_dropdown($category_id);?>

            <?php echo ($genres);?>
            
            <br>
            <?php echo form_submit($submit);?>

            <?php echo form_close();?>
        </div>
      </div>
    </div>
    <!-- images -->
    <div class="col-md-3">
      <!-- card -->
      <?php 
      $_images = explode(";", $book->images );
      foreach( $_images as $i=>$image ):
      ?>
        <div class="box">
          <div class="box-header">
            <button class="btn btn-white btn-danger btn-sm" data-toggle="modal" data-target="#delete_image<?php echo  $i;?>">
                Hapus
            </button>
            <!-- Modal Delete-->
            <div class="modal fade" id="delete_image<?php echo  $i;?>" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <?php echo form_open("user/book/delete_image");?>
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">#Delete images</h4>
                    </div>
                    <div class="modal-body">
                    <div class="alert alert-danger">Are you sure want delete <b><?php echo $image?></b> ?</div>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" class="form-control" value="<?php echo  $i ?>" name="image_index" required="required">
                    <input type="hidden" class="form-control" value="<?php echo  $book->id ?>" name="id" required="required">
                    <button type="submit" class="btn btn-danger">Ya</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                </div>
            </div>
            <!--  -->
          </div>
          <div class="box-body">
            <img class="img-responsive" src="<?php echo base_url().BOOK_PHOTO_PATH.$image ?>" alt="Photo">
          </div>
        </div>
      <?php 
          endforeach;
      ?>
      <!-- card -->
      <div class="box">
        <div class="box-header">
          <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_image">
              Tambah Gambar
          </button>
          <!-- Modal -->
          <div class="modal fade" id="add_image"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <?php echo form_open_multipart("user/book/add_image");?>
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Ubah Foto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <?php echo form_label( lang( $images["label"]));?>
                    <?php echo form_input($images);?>
                  </div>
                  <div class="modal-footer">
                      <input type="hidden" class="form-control" value="<?php echo  $book->id ?>" name="id" required="required">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Upload</button>
                  </div>
                  </div>
              </div>
              <?php echo form_close(); ?>
          </div>
          <!-- Modal -->
        </div>
      </div>
    </div>
    <!-- images -->
  </div>
  </section>
<!-- /.content -->
</div>