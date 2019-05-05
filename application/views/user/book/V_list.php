<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_title ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
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
    <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo $page_title ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Buku</th>
                        <th>Kategori</th>
                        <th>Genre</th>
                        <th style="width:25%" >deskripsi</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    foreach( $books as $item ):
                    ?>
                    <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo  lang( "title")." : ". $item->title?><br>
                            <?php echo  lang( "author")." : ". $item->author?><br>
                            <?php echo  lang( "page_count")." : ". $item->page_count?><br>
                            <?php echo  lang( "publisher")." : ". $item->publisher?><br>
                            <?php echo  lang( "price")." : ". $item->price?><br>
                        </td>
                        <td>
                            <?php echo $item->category_name  ?>
                            <!-- <?php echo $this->m_category->category( $item->category_id )->row()->name  ?> -->
                        </td>
                        <td>
                            <?php 
                                $genres =  $this->m_genre->genres( $item->id )->result();
                                foreach( $genres as $genre )
                                {
                                    echo $genre->name.", ";
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $item->description?>
                        </td>
                        <td>
                            <!-- IMAGE -->
                            <?php
                                // $images = $file->kamar_foto;
                                $images = explode(";", $item->images );
                                foreach( $images as $i => $image ):
                            ?>
                                <a href="" data-toggle="modal" data-target="#image<?php echo  $item->id.$i  ;?>"><?php echo $image;?></a>
                                <br>
                                <div class="modal fade" id="image<?php echo  $item->id.$i  ;?>" role="dialog">
                                    <div class="modal-dialog">
                                    <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><b>#Image Preview</b></h4>
                                            </div>
                                            <div class="modal-body">
                                            <div class="box-body">
                                            <img src="<?php echo base_url().BOOK_PHOTO_PATH.$image  ?>" alt="" height="auto" width="500" >
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                endforeach;
                            ?>
                            <!-- IMAGE -->
                        </td>
                        <td>
                            <a href="<?php echo site_url('user/book/edit/').$item->id;?>" class=" btn btn-white  btn-sm btn-primary">Edit</a>
                            <button class="btn btn-white btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo $item->id?>">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    <!-- item -->
                        <!-- Modal Delete-->
                        <div class="modal fade" id="deleteModal<?php echo  $item->id;?>" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php echo form_open("user/book/delete");?>
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">#Delete item</h4>
                                </div>
                                <div class="modal-body">
                                <div class="alert alert-danger">Are you sure want delete "<b><?php echo $item->title?></b>?" ?</div>
                                </div>
                                <div class="modal-footer">
                                <input type="hidden" class="form-control" value="<?php echo  $item->id ?>" name="id" required="required">
                                <button type="submit" class="btn btn-danger">Ya</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            </div>
                        </div>
                        <!--  -->
                    <?php 
                    $no++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>    
      </div>
    </div>

    
  </section>
</div>