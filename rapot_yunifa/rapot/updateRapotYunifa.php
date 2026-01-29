<?php include '../koneksiYunifa.php'; 
$id_siswa = $_GET['id_siswa'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai - Yunifa</title>
</head>
<body>
    <div>
        <?php
        $idNilaiYunifa = $_GET['id_nilai'];
        
        $queryNilaiYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM nilai_yunifa WHERE id_nilai='$idNilaiYunifa'");
        $dataLamaYunifa = mysqli_fetch_array($queryNilaiYunifa);

        $querySiswaYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM siswa_yunifa");
        $queryMapelYunifa = mysqli_query($koneksiYunifa, "SELECT * FROM mapel_yunifa");

        if ($dataLamaYunifa) {
        ?>
        <form action="" method="POST">
            <table>
                <tr><td colspan="2"><h2>Edit Data Nilai</h2></td></tr>
                    <td>Nama Siswa</td>
                    <td>
                        <strong><?php echo $dataLamaYunifa['nama']; ?></strong> 
                        
                        <input type="hidden" name="nama_yunifa" value="<?php echo $dataLamaYunifa['id_siswa']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td>
                        <select name="mapel_yunifa">
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
                    <td><input type="number" name="tugas_yunifa" value="<?php echo $dataLamaYunifa['nilai_tugas']; ?>" required></td>
                </tr>
                <tr>
                    <td>Nilai UTS</td>
                    <td><input type="number" name="uts_yunifa" value="<?php echo $dataLamaYunifa['nilai_uts']; ?>" required></td>
                </tr>
                <tr>
                    <td>Nilai UAS</td>
                    <td><input type="number" name="uas_yunifa" value="<?php echo $dataLamaYunifa['nilai_uas']; ?>" required></td>
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
            <br>
            <input type="submit" name="update_yunifa" value="Perbaharui Data">
            <a href="readRapotYunifa.php?id_siswa=<?= $id_siswa; ?>" class="btn-back">&larr; Balik</a>
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
                echo "<script>alert('Data berhasil diubah!'); window.location='readRapotYunifa.php';</script>";
            } else {
                echo "<script>alert('Gagal update data!');</script>";
            }
        }
        ?>
    </div>
</body>
</html>