<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$tables = Schema::getTables();
$schema = [];

foreach ($tables as $tableInfo) {
    $table = $tableInfo['name'];
    if (in_array($table, ['migrations', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'])) continue;
    
    $columns = Schema::getColumns($table);
    $columnNames = array_map(function($c) { return $c['name']; }, $columns);
    $schema[$table] = $columnNames;
}

$modelsDir = __DIR__ . '/app/Models';
$models = [];
foreach (glob($modelsDir . '/*.php') as $file) {
    $className = 'App\\Models\\' . basename($file, '.php');
    if (class_exists($className)) {
        $model = new $className;
        $models[$className] = [
            'table' => $model->getTable(),
            'fillable' => $model->getFillable(),
        ];
    }
}

$output = [
    'schema' => $schema,
    'models' => $models,
];

file_put_contents('db_audit.json', json_encode($output, JSON_PRETTY_PRINT));
echo "Done.\n";
