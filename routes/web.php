<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FinancialReportController;
use App\Mail\TenantCredentialsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
    
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');

    Route::get('/financial-report', [FinancialReportController::class, 'index'])->name('financial-report.index');
    
    Route::get('/email-preview', function () {
        $email = 'e.luis.pelaez@gmail.com';
        $password = 'pelaez20251005';

        $token = \Illuminate\Support\Str::random(40);
        \Illuminate\Support\Facades\Cache::put('direct_login_' . $token, [
            'email' => $email,
        ], now()->addMinutes(30));

        $loginUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute('direct-login', now()->addMinutes(30), [
            'token' => $token,
        ]);
        
        return view('emails.tenant-credentials', [
            'tenantName' => 'Luis Pelaez',
            'email' => $email,
            'password' => $password,
            'loginUrl' => $loginUrl
        ]);
    })->name('email.preview');
});

Route::get('/direct-login/{token}', function ($token) {

    if (!request()->hasValidSignature()) {
        abort(403, 'Invalid or expired link');
    }
    
    $cacheKey = 'direct_login_' . $token;
    $payload = \Illuminate\Support\Facades\Cache::pull($cacheKey);

    if (!$payload || empty($payload['email'])) {
        abort(403, 'Invalid or used link');
    }

    $user = User::where('email', $payload['email'])->first();
    if (!$user) {
        abort(404);
    }

    Auth::login($user);
    
    return redirect()->route('dashboard')->with('success', 'Welcome! You have been automatically logged in.');
})->name('direct-login');

require __DIR__.'/auth.php';
