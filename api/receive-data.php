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

// TouchDesignerのIPアドレスとポート
$touchDesignerIP = '192.168.1.10'; // TouchDesignerが動作しているIPアドレス
$touchDesignerPort = 7000; // TouchDesignerがデータを受け取るポート

// UDPソケットを作成
$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

// データをTouchDesignerに送信
socket_sendto($sock, $json, strlen($json), 0, $touchDesignerIP, $touchDesignerPort);

// ソケットを閉じる
socket_close($sock);

// 成功のレスポンスを返す
echo json_encode(['status' => 'success', 'data' => $data]);
