<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['game_title'], $data['game_price'], $data['game_image'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Неверные данные']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Проверка существования игры
    $stmt = $pdo->prepare("SELECT id FROM user_games WHERE user_id = ? AND game_title = ?");
    $stmt->execute([$_SESSION['user_id'], $data['game_title']]);
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Игра уже есть в коллекции']);
        exit;
    }
    
    // Добавление игры
    $stmt = $pdo->prepare("INSERT INTO user_games (user_id, game_title, game_price, game_image, purchase_date) 
                          VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([
        $_SESSION['user_id'],
        $data['game_title'],
        $data['game_price'],
        $data['game_image']
    ]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Игра добавлена']);
    
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных']);
}
?>