<?php 
include '../koneksiYunifa.php';
$nilai = $_GET['id_nilai'];
mysqli_query($koneksiYunifa, "DELETE FROM nilai_yunifa WHERE id_nilai='$nilai'");
echo "<script>alert('Data Berhasil Dihapus!');window.location='readRapotYunifa.php';</script>";
?>