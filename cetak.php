
<?php
require('fpdf.php');
include 'rapot_yunifa/koneksiYunifa.php';

// Ambil parameter dari URL
$id_siswa = $_GET['id_siswa'];
$semester = $_GET['semester']; // Diambil dari tombol yang diklik

// 1. Ambil Data Siswa
$querySiswa = mysqli_query($koneksiYunifa, 
    "SELECT s.nama, s.nis, k.kelas 
     FROM siswa_yunifa s 
     JOIN kelas_yunifa k ON s.id_kelas = k.id_kelas 
     WHERE s.id_siswa = '$id_siswa'");
$siswa = mysqli_fetch_array($querySiswa);

// 2. Ambil Data Nilai berdasarkan Semester
$queryNilai = mysqli_query($koneksiYunifa, 
    "SELECT m.mapel, n.nilai_tugas, n.nilai_uts, n.nilai_uas, n.tahun_ajaran
     FROM nilai_yunifa n 
     JOIN mapel_yunifa m ON n.id_mapel = m.id_mapel 
     WHERE n.id_siswa = '$id_siswa' AND n.semester = '$semester'");

// --- Mulai Pembuatan PDF ---
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Header Rapot
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN HASIL BELAJAR (RAPOT)', 0, 1, 'C');
$pdf->Ln(5);

// Informasi Siswa
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

// Tabel Nilai
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230); // Warna abu-abu untuk header tabel
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(70, 10, 'Mata Pelajaran', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Tugas', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'UTS', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'UAS', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Rata-rata', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$no = 1;
if(mysqli_num_rows($queryNilai) > 0) {
    while($row = mysqli_fetch_array($queryNilai)) {
        $rerata = number_format(($row['nilai_tugas'] + $row['nilai_uts'] + $row['nilai_uas']) / 3, 2);
        
        $pdf->Cell(10, 8, $no++, 1, 0, 'C');
        $pdf->Cell(70, 8, ucwords($row['mapel']), 1, 0, 'L');
        $pdf->Cell(25, 8, $row['nilai_tugas'], 1, 0, 'C');
        $pdf->Cell(25, 8, $row['nilai_uts'], 1, 0, 'C');
        $pdf->Cell(25, 8, $row['nilai_uas'], 1, 0, 'C');
        $pdf->Cell(35, 8, $rerata, 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 8, 'Data Nilai Belum Tersedia', 1, 1, 'C');
}

// Tanda Tangan
$pdf->Ln(20);
$pdf->Cell(130);
$pdf->Cell(0, 5, 'Cimahi, ' . date('d F Y'), 0, 1, 'C');
$pdf->Ln(15);
$pdf->Cell(130);
$pdf->Cell(0, 5, '(..........................................)', 0, 1, 'C');
$pdf->Cell(130);
$pdf->Cell(0, 5, 'Wali Kelas', 0, 1, 'C');

// Output ke Browser
$pdf->Output('I', 'Rapot_' . $siswa['nama'] . '_Smstr' . $semester . '.pdf');
?>