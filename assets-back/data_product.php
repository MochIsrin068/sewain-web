<?php
    require_once("../class_php/Class.php");

    $id_table_user1 = $_SESSION['id_table_user'];
    $sql = "SELECT * FROM table_produk p, table_user u WHERE p.id_table_user = u.id_table_user AND u.id_table_user = '$id_table_user1'";
    $getData = $query->select($sql);
    while ($data = mysqli_fetch_array($getData)) {
?>
<style>
.product-description{
    max-height: 70px;
    height: 70px;
    width: 100%;
    border: 0px transparent;

}
.product-name{
    max-height: 25px;
    height: 25px;
    width: 100%;
    border: 0px transparent;
    /* background-color:#501111; */
}
.product-image{
    max-height: 35%;
    height: 35%;
    width: 100%;
    border: 2px solid transparent;
    /* background-color:#501111; */
}
.product-image img{
    /* max-height: 100%; */
    height: 200px;
    width: 100%;
    object-fit: cover;
    /* border: 2px solid black;
    background-color:#501111; */
}
</style>
<div class="col-lg-4 pb-4">
    <div class="card card-lift--hover shadow border-0" >
        <div class="card-body py-3">
            <div class="product-image">
                <img class="card-img-top" src="..\assets\image\product\<?=$data['table_produk_gambar']?>" alt="Card image cap">
            </div>
            <div class="product-name">
                <h6 class="text-primary text-uppercase pt-2 pb-0 mb-0"><?=$data['table_produk_nama']?></h6>
            </div>
            <div class="product-description ml-0 mr-0 mt-2 mb-0">
                <p class="description"><?=$data['table_produk_deskripsi']?></p>
            </div>
            <div class="product-footer pt-3">
                <div>
                    <span class="badge badge-pill badge-lg badge-info">Rp. <?=$data['table_produk_harga']?>,-</span>
                    <span class="badge badge-pill badge-danger">Baru</span>
                </div>
                <a href="edit_product.php?id_table_produk=<?=$data['id_table_produk']?>&table_produk_gambar=<?=$data['table_produk_gambar']?>" table_produk_nama="<?=$data['table_produk_nama']?>" table_produk_harga="<?=$data['table_produk_harga']?>" table_produk_jumlah="<?=$data['table_produk_jumlah']?>" table_produk_deskripsi="<?=$data['table_produk_deskripsi']?>" table_produk_gambar="<?=$data['table_produk_gambar']?>" class="btn btn-primary mt-4 edit-product">Edit Produk</a>
                <a href="delete_product.php?id_table_produk=<?=$data['id_table_produk']?>&table_produk_gambar=<?=$data['table_produk_gambar']?>" class="btn btn-danger mt-4 delete-product">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>