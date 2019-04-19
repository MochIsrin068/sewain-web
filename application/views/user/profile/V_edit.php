<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
  <div class="container-fluid">
    <div class="header-body">
        <?php
            if($this->session->flashdata('alert')){
            echo $this->session->flashdata('alert');
            }
        ?>
      <!-- Card stats -->
    </div>
  </div>
</div>
<!-- Page content -->
<?php
foreach($users as $user):
?>
<div class="container-fluid mt--7">
    <div class="row">
        <!-- user photo -->
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            <img src="<?php  echo $a =  ( empty($user->user_image) ) ?  base_url('assets-front').'/assets/img/theme/team-4-800x800.jpg' : base_url('uploads/users_photo/').$user->user_image ?>" class="rounded-circle">
                        </a>
                    </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#ubah_foto">
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
                    </div>
                </div>
            </div>
        </div>
        <!-- user photo -->
        <div class="col-xl-8 order-xl-1">
            <?php echo form_open();?>
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0"><?php echo $page_title ?></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-username">Username</label>
                                <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="<?php echo $user->user_username ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-email">Email address</label>
                                <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Email address" value="<?php echo $user->user_email ?>" readonly >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-username">Phone</label>
                                <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Phone" value="<?php echo $user->user_phone ?>" readonly >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-first-name">First name</label>
                                    <?php echo form_input( $user_first_name ) ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-control-label" for="input-last-name">Last name</label>
                                    <?php echo form_input( $user_last_name ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="form-control-label" for="input-address">Password</label>
                                    <?php echo form_input( $user_password ) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="form-control-label" for="input-address">Retype Password</label>
                                    <?php echo form_input( $password_confirm ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="form-control-label" for="input-address">Address</label>
                                    <?php echo form_input( $user_address ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-md btn-success my-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close()?>
        </div>
    </div>
</div>
<?php
 endforeach;
?>

