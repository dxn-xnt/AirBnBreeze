<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PropertyAmenityController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/Amenity', [AmenityController::class,'getAllAmenities']);
Route::get('/Amenity/{id}', [AmenityController::class,'getAmenityById']);

Route::get('/Booking/{id}', [BookingController::class,'getBookingById']);
Route::get('/Booking', [BookingController::class,'getAllBooking']);

Route::post('/User', [UserController::class,'createUser']);
Route::get('/User', [UserController::class,'getAllUser']);
Route::get('/User/{id}', [UserController::class,'getUserById']);
Route::put('/User/{id}', [UserController::class,'updateUser']);
Route::delete('/User/{id}', [UserController::class,'deleteUser']);