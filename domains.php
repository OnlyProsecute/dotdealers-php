<?php
session_start();

include('components/domain_card.php');
include('components/custom_button.php');

$domains = [
    ['name' => 'example1.com', 'price' => '$10', 'status' => 'free'],
    ['name' => 'example2.com', 'price' => '$20', 'status' => 'unavailable'],
    ['name' => 'example3.com', 'price' => '$15', 'status' => 'free'],
];

echo "<h1>Domains</h1>";

foreach ($domains as $domain) {
    renderDomainCard($domain);
}
?>
