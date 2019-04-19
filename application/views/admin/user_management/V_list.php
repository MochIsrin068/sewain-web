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
<div class="container-fluid mt--8">

  <div class="row ">
    <div class="col-xl-12 mb-5 mb-xl-0">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">User</h3>
            </div>
            <!-- <div class="col text-right">
              <a href="#!" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div> -->
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Username</th>
                <th scope="col">Full Name</th>
                <th scope="col">Alamat</th>
                <th scope="col">Email</th>
                <th scope="col">no HP</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                $no =1;

                foreach( $users as $user ):
                    if(  $user->id_user == 1 ) continue;
                ?>
                <tr <?php if($user->user_status == 0) echo "style='background-color: #f7c8c8 !important'" ?>>
                    <td>
                        <?php echo $user->user_username?>
                    </td>
                    <td>
                        <?php echo $user->user_first_name." ".$user->user_last_name  ?>
                    </td>
                    <td>
                        <?php echo $user->user_address?>
                    </td>
                    <td>
                        <?php echo $user->user_email?>
                    </td>
                    <td>
                        <?php echo $user->user_phone?>
                    </td>
                    <td>
                        <!-- <button class="btn btn-white btn-info btn-bold btn-xs" data-toggle="modal" data-target="#editModal<?php echo $user->user_id;?>">
                            <i class="ace-icon fa fa-edit bigger-120 blue"></i>
                        </button> -->
                        <a href="<?php echo site_url('admin/user_management/index/').$user->id_user;?>" class="btn btn-sm btn-primary">Detail</a>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $user->id_user?>">
                            Hapus
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $user->id_user?>"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <?php echo form_open("admin/user_management/delete_user");?>
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger">Are you sure want delete "<b><?php echo $user->user_username?></b>?" ?</div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $user->id_user?>" name="id_user" required="required">
                                    <input type="hidden" class="form-control" value="<?php echo  $user->user_username?>" name="user_username" required="required">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Ya</button>
                                </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        <!-- Modal -->
                    </td>
                </tr>
                <!-- user -->
                <?php 
                $no++;
                endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>