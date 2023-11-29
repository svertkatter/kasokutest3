<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// GETリクエストのクエリパラメータからデータを受け取る
$x = $_GET['x'] ?? null;
$y = $_GET['y'] ?? null;
$z = $_GET['z'] ?? null;

// データの存在をチェック
if ($x === null || $y === null || $z === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

// 加速度データの処理
file_put_contents('acceleration_log.txt', "X: $x, Y: $y, Z: $z\n", FILE_APPEND);

// 成功のレスポンスを返す
echo json_encode(['status' => 'success', 'data' => ['x' => $x, 'y' => $y, 'z' => $z]]);
