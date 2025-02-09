<?php
    include('components/domain_card.php');
    include('components/custom_button.php');
    include('components/header.php');

    $searchQuery = isset($_GET['url-search']) ? trim($_GET['url-search']) : null;
    $domainData = null;

    if ($searchQuery) {
        $url = 'https://dev.api.mintycloud.nl/api/v2.1/domains/search?with_price=true';
        $authorizationHeader = 'Authorization: Basic 072dee999ac1a7931c205814c97cb1f4d1261559c0f6cd15f2a7b27701954b8d';
        
        $postData = json_encode([
            ["name" => $searchQuery, "extension" => "nl"],
            ["name" => $searchQuery, "extension" => "com"],
            ["name" => $searchQuery, "extension" => "org"],
            ["name" => $searchQuery, "extension" => "net"],
            ["name" => $searchQuery, "extension" => "eu"],
            ["name" => $searchQuery, "extension" => "de"],
            ["name" => $searchQuery, "extension" => "co.uk"],
            ["name" => $searchQuery, "extension" => "be"],
            ["name" => $searchQuery, "extension" => "fr"],
            ["name" => $searchQuery, "extension" => "it"]
        ]
        );
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            $authorizationHeader
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $domainData = json_decode($response, true);
    }

    echo '<link rel="stylesheet" href="globals.css">';
    echo '<link rel="stylesheet" href="assets/css/domain_card.css">';
    echo '<link rel="stylesheet" href="assets/css/custom_button.css">';
    echo '<link rel="stylesheet" href="assets/css/header.css">';
    echo '<link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&display=swap" rel="stylesheet">';

    renderHeader('DOT•DEALERS');

    if ($domainData) {
        renderDomainCard($domainData);
    }
?>
