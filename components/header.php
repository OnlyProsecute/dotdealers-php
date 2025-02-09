<?php
function renderHeader() {
    $currentPage = basename($_SERVER['PHP_SELF']); 
    $isCartPage = $currentPage === 'shopping_cart.php'; 
    ?>
    <div class="header">
        <a href="/dotdealers-php">DOT•DEALERS</a>
        
        <form action="<?php echo ($currentPage !== 'domains.php' ? 'domains.php' : '#'); ?>" method="GET" class="search-container">
            <input class="input-field" type="text" placeholder="Enter URL without extension" name="url-search" required>
            <button type="submit" class="link-button" style="color: black;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        
        <div class="header-icon">
            <div class="dropdown">
                <button class="dropdown-button"><?php echo $_SESSION['username']; ?></button>
                <div class="dropdown-content">
                    <?php if ($isCartPage): ?>
                        <ul>
                            <li><a href="domains.php">Search Domains</a></li>
                        </ul>
                    <?php else: ?>
                        <ul>
                            <li><a href="shopping_cart.php">View Cart</a></li>
                        </ul>
                    <?php endif; ?>
                    <ul>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
