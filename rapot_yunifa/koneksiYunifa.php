<?php
$koneksiYunifa = mysqli_connect("localhost","root","","db_rapot_yunifa");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>