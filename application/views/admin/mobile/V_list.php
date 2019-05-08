

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
    <div class="col-md-10">
      <div class="box">
        <div class="box-header">
            <h4><?php echo $page_title ?></h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead class="thin-border-bottom">
                  <tr >
                      <th style="width:50px">No</th>
                      <th>Versi</th>
                      <th>Kode Pesan</th>
                      <th>Pesan</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no =1;
                  foreach( $mobile_settings as $i=>$_item ):
                  ?>
                  <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $_item->version?>
                        </td>
                        <td>
                            <?php echo $_item->message_code  ?>
                        </td>
                        <td>
                            <?php echo $_item->message  ?>
                        </td>
                        <td>
                            <button class="btn   btn-bold btn-xs btn-primary" data-toggle="modal" data-target="#edit_mobile<?php echo $_item->id;?>">
                                edit
                            </button>
                            <!-- edit_category-->
                            <div class="modal fade" id="edit_mobile<?php echo  $_item->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/mobile/edit");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#edit Setting</h4>
                                    </div>
                                    <div class="modal-body">
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Versi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control"  name="version" value="<?php echo  $_item->version ?>"  />
                                        </div>
                                    </div>
                                    <!--  -->
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Kode Pesan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <input type="text" class="form-control"  name="message_code"   /> -->
                                            <select class="form-control" name="message_code" >
                                                <option value="1">info</option>
                                                <option value="0">error</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <!-- - -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Pesan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control"  name="message"   />
                                        </div>
                                    </div>
                                    <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $_item->id ?>" name="id" required="required">
                                    <button type="submit" class="btn btn-success">Ya</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
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
  </div>
</section>
<!-- /.content -->
</div>

