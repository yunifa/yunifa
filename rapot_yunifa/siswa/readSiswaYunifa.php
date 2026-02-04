<?php 
include '../koneksiYunifa.php';

$filter_kelas    = $_GET['f_kelas']    ?? '';

$sqlYunifaStr = "SELECT a.id_siswa, a.nis, a.nama, b.kelas, c.semester, c.tahun_ajaran 
          FROM siswa_yunifa a 
          INNER JOIN kelas_yunifa b ON a.id_kelas = b.id_kelas 
          LEFT JOIN nilai_yunifa c ON a.id_siswa = c.id_siswa 
          WHERE 1=1";

if($filter_kelas != '')    { $sqlYunifaStr .= " AND b.kelas = '$filter_kelas'"; }


$sqlYunifaStr .= " GROUP BY a.id_siswa ORDER BY b.kelas ASC, a.nama ASC";
$sqlYunifa = mysqli_query($koneksiYunifa, $sqlYunifaStr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Siswa</title>
    <style>
        /* CSS Simpel & Modern */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; text-align: center; margin-bottom: 30px; }
        
        /* Styling Filter */
        .filter-box { background: #f1f3f5; padding: 20px; border-radius: 6px; margin-bottom: 25px; border: 1px solid #dee2e6; }
        .filter-box form { display: flex; flex-wrap: wrap; gap: 15px; align-items: center; }
        .filter-box label { font-weight: bold; font-size: 14px; }
        .filter-box select, .filter-box button { padding: 8px 12px; border-radius: 4px; border: 1px solid #ced4da; }
        
        .btn-cari { background-color: #007bff; color: white; border: none; cursor: pointer; transition: 0.3s; }
        .btn-cari:hover { background-color: #0056b3; }
        .btn-reset { text-decoration: none; color: #dc3545; font-size: 13px; font-weight: bold; }

        /* Styling Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; }
        table th { background-color: #343a40; color: white; text-transform: uppercase; font-size: 13px; }
        table tr:hover { background-color: #f1f1f1; }
        
        /* Styling Aksi */
        .btn-lihat { text-decoration: none; background: #28a745; color: white; padding: 5px 12px; border-radius: 4px; font-size: 12px; transition: 0.3s; }
        .btn-lihat:hover { background: #218838; }
        
        .btn-cetak {
            display: inline-block;
            background: #28a745;
            color: #fff;
            font-weight: bold;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(32,201,151,0.08);
            transition: background 0.2s, box-shadow 0.2s;
            margin-right: 15px;
            border: none;
        }
        .btn-cetak:hover {
            background: #218838;
            color: #fff;
            box-shadow: 0 4px 12px rgba(23,162,184,0.15);
        }
        .empty-row { text-align: center; color: #6c757d; font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <h1>Tabel Nilai Siswa SMK Negeri 2 Cimahi</h1>

    <div class="filter-box">
        <form method="GET" action="">
            <div>
                <a href="../../cetak_semua.php" target="_blank" class="btn-cetak">Cetak Semua Rapot</a>
                <label>Kelas:</label>
                <select name="f_kelas">
                    <option value="">Semua Kelas</option>
                    <?php
                    $list_kelas = mysqli_query($koneksiYunifa, "SELECT * FROM kelas_yunifa");
                    while($k = mysqli_fetch_array($list_kelas)){
                        $selected = ($filter_kelas == $k['kelas']) ? 'selected' : '';
                        echo "<option value='".$k['kelas']."' $selected>".$k['kelas']."</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn-cari">Cari Data</button>
            <a href="readSiswaYunifa.php" class="btn-reset">Reset Filter</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama</th>
                <th width="15%">Kelas</th>
                <th width="15%">NIS</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if(mysqli_num_rows($sqlYunifa) > 0) {
                while($sqly = mysqli_fetch_assoc($sqlYunifa)) { ?>
                    <tr>
                        <td><?= $no++; ?></td> 
                        <td><strong><?= strtoupper($sqly['nama']); ?></strong></td>
                        <td><?= $sqly['kelas']; ?></td>
                        <td><?= $sqly['nis']; ?></td>
                        <td>
                            <a href="../rapot/readRapotYunifa.php?id_siswa=<?= $sqly['id_siswa']; ?>" class="btn-lihat">LIHAT</a>
                        </td>
                    </tr>
                <?php } 
            } else {
                echo "<tr><td colspan='7' class='empty-row'>Data tidak ditemukan</td></tr>";
            } ?>
        </tbody>
    </table>
</div>

</body>
</html>