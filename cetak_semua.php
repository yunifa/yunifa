
<?php
require('fpdf.php');
include 'rapot_yunifa/koneksiYunifa.php';

$querySiswa = mysqli_query($koneksiYunifa, 
    "SELECT s.id_siswa, s.nama, s.nis, k.kelas 
     FROM siswa_yunifa s 
     JOIN kelas_yunifa k ON s.id_kelas = k.id_kelas 
     ORDER BY k.kelas ASC, s.nama ASC");

$pdf = new FPDF('P', 'mm', 'A4');

while($siswa = mysqli_fetch_array($querySiswa)) {
    $querySemester = mysqli_query($koneksiYunifa, 
        "SELECT DISTINCT semester FROM nilai_yunifa WHERE id_siswa = '{$siswa['id_siswa']}' ORDER BY semester ASC");
    
    while($sem = mysqli_fetch_array($querySemester)) {
        $semester = $sem['semester'];
        $queryNilai = mysqli_query($koneksiYunifa, 
            "SELECT m.mapel, n.nilai_tugas, n.nilai_uts, n.nilai_uas, n.deskripsi 
             FROM nilai_yunifa n 
             JOIN mapel_yunifa m ON n.id_mapel = m.id_mapel 
             WHERE n.id_siswa = '{$siswa['id_siswa']}' AND n.semester = '$semester'");
        
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN HASIL BELAJAR (RAPOT)', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(30, 7, 'Nama', 0, 0);
        $pdf->Cell(80, 7, ': ' . strtoupper($siswa['nama']), 0, 0);
        $pdf->Cell(30, 7, 'Kelas', 0, 0);
        $pdf->Cell(0, 7, ': ' . $siswa['kelas'], 0, 1);

        $pdf->Cell(30, 7, 'NIS', 0, 0);
        $pdf->Cell(80, 7, ': ' . $siswa['nis'], 0, 0);
        $pdf->Cell(30, 7, 'Semester', 0, 0);
        $pdf->Cell(0, 7, ': ' . $semester, 0, 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230); 
        $pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
        $pdf->Cell(70, 10, 'Mata Pelajaran', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Nilai Akhir', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'Deskripsi Kompetensi', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        if(mysqli_num_rows($queryNilai) > 0) {
            while($row = mysqli_fetch_array($queryNilai)) {
                $rerata = number_format(($row['nilai_tugas'] + $row['nilai_uts'] + $row['nilai_uas']) / 3, 2);
                $pdf->Cell(10, 8, $no++, 1, 0, 'C');
                $pdf->Cell(70, 8, ucwords($row['mapel']), 1, 0, 'L');
                $pdf->Cell(30, 8, $rerata, 1, 0, 'C');
                $text_deskripsi = !empty($row['deskripsi']) ? $row['deskripsi'] : '-';
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(80, 8, $text_deskripsi, 1, 'L');
                $pdf->SetXY(10, $y + 8); // pindah ke baris berikutnya
            }
        } else {
            $pdf->Cell(190, 10, 'Data Nilai Belum Tersedia', 1, 1, 'C');
        }

        $pdf->Ln(20);
        $pdf->Cell(130);
        $pdf->Cell(0, 5, 'Cimahi, ' . date('d F Y'), 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->Cell(130);
        $pdf->Cell(0, 5, ' ____________________ ', 0, 1, 'C');
        $pdf->Cell(130);
        $pdf->Cell(0, 5, 'Wali Kelas', 0, 1, 'C');
    }
}

$pdf->Output('I', 'Rapot_Semua_Siswa.pdf');
?>