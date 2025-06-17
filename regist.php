<?php
require 'config.php';
require 'auth_functions.php';

// Если пользователь уже авторизован, перенаправляем его
if (check_auth()) {
    header("Location: game.php");
    exit;
}

// Стартуем сессию, если еще не начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GM</title>
    <link rel="stylesheet" href="regist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="regist.js"></script>
</head>
<body>
    <nav class="sidebar">
        <div class="logo">
            <i class="fas fa-gamepad"></i>
            <span>GM</span>
        </div>
        <a href="index.php" class="menu-item">
            <i class="fas fa-home"></i>
            <span>Главная</span>
        </a>
        <a href="news.php" class="menu-item">
            <i class="fas fa-newspaper"></i>
            <span>Новости</span>
        </a>
        <a href="game.php" class="menu-item">
            <i class="fas fa-store"></i>
            <span>Магазин</span>
        </a>
        <a href="Freegames.php" class="menu-item">
            <i class="fas fa-tags"></i>
            <span>Игры</span>
        </a>
        <?php if($isLoggedIn): ?>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Выход (<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>)</span>
            </a>
        <?php else: ?>
            <a href="regist.php" class="menu-item">
                <i class="fas fa-sign-in-alt"></i>
                <span>Вход</span>
            </a>
        <?php endif; ?>
        <a href="profile.php" class="menu-item">
            <i class="fas fa-user"></i>
            <span>Профиль</span>
        </a>
    </nav>

    <div class="main-content">
        <div class="auth-container">
            <div class="auth-tabs">
                <div class="auth-tab active" data-tab="login">Вход</div>
                <div class="auth-tab" data-tab="register">Регистрация</div>
            </div>
            
            <!-- Форма входа -->
            <form class="auth-form active" id="login-form" method="POST">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" placeholder="Введите ваш email" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Пароль</label>
                    <input type="password" id="login-password" name="password" placeholder="Введите ваш пароль" required>
                </div>
                
                <button type="submit" class="submit-btn">Войти</button>
                
                <div id="login-message" class="message"></div>
            </form>
            
            <!-- Форма регистрации -->
            <form class="auth-form" id="register-form" method="POST">
                <div class="form-group">
                    <label for="register-username">Имя пользователя</label>
                    <input type="text" id="register-username" name="username" placeholder="Придумайте имя пользователя" required>
                </div>
                
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" placeholder="Введите ваш email" required>
                </div>
                
                <div class="form-group">
                    <label for="register-password">Пароль</label>
                    <input type="password" id="register-password" name="password" placeholder="Придумайте пароль" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="register-confirm">Подтвердите пароль</label>
                    <input type="password" id="register-confirm" name="confirm" placeholder="Повторите пароль" required>
                </div>
                
                <button type="submit" class="submit-btn">Зарегистрироваться</button>
                
                <div id="register-message" class="message"></div>
            </form>
        </div>
    </div>

    <script>
        // Переключение между вкладками
        document.querySelectorAll('.auth-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabName = tab.getAttribute('data-tab');
                
                // Обновляем активные вкладки
                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
                
                tab.classList.add('active');
                document.getElementById(`${tabName}-form`).classList.add('active');
            });
        });

        // Обработка формы входа
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            const messageEl = document.getElementById('login-message');
            
            try {
                const response = await fetch('process_regist.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'login',
                        email: formData.get('email'),
                        password: formData.get('password')
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    messageEl.textContent = 'Успешный вход! Перенаправление...';
                    messageEl.style.color = 'green';
                    setTimeout(() => window.location.href = 'game.php', 1000);
                } else {
                    messageEl.textContent = result.message;
                    messageEl.style.color = 'red';
                }
            } catch (error) {
                messageEl.textContent = 'Ошибка соединения';
                messageEl.style.color = 'red';
            }
        });

         // Обработка формы регистрации с автоматическим входом
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const messageEl = document.getElementById('register-message');
    
    // Проверка совпадения паролей
    if (formData.get('password') !== formData.get('confirm')) {
        messageEl.textContent = 'Пароли не совпадают';
        messageEl.style.color = 'red';
        return;
    }
    
    try {
        const response = await fetch('process_regist.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'register',
                username: formData.get('username'),
                email: formData.get('email'),
                password: formData.get('password'),
                confirm: formData.get('confirm')
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            messageEl.textContent = 'Регистрация и вход выполнены! Перенаправление...';
            messageEl.style.color = 'green';
            setTimeout(() => window.location.href = 'game.php', 1000);
        } else {
            messageEl.textContent = result.message;
            messageEl.style.color = 'red';
        }
    } catch (error) {
        messageEl.textContent = 'Ошибка соединения';
        messageEl.style.color = 'red';
        console.error('Register error:', error);
    }
});
    </script>
</body>
</html>