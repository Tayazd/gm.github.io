<?php
require_once __DIR__ . '/config.php';

// Убедимся, что сессия стартовала
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Проверяет, авторизован ли пользователь
 * Если не авторизован - перенаправляет на страницу регистрации
 */
function check_auth() {
    return isset($_SESSION['user_id']);
}

/**
 * Проверяет, авторизован ли пользователь (без перенаправления)
 * @return bool Возвращает true если пользователь авторизован
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Регистрация нового пользователя
 * @param string $username Имя пользователя
 * @param string $email Email пользователя
 * @param string $password Пароль
 * @return array Результат операции
 */
function registerUser(string $username, string $email, string $password): array {
    global $pdo;
    
    try {
        // Валидация ввода
        if (empty($username) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Все поля обязательны для заполнения'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Некорректный email'];
        }
        
        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Пароль должен содержать минимум 6 символов'];
        }

        // Проверка существования пользователя
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Пользователь с таким email или именем уже существует'];
        }
        
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Создание пользователя
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        
        // Автоматический вход после регистрации
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        
        return ['success' => true, 'message' => 'Регистрация прошла успешно'];
        
    } catch (PDOException $e) {
        error_log('Database error in registerUser: ' . $e->getMessage());
        return ['success' => false, 'message' => 'Ошибка при регистрации. Пожалуйста, попробуйте позже.'];
    }
}

/**
 * Аутентификация пользователя
 * @param string $email Email пользователя
 * @param string $password Пароль
 * @return array Результат операции
 */
function loginUser(string $email, string $password): array {
    global $pdo;
    
    try {
        // Базовая валидация
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email и пароль обязательны'];
        }
        
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'message' => 'Неверный email или пароль'];
        }
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            return ['success' => true, 'message' => 'Вход выполнен успешно'];
        }
        
        return ['success' => false, 'message' => 'Неверный email или пароль'];
        
    } catch (PDOException $e) {
        error_log('Database error in loginUser: ' . $e->getMessage());
        return ['success' => false, 'message' => 'Ошибка при входе. Пожалуйста, попробуйте позже.'];
    }
}

/**
 * Выход пользователя
 * @return array Результат операции
 */
function logoutUser(): array {
    // Очищаем данные сессии
    $_SESSION = [];
    
    // Удаляем куки сессии
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Уничтожаем сессию
    session_destroy();
    
    return ['success' => true, 'message' => 'Вы успешно вышли'];
}