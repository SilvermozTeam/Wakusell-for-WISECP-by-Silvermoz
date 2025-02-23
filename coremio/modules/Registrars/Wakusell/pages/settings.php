<?php

// Ensure $config and $lang variables are defined
$config = $config ?? [];
$lang = $lang ?? [];

?>

<div class="form-group">
    <label><?= $lang["fields"]["username"] ?? "Username" ?></label>
    <input type="text" name="username" value="<?= $config["settings"]["username"] ?? "" ?>" class="form-control">
</div>
<div class="form-group">
    <label><?= $lang["fields"]["apiKey"] ?? "API Key" ?></label>
    <input type="password" name="apiKey" value="<?= Crypt::decode($config["settings"]["apiKey"] ?? "", Config::get("crypt/system")) ?>" class="form-control">
</div>
<div class="form-group">
    <label><?= $lang["fields"]["test-mode"] ?? "Sandbox / Test Mode" ?></label>
    <input type="checkbox" name="test-mode" <?= isset($config["settings"]["test-mode"]) && $config["settings"]["test-mode"] ? 'checked' : '' ?>>
</div>

<!-- Add the Save button -->
<div class="form-group">
    <button type="submit" name="save-settings" class="btn btn-primary">
        <?= $lang["save-button"] ?? "Save Settings" ?>
    </button>
</div>

<!-- Add the Test Connection button -->
<div class="form-group">
    <button type="submit" name="test-connection" class="btn btn-success">
        <?= $lang["test-button"] ?? "Test Connection" ?>
    </button>
</div>