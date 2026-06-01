<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userClass = 'App\\Models\\User';
$requestClass = 'Illuminate\\Http\\Request';

$user = $userClass::where('email', 'manager@example.com')->first();
if (! $user) {
    echo "NO_MANAGER\n";
    exit(1);
}

$token = $user->createToken('test')->plainTextToken;
$request = $requestClass::create(
    '/api/v1/inventory/movements',
    'POST',
    ['product_id' => 1, 'type' => 'purchase', 'quantity' => 2, 'unit_cost' => 12.00, 'note' => 'manager purchase'],
    [],
    [],
    ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
);

$response = app('router')->dispatch($request);
echo "Inventory movements response: " . $response->getStatusCode() . "\n";
echo $response->getContent() . "\n\n";

$unauthRequest = $requestClass::create('/api/v1/reports/most-sold', 'GET');
$unauthResponse = app('router')->dispatch($unauthRequest);
echo "Reports no auth response: " . $unauthResponse->getStatusCode() . "\n";
echo $unauthResponse->getContent() . "\n";

