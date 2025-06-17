<?php
require 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GM - Магазин</title>
    <link rel="stylesheet" href="game.css">
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
        <?php if(!$isLoggedIn): ?>
            <div class="auth-notice">
                <h2>Требуется авторизация</h2>
                <p>Для полного доступа к магазину пожалуйста <a href="regist.php">войдите</a> или <a href="regist.php">зарегистрируйтесь</a>.</p>
                <p>Вы можете просматривать каталог, но покупки доступны только авторизованным пользователям.</p>
            </div>
        <?php endif; ?>

        <div class="catalog-header">
            <h1 class="catalog-title">Магазин Игр</h1>
            <div class="search-bar">
                <span class="search-icon">🔍</span>
                <input type="text" placeholder="Search games...">
            </div>
        </div>
        
        <div class="filter-controls">
            <button class="filter-btn active">Все игры</button>
            <button class="filter-btn">Аркады</button>
            <button class="filter-btn">Приключения</button>
            <button class="filter-btn">РПГ</button>
            <button class="filter-btn">Стратегии</button>
            <button class="filter-btn">Спорт</button>
            <button class="filter-btn">Симуляторы</button>
            <button class="filter-btn">Инди</button>
            <button class="filter-btn">VR</button>
            <button class="filter-btn">По скидки</button>
            <button class="filter-btn">Новые релизы</button>
        </div>
        <div class="game-grid">
            <!-- Игра 1 -->
            <div class="game-card" style="--order: 1">
                <div class="game-image-container">
                    <img src="img/Amerzone - The Explorer's Legacy.jpg" alt="Amerzone" class="game-image">
                    <span class="game-badge">18+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Amerzone - The Explorer's Legacy</h3>
                    <p class="game-genre">Отправьтесь на поиски больших белых птиц в загадочном краю!</p>
                    <div class="game-price">
                        <span class="current-price">1 500 ₽</span>
                        <span class="original-price">1 350 ₽</span>
                        <span class="discount">-10%</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 2 -->
            <div class="game-card" style="--order: 2">
                <div class="game-image-container">
                    <img src="img/blad.jpg" alt="Приключения Капитана Блада" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Приключения Капитана Блада</h3>
                    <p class="game-genre"> Пиратский боевик, в котором вы играете роль грозного флибустьера</p>
                    <div class="game-price">
                        <span class="current-price">1 199 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 3 -->
            <div class="game-card" style="--order: 3">
                <div class="game-image-container">
                    <img src="img/EscapefromTarkovArena.jpg" alt="Escape from Tarkov: Arena" class="game-image">
                    <span class="game-badge">18+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Escape from Tarkov: Arena</h3>
                    <p class="game-genre">Это тактический шутер с высоким уровнем реализма</p>
                    <div class="game-price">
                        <span class="current-price">1 300 ₽*</span>
                        <span class="original-price">1 040 ₽</span>
                        <span class="discount">-20%</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 4 -->
            <div class="game-card" style="--order: 4">
                <div class="game-image-container">
                    <img src="img/INAYAH.jpg" alt="INAYAH" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">«INAYAH – Жизнь после богов»</h3>
                    <p class="game-genre">Захватывающий экшен-платформер с элементами метроидвании</p>
                    <div class="game-price">
                        <span class="current-price">1 199 ₽</span>
                        <span class="original-price">815,32 ₽</span>
                        <span class="discount">-30%</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 5 -->
            <div class="game-card" style="--order: 5">
                <div class="game-image-container">
                    <img src="img/AI LIMIT.jpg" alt="AI LIMIT" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">AI LIMIT</h3>
                    <p class="game-genre">AI LIMIT - это экшн-RPG, действие которой разворачивается в постапокалиптическом мире.</p>
                    <div class="game-price">
                        <span class="current-price">2 100 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 6 -->
            <div class="game-card" style="--order: 6">
                <div class="game-image-container">
                    <img src="img/Velvet Bite.jpg" alt="Velvet Bite" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Velvet Bite: Softly, with Teeth</h3>
                    <p class="game-genre">Вас пригласили на вечеринку в честь Хэллоуина! Ура! Музыка! Еда! Напитки! Вампиры!</p>
                    <div class="game-price">
                        <span class="current-price">1 199 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 7 -->
            <div class="game-card" style="--order: 7">
                <div class="game-image-container">
                    <img src="img/River City Girls 2.jpg" alt="River City Girls 2" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">River City Girls 2</h3>
                    <p class="game-genre">Ставки возросли. Улицы еще опаснее. Девушки из Ривер-сити снова в деле! Враг возвращается, чтобы отомстить.</p>
                    <div class="game-price">
                        <span class="current-price">1 199 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 8 -->
            <div class="game-card" style="--order: 8">
                <div class="game-image-container">
                    <img src="img/Big Helmet Heroes.jpg" alt="Big Helmet Heroes" class="game-image">
                     <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Big Helmet Heroes</h3>
                    <p class="game-genre">Эпическое трехмерное приключение в жанре «избей их всех» с харизматичными рыцарями</p>
                    <div class="game-price">
                        <span class="current-price">1 210 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 9 -->
            <div class="game-card" style="--order: 9">
                <div class="game-image-container">
                    <img src="img/Pax Dei.jpg" alt="Pax Dei" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Pax Dei</h3>
                    <p class="game-genre">Добро пожаловать в обширную социальную ММО-песочницу, вдохновленную средневековыми легендами.</p>
                    <div class="game-price">
                        <span class="current-price">1 499,25 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 10 -->
            <div class="game-card" style="--order: 10">
                <div class="game-image-container">
                    <img src="img/Mark of the Deep.jpg" alt="Mark of the Deep" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Mark of the Deep</h3>
                    <p class="game-genre">Mark of the Deep - это эпическое приключение на пиратскую тематику с сильным повествованием.</p>
                    <div class="game-price">
                        <span class="current-price">1 100 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 11 -->
            <div class="game-card" style="--order: 11">
                <div class="game-image-container">
                    <img src="img/Killer Klowns From Outer Space.jpg" alt="Killer Klowns From Outer Space: The Game" class="game-image">
                    <span class="game-badge">18+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Killer Klowns From Outer Space: The Game</h3>
                    <p class="game-genre">Спланируйте собственное вторжение инопланетян и переловите людей в роли культовых клоунов-убийц.</p>
                    <div class="game-price">
                        <span class="current-price">1 199 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- игра 12 -->
            <div class="game-card" style="--order: 12">
                <div class="game-image-container">
                    <img src="img/FlintTreasure of Oblivion.jpg" alt="Flint: Treasure of Oblivion" class="game-image">
                    <span class="game-badge">18+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Flint: Treasure of Oblivion</h3>
                    <p class="game-genre">Играйте в тактическую RPG с неповторимым сюжетом, действие которого разворачивается в мире пиратов.</p>
                    <div class="game-price">
                        <span class="current-price">1 799 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 13 -->
            <div class="game-card" style="--order: 1">
                <div class="game-image-container">
                    <img src="img/MiraculousParis Under Siege.jpg" alt="Miraculous: Paris Under Siege" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Miraculous: Paris Under Siege</h3>
                    <p class="game-genre">Примерьте костюмы Ladybug и Cat Noir в их самом отчаянном путешествии!</p>
                    <div class="game-price">
                        <span class="current-price">1 499 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 14 -->
            <div class="game-card" style="--order: 2">
                <div class="game-image-container">
                    <img src="img/The Smurfs  Dreams.jpg" alt="The Smurfs – Dreams" class="game-image">
                     <span class="game-badge">12+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">The Smurfs – Dreams</h3>
                    <p class="game-genre">Ключ к спасению деревни смурфиков – в ваших снах.</p>
                    <div class="game-price">
                        <span class="current-price">1 499 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 15 -->
            <div class="game-card" style="--order: 3">
                <div class="game-image-container">
                    <img src="img/Looney Tunes Wacky World of Sports.jpg" alt="Looney Tunes: Wacky World of Sports" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Looney Tunes: Wacky World of Sports</h3>
                    <p class="game-genre">Баскетбол, футбол, гольф и теннис, объединенные в одну спортивную игру.</p>
                    <div class="game-price">
                        <span class="current-price">1 499 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 16 -->
            <div class="game-card" style="--order: 4">
                <div class="game-image-container">
                    <img src="img/Creatures of Ava.jpg" alt="Creatures of Ava" class="game-image">
                    <span class="game-badge">12+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Creatures of Ava</h3>
                    <p class="game-genre">Продемонстрируйте всю свою эмпатию в этой увлекательной игре.</p>
                    <div class="game-price">
                        <span class="current-price">1 050 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 17 -->
            <div class="game-card" style="--order: 5">
                <div class="game-image-container">
                    <img src="img/Boti Byteland Overclocked.jpg" alt="Boti: Byteland Overclocked" class="game-image">
                     <span class="game-badge">12+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Boti: Byteland Overclocked</h3>
                    <p class="game-genre">Прыгай, рывок, скользи! Погрузитесь в классический 3D-платформер с Boti</p>
                    <div class="game-price">
                        <span class="current-price">999 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
            
            <!-- Игра 18 -->
            <div class="game-card" style="--order: 6">
                <div class="game-image-container">
                    <img src="img/Orcs Must Die.jpg" alt="Orcs Must Die! 3" class="game-image">
                    <span class="game-badge">16+</span>
                </div>
                <div class="game-content">
                    <h3 class="game-title">Orcs Must Die! 3</h3>
                    <p class="game-genre">Потрошите огромные орды отвратительных орков.</p>
                    <div class="game-price">
                        <span class="current-price">899 ₽</span>
                    </div>
                    <button class="buy-btn">Купить</button>
                </div>
            </div>
        </div>
        <div class="pagination">
            <button class="page-btn">1</a></button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">5</button>
            <button class="page-btn">></button>
        </div>
        <footer>
           <div class="social-links">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-discord"></i></a>
            </div>
            <p>© 2025 GM.</p>
        </footer>
    </div>

    <script>
        // Обработчик кнопок "Купить"
        document.querySelectorAll('.buy-btn').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                if (!<?= $isLoggedIn ? 'true' : 'false' ?>) {
                    alert('Для покупки игр необходимо войти в систему');
                    window.location.href = 'regist.php';
                    return;
                }

                const gameCard = this.closest('.game-card');
                const gameTitle = gameCard.querySelector('.game-title').textContent;
                const gamePrice = gameCard.querySelector('.current-price').textContent;
                const gameImage = gameCard.querySelector('.game-image').src;
                
                try {
                    const response = await fetch('process_purchase.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            game_title: gameTitle,
                            game_price: gamePrice,
                            game_image: gameImage
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Игра "' + gameTitle + '" успешно добавлена в вашу коллекцию!');
                    } else {
                        alert('Ошибка: ' + result.message);
                    }
                } catch (error) {
                    alert('Ошибка соединения с сервером');
                    console.error('Ошибка:', error);
                }
            });
        });
    </script>
</body>
</html>

