<?php

use App\Http\Controllers\HostController;
use App\Http\Controllers\PropertyEditController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\PropertyCreationController;
use App\Http\Controllers\NotificationController;

// Public Property Views
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.show');

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

    // Updated booking routes with category support
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{category}', [BookingController::class, 'index'])->name('bookings.category');

    Route::get('/bookings/details/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/logout', [LogInController::class, 'logout'])->name('logout');
    Route::get('/profile/edit/{id}', [UserController::class, 'editProfile'])->name('owner.edit');
    Route::put('/profile/update/{id}', [UserController::class, 'updateProfile'])->name('owner.update');
});

Route::prefix('property/create')->middleware(['auth'])->group(function () {
    Route::get('/starter', [PropertyCreationController::class, 'createProperty_starter'])->name('property.create.starter');
    //Property Type
    Route::get('/identify-house', [PropertyCreationController::class, 'createProperty_step1'])->name('property.create');
    Route::post('/identify-house', [PropertyCreationController::class, 'storePropertyType'])->name('property.store.type');
    //Location
    Route::get('/location', [PropertyCreationController::class, 'createProperty_step2'])->name('property.step2');
    Route::post('/location', [PropertyCreationController::class, 'storeLocation'])->name('property.storeLocation');
    //Capacity
    Route::get('/capacity', [PropertyCreationController::class, 'createProperty_step3'])->name('property.step3');
    Route::post('/capacity', [PropertyCreationController::class, 'storeCapacity'])->name('property.storeCapacity');
    //Title & Description
    Route::get('/description', [PropertyCreationController::class, 'createProperty_step4'])->name('property.step4');
    Route::post('/description', [PropertyCreationController::class, 'storeDescription'])->name('property.storeDescription');
    //Amenities
    Route::get('/amenities', [PropertyCreationController::class, 'createProperty_step5'])->name('property.step5');
    Route::post('/amenities', [PropertyCreationController::class, 'storeAmenities'])->name('property.storeAmenities');
    //Pictures
    Route::get('/pictures', [PropertyCreationController::class, 'createProperty_step6'])->name('property.step6');
    Route::post('/store-pictures', [PropertyCreationController::class, 'storePictures'])->name('property.storePictures');
    Route::delete('/property/remove-image/{index}', [PropertyCreationController::class, 'removeImage']);
    Route::post('/remove-image', [PropertyCreationController::class, 'removeImage'])->name('property.removeImage');
    //Price
    Route::get('/price', [PropertyCreationController::class, 'createProperty_step7'])->name('property.step7');
    Route::post('/property/store-price-and-save', [PropertyCreationController::class, 'storePriceAndSave'])->name('property.storePriceAndSave');
});

Route::prefix('host')->middleware(['auth'])->group(function () {
    // General host routes
    Route::get('/listing', [HostController::class, 'viewListing'])->name('host.listing');
    Route::get('/bookings', [PropertyCreationController::class, 'createProperty_step1'])->name('host.bookings');

    // Property routes group
    Route::prefix('property/{property}')->group(function () {
        // Property edit routes group
        Route::prefix('view-edit')->group(function () {
            Route::get('/type', [PropertyEditController::class, 'viewEditType'])->name('property.edit.type');
            Route::get('/location', [PropertyEditController::class, 'viewEditLocation'])->name('property.edit.location');
            Route::get('/capacity', [PropertyEditController::class, 'viewEditCapacity'])->name('property.edit.capacity');
            Route::get('/description', [PropertyEditController::class, 'viewEditDescription'])->name('property.edit.description');
            Route::get('/amenities', [PropertyEditController::class, 'viewEditAmenities'])->name('property.edit.amenities');
            Route::get('/pictures', [PropertyEditController::class, 'viewEditPictures'])->name('property.edit.pictures');
            Route::get('/price', [PropertyEditController::class, 'viewEditPrice'])->name('property.edit.price');
            Route::get('/rules', [PropertyEditController::class, 'viewEditRules'])->name('property.edit.rules');
        });
    });
});
Route::get('/profile-view', [UserController::class, 'viewProfile'])->name('profile.view');

// Request booking process
Route::get('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');
Route::post('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');
Route::get('/property/{id}/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process');
Route::post('/property/{id}/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process')->middleware('auth');
Route::get('/property/{id}/cancel-request', [BookingController::class, 'cancelRequest'])->name('bookings.cancel-request');

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
