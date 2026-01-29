<?php 
include '../koneksiYunifa.php'; 

// Ambil ID Siswa dari URL
$id_siswa = $_GET['id_siswa'];

// Ambil data siswa untuk ditampilkan di header form
$ambilSiswa = mysqli_query($koneksiYunifa, "SELECT * FROM siswa_yunifa WHERE id_siswa = '$id_siswa'");
$dataSiswa = mysqli_fetch_array($ambilSiswa);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai Rapot - <?= $dataSiswa['nama']; ?></title>
    <style>
        /* CSS Tema Seragam */
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        
        .header-top { display: flex; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .btn-back { text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 14px; color: white; background: #6c757d; transition: 0.3s; }
        .btn-back:hover { background: #5a6268; }
        
        h2 { margin: 0; color: #2c3e50; flex-grow: 1; text-align: center; font-size: 20px; }

        /* Styling Form */
        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 5px; vertical-align: middle; }
        td:first-child { width: 35%; font-weight: bold; color: #444; }

        input[type="number"], select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px;
        }
        
        input[type="number"]:focus, select:focus {
            border-color: #007bff; outline: none; box-shadow: 0 0 5px rgba(0,123,255,0.2);
        }

        .btn-submit {
            width: 100%; background: #28a745; color: white; border: none; padding: 12px; 
            border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; transition: 0.3s;
        }
        .btn-submit:hover { background: #218838; }

    </style>
</head>
<body>

<div class="container">
    <div class="header-top">
        <a href="readRapotYunifa.php?id_siswa=<?= $id_siswa; ?>" class="btn-back">&larr; Balik</a>
        <h2>Tambah Data Nilai</h2>
    </div>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>
                    <p class="nama-siswa-static"><?= $dataSiswa['nama']; ?></p>
                    <input type="hidden" name="id_siswa_hidden" value="<?= $id_siswa; ?>">
                </td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>
                    <select name="mapel" required>
                        <option value="">-- pilih mapel --</option>
                        <?php
                        $dataMapelYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM mapel_yunifa");
                        while($mapel = mysqli_fetch_array($dataMapelYunifa)) {
                            echo "<option value='".$mapel['id_mapel']."'>".$mapel['mapel']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nilai Tugas</td>
                <td><input type="number" name="tugas" min="0" max="100" placeholder="0 - 100" required></td>
            </tr>
            <tr>
                <td>Nilai UTS</td>
                <td><input type="number" name="uts" min="0" max="100" placeholder="0 - 100" required></td>
            </tr>
            <tr>
                <td>Nilai UAS</td>
                <td><input type="number" name="uas" min="0" max="100" placeholder="0 - 100" required></td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>
                    <select name="semester" required>
                        <option value="">-- pilih semester --</option>
                        <option value="1">1 (Ganjil)</option>
                        <option value="2">2 (Genap)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>
                    <select name="tahunajaran" required>
                        <option value="">-- pilih tahun --</option>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <input type="submit" name="tambah" value="Simpan Data Nilai" class="btn-submit">
    </form>

    <?php
    if(isset($_POST['tambah'])) {
        // Otomatisasi ID Nilai (NS001, dst)
        $sqly = mysqli_query($koneksiYunifa, "SELECT id_nilai FROM nilai_yunifa ORDER BY id_nilai DESC LIMIT 1");
        $data = mysqli_fetch_array($sqly);

        if($data) {
            $no = (int) substr($data['id_nilai'], 2);
            $no++;
        } else {
            $no = 1;
        }
        $id_nilai = "NS" . str_pad($no, 3, "0", STR_PAD_LEFT);

        // Ambil Data dari Form
        $id_siswa_post = $_POST['id_siswa_hidden'];
        $mapel         = $_POST['mapel'];
        $tugas         = $_POST['tugas'];
        $uts           = $_POST['uts'];
        $uas           = $_POST['uas'];
        $semester      = $_POST['semester'];
        $tahun         = $_POST['tahunajaran'];

        // Cek apakah nilai mapel tersebut sudah ada di semester yang sama untuk siswa ini
        $cek = mysqli_query($koneksiYunifa, "SELECT * FROM nilai_yunifa WHERE id_siswa='$id_siswa_post' AND id_mapel='$mapel' AND semester='$semester' AND tahun_ajaran='$tahun'");
        
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Gagal! Nilai mata pelajaran ini sudah diinput untuk semester & tahun ajaran tersebut.');</script>";
        } else {
            $queryInsert = "INSERT INTO nilai_yunifa (id_nilai, id_siswa, id_mapel, nilai_tugas, nilai_uts, nilai_uas, semester, tahun_ajaran) 
                            VALUES ('$id_nilai', '$id_siswa_post', '$mapel', '$tugas', '$uts', '$uas', '$semester', '$tahun')";
            
            if (mysqli_query($koneksiYunifa, $queryInsert)) {
                echo "<script>
                        alert('Data Berhasil Disimpan!');
                        window.location='readRapotYunifa.php?id_siswa=$id_siswa_post';
                      </script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data.');</script>";
            }
        }
    }
    ?>
</div>

</body>
</html>