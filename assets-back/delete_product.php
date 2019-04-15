<?php
    require_once("../class_php/Class.php");

    $sql = "DELETE FROM table_produk WHERE id_table_produk = '$_GET[id_table_produk]'";
    $query->delete($sql);
    $query->delete_image("../assets/image/product/".$_GET['table_produk_gambar']."");
?>