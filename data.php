<?php
// Set header sebagai JSON
header('Content-Type: application/json');

// --- SIMULASI DATA SENSOR ---
// Di proyek nyata, kamu akan ganti bagian ini dengan query ke database
// misal: "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1"

$value = rand(0, 1023); // Simulasi nilai sensor SW-420 (0-1023)
$location = "Gedung Laboratorium";
$time = date('Y-m-d H:i:s'); // Waktu server saat ini

// --- LOGIKA ANALISIS SENSOR (INI INTI DARI PERMINTAANMU) ---
$status = "";

if ($value < 300) {
    $status = "AMAN";
} elseif ($value < 700) {
    $status = "WASPADA";
} else {
    $status = "BAHAYA";
}

// --- KEMAS DATA UNTUK DIKIRIM ---
// Data ini akan dikirim kembali ke JavaScript
$response = [
    'value'       => $value,
    'status'      => $status,
    'location'    => $location,
    'timestamp'   => $time
];

// --- CETAK SEBAGAI JSON ---
echo json_encode($response);
exit;

?>