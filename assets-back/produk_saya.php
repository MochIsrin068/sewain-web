<div class="col-xl-12 order-xl-1 center">
  <div class="card bg-secondary shadow">
    <div class="card-header bg-white border-0">
      <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">Tambah Produk</h3>
          </div>
      </div>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data" action="./insert.php">
      <h6 class="heading-small text-muted mb-4">Isikan detail produk yang ingin anda jual</h6>
      <div class="pl-lg-4">
        <div class="row">
            <div class="col-lg-4">
              <div class="form-group focused">
              <label class="form-control-label">Nama Produk</label>
              <input type="text" name="table_produk_nama" class="form-control form-control-alternative" placeholder="misal: Toples">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
              <label class="form-control-label">Harga Produk</label>
              <input type="number" name="table_produk_harga" class="form-control form-control-alternative" placeholder="misal: 10000">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
              <label class="form-control-label">Jumlah Produk</label>
              <input type="number" name="table_produk_jumlah" class="form-control form-control-alternative" placeholder="misal: 100">
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group focused">
              <label>Deskripsi Singkat Produk</label>
              <textarea rows="4" type="text" name="table_produk_deskripsi" id="table_produk_deskripsi" class="form-control form-control-alternative" placeholder="misal: Produk ini sangat cocok untuk meng..."></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group focused">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="input-image" name="table_produk_gambar">
                <label class="custom-file-label" id="view-text-image">Pilih Gambar</label>
              </div>
            </div>
            <img class="" id="view-image" src="" alt="" width="auto" height="200px">
          </div>
        </div>
      </div>           
      <hr class="my-4">
      <!-- Button -->
      <div class="pl-lg-4">
        <div class="form-group focused">
          <button class="btn btn-lg btn-info btn-icon mr-4" type="submit" name="submit">
            <span class="btn-inner--icon text-md"> <i class="ni ni-bag-17" id="icon-button"></i> </span>
            <span class="btn-inner--text text-md" id="text-button">Tambahkan Produk</span>
          </button>
          <button class="btn btn-lg btn-default btn-icon mr-4" type="reset" id="cancel-button" name="batal" style="display:none;">
            <span class="btn-inner--icon text-md"> <i class="ni ni-fat-remove"></i> </span>
            <span class="btn-inner--text text-md">Batal</span>
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
  
  <h2 class="mt-4">
      <span>Semua Produk Saya</span>
  </h2>

  <div class="row row-grid" id="all-product">
   
  </div>

</div>

<script>

  
  $("document").ready(function(){

    // membuat preview gambar sebelum diupload
    function viewGambar(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader()
    
          reader.onload = function (e) {
              $('#view-image').attr('src', e.target.result)
          }
    
          reader.readAsDataURL(input.files[0])
      }
    }

    $("#input-image").change(function(){
      viewGambar(this)
    })
    // end

    // membuat preview gambar sebelum diupload

    // $('input[type="file"]').change(function(e){
    //   var fileName = e.target.files[0].name
    //   alert('The file "'+fileName+'"has been selected.')
    //   })
    // })
    $("#input-image").change(function(){
      var fileName = $('#input-image').val().split('\\').pop();
      $('#view-text-image').text(fileName)
    })
    // end

    // ajax untuk data produk CRUD
    loadData()
    $("form").on("submit", function(e){
      e.preventDefault()
      $.ajax({
        method : $(this).attr("method"),
        url : $(this).attr("action"),
        beforeSend : function(){
          swal.showLoading()
        },
        data : new FormData(this),
        contentType : false,
        cache : false,
        processData : false,
        success : function(){
          sucessInput()
          loadData()
          resetForm()
          // console.log("COba Coba")
        }
      })
    })

    $("#cancel-button").click(function(e){
      e.preventDefault()
      resetForm()
      Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Batal Edit Data!',
          showConfirmButton: false,
          beforeSend : function(){
            swal.showLoading()
          },
          // closeModal : false,
          timer: 900,
          onAfterClose : () => {
            setTimeout(() => $("[name=table_produk_nama]").focus(), 110)
          }
        })
    })

  })

  function loadData(){
    $.get("data_product.php", function(data){
      $("#all-product").html(data)

      // delete data produk
      $(".delete-product").click(function(e){
        e.preventDefault()
        Swal.fire({
          title: 'Anda yakin ingin menghapusnya?',
          text: "Hati-hati, data produk anda akan terhapus secara permanen!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus saja!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type : "get",
              url : $(this).attr("href"),
              beforeSend : function(){
                swal.showLoading()
              },
              success : function(){
                loadData()
                Swal.fire(
                  'Data Produk Terhapus!',
                  'Data produk anda telah terhapus secara permanen.',
                  'success'
                )
              }
            })
            
          }
        })
      })
      // end

      // edit data produk
      $(".edit-product").click(function(e){
        e.preventDefault()
        Swal.fire({
          position: 'center',
          type: 'info',
          title: 'Edit Data!',
          showConfirmButton: false,
          beforeSend : function(){
            swal.showLoading()
          },
          // closeModal : false,
          timer: 900,
          onAfterClose : () => {
            setTimeout(() => $("[name=table_produk_nama]").focus(), 110)
          }
        })
        var gambar = $(this).attr("table_produk_gambar")
        $("[name=table_produk_nama]").val($(this).attr("table_produk_nama"))
        $("[name=table_produk_harga]").val($(this).attr("table_produk_harga"))
        $("[name=table_produk_jumlah]").val($(this).attr("table_produk_jumlah"))
        $("#table_produk_deskripsi").text($(this).attr("table_produk_deskripsi"))
        // $("[name=table_produk_gambar]").val("../assets/image/product/"+gambar)
        // $("[name=table_produk_nama]").focus()
        $("#view-text-image").text(gambar)
        $('#text-button').text("Simpan Perubahan")
        $("#icon-button").attr("class", "ni ni-check-bold")
        $("#cancel-button").attr("style", "display:;")
        $('#view-image').attr('src', "../assets/image/product/"+gambar)
        $("form").attr("action", $(this).attr("href"))
      })
      // end

    })
  }
  

  function resetForm(){
    $("[type=text]").val("")
    $("[type=number]").val("")
    $("[type=file]").val("")
    $("#view-image").attr("src", "")
    $("#cancel-button").attr("style", "display:none;")
    $("#view-text-image").text("Pilih Gambar")
    $('#text-button').text("Tambahkan Produk")
    $("#icon-button").attr("class", "ni ni-bag-17")
    $("[name=table_produk_nama]").focus()
    $("form").attr("action", "./insert.php")
    $("[name=submit]").val("submit")
  }
  // end

  // sweet alert
  function sucessInput(){
    Swal.fire({
      position: 'top-center',
      type: 'success',
      title: 'Data Produk Tersimpan',
      showConfirmButton: false,
      timer: 1000
    })
  }

  // end

</script>