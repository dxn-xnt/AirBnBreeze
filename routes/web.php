<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\PropertyCreationController;
use App\Http\Controllers\NotificationController;

// Public Property Views
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/property/', [PropertyController::class, 'show'])->name('property.show');

// Public Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/user/login', [LogInController::class, 'login'])->name('user.login');

    Route::get('/signup', [UserController::class, 'showSignUp'])->name('signup');
    Route::post('/user/create', [UserController::class, 'createUser'])->name('user.create');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::post('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/logout', [LogInController::class, 'logout'])->name('logout');
});

Route::prefix('property/create')->middleware(['auth'])->group(function () {
    Route::get('/starter', [PropertyCreationController::class, 'createProperty_starter'])
        ->name('property.create.starter');

    Route::get('/identify-house', [PropertyCreationController::class, 'createProperty_step1'])
        ->name('property.create');

    Route::post('/identify-house', [PropertyCreationController::class, 'storePropertyType'])
        ->name('property.store.type');

    Route::get('/location', [PropertyCreationController::class, 'createProperty_step2'])
        ->name('property.step2');

    Route::post('/location', [PropertyCreationController::class, 'storeLocation'])
        ->name('property.storeLocation');

    Route::get('/capacity', [PropertyCreationController::class, 'createProperty_step3'])
        ->name('property.step3');

    Route::post('/capacity', [PropertyCreationController::class, 'storeCapacity'])
        ->name('property.storeCapacity');

    Route::get('/description', [PropertyCreationController::class, 'createProperty_step4'])
        ->name('property.step4');

    Route::post('/description', [PropertyCreationController::class, 'storeDescription'])
        ->name('property.storeDescription');

    Route::get('/amenities', [PropertyCreationController::class, 'createProperty_step5'])
        ->name('property.step5');

    Route::post('/amenities', [PropertyCreationController::class, 'storeAmenities'])
        ->name('property.storeAmenities');

    // Route for displaying the pictures form
    Route::get('/pictures', [PropertyCreationController::class, 'createProperty_step6'])
        ->name('property.step6');

// Route for storing uploaded images
    Route::post('/store-pictures', [PropertyCreationController::class, 'storePictures'])
        ->name('property.storePictures');
    Route::delete('/property/remove-image/{index}', [PropertyCreationController::class, 'removeImage']);
// Route for removing an image (if needed)
    Route::post('/remove-image', [PropertyCreationController::class, 'removeImage'])
        ->name('property.removeImage');

    Route::get('/price', [PropertyCreationController::class, 'createProperty_step7'])
        ->name('property.step7');

    Route::post('/property/store-price-and-save', [PropertyCreationController::class, 'storePriceAndSaveProperty'])
        ->name('property.storePriceAndSave');
});


// Request booking process
Route::get('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');
Route::post('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');
Route::get('/property/{id}/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process');
Route::post('/property/{id}/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process');
Route::get('/property/{id}/cancel-request', [BookingController::class, 'cancelRequest'])->name('bookings.cancel-request');

// Cancel existing booking
Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

// Notifications
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
});

// Favorites page
Route::get('/favorites', function () {
    return view('pages.Favorites');
})->name('favorites');

// About Us page
Route::get('/about', function () {
    return view('pages.AboutUs');
})->name('about');

// Help Center page
Route::get('/help', function () {
    return view('pages.HelpCenter');
})->name('help');

// Fallback route
Route::fallback(function () {
    return view('pages.404');
});
// Fallback route
Route::fallback(function () {
    return view('pages.404');
});
