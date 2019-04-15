<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_name ?>
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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                    <!-- - -->
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><?php echo $user->user_first_name." ".$user->user_last_name ." ( ".$user->user_username." ) "  ?> </h2>
                            <h4> Alamat : <?php echo $user->user_address ?> </h4>
                            <h4> <?php echo $user->user_email ?> </h4>
                            <h4> <?php echo $user->user_phone ?> </h4>
                            <br><br>
                            <a href="<?php echo site_url('user/profile/edit') ?>" class="btn btn-white btn-info btn-bold btn-m">
                                Edit 
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <center>
                                <div style="background-color: grey ; padding : 8px">
                                    <img src="<?php echo base_url()."upload/user/".$user->user_image  ?>" alt="" height="300" width="auto" >
                                </div>
                            </center>  
                        </div>
                    </div>
                    <!--  -->
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;  ?>
</section>
<!-- /.content -->
</div>