<?php
// CORSポリシーを満たすためのヘッダー（必要に応じて）
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// POSTリクエストのボディからJSONデータを受け取る
$json = file_get_contents('php://input');
$data = json_decode($json);

// データの存在をチェック
if (!isset($data->x) || !isset($data->y) || !isset($data->z)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

// 加速度データの処理（例: ログに記録）
// 以下は単純な例です。実際のアプリケーションに応じて適切な処理を行ってください。
file_put_contents('acceleration_log.txt', "X: {$data->x}, Y: {$data->y}, Z: {$data->z}\n", FILE_APPEND);

// 成功のレスポンスを返す
echo json_encode(['status' => 'success', 'data' => $data]);