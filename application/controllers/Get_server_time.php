<?php
// Pastikan hanya mengizinkan permintaan GET atau POST sesuai kebutuhan
header('Content-Type: application/json');
echo json_encode(['serverTime' => time() * 1000]); // Waktu dalam milidetik
?>