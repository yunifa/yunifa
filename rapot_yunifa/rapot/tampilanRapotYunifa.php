<?php 
include '../koneksiYunifa.php';
$id_siswa = $_GET['id_siswa'];

$queryProfil = mysqli_query($koneksiYunifa, 
    "SELECT s.*, k.kelas, g.nama AS wali_kelas, g.nip 
     FROM siswa_yunifa s
     JOIN kelas_yunifa k ON s.id_kelas = k.id_kelas
     JOIN guru_yunifa g ON k.id_guru = g.id_guru
     WHERE s.id_siswa = '$id_siswa'");
$siswa = mysqli_fetch_array($queryProfil);

$queryNilai = mysqli_query($koneksiYunifa, 
    "SELECT n.*, m.mapel, m.kkm 
     FROM nilai_yunifa n
     JOIN mapel_yunifa m ON n.id_mapel = m.id_mapel
     WHERE n.id_siswa = '$id_siswa'");

if (!$siswa) {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rapot_<?php echo $siswa['nama']; ?></title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; padding: 40px; color: #000; }
        .judul { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 30px; }
        
        .info { width: 100%; margin-bottom: 20px; border: none; }
        .info td { padding: 2px; }

        .nilai { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .nilai th, .nilai td { border: 1px solid black; padding: 5px; text-align: center; }
        .nilai th { background-color: #eee; } 
        
        .ttd-container { width: 100%; margin-top: 40px; }
        .ttd-kiri { float: left; width: 40%; text-align: center; }
        .ttd-kanan { float: right; width: 40%; text-align: center; }
        
        @media print {
            .tombol { display: none; }
        }
    </style>
</head>
<body>

    <div class="tombol">
        <a href="../../cetak.php" target="_blank">
            <button>Cetak PDF</button>
        </a>
        <a href="readRapotYunifa.php?id_siswa=<?php echo $id_siswa; ?>">Kembali</a>
        <hr>
    </div>

    <div class="judul">
        LAPORAN HASIL BELAJAR SISWA (RAPOT)
    </div>

    <table class="info">
        <tr>
            <td width="15%">Sekolah</td>
            <td width="35%">: SMKN 2 CIMAHI</td>
            
            <td width="15%">Kelas</td>
            <td width="35%">: <?php echo $siswa['kelas']; ?></td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>: <?php echo strtoupper($siswa['nama']); ?></td>
            
            <td>Semester</td>
            <td>: 
                <?php 
                $inf = mysqli_fetch_array(mysqli_query($koneksiYunifa, "SELECT semester, tahun_ajaran FROM nilai_yunifa WHERE id_siswa='$id_siswa' LIMIT 1"));
                echo $inf['semester'] ?? '-'; 
                ?>
            </td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: <?php echo $siswa['nis']; ?></td>
            
            <td>Tahun Ajaran</td>
            <td>: <?php echo $inf['tahun_ajaran'] ?? '-'; ?></td>
        </tr>
    </table>

    <table class="nilai">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Mata Pelajaran</th>
                <th width="10%">KKM</th>
                <th width="15%">Nilai Akhir</th>
                <th width="30%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total = 0;
            $count = mysqli_num_rows($queryNilai);

            while($n = mysqli_fetch_array($queryNilai)) { 
                $rata = ($n['nilai_tugas'] + $n['nilai_uts'] + $n['nilai_uas']) / 3;
                $total += $rata;
                
                if($rata >= 75) { $ket = "TUNTAS"; } else { $ket = "BELUM TUNTAS"; }
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td style="text-align: left;"><?php echo $n['mapel']; ?></td>
                <td><?php echo $n['kkm']; ?></td>
                <td><?php echo number_format($rata, 0); ?></td>
                <td><?php echo $ket; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Rata-Rata</strong></td>
                <td><strong><?php echo ($count > 0) ? number_format($total/$count, 2) : '0'; ?></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-container">
        <div class="ttd-kiri">
            <p>Orang Tua/Wali</p>
            <br><br><br>
            ( ............................. )
        </div>
        <div class="ttd-kanan">
            <p>Wali Kelas,</p>
            <br><br><br>
            <strong><?php echo $siswa['wali_kelas']; ?></strong><br>
            NIP. <?php echo $siswa['nip']; ?>
        </div>
    </div>

</body>
</html>