<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

$user = App\Models\User::where('email', 'manager@example.com')->first();

echo "TOKEN:\n";
print_r($user);
