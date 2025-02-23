<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $username = $_POST["username"] ?? "";
    $apiKey = $_POST["apiKey"] ?? "";
    $testMode = isset($_POST["test-mode"]) ? 1 : 0;

    // Encrypt the API key
    $apiKey = Crypt::encode($apiKey, Config::get("crypt/system"));

    // Save the settings
    $config = [
        "meta" => [
            "name" => "Wakusell",
            "version" => "1.0",
            "logo" => "logo.png"
        ],
        "settings" => [
            "username" => $username,
            "apiKey" => $apiKey,
            "test-mode" => $testMode,
            "whidden-amount" => 0,
            "whidden-currency" => 4,
            "adp" => 0,
            "cost-currency" => 4
        ]
    ];

    // Save the config to the database or file
    Modules::SaveConfig("Registrars", "Wakusell", $config);

    // Redirect back to the settings page with a success message
    header("Location: /admin/module/registrars?mainTab=all&module=Wakusell&message=Settings+saved+successfully");
    exit;
}