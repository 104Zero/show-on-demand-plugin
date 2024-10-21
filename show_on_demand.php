<?php
include_once "/opt/fpp/www/common.php"; // Allows use of FPP Functions
$pluginName = basename(dirname(__FILE__));
$pluginConfigFile = $settings['configDirectory'] . "/plugin." . $pluginName; // Gets path to configuration files for plugin


if (file_exists($pluginConfigFile)) {
    $pluginSettings = parse_ini_file($pluginConfigFile, false, INI_SCANNER_TYPED); // Added INI_SCANNER_TYPED to parse with type handling
}

$madeChange = false;

// Ensure $pluginSettings array exists and check if settings are not set or empty
if (empty($pluginSettings['show_on_demand_enabled'])) {
    WriteSettingToFile("show_on_demand_enabled", urlencode("false"), $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['on_demand_playlist'])) {
    WriteSettingToFile("on_demand_playlist", "", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['main_playlist'])) {
    WriteSettingToFile("main_playlist", "", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['voipms_api_username'])) {
    WriteSettingToFile("voipms_api_username", "", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['voipms_api_password'])) {
    WriteSettingToFile("voipms_api_password", "", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['start_command'])) {
    WriteSettingToFile("start_command", "START", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['message_success'])) {
    WriteSettingToFile("message_success", "Message received. The show will begin momentarily.", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['message_not_started'])) {
    WriteSettingToFile("message_not_started", "Sorry, the show cannot be started right now.", $pluginName);
    $madeChange = true;
}

if (empty($pluginSettings['random_playlist_item'])) {
    WriteSettingToFile("random_playlist_item", urlencode("false"), $pluginName);
    $madeChange = true;
}

if ($madeChange) {
    $pluginSettings = parse_ini_file($pluginConfigFile, false, INI_SCANNER_TYPED); // Re-read config after changes
}

$playlists = [];
if (is_dir($playlistDirectory)) {
    foreach (scandir($playlistDirectory) as $pFile) {
        if ($pFile != "." && $pFile != ".." && preg_match('/\.json$/', $pFile)) {
            $pFile = preg_replace('/\.json$/', '', $pFile);
            $playlists[$pFile] = $pFile;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="pluginBody" style="margin-left: 1em;">
    <div class="title">
        <h1>Show On Demand</h1>
        <h4></h4>
    </div>

<p>Press F1 for setup instructions</p>
<table cellspacing="5">
<tr>
    <th style="text-align: left">Enable Show On Demand</th>
    <td>
    <?php
        PrintSettingCheckbox("Show On Demand", "show_on_demand_enabled", 1, 0, "true", "false", $pluginName, "", 0, "", []);
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Voip.ms API Username</th>
    <td>
    <?php
        PrintSettingTextSaved("voipms_api_username", 1, 0, 32, 32, $pluginName, "");
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Voip.ms API Password</th>
    <td>
    <?php
        PrintSettingPasswordSaved("voipms_api_password", 1, 0, 50, 32, $pluginName, "");
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Start Command</th>
    <td>
    <?php
        PrintSettingTextSaved("start_command", 1, 0, 32, 32, $pluginName, "");
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Success Message</th>
    <td>
    <?php
        PrintSettingTextSaved("message_success", 1, 0, 160, 100, $pluginName, "");
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Not started message</th>
    <td>
    <?php
        PrintSettingTextSaved("message_not_started", 1, 0, 160, 100, $pluginName, "");
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">On-Demand Playlist</th>
    <td>
    <?php
        PrintSettingSelect("On-Demand Playlist", "on_demand_playlist", 1, 0, "", $playlists, $pluginName);
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Show Playlist</th>
    <td>
    <?php
        PrintSettingSelect("Show Playlist", "main_playlist", 1, 0, "", $playlists, $pluginName);
    ?>
    </td>
</tr>

<tr>
    <th style="text-align: left">Select Random Item from Playlist</th>
    <td>
    <?php
        PrintSettingCheckbox("Randomize Single Playlist Item", "random_playlist_item", 1, 0, "true", "false", $pluginName, "", 0, "", []);
    ?>
    </td>
</tr>

</table>
</div>
</body>
</html>
