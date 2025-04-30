<?php
session_start();

$USERNAME = 'admin'; # Provisioning Server Admin Username
$PASSWORD = 'admin'; # Provisioning Server Admin Password

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $USERNAME || $_SERVER['PHP_AUTH_PW'] !== $PASSWORD) {
    header('WWW-Authenticate: Basic realm="CSP Cisco Provisioning Server"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required';
    exit;
}

$template = file_get_contents(__DIR__ . '/template.xml');

function sanitize_input($input) {
    return htmlspecialchars(trim($input));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mac = strtoupper(sanitize_input($_POST['mac']));
    $label = sanitize_input($_POST['linelabel']);
    $ext = sanitize_input($_POST['ext']);
    $pass = sanitize_input($_POST['extpass']);
    $tz = sanitize_input($_POST['timezone']);
    $load = sanitize_input($_POST['phonemodel']);
    $settingsAccess = sanitize_input($_POST['enable_settings']);
    $voiceAlert = sanitize_input($_POST['lower_voice']);

    $output = str_replace(
        ['(MAC)', 'EXTENPASS', 'EXTEN', 'TIMEZONE', 'LOADS', 'LINELABEL', '<settingsAccess>1</settingsAccess>', '<lowerYourVoiceAlert>1</lowerYourVoiceAlert>'],
        [$mac, $pass, $ext, $tz, $load, $label, "<settingsAccess>$settingsAccess</settingsAccess>", "<lowerYourVoiceAlert>$voiceAlert</lowerYourVoiceAlert>"],
        $template
    );

    $filename = "SEP$mac.cnf.xml";
    file_put_contents(__DIR__ . "/$filename", $output);

    echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>CSP Cisco Provisioning Server</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; padding: 40px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .top-left { position: absolute; top: 20px; left: 20px; font-weight: bold; }
        a.button { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #007BFF; color: white; border-radius: 5px; text-decoration: none; }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="top-left">CSP Cisco Provisioning Server</div>
    <div class="container">
        <h1>File Created: $filename</h1>
        <a href="provision.php" class="button">Create Another</a>
        <a href="logout.php" class="button" style="background:#dc3545;">Logout</a>
    </div>
</body>
</html>
HTML;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSP Cisco Provisioning Server</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; padding: 40px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .top-left { position: absolute; top: 20px; left: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="top-left">CSP Cisco Provisioning Server</div>
    <div class="container">
        <form method="post">
            <label>MAC Address (ALL CAPS)</label>
            <input name="mac" required>

            <label>Line Label</label>
            <input name="linelabel" required>

            <label>Extension Number</label>
            <input name="ext" required>

            <label>Extension Secret</label>
            <input name="extpass" required>

            <label>Timezone</label>
            <input name="timezone" required>

            <label>Phone Model</label>
            <select name="phonemodel" required>
                <option value="sip78xx.14-3-1-0201-246">7800 Series</option>
                <option value="sip88xx.14-3-1-0201-246">8800 Audio</option>
                <option value="sip8845_65.14-3-1-0201-246">8800 Video</option>
            </select>

            <label>Enable Settings?</label>
            <select name="enable_settings" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>

            <label>Enable Lower Your Voice Alerts?</label>
            <select name="lower_voice" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
