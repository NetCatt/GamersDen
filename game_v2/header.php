<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store</title>
    <link rel="icon" type="image/jpg" sizes="192x192" href="image/geto.jpg">
    <link rel="stylesheet" href="css\style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="nav container">
            <a href="index.php" class="logo">GamersDen</a>
            <ul class="nav">
                <?php if(!isset($isHomePage)): ?>
                <li><a href="index.php">Home</a></li>
                <?php endif; ?>
                <li><a href="gamelibrary.php">Games</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Categories</a>
                    <div class="dropdown-content">
                        <a href="gamelibrary.php?category=RPG">RPG</a>
                        <a href="gamelibrary.php?category=Strategy">Strategy</a>
                        <a href="gamelibrary.php?category=Sports">Sports</a>
                        <a href="gamelibrary.php?category=Simulation">Simulation</a>
                        <a href="gamelibrary.php?category=Battle Royale">Battle Royale</a>
                        <a href="gamelibrary.php?category=First-Person Shooter">First-Person Shooter</a>
                        <a href="gamelibrary.php?category=Sandbox">Sandbox</a>
                        <a href="gamelibrary.php?category=Survival">Survival</a>
                        <a href="gamelibrary.php?category=Racing">Racing</a>
                        <a href="gamelibrary.php?category=Platformer">Platformer</a>
                        <a href="gamelibrary.php?category=Action-Adventure">Action-Adventure</a>
                        <a href="gamelibrary.php?category=Third-Person Shooter">Third-Person Shooter</a>
                        <a href="gamelibrary.php?category=Survival Horror">Survival Horror</a>
                    </div>
                </li>
                <li><a href="about.php">About</a></li>
            </ul>
            <div class="nav-icons">
                <div class="action">
                    <div class="search">
                        <form action="search.php" method="GET">
                            <input type="text" name="query" placeholder="Search games..." required>
                            <button type="submit"><i class='bx bx-search'></i></button>
                        </form>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cart.php"><i class='bx bx-cart-download'></i></a>
                    <a href="wishlist.php"><i class='bx bxs-bookmark-heart'></i></a>
                    <a href="notifications.php"><i class='bx bx-bell' id="bell-icon"><span></span></i></a>
                    <a href="logout.php"><i class='bx bx-log-out'></i></a>
                <?php else: ?>
                    <a href="login.php"><i class='bx bx-log-in'></i></a>
                <?php endif; ?>
                <div class="menu-icon">
                    <div class="togglemenu"></div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>