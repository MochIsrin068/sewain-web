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

            <?php echo form_label( lang( $images["label"]));?>
            <?php echo form_input($images);?>

            <br>
            <?php echo form_submit($submit);?>

            <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
  </section>
<!-- /.content -->
</div>