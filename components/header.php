<?php

function renderHeader() {
    ?>
    <div class="header">
        <a href="/dotdealers-php">DOT•DEALERS</a>

        <form action="" method="GET" class="search-container">
            <input type="text" placeholder="Enter URL without extension" name="url-search" required>
            <button type="submit" class="link-button" style="color: black;">Check URL</button>
        </form>
        
        <div class="header-icon">
            <a href="shopping_cart.php" class="link-button" style="font-size:1rem;">Shopping Cart</a>
        </div>
    </div>
    <?php
}

?>
