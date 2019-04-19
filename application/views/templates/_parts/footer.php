<div class="container-fluid ">      
      <!-- Footer -->
      <footer class="footer">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank"><?php echo APP_NAME ?></a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank"><?php echo APP_NAME ?></a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">Tentang Kami</a>
            </li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
  <!--  -->
</div>

<!-- Argon Scripts -->
<!-- Core -->
<script src="<?php echo base_url();?>assets-back/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets-back/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- Optional JS -->
<script src="<?php echo base_url();?>assets-back/assets/vendor/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo base_url();?>assets-back/assets/vendor/chart.js/dist/Chart.extension.js"></script>
<!-- Argon JS -->
<script src="<?php echo base_url();?>assets-back/assets/js/argon.js?v=1.0.0"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="alert"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <?php echo $this->session->flashdata('alert') ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- <?php
if($this->session->flashdata('alert')){
    echo "  <script>
                $('#alert').modal('show');
            </script>";
}
?> -->
</html>