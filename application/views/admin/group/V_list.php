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
  <div class="row"> 
    <!-- kategory -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="row"> 
            <div class="col-md-6">
              <h4>kategory</h4>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn  pull-right btn-success" data-toggle="modal" data-target="#add_category" >tambah</button>
              <!-- edit_category-->
              <div class="modal fade" id="add_category" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                      <?php echo form_open("admin/group/add_category");?>
                      <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">#add category</h4>
                      </div>
                      <div class="modal-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Nama</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                                <span style="color:red"><?php echo form_error("name"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">deskripsi</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" ); ?>" />
                                <span style="color:red"><?php echo form_error("description"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                      </div>
                      <div class="modal-footer">
                      <button type="submit" class="btn btn-danger">Ya</button>
                      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                      </div>
                      <?php echo form_close(); ?>
                  </div>
                  </div>
              </div>
              <!--  -->
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead class="thin-border-bottom">
                  <tr >
                      <th style="width:50px">No</th>
                      <th>Nama</th>
                      <th>deskripsi</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no =1;
                  foreach( $categories as $category ):
                  ?>
                  <tr >
                      <td>
                          <?php echo $no?>
                      </td>
                  <td>
                          <?php echo $category->name?>
                      </td>
                      <td>
                          <?php echo $category->description  ?>
                      </td>
                      <td>
                          <button class="btn   btn-bold btn-xs btn-primary" data-toggle="modal" data-target="#edit_category<?php echo $category->id;?>">
                              edit
                          </button>
                          <!-- edit_category-->
                          <div class="modal fade" id="edit_category<?php echo  $category->id;?>" role="dialog">
                              <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                  <?php echo form_open("admin/group/edit_category");?>
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">#edit category</h4>
                                  </div>
                                  <div class="modal-body">
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Nama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control"  name="name" value="<?php echo set_value("name" , $category->name); ?>"  />
                                            <span style="color:red"><?php echo form_error("name"); ?></span>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">deskripsi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" , $category->description); ?>" />
                                            <span style="color:red"><?php echo form_error("description"); ?></span>
                                        </div>
                                    </div>
                                    <!--  -->
                                  </div>
                                  <div class="modal-footer">
                                  <input type="hidden" class="form-control" value="<?php echo  $category->id ?>" name="id" required="required">
                                  <button type="submit" class="btn btn-danger">Ya</button>
                                  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                  </div>
                                  <?php echo form_close(); ?>
                              </div>
                              </div>
                          </div>
                          <!--  -->
                          <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#deleteModal<?php echo $category->id?>">
                              hapus
                          </button>
                          <!-- Modal Delete-->
                          <div class="modal fade" id="deleteModal<?php echo  $category->id;?>" role="dialog">
                              <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                  <?php echo form_open("admin/group/delete_category");?>
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">#Delete category</h4>
                                  </div>
                                  <div class="modal-body">
                                  <div class="alert alert-danger">Are you sure want delete "<b><?php echo $category->name?></b>?" ?</div>
                                  </div>
                                  <div class="modal-footer">
                                  <input type="hidden" class="form-control" value="<?php echo  $category->id ?>" name="id" required="required">
                                  <button type="submit" class="btn btn-danger">Ya</button>
                                  <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                  </div>
                                  <?php echo form_close(); ?>
                              </div>
                              </div>
                          </div>
                          <!--  -->
                      </td>
                  </tr>
                  <?php 
                  $no++;
                  endforeach;?>
                  </tbody>
              </table>
          </div>  
        </div>
      </div>
    </div>
    <!-- kategory -->
    <!-- genre -->
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <div class="row"> 
            <div class="col-md-6">
              <h4>genre</h4>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn  pull-right btn-success" data-toggle="modal" data-target="#add_genre" >tambah</button>
              <!-- edit_category-->
              <div class="modal fade" id="add_genre" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                      <?php echo form_open("admin/group/add_genre");?>
                      <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">#add_genre</h4>
                      </div>
                      <div class="modal-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Nama</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                                <span style="color:red"><?php echo form_error("name"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">deskripsi</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" ); ?>" />
                                <span style="color:red"><?php echo form_error("description"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                      </div>
                      <div class="modal-footer">
                      <button type="submit" class="btn btn-danger">Ya</button>
                      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                      </div>
                      <?php echo form_close(); ?>
                  </div>
                  </div>
              </div>
              <!--  -->
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead class="thin-border-bottom">
                  <tr >
                      <th style="width:50px">No</th>
                      <th>Nama</th>
                      <th>deskripsi</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no =1;
                  foreach( $genres as $item ):
                  ?>
                  <tr >
                      <td>
                          <?php echo $no?>
                      </td>
                    <td>
                          <?php echo $item->name?>
                      </td>
                      <td>
                          <?php echo $item->description  ?>
                      </td>
                      <td>
                          <button class="btn   btn-bold btn-xs btn-primary" data-toggle="modal" data-target="#edit_genre<?php echo $item->id;?>">
                              edit
                          </button>
                          <!-- edit_item-->
                          <div class="modal fade" id="edit_genre<?php echo  $item->id;?>" role="dialog">
                              <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                  <?php echo form_open("admin/group/edit_genre");?>
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">#edit genre</h4>
                                  </div>
                                  <div class="modal-body">
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Nama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control"  name="name" value="<?php echo set_value("name" , $item->name); ?>"  />
                                            <span style="color:red"><?php echo form_error("name"); ?></span>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">deskripsi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" , $item->description); ?>" />
                                            <span style="color:red"><?php echo form_error("description"); ?></span>
                                        </div>
                                    </div>
                                    <!--  -->
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
                          <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#delete_genre<?php echo $item->id?>">
                              hapus
                          </button>
                          <!-- Modal Delete-->
                          <div class="modal fade" id="delete_genre<?php echo  $item->id;?>" role="dialog">
                              <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                  <?php echo form_open("admin/group/delete_genre");?>
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">#Delete genre</h4>
                                  </div>
                                  <div class="modal-body">
                                  <div class="alert alert-danger">Are you sure want delete "<b><?php echo $item->name?></b>?" ?</div>
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
                      </td>
                  </tr>
                  <?php 
                  $no++;
                  endforeach;?>
                  </tbody>
              </table>
          </div>  
        </div>
      </div>
    </div>
    <!-- genre -->
  </div>
</section>
<!-- /.content -->
</div>