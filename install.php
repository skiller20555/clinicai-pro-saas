<?php

/**
 * ClinicAI Pro SaaS - cPanel Installation Script
 *
 * This script guides the installation of ClinicAI Pro on cPanel-based hosting.
 * Run this script from your browser after uploading all files.
 *
 * Requirements:
 * - PHP 8.2+
 * - MySQL 8.0+
 * - Apache with mod_rewrite
 * - cPanel access
 */

session_start();

if (!function_exists('is_cli')) {
    function is_cli() {
        return php_sapi_name() === 'cli';
    }
}

if (is_cli()) {
    die("This installation script must be run via a web browser.\n");
}

$config = [
    'app_name' => 'ClinicAI Pro SaaS',
    'min_php' => '8.2.0',
    'min_mysql' => '8.0.0',
];

$step = $_GET['step'] ?? 1;
$errors = [];
$success = [];
$warnings = [];

// Step 1: Environment Check
if ($step == 1) {
    $php_version = phpversion();
    $php_ok = version_compare($php_version, $config['min_php'], '>=');

    $mysql_ok = extension_loaded('mysqli') || extension_loaded('pdo_mysql');

    $extensions_required = [
        'json' => extension_loaded('json'),
        'mbstring' => extension_loaded('mbstring'),
        'openssl' => extension_loaded('openssl'),
        'pdo' => extension_loaded('pdo'),
        'curl' => extension_loaded('curl'),
        'gd' => extension_loaded('gd'),
    ];

    $writable_dirs = [
        'storage' => is_writable(__DIR__ . '/backend/storage'),
        'bootstrap/cache' => is_writable(__DIR__ . '/backend/bootstrap/cache'),
    ];

    if (!$php_ok) {
        $errors[] = "PHP version {$php_version} is below minimum required {$config['min_php']}";
    } else {
        $success[] = "PHP version {$php_version} is compatible";
    }

    if (!$mysql_ok) {
        $errors[] = "MySQL/MySQLi extension not loaded";
    } else {
        $success[] = "MySQL extension detected";
    }

    foreach ($extensions_required as $ext => $loaded) {
        if (!$loaded) {
            $warnings[] = "Extension '{$ext}' is not loaded";
        } else {
            $success[] = "Extension '{$ext}' is loaded";
        }
    }

    foreach ($writable_dirs as $dir => $writable) {
        if (!$writable) {
            $errors[] = "Directory '{$dir}' is not writable. Run: chmod -R 775 backend/{$dir}";
        } else {
            $success[] = "Directory '{$dir}' is writable";
        }
    }
}

// Step 2: Database Configuration
if ($step == 2 && $_POST) {
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';

    if (!$db_host || !$db_name || !$db_user) {
        $errors[] = "Database credentials are required";
    } else {
        try {
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            if ($conn->connect_error) {
                $errors[] = "Database connection failed: " . $conn->connect_error;
            } else {
                $success[] = "Database connection successful";
                $_SESSION['db_config'] = [
                    'host' => $db_host,
                    'name' => $db_name,
                    'user' => $db_user,
                    'pass' => $db_pass,
                ];
                $conn->close();
            }
        } catch (Exception $e) {
            $errors[] = "Database connection error: " . $e->getMessage();
        }
    }
}

// Step 3: Application Configuration
if ($step == 3 && $_POST) {
    $app_url = $_POST['app_url'] ?? '';
    $app_key = $_POST['app_key'] ?? bin2hex(random_bytes(32));
    $admin_name = $_POST['admin_name'] ?? '';
    $admin_email = $_POST['admin_email'] ?? '';
    $admin_password = $_POST['admin_password'] ?? '';

    if (!$app_url || !$admin_name || !$admin_email || !$admin_password) {
        $errors[] = "Application configuration is incomplete";
    } else {
        $_SESSION['app_config'] = [
            'url' => $app_url,
            'key' => $app_key,
            'admin_name' => $admin_name,
            'admin_email' => $admin_email,
            'admin_password' => $admin_password,
        ];
        $success[] = "Application configuration saved";
    }
}

// Step 4: Environment File Creation
if ($step == 4 && $_POST) {
    if (!isset($_SESSION['db_config']) || !isset($_SESSION['app_config'])) {
        $errors[] = "Configuration data missing. Please complete steps 2 and 3.";
    } else {
        $db = $_SESSION['db_config'];
        $app = $_SESSION['app_config'];

        $env_content = "APP_NAME=\"ClinicAI Pro SaaS\"\n";
        $env_content .= "APP_ENV=production\n";
        $env_content .= "APP_DEBUG=false\n";
        $env_content .= "APP_URL={$app['url']}\n";
        $env_content .= "APP_KEY=base64:" . base64_encode($app['key']) . "\n\n";
        $env_content .= "DB_CONNECTION=mysql\n";
        $env_content .= "DB_HOST={$db['host']}\n";
        $env_content .= "DB_PORT=3306\n";
        $env_content .= "DB_DATABASE={$db['name']}\n";
        $env_content .= "DB_USERNAME={$db['user']}\n";
        $env_content .= "DB_PASSWORD={$db['pass']}\n\n";
        $env_content .= "CACHE_DRIVER=file\n";
        $env_content .= "SESSION_DRIVER=file\n";
        $env_content .= "QUEUE_CONNECTION=database\n\n";
        $env_content .= "MAIL_MAILER=sendmail\n";
        $env_content .= "MAIL_FROM_ADDRESS={$app['admin_email']}\n";
        $env_content .= "MAIL_FROM_NAME=\"ClinicAI Pro SaaS\"\n\n";
        $env_content .= "SANCTUM_STATEFUL_DOMAINS=" . parse_url($app['url'], PHP_URL_HOST) . "\n";
        $env_content .= "AI_API_URL=\n";
        $env_content .= "AI_API_TOKEN=\n";
        $env_content .= "AI_MODEL=gpt-4o-mini\n";
        $env_content .= "AI_REVIEW_REQUIRED=true\n";

        $env_file = __DIR__ . '/backend/.env';
        if (file_put_contents($env_file, $env_content)) {
            $success[] = ".env file created successfully";
            $_SESSION['env_created'] = true;
        } else {
            $errors[] = "Failed to create .env file. Check directory permissions.";
        }
    }
}

// Step 5: Database Migrations
if ($step == 5 && $_POST) {
    if (!isset($_SESSION['env_created'])) {
        $errors[] = ".env file not created yet";
    } else {
        $success[] = "Ready to run migrations. Execute this command via SSH or cPanel terminal:";
        $success[] = "cd " . __DIR__ . "/backend && php artisan migrate --force";
    }
}

// Step 6: Final Setup
if ($step == 6 && $_POST) {
    $setup_complete = true;
    $success[] = "Installation complete! Your ClinicAI Pro SaaS is ready.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicAI Pro SaaS - Installation Wizard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 { font-size: 32px; margin-bottom: 10px; }
        .header p { font-size: 16px; opacity: 0.9; }
        .content {
            padding: 40px;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 10px;
        }
        .step-badge {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            background: #f0f0f0;
            color: #666;
            font-weight: 500;
            position: relative;
        }
        .step-badge.active {
            background: #667eea;
            color: white;
        }
        .step-badge.completed {
            background: #10b981;
            color: white;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-top: 30px;
        }
        button {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
            flex: 1;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #333;
        }
        .btn-secondary:hover {
            background: #d1d5db;
        }
        .code-block {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 15px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 ClinicAI Pro SaaS</h1>
            <p>Installation Wizard for cPanel Hosting</p>
        </div>

        <div class="content">
            <div class="step-indicator">
                <div class="step-badge <?php echo $step >= 1 ? 'active' : ''; ?>">1. Check</div>
                <div class="step-badge <?php echo $step >= 2 ? 'active' : ''; ?>">2. Database</div>
                <div class="step-badge <?php echo $step >= 3 ? 'active' : ''; ?>">3. App</div>
                <div class="step-badge <?php echo $step >= 4 ? 'active' : ''; ?>">4. Config</div>
                <div class="step-badge <?php echo $step >= 5 ? 'active' : ''; ?>">5. Migrate</div>
                <div class="step-badge <?php echo $step >= 6 ? 'active' : ''; ?>">6. Done</div>
            </div>

            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="alert alert-error">
                        <span>❌</span>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($warnings)): ?>
                <?php foreach ($warnings as $warning): ?>
                    <div class="alert alert-warning">
                        <span>⚠️</span>
                        <span><?php echo htmlspecialchars($warning); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <?php foreach ($success as $msg): ?>
                    <div class="alert alert-success">
                        <span>✅</span>
                        <span><?php echo htmlspecialchars($msg); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Step 1: Environment Check -->
            <?php if ($step == 1): ?>
                <h2>System Requirements Check</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Verifying your server meets the minimum requirements for ClinicAI Pro SaaS.</p>
                <form method="GET">
                    <input type="hidden" name="step" value="2">
                    <div class="button-group">
                        <button type="submit" class="btn-primary" <?php echo empty($errors) ? '' : 'disabled'; ?>>Continue to Step 2 →</button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Step 2: Database Configuration -->
            <?php if ($step == 2): ?>
                <h2>Database Configuration</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Enter your MySQL database details from cPanel.</p>
                <form method="POST" action="?step=2">
                    <div class="form-group">
                        <label for="db_host">Database Host</label>
                        <input type="text" id="db_host" name="db_host" placeholder="127.0.0.1 or localhost" value="<?php echo $_POST['db_host'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="db_name">Database Name</label>
                        <input type="text" id="db_name" name="db_name" placeholder="username_clinicai" value="<?php echo $_POST['db_name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="db_user">Database User</label>
                        <input type="text" id="db_user" name="db_user" placeholder="username_dbuser" value="<?php echo $_POST['db_user'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="db_pass">Database Password</label>
                        <input type="password" id="db_pass" name="db_pass" placeholder="Your database password">
                    </div>
                    <div class="button-group">
                        <button type="button" class="btn-secondary" onclick="window.location='?step=1'">← Back</button>
                        <button type="submit" class="btn-primary">Test & Continue →</button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Step 3: Application Configuration -->
            <?php if ($step == 3): ?>
                <h2>Application Configuration</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Configure your ClinicAI Pro SaaS application.</p>
                <form method="POST" action="?step=3">
                    <div class="form-group">
                        <label for="app_url">Application URL</label>
                        <input type="url" id="app_url" name="app_url" placeholder="https://yourdomain.com" value="<?php echo $_POST['app_url'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="admin_name">Administrator Name</label>
                        <input type="text" id="admin_name" name="admin_name" placeholder="John Doe" value="<?php echo $_POST['admin_name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="admin_email">Administrator Email</label>
                        <input type="email" id="admin_email" name="admin_email" placeholder="admin@yourdomain.com" value="<?php echo $_POST['admin_email'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="admin_password">Administrator Password</label>
                        <input type="password" id="admin_password" name="admin_password" placeholder="Strong password (min 8 characters)" required>
                    </div>
                    <div class="button-group">
                        <button type="button" class="btn-secondary" onclick="window.location='?step=2'">← Back</button>
                        <button type="submit" class="btn-primary">Continue →</button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Step 4: Environment File Creation -->
            <?php if ($step == 4): ?>
                <h2>Create Environment File</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Your .env configuration file is being created.</p>
                <form method="POST" action="?step=4">
                    <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px;">Create .env File →</button>
                </form>
            <?php endif; ?>

            <!-- Step 5: Database Migrations -->
            <?php if ($step == 5): ?>
                <h2>Database Setup</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Run the following command via SSH or cPanel Terminal:</p>
                <div class="code-block">cd <?php echo __DIR__; ?>/backend && php artisan migrate --force</div>
                <p style="color: #666; margin-top: 15px; margin-bottom: 15px;">After running the command, click Continue below.</p>
                <form method="POST" action="?step=5">
                    <div class="button-group">
                        <button type="button" class="btn-secondary" onclick="window.location='?step=4'">← Back</button>
                        <button type="submit" class="btn-primary">Continue to Completion →</button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Step 6: Completion -->
            <?php if ($step == 6): ?>
                <h2>Installation Complete! 🎉</h2>
                <p style="color: #666; margin-top: 10px; margin-bottom: 20px;">Your ClinicAI Pro SaaS is now ready to use.</p>
                <div class="code-block" style="margin-bottom: 20px;">
                    <strong>Next Steps:</strong><br><br>
                    1. Delete this install.php file for security<br>
                    2. Visit your application URL<br>
                    3. Login with your admin credentials<br>
                    4. Set up your first clinic<br>
                    5. Configure cron jobs in cPanel (see docs)
                </div>
                <a href="../" style="display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;" target="_blank">Visit Your Application →</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
