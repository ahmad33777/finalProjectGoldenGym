<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProdcutController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SaunaReservationsController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TrainerComplaintController;
use App\Http\Controllers\Api\TrainerController;
use App\Http\Controllers\Api\TrainerAttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('complaints/store', [App\Http\Controllers\Api\ComplaintController::class, 'store']);

    Route::prefix('trainer')->group(function () {
        Route::put('/changePassword', [TrainerController::class, 'changePassword']);
        Route::post('/attendances_store', [TrainerAttendanceController::class, 'attendances_store']);
        Route::post('/attendances_store', [TrainerAttendanceController::class, 'attendances_store']);
        Route::post('/departure', [TrainerAttendanceController::class, 'departure']);
        Route::post('/attendances/index', [TrainerAttendanceController::class, 'index']);
        Route::post('/ratings', [RatingController::class, 'ratings']);
        Route::post('/complaints/store', [TrainerComplaintController::class, 'store']);
        Route::get('/notificatios', [TrainerController::class, 'showNotificatio']); // to show all notification
        Route::post('/subscribers', [TrainerController::class, 'showSubscribers']); // to show all notification
    });

    Route::prefix('subscribers')->group(function () {
        Route::get('/showNotification', [SubscriberController::class, 'showNotification']);
        Route::put('/changePassword', [SubscriberController::class, 'changePassword']);
        Route::post('/ratingStore', [SubscriberController::class, 'ratingStore']);
        Route::put('/changeTrainers', [SubscriberController::class, 'changeTrainers']);

        Route::post('/order', [OrderController::class, 'order']);

        Route::post('/myOrders', [OrderController::class, 'showMyOrders']);
        Route::post('/removeOrder', [OrderController::class, 'cancellingOrder']);


        Route::post('/reservation', [SaunaReservationsController::class, 'reservation']);
        Route::post('/cancellationReservation', [SaunaReservationsController::class, 'cancellationReservation']);
        Route::post('/showReservations', [SaunaReservationsController::class, 'showReservations']);

        Route::put('/updatePhone', [SubscriberController::class, 'updatePhone']);
    });












});
Route::prefix('subscribers')->group(function () {
    Route::get('/trainers', [SubscriberController::class, 'showTrainers']);
});

Route::prefix('subscribers')->group(function () {
    Route::get('/showOffers', [SubscriberController::class, 'showOffers']);
    Route::get('/categories', [CategoryController::class, 'showCategories']);
    Route::post('/products', [ProdcutController::class, 'showProducts']);

});

Route::post('subscriber/forget-password', [SubscriberController::class, 'forgetPassword']);