<?php
// Set header sebagai JSON
header('Content-Type: application/json');

$value = rand(0, 1023); // Simulasi nilai sensor SW-420 (0-1023)
$location = "Gedung Laboratorium";
$time = date('Y-m-d H:i:s'); // Waktu server saat ini
$status = "";

if ($value < 300) {
    $status = "AMAN";
} elseif ($value < 700) {
    $status = "WASPADA";
} else {
    $status = "BAHAYA";
}

$response = [
    'value'       => $value,
    'status'      => $status,
    'location'    => $location,
    'timestamp'   => $time
];

echo json_encode($response);
exit;


?>
