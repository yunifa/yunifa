<?php
include '../koneksiYunifa.php';

$id_siswa        = $_GET['id_siswa'];
$filter_semester = $_GET['f_semester'] ?? '';
$filter_tahun    = $_GET['f_tahun']    ?? '';
$filter_pelajaran = $_GET['f_pelajaran'] ?? '';

$dataSiswa = mysqli_query($koneksiYunifa,
    "SELECT a.id_siswa, a.nis, a.nama, b.kelas 
    FROM siswa_yunifa a 
    INNER JOIN kelas_yunifa b ON a.id_kelas = b.id_kelas 
    WHERE a.id_siswa = '$id_siswa'");

$query_kondisi = "WHERE a.id_siswa = '$id_siswa'";
if($filter_semester != '') { $query_kondisi .= " AND a.semester = '$filter_semester'"; }
if($filter_tahun != '')    { $query_kondisi .= " AND a.tahun_ajaran = '$filter_tahun'"; }
if($filter_pelajaran != '') { $query_kondisi .= " AND b.mapel = '$filter_pelajaran'"; }

$dataNilai = mysqli_query($koneksiYunifa, 
    "SELECT a.id_nilai, a.id_siswa, b.mapel, a.nilai_tugas, 
            a.nilai_uts, a.nilai_uas, a.nilai_akhir, a.semester, a.tahun_ajaran
    FROM nilai_yunifa a 
    INNER JOIN mapel_yunifa b ON a.id_mapel = b.id_mapel 
    $query_kondisi"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Raport Siswa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h1 { margin: 0; color: #2c3e50; text-align: center; flex-grow: 1; }
        .btn-link { text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 14px; color: white; transition: 0.3s; display: inline-block; }
        .btn-back { background: #6c757d; }
        .btn-add { background: #28a745; }
        .action-row { display: flex; flex-direction: column; align-items: center; gap: 15px; margin-bottom: 30px; }
        .filter-group { background: #f8f9fa; padding: 10px 20px; border-radius: 30px; border: 1px solid #ddd; }
        .siswa-info-container { margin-bottom: 20px; }
        .table-siswa { border-collapse: collapse; margin: 0 auto; }
        .table-siswa td { padding: 5px 10px; font-size: 16px; text-align: left; }
        .btn-print { background: #17a2b8; border: none; padding: 8px 16px; color: white; border-radius: 5px; cursor: pointer; }
        .btn-search { background: #007bff; border: none; padding: 6px 15px; color: white; border-radius: 4px; cursor: pointer; }
        .main-table { width: 100%; border-collapse: collapse; }
        .main-table th { background: #343a40; color: white; padding: 12px; font-size: 14px; }
        .main-table td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        .text-left { text-align: left; }
        tr:hover { background: #f1f1f1; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-top">
        <a href="../siswa/readSiswaYunifa.php" class="btn-link btn-back">&larr; Balik</a>
        <h1>E-RAPORT</h1>
        <a href="createRapotYunifa.php?id_siswa=<?= $id_siswa; ?>" class="btn-link btn-add">+ Tambah Data</a>
    </div>

    <div class="action-row">
        <div class="filter-group">
            <form method="GET">
                <input type="hidden" name="id_siswa" value="<?= $id_siswa; ?>">
                <label>Filter:</label>
                <select name="f_semester">
                    <option value="">Semua Semester</option>
                    <option value="1" <?= $filter_semester == '1' ? 'selected' : '' ?>>Semester 1</option>
                    <option value="2" <?= $filter_semester == '2' ? 'selected' : '' ?>>Semester 2</option>
                </select>
                <select name="f_tahun">
                    <option value="">Semua Tahun</option>
                    <option value="2024-2025" <?= $filter_tahun == '2024-2025' ? 'selected' : '' ?>>2024-2025</option>
                    <option value="2025-2026" <?= $filter_tahun == '2025-2026' ? 'selected' : '' ?>>2025-2026</option>
                </select>
                <select name="f_pelajaran">
                    <option value="">Semua Mapel</option>
                    <?php
                    $list_mapel = mysqli_query($koneksiYunifa, "SELECT mapel FROM mapel_yunifa");
                    while($m = mysqli_fetch_array($list_mapel)){
                        $selected = ($filter_pelajaran == $m['mapel']) ? 'selected' : '';
                        echo "<option value='".$m['mapel']."' $selected>".$m['mapel']."</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn-search">Cari</button>
                <a href="readRapotYunifa.php?id_siswa=<?= $id_siswa; ?>" style="color:red; font-size:12px; margin-left:10px;">Reset</a>
            </form>
        </div>
    </div>

    <?php if($pem = mysqli_fetch_array($dataSiswa)): ?>
    <div class="siswa-info-container">
        <table class="table-siswa">
            <tr>
                <td><strong>Nama</strong></td>
                <td>: <?= strtoupper($pem['nama']); ?></td>
            </tr>
            <tr>
                <td><strong>No. Induk</strong></td>
                <td>: <?= $pem['nis']; ?></td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: <?= $pem['kelas']; ?></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>

    <table class="main-table">
        <thead>
            <tr>
                <th>Mapel</th>
                <th>Semester</th>
                <th>Tahun Ajaran</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(mysqli_num_rows($dataNilai) > 0) {
                while($sql = mysqli_fetch_array($dataNilai)) {
            ?>
                <tr>
                    <td class="text-left"><?= $sql['mapel'];?></td>
                    <td><?= $sql['semester'];?></td>
                    <td><?= $sql['tahun_ajaran'];?></td>
                    <td><?= $sql['nilai_tugas'];?></td>
                    <td><?= $sql['nilai_uts'];?></td>
                    <td><?= $sql['nilai_uas'];?></td>
                    <td style="font-weight:bold;"><?= number_format($sql['nilai_akhir'], 2);?></td>
                    <td>
                        <a href="updateRapotYunifa.php?id_nilai=<?= $sql['id_nilai'];?>&id_siswa=<?= $id_siswa;?>" style="color:orange; text-decoration:none;">EDIT</a> | 
                        <a href="deleteRapotYunifa.php?id_nilai=<?= $sql['id_nilai'];?>&id_siswa=<?= $id_siswa;?>" onclick="return confirm('Hapus?')" style="color:red; text-decoration:none;">HAPUS</a> | 
                        <a href="../../cetak.php?id_siswa=<?= $id_siswa; ?>&semester=<?= $sql['semester']; ?>&tahun=<?= $sql['tahun_ajaran']; ?>&kelas=<?= urlencode($pem['kelas']); ?>" target="_blank" style="color:#17a2b8; text-decoration:none;">CETAK</a>
                    </td>
                </tr>
            <?php } } else { ?>
                <tr><td colspan="8">Belum ada data nilai.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>