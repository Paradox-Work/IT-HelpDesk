<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;


// Public routes
Route::get('/', function () {
    return view('home');
});


// Protected routes (logged in users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // ===== ADD THESE TICKET ROUTES =====
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/replies', [TicketController::class, 'storeReply'])->name('tickets.replies.store');
    Route::get('/tickets/{ticket}/replies', [TicketController::class, 'pollReplies'])->name('tickets.replies.poll');
    // This creates all these routes automatically:
    // GET    /tickets          → tickets.index
    // GET    /tickets/create   → tickets.create  
    // POST   /tickets          → tickets.store
    // GET    /tickets/{ticket} → tickets.show
    // GET    /tickets/{ticket}/edit → tickets.edit
    // PUT    /tickets/{ticket} → tickets.update
    // DELETE /tickets/{ticket} → tickets.destroy
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; // Breeze auth routes
