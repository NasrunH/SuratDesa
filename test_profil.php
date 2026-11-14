<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

view()->share('errors', new \Illuminate\Support\ViewErrorBag);

$users = Penduduk::all();
echo "Found " . $users->count() . " users.\n";

foreach (['warga', 'staff', 'kades'] as $role) {
    $u = Penduduk::where('role', $role)->first();
    if (!$u) {
        echo "No user for role $role\n";
        continue;
    }
    echo "Testing role: $role (Name: {$u->nama}, ID: {$u->id_penduduk})\n";
    Auth::login($u);
    try {
        $controller = new ProfileController();
        $response = $controller->show();
        $view = $response->render();
        echo "  [OK] Rendered successfully (" . strlen($view) . " bytes)\n";
    } catch (\Throwable $e) {
        echo "  [FAIL] " . get_class($e) . ": " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}
