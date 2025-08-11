<?php
// CLI migrate: php database/migrate.php
$app = require __DIR__ . '/../bootstrap.php';

use App\Core\Database;

$config = $app['config'];
$pdo = Database::connection($config['db']);
if (!$pdo) {
    fwrite(STDERR, "DB connection failed. Check config env.\n");
    exit(1);
}

$schemaFile = __DIR__ . '/schema.sql';
if (!file_exists($schemaFile)) {
    fwrite(STDERR, "schema.sql not found.\n");
    exit(1);
}

$sql = file_get_contents($schemaFile);
// Split on semicolons not within strings (simple approach for our schema)
$statements = array_filter(array_map('trim', explode(';', $sql)));

try {
    $pdo->beginTransaction();
    foreach ($statements as $statement) {
        if ($statement === '' || strpos($statement, '--') === 0) { continue; }
        $pdo->exec($statement);
    }
    $pdo->commit();
    echo "Migration completed.\n";
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, "Migration error: " . $e->getMessage() . "\n");
    exit(1);
}
