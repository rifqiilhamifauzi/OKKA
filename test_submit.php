<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/registration/store', 'POST', [
    'event_id' => 1,
    'full_name' => 'Rifqi Ilhami',
    'identity_number' => '1237050121',
    'gender' => 'L',
    'birth_place' => 'ciamis',
    'birth_date' => '2026-07-29',
    'phone' => '082129130616',
    'scout_status' => false
]);
$response = $kernel->handle($request);
echo 'STATUS: ' . $response->getStatusCode() . "\n";
echo 'CONTENT: ' . $response->getContent() . "\n";
echo 'SESSION: ' . json_encode(session()->all()) . "\n";
