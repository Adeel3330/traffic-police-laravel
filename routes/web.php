<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Jobs\ProcessPendingFiles;
use App\Http\Controllers\StorageController;

Route::get('/upload', [StorageController::class, 'index'])->name('storage.index');
Route::post('/storage/upload', [StorageController::class, 'upload'])->name('storage.upload');

Route::get('/verify-license', [LicenseController::class, 'index'])->name('license.form');
Route::post('/verify-license', [LicenseController::class, 'verify'])->name('license.verify');

Route::get('/VerifyLicense', [LicenseController::class, 'index'])->name('license.Verify');
Route::get('/public/VerifyLicense', [LicenseController::class, 'index'])->name('VerifyLicense.index');


Route::get('/', function () {
    return view('home');
});

Route::get('/test-job', function () {
    ProcessPendingFiles::dispatch();
    return "ProcessPendingFiles job dispatched!";
});

Route::get('/run-artisan/{command}', function ($command) {
    // Run the artisan migrate command
    $exitCode = Artisan::call($command);

    // Get output
    $output = Artisan::output();

    return "<pre>Exit Code: $exitCode\n$output</pre>";
});
