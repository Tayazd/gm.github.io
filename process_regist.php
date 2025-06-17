<?php
declare(strict_types=1);

// Настройка вывода ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Подключение файлов
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth_functions.php';

// Установка заголовков
header('Content-Type: application/json');

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit;
}

// Обработка действия
try {
    if (!isset($_POST['action'])) {
        throw new InvalidArgumentException('Не указано действие');
    }

    $response = match ($_POST['action']) {
        'register' => handleRegister(),
        'login' => handleLogin(),
        'logout' => logoutUser(),
        default => throw new InvalidArgumentException('Неизвестное действие'),
    };

    echo json_encode($response);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

exit;

/**
 * Обработка регистрации
 */
function handleRegister(): array
{
    $required = ['username', 'email', 'password', 'confirm'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new InvalidArgumentException("Поле $field обязательно");
        }
    }

    if ($_POST['password'] !== $_POST['confirm']) {
        throw new InvalidArgumentException('Пароли не совпадают');
    }

    $result = registerUser(
        trim($_POST['username']),
        trim($_POST['email']),
        $_POST['password']
    );

    // Если регистрация успешна, сразу авторизуем пользователя
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['username'] = trim($_POST['username']);
        $_SESSION['email'] = trim($_POST['email']);
        
        // Добавляем информацию о пользователе в ответ
        $result['user'] = [
            'id' => $result['user_id'],
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email'])
        ];
    }

    return $result;
}
/**
 * Обработка входа
 */
function handleLogin(): array
{
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new InvalidArgumentException('Email и пароль обязательны');
    }

    return loginUser(
        trim($_POST['email']),
        $_POST['password']
    );
}
?>