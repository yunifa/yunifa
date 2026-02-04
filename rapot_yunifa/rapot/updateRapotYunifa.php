<?php include '../koneksiYunifa.php'; 
$id_siswa = $_GET['id_siswa'];
$idNilaiYunifa = $_GET['id_nilai'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai - Yunifa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        
        .header-top { display: flex; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .btn-back { text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 14px; color: white; background: #6c757d; transition: 0.3s; }
        .btn-back:hover { background: #5a6268; }
        h2 { margin: 0; color: #2c3e50; flex-grow: 1; text-align: center; font-size: 20px; }

        table { width: 100%; border-collapse: collapse; }
        td { padding: 12px 5px; vertical-align: middle; }
        td:first-child { width: 35%; font-weight: bold; color: #444; }
        
        input[type="number"], select { 
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px;
        }
        
        .nama-siswa-box { font-size: 16px; font-weight: bold; }

        .btn-submit { 
            width: 100%; background: #ffc107; color: #212529; border: none; padding: 12px; 
            border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; transition: 0.3s;
        }
        .btn-submit:hover { background: #e0a800; }
    </style>
</head>
<body>

<div class="container">
    <?php
    $queryNilaiYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM nilai_yunifa WHERE id_nilai='$idNilaiYunifa'");
    $dataLamaYunifa = mysqli_fetch_array($queryNilaiYunifa);
    $queryMapelYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM mapel_yunifa");

    if ($dataLamaYunifa) {
        $id_siswa_lama = $dataLamaYunifa['id_siswa'];
        $getSiswa = mysqli_query($koneksiYunifa, "SELECT nama FROM siswa_yunifa WHERE id_siswa='$id_siswa_lama'");
        $dataSiswa = mysqli_fetch_array($getSiswa);
    ?>
    
    <div class="header-top">
        <a href="readRapotYunifa.php?id_siswa=<?= $id_siswa; ?>" class="btn-back">&larr; Balik</a>
        <h2>Edit Data Nilai</h2>
    </div>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>
                    <span class="nama-siswa-box"><?php echo strtoupper($dataSiswa['nama']); ?></span>
                    <input type="hidden" name="nama_yunifa" value="<?php echo $id_siswa_lama; ?>">
                </td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>
                    <select name="mapel_yunifa" required>
                        <option value="">-- pilih mapel --</option>
                        <?php
                        while($rowMapelYunifa = mysqli_fetch_array($queryMapelYunifa)) {
                            $pilihMapelYunifa = ($rowMapelYunifa['id_mapel'] == $dataLamaYunifa['id_mapel']) ? "selected" : "";
                            echo "<option value='".$rowMapelYunifa['id_mapel']."' $pilihMapelYunifa>".$rowMapelYunifa['mapel']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nilai Tugas</td>
                <td><input type="number" name="tugas_yunifa" value="<?php echo $dataLamaYunifa['nilai_tugas']; ?>" min="0" max="100" required></td>
            </tr>
            <tr>
                <td>Nilai UTS</td>
                <td><input type="number" name="uts_yunifa" value="<?php echo $dataLamaYunifa['nilai_uts']; ?>" min="0" max="100" required></td>
            </tr>
            <tr>
                <td>Nilai UAS</td>
                <td><input type="number" name="uas_yunifa" value="<?php echo $dataLamaYunifa['nilai_uas']; ?>" min="0" max="100" required></td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>
                    <select name="semester_yunifa">
                        <option value="1" <?php if($dataLamaYunifa['semester'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if($dataLamaYunifa['semester'] == '2') echo 'selected'; ?>>2</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>
                    <select name="tahun_yunifa">
                        <option value="2024-2025" <?php if($dataLamaYunifa['tahun_ajaran'] == '2024-2025') echo 'selected'; ?>>2024-2025</option>
                        <option value="2025-2026" <?php if($dataLamaYunifa['tahun_ajaran'] == '2025-2026') echo 'selected'; ?>>2025-2026</option>
                        <option value="2026-2027" <?php if($dataLamaYunifa['tahun_ajaran'] == '2026-2027') echo 'selected'; ?>>2026-2027</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <input type="submit" name="update_yunifa" value="Perbaharui Data Nilai" class="btn-submit">
    </form>

    <?php 
    } 
    if(isset($_POST['update_yunifa'])) {
        $inputSiswaYunifa = $_POST['nama_yunifa'];
        $inputMapelYunifa = $_POST['mapel_yunifa'];
        $inputTugasYunifa = $_POST['tugas_yunifa'];
        $inputUtsYunifa   = $_POST['uts_yunifa'];
        $inputUasYunifa   = $_POST['uas_yunifa'];
        $inputSemYunifa   = $_POST['semester_yunifa'];
        $inputThnYunifa   = $_POST['tahun_yunifa'];

        $sqlSimpanYunifa = "UPDATE nilai_yunifa SET 
                            id_siswa='$inputSiswaYunifa', 
                            id_mapel='$inputMapelYunifa', 
                            nilai_tugas='$inputTugasYunifa', 
                            nilai_uts='$inputUtsYunifa', 
                            nilai_uas='$inputUasYunifa',  
                            semester='$inputSemYunifa', 
                            tahun_ajaran='$inputThnYunifa' 
                            WHERE id_nilai='$idNilaiYunifa'";

        if (mysqli_query($koneksiYunifa, $sqlSimpanYunifa)) {
            echo "<script>
                    alert('Data berhasil diubah!'); 
                    window.location='readRapotYunifa.php?id_siswa=$id_siswa';
                  </script>";
        } else {
            echo "<script>alert('Gagal update data!');</script>";
        }
    }
    ?>
</div>

</body>
</html>