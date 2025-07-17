<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;
use App\Http\Controllers\PropertyEditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\PropertyCreationController;
use App\Http\Controllers\NotificationController;

// Public Property Views
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/result', [PropertyController::class, 'search'])->name('property.search');
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('property.show');
Route::view('/about', 'pages.about-us')->name('about');
Route::view('/help', 'pages.help-center')->name('help');

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
    //Route::post('/property/{id}/book', [BookingController::class, 'book'])->name('bookings.book');

    // Updated booking routes with category support
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{category}', [BookingController::class, 'index'])->name('bookings.category');
    Route::get('/bookings/details/{id}', [BookingController::class, 'show'])->name('bookings.show.details');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/logout', [LogInController::class, 'logout'])->name('logout');
    Route::get('/profile/edit/{id}', [UserController::class, 'editProfile'])->name('owner.edit');
    Route::put('/profile/update/{id}', [UserController::class, 'updateProfile'])->name('owner.update');
    Route::view('/favorites', 'pages.Favorites')->name('favorites');
    Route::get('/profile-view', [UserController::class, 'viewProfile'])->name('profile.view');

    // Booking Routes
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/{id}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });

    // Property Booking Process
    Route::prefix('property/{id}')->group(function () {
        Route::get('/book', [BookingController::class, 'book'])->name('bookings.book');
        Route::post('/book', [BookingController::class, 'book'])->name('bookings.book');
        Route::get('/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process');
        Route::post('/process-booking', [BookingController::class, 'processBooking'])->name('bookings.process');
        Route::get('/cancel-request', [BookingController::class, 'cancelRequest'])->name('bookings.cancel-request');
    });

    // Notification Routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::delete('/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    });
});
//Creating Property
Route::prefix('property/create')->middleware(['auth'])->group(function () {
    Route::get('/starter', [PropertyCreationController::class, 'createProperty_starter'])->name('property.create.starter');
    Route::get('/identify-house', [PropertyCreationController::class, 'createProperty_step1'])->name('property.create');
    Route::post('/identify-house', [PropertyCreationController::class, 'storePropertyType'])->name('property.store.type');
    Route::get('/location', [PropertyCreationController::class, 'createProperty_step2'])->name('property.step2');
    Route::post('/location', [PropertyCreationController::class, 'storeLocation'])->name('property.storeLocation');
    Route::get('/capacity', [PropertyCreationController::class, 'createProperty_step3'])->name('property.step3');
    Route::post('/capacity', [PropertyCreationController::class, 'storeCapacity'])->name('property.storeCapacity');
    Route::get('/description', [PropertyCreationController::class, 'createProperty_step4'])->name('property.step4');
    Route::post('/description', [PropertyCreationController::class, 'storeDescription'])->name('property.storeDescription');
    Route::get('/amenities', [PropertyCreationController::class, 'createProperty_step5'])->name('property.step5');
    Route::post('/amenities', [PropertyCreationController::class, 'storeAmenities'])->name('property.storeAmenities');
    Route::get('/pictures', [PropertyCreationController::class, 'createProperty_step6'])->name('property.step6');
    Route::post('/store-pictures', [PropertyCreationController::class, 'storePictures'])->name('property.storePictures');
    Route::delete('/property/remove-image/{index}', [PropertyCreationController::class, 'removeImage']);
    Route::post('/remove-image', [PropertyCreationController::class, 'removeImage'])->name('property.removeImage');
    Route::get('/price', [PropertyCreationController::class, 'createProperty_step7'])->name('property.step7');
    Route::post('/property/store-price-and-save', [PropertyCreationController::class, 'storePriceAndSave'])->name('property.storePriceAndSave');
});

Route::prefix('host')->middleware(['auth'])->group(function () {
    // General host routes
    Route::prefix('/listing')->group(function () {
        Route::get('', [HostController::class, 'viewListing'])->name('host.listing');
        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('property.delete');
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/pending', [HostController::class, 'viewPendingBookings'])->name('host.bookings.pending');
        Route::get('/accepted', [HostController::class, 'viewAcceptedBookings'])->name('host.bookings.accepted');
        Route::get('/ongoing', [HostController::class, 'viewOngoingBookings'])->name('host.bookings.ongoing');
        Route::get('/completed', [HostController::class, 'viewCompletedBookings'])->name('host.bookings.completed');
        Route::get('/cancelled', [HostController::class, 'viewCancelledBookings'])->name('host.bookings.cancelled');

        // Accept Booking
        Route::patch('/{booking}/approve', [HostController::class, 'acceptBooking'])->name('host.bookings.approve');
        Route::patch('/{booking}/cancel', [HostController::class, 'cancelBooking'])->name('host.bookings.cancel');
        Route::patch('/{booking}/decline', [HostController::class, 'declineBooking'])->name('host.bookings.decline');

    });

    //Host Management
    Route::prefix('property/{property}')->group(function () {
        Route::prefix('view-edit')->group(function () {
            Route::get('/type', [PropertyEditController::class, 'viewEditType'])->name('property.edit.type');
            Route::put('/type', [PropertyEditController::class, 'updateType'])->name('property.update.type');
            Route::get('/location', [PropertyEditController::class, 'viewEditLocation'])->name('property.edit.location');
            Route::put('/location', [PropertyEditController::class, 'updateLocation'])->name('property.update.location');
            Route::get('/capacity', [PropertyEditController::class, 'viewEditCapacity'])->name('property.edit.capacity');
            Route::put('/capacity', [PropertyEditController::class, 'updateCapacity'])->name('property.update.capacity');
            Route::get('/description', [PropertyEditController::class, 'viewEditDescription'])->name('property.edit.description');
            Route::put('/description', [PropertyEditController::class, 'updateDescription'])->name('property.update.description');
            Route::get('/amenities', [PropertyEditController::class, 'viewEditAmenities'])->name('property.edit.amenities');
            Route::put('/amenities', [PropertyEditController::class, 'updateAmenities'])->name('property.update.amenities');
            Route::get('/pictures', [PropertyEditController::class, 'viewEditPictures'])->name('property.edit.pictures');
            Route::put('/pictures', [PropertyEditController::class, 'updatePictures'])->name('property.update.pictures');
            Route::delete('/pictures/{image}', [PropertyEditController::class, 'removeImage'])->name('property.remove.image');
            Route::post('/mark-image-removal', [PropertyEditController::class, 'markImageForRemoval'])->name('property.mark.image.removal');
            Route::get('/price', [PropertyEditController::class, 'viewEditPrice'])->name('property.edit.price');
            Route::put('/price', [PropertyEditController::class, 'updatePrice'])->name('property.update.price');
            Route::get('/rules', [PropertyEditController::class, 'viewEditRules'])->name('property.edit.rules');
            Route::post('/rules', [PropertyEditController::class, 'updateRules'])->name('property.update.rules');
            Route::post('/save-all', [PropertyEditController::class, 'saveAllUpdates'])->name('property.save.all.updates');
        });
    });
});
// Fallback Route
Route::fallback(function () {
    return view('pages.404');
});
