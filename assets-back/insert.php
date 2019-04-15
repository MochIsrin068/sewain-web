<?php
    require_once("../class_php/Class.php");

    if(isset($_POST['table_produk_nama'])){
        
        $id_table_user = $_SESSION['id_table_user'];

        $sqlCek = "SELECT * FROM table_user WHERE id_table_user = '$id_table_user'";
        $getDataCek = $query->select($sqlCek);
        $dataCek = mysqli_fetch_array($getDataCek);

        $time = time();
        $name = $_FILES['table_produk_gambar']['name'];
		$location = $_FILES['table_produk_gambar']['tmp_name'];

		$name = str_replace($name, "", $name);
		$name = $dataCek['table_user_username']."_".$time.".jpg";

		$destination = "../assets/image/product/";

		$sql = "INSERT INTO table_produk (table_produk_nama, table_produk_deskripsi, table_produk_jumlah, table_produk_harga, table_produk_gambar, id_table_user) VALUES ('$_POST[table_produk_nama]', '$_POST[table_produk_deskripsi]', '$_POST[table_produk_jumlah]', '$_POST[table_produk_harga]', '$name', ' $id_table_user')";
		$query->insert($sql);
        $query->upload_image($location, $destination, $name);
        
    }
?>