<?php
echo '<link rel="stylesheet" href="../assets/css/domain_card.css">';

function renderDomainCard($domainData) {

    $baseDomain = explode('.', $domainData[0]['domain'])[0];
    ?>
    <div class="domain-card">
        <div class="domain-title">
            <h2>
                <?php echo htmlspecialchars($baseDomain); ?>
            
                <select class="domain-dropdown" id="domain-extension">
                    <?php
                    foreach ($domainData as $domain) {
                        $extension = $domain['domain'];
                        $extensionParts = explode('.', $extension);
                        $ext = $extensionParts[1];
                        $price = isset($domain['price']['product']['price']) ? $domain['price']['product']['price'] : 'N/A';
                        $status = $domain['status'];
                        echo "<option value='{$ext}' data-price='{$price}' data-status='{$status}'>.{$ext}</option>";
                    }
                    ?>
                </select>
            </h2>
        </div>

        <div class="domain-information">
            <p id="domain-price">Price: N/A</p>

            <div id="add-to-cart">
                <button class="link-button" style="color:black;" disabled>Add to Cart</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('domain-extension').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            var status = selectedOption.getAttribute('data-status');

            document.getElementById('domain-price').innerText = 'Price: ' + price;

            var addToCartButton = document.getElementById('add-to-cart');

            if (status === 'free') {
                addToCartButton.innerHTML = '<button class="link-button" style="color:black;">Add to Cart</button>';
            } else {
                addToCartButton.innerHTML = '<p>Unavailable</p>';
            }
        });

        document.getElementById('domain-extension').dispatchEvent(new Event('change'));
    </script>
<?php
}
?>
