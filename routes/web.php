<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FinancialReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantCredentialsMail;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    // Temporary maintenance request endpoint (mock wiring)
    Route::post('/maintenance-requests', function () {
        request()->validate([
            'type' => 'required|string|max:255',
            'preferred_time' => 'nullable|string|max:255',
            'description' => 'required|string|max:2000',
        ]);
        return redirect()->route('dashboard')->with('success', 'Maintenance request submitted!');
    })->name('maintenance-requests.store');

    // email test: visiting this link immediately sends a test email
    // Route::get('/test-email', function () {
    //     $name = 'Design Tester';
    //     $email = 'e.luis.pelaez@gmail.com';
    //     $password = 'pelaez20251005';

    //     Mail::to($email)->send(new TenantCredentialsMail($name, $email, $password));

    //     return 'Test email sent to ' . $email;
    // })->name('mail.test');
    
    // one-time login route
    Route::get('/direct-login', function () {
        request()->validate(['token' => 'required']);
        if (! request()->hasValidSignature()) {
            abort(403);
        }

        $token = request('token');
        $payload = Cache::pull('direct_login_' . $token);
        if (! $payload || empty($payload['email'])) {
            abort(403);
        }

        $user = User::where('email', $payload['email'])->first();
        if (! $user) {
            abort(404);
        }

        Auth::login($user, false);
        return redirect()->route('dashboard');
    })->name('direct-login');

});

require __DIR__.'/auth.php';
