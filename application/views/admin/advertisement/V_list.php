<style>
    label.cabinet{
	display: block;
	cursor: pointer;
}

label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
	width: 250px;
	height: 250px;
  padding-bottom:25px;
}
figure figcaption {
    position: absolute;
    bottom: 0;
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    text-shadow: 0 0 10px #000;
}
</style>

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
    <div class="col-md-8">
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
                      <th>Gambar</th>
                      <th>deskripsi</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no =1;
                  foreach( $advertisements as $i=>$_item ):
                  ?>
                  <tr >
                    <td>
                        <?php echo $no?>
                    </td>
                    <td>
                        <!-- IMAGE -->
                        <a href="" data-toggle="modal" data-target="#image<?php echo $i;?>"><?php echo $_item->image;?></a>
                        <br>
                        <div class="modal fade" id="image<?php echo $i;?>" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><b>#Image Preview</b></h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="box-body">
                                        <img src="<?php echo base_url().ADVERTISEMENT_PHOTO_PATH.$_item->image  ?>" alt="" height="auto" width="500" >
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- IMAGE -->
                    </td>
                      <td>
                          <?php echo $_item->description  ?>
                      </td>
                      <td>
                          <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#deleteModal<?php echo $_item->id?>">
                              hapus
                          </button>
                          <!-- Modal Delete-->
                          <div class="modal fade" id="deleteModal<?php echo  $_item->id;?>" role="dialog">
                              <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                  <?php echo form_open("admin/iklan/delete");?>
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">#Delete _item</h4>
                                  </div>
                                  <div class="modal-body">
                                  <div class="alert alert-danger">Are you sure want delete "<b><?php echo $_item->image?></b>?" ?</div>
                                  </div>
                                  <div class="modal-footer">
                                  <input type="hidden" class="form-control" value="<?php echo  $_item->id ?>" name="id" required="required">
                                  <input type="hidden" class="form-control" value="<?php echo  $_item->image ?>" name="image" required="required">
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
    <div class="col-md-4">
      <div class="box">
        <div class="box-header">
            <h4>Tambah</h4>
        </div>
        <div class="box-body">
            <?php echo form_open("admin/iklan/add");?>
                <!--  -->
                <div class="row">
                    <div class="col-xs-12">
                        <label class="cabinet center-block">
                            <figure>
                                <img src="<?php echo base_url('assets/images/dummy/640x360.png') ?>" id="item-img-output" class="gambar img-responsive img-thumbnail" >
                                <figcaption><i class="fa fa-camera"></i></figcaption>
                        </figure>
                            <input type="file" class="item-img file center-block" name="file_photo"/>
                        </label>
                    </div>
                </div>
                <textarea style="display:none" class="form-control" id="image"  name="image" ></textarea>
                <br>
                <!--  -->
                <!-- - -->
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="control-label">deskripsi</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" ); ?>"  />
                    </div>
                </div>
                <!--  -->
                <!-- - -->
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="control-label">urutan</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control"  name="order" value="<?php echo set_value("order" ); ?>" />
                    </div>
                </div>
                <!--  -->
                <button type="submit"  class="btn btn-primary">Tambah</button>
            <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <!-- genre -->
  </div>

</section>
<!-- /.content -->
</div>

<!--  -->
<div class="modal " id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                    GAMBAR</h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" style="width:350px"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>
<!--  -->
<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script src="<?php echo base_url();?>assets/cropie/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/cropie/croppie.css">

<script type="text/javascript">
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                rawImg = e.target.result;
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }
    
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 640/1.8,height: 360/1.8
        },
        boundary: {
                width: 740/1.8,height: 460/1.8
        },
    });
    

    $('.item-img').on('change', function () {
        imageId = $(this).data('id'); tempFilename = $(this).val(); 

        $('#cancelCropBtn').data('id', imageId); 

        readFile(this); 
    });

    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpg',
            size: {width: 640*1.5,height: 360*1.5}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#image').val(resp);
            $('#cropImagePop').modal('hide');
        });
    });
    // End upload preview image
    
</script>


