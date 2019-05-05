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
    <?php foreach( $users as $user ):  ?>
        <div class="row">
            <div class="col-md-9">
            <?php echo form_open_multipart();?>
                <div class="box">
                    <div class="box-body">
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">Username</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control"  name="user_username" value="<?php echo set_value("user_username" , $user->user_username); ?>" readonly />
                            <span style="color:red"><?php echo form_error("user_username"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control"  name="user_email" value="<?php echo set_value("user_email" , $user->user_email); ?>" readonly/>
                            <span style="color:red"><?php echo form_error("user_email"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">Nama Depan</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo form_input( $user_first_name ) ?>
                            <span style="color:red"><?php echo form_error("user_first_name"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">Nama Belakang</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo form_input( $user_last_name ) ?>
                            <span style="color:red"><?php echo form_error("user_last_name"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">Alamat</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo form_input( $user_address ) ?>
                            <span style="color:red"><?php echo form_error("user_address"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    <!-- - -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="" class="control-label">No Telp</label>
                        </div>
                        <div class="col-md-8">
                            <!-- <input type="text" class="form-control"  name="user_phone" value="<?php echo set_value("user_phone" , $user->user_phone); ?>" /> -->
                            <?php echo form_input( $user_phone ) ?>
                            <span style="color:red"><?php echo form_error("user_phone"); ?></span>
                        </div>
                    </div>
                    <!--  -->
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        edit password
                    </div>
                    <div class="box-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Password lama </label>
                            </div>
                            <div class="col-md-8">
                                <?php echo form_input( $old_password ) ?>
                                <span style="color:red"><?php echo form_error("user_password"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Password</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo form_input( $user_password ) ?>
                                <span style="color:red"><?php echo form_error("user_password"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">konfirasi Password</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo form_input( $password_confirm ) ?>
                                <span style="color:red"><?php echo form_error("password_confirm"); ?></span>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <button type="submit" class="btn  pull-right btn-success">Simpan</button>
                    </div>
                </div>
            <?php echo form_close()?>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-box" src="<?php  echo $a =  ( empty($user->user_image) ) ?  base_url(FAVICON_IMAGE) : base_url('uploads/users_photo/').$user->user_image ?>" >   
                    <br>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#ubah_foto">
                            Ubah Foto
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="ubah_foto"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <?php echo form_open_multipart("user/profile/upload_photo");?>
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Foto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    File <input type="file" name="user_image" size="20" />
                                </div>
                                <div class="modal-footer">
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
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    <?php endforeach;  ?>
  </section>
</div>