<?php
// CLI seed: php database/seed_admin.php
$app = require __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Models\User;

$config = $app['config'];
$pdo = Database::connection($config['db']);
if (!$pdo) {
    fwrite(STDERR, "DB connection failed. Check config env.\n");
    exit(1);
}

$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.com';
$adminPass = getenv('ADMIN_PASSWORD') ?: 'admin1234';
$adminName = getenv('ADMIN_NAME') ?: 'Administrator';

$existing = User::findByEmail($pdo, $adminEmail);
if ($existing) {
    echo "Admin already exists: {$adminEmail}\n";
    exit(0);
}

User::create($pdo, $adminName, $adminEmail, $adminPass, 'admin');
echo "Admin created: {$adminEmail} / {$adminPass}\n";
