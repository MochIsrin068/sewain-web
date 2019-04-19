<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Profile
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
        <?php echo form_open_multipart();?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                        <!-- - -->
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group has-feedback">
                                        <?php echo form_input($user_first_name);?>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <?php echo form_input($user_last_name);?>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <?php echo form_input($user_email);?>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <?php echo form_input($user_phone);?>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <?php echo form_input($user_address);?>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <!--  -->
                                    <label for="">Foto </label>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <input type="file" class="form-control"  name="user_image"/>
                                        </span>
                                    </label>
                                    <!--  -->
                                </div>
                                <div class="col-xs-6">
                                    <center>
                                        <div style="background-color: grey ; padding : 8px">
                                            <img src="<?php echo base_url()."upload/user/".$user->user_image  ?>" alt="" height="300" width="auto" >
                                        </div>
                                    </center>  
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <input id="" type="text" name="user_old_images" value="<?php echo $user->user_image ?>"  hidden readonly />
                                    <button type="submit" class="pull-right btn btn-sm btn-success ">
                                        <i class="ace-icon fa fa-paper-plane"></i>
                                        <span class="bigger-110">Simpan</span>
                                    </button>  
                                </div>
                            </div>
                        <!--  -->
                        </div>
                    </div>
                </div>
            </div>
        <?php echo form_close()?>
    <?php endforeach;  ?>
</section>
<!-- /.content -->
</div>