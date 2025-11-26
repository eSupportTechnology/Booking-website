<?php

use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$columns = ['adult_price', 'child_price', 'commission_rate'];
$missing = [];

foreach ($columns as $column) {
    if (!Schema::hasColumn('properties', $column)) {
        $missing[] = $column;
    }
}

if (empty($missing)) {
    echo "COLUMNS_EXIST";
} else {
    echo "MISSING_COLUMNS: " . implode(', ', $missing);
}
