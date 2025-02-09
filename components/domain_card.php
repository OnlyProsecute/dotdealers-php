<?php


    echo '<link rel="stylesheet" href="../assets/css/domain_card.css>">';

    function renderDomainCard($domain) {
        ?>
        <div class="domain-card">
            <div class="domain-title">
                <h2><?php echo htmlspecialchars($domain['name']); ?></h2>
            </div>

            <div class="domain-information">
                <p><?php echo htmlspecialchars($domain['price']); ?></p>
                <?php if ($domain['status'] == 'free'): ?>
                    <?php echo renderCustomButton('Add to cart'); ?>
                <?php else: ?>
                    <p>Unavailable</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
?>
