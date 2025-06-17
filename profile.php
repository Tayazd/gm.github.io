<?php
require 'config.php';
require 'auth_functions.php';

// Проверяем авторизацию
if (!check_auth()) {
    header("Location: regist.php");
    exit;
}
// Определяем переменную для меню
$isLoggedIn = true; // Так как мы уже прошли проверку auth, пользователь авторизован
// Получаем информацию о пользователе
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Получаем игры пользователя с пагинацией
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM user_games WHERE user_id = :user_id ORDER BY purchase_date DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll();

$totalGames = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
$totalPages = ceil($totalGames / $limit);

// Исправленный запрос для статистики
$stats = $pdo->prepare("SELECT COUNT(*) as count, SUM(CAST(REGEXP_REPLACE(game_price, '[^0-9.]', '') AS DECIMAL(10,2))) as total FROM user_games WHERE user_id = ?");
$stats->execute([$_SESSION['user_id']]);
$stats = $stats->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой профиль | GM</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <a href="logout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Выход (<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>)</span>
        </a>
        <a href="profile.php" class="menu-item">
            <i class="fas fa-user"></i>
            <span>Профиль</span>
        </a>
    </nav>

    <div class="main-content">
        <div class="profile-header">
            <h1>Ваш профиль</h1>
            <div class="user-info">
                <div class="avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="details">
                    <h2><?= htmlspecialchars($user['username']) ?></h2>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                    <p>Зарегистрирован: <?= date('d.m.Y', strtotime($user['created_at'])) ?></p>
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-value"><?= $stats['count'] ?? 0 ?></span>
                            <span class="stat-label">Игр</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?= number_format($stats['total'] ?? 0, 2, '.', ' ') ?> ₽</span>
                            <span class="stat-label">Потрачено</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="games-section">
            <div class="section-header">
                <h2>Мои игры</h2>
            </div>
            
            <?php if (empty($games)): ?>
                <div class="empty-collection">
                    <i class="fas fa-gamepad"></i>
                    <p>Ваша коллекция игр пуста</p>
                    <a href="game.php" class="btn">Перейти в магазин</a>
                </div>
            <?php else: ?>
                <div class="games-grid">
                    <?php foreach ($games as $game): ?>
                        <div class="game-item">
                            <img src="<?= htmlspecialchars($game['game_image']) ?>" alt="<?= htmlspecialchars($game['game_title']) ?>">
                            <div class="game-info">
                                <h3><?= htmlspecialchars($game['game_title']) ?></h3>
                                <p class="price"><?= htmlspecialchars($game['game_price']) ?></p>
                                <p class="date"><?= date('d.m.Y H:i', strtotime($game['purchase_date'])) ?></p>
                                <button class="play-btn">Играть</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page-1 ?>" class="page-link">&laquo; Назад</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="page-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page+1 ?>" class="page-link">Вперед &raquo;</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Сортировка игр
        document.getElementById('sort-games').addEventListener('change', function() {
            const sortValue = this.value;
            window.location.href = `profile.php?sort=${sortValue}`;
        });

        // Проверяем параметры URL для установки текущей сортировки
        const urlParams = new URLSearchParams(window.location.search);
        const sortParam = urlParams.get('sort');
        if (sortParam) {
            document.getElementById('sort-games').value = sortParam;
        }
    </script>
</body>
</html>