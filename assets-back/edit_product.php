<?php
    require_once("../class_php/Class.php");
   
    if(isset($_FILES['table_produk_gambar']['name'])){
        if($_FILES['table_produk_gambar']['name'] != null || $_FILES['table_produk_gambar']['name'] != ""){

            $id_table_user = $_SESSION['id_table_user'];

            $sqlCek = "SELECT * FROM table_user WHERE id_table_user = '$id_table_user'";
            $getDataCek = $query->select($sqlCek);
            $dataCek = mysqli_fetch_array($getDataCek);

            $time = time();
            $location = $_FILES['table_produk_gambar']['tmp_name'];

            $name = $_GET['table_produk_gambar'];

            $destination = "../assets/image/product/";

            $sql = "UPDATE table_produk SET table_produk_nama = '$_POST[table_produk_nama]', table_produk_deskripsi = '$_POST[table_produk_deskripsi]', table_produk_jumlah = '$_POST[table_produk_jumlah]', table_produk_harga = '$_POST[table_produk_harga]', table_produk_gambar = '$name' WHERE id_table_produk = '$_GET[id_table_produk]'";
            $query->update($sql);
            $query->upload_image($location, $destination, $name);
        }else{
            $sql = "UPDATE table_produk SET table_produk_nama = '$_POST[table_produk_nama]', table_produk_deskripsi = '$_POST[table_produk_deskripsi]', table_produk_jumlah = '$_POST[table_produk_jumlah]', table_produk_harga = '$_POST[table_produk_harga]' WHERE id_table_produk = '$_GET[id_table_produk]'";
            $query->update($sql);
        }
    }else{
        $sql = "UPDATE table_produk SET table_produk_nama = '$_POST[table_produk_nama]', table_produk_deskripsi = '$_POST[table_produk_deskripsi]', table_produk_jumlah = '$_POST[table_produk_jumlah]', table_produk_harga = '$_POST[table_produk_harga]' WHERE id_table_produk = '$_GET[id_table_produk]'";
        $query->update($sql);
    }
?>