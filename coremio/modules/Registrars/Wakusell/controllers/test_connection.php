<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the saved settings
    $config = Modules::Config("Registrars", "Wakusell");

    // Initialize the Wakusell API
    if (!class_exists("Wakusell_API")) {
        include __DIR__ . DS . ".." . DS . "api.php";
    }

    $api = new Wakusell_API($config);

    // Test the connection by fetching the credit balance
    $creditBalance = $api->getCreditBalance();

    if ($creditBalance !== false) {
        // Connection successful
        $message = "Connection successful. Your credit balance is: " . $creditBalance;
    } else {
        // Connection failed
        $message = "Connection failed. Please check your API credentials.";
    }

    // Redirect back to the settings page with the result
    header("Location: /admin/module/registrars?mainTab=all&module=Wakusell&message=" . urlencode($message));
    exit;
}