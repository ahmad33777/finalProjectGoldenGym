<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SendNotificationr;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SubscriptionRenewalController;
use App\Http\Controllers\TrainerAttendanceController;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleControler;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\LatetimeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;



Route::get('users/forgetPassword', [UserAuthController::class, 'forgetPasswordLoad'])->name('user.forgetPasswordLoad');
Route::post('users/sendURL', [UserAuthController::class, 'sendURL'])->name('user.sendURL');
Route::get('/user/reset-password', [UserAuthController::class, 'resetPasswordshow'])->name('user.reset-password');
Route::post('/user/reset-password', [UserAuthController::class, 'resetPassword'])->name('user.resetPassword'); // changepassword



Route::get('/subscriber/reset-password', [\App\Http\Controllers\Api\SubscriberController::class, 'resetPasswordshow']);
Route::post('/subscriber/reset-password', [\App\Http\Controllers\Api\SubscriberController::class, 'resetPassword'])->name('subscriber.reset-password');



Route::get('/reset-password', [\App\Http\Controllers\Api\ForgetPasswordController::class, 'resetPasswordshow']);
Route::post('/reset-password', [\App\Http\Controllers\Api\ForgetPasswordController::class, 'resetPassword'])->name('reset-password');



Route::prefix('/admin')->middleware(['guest:web'])->group(function () {
    Route::get('login', [UserAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [UserAuthController::class, 'login'])->name('login');
});

Route::prefix('/admin')->middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [UserAuthController::class, 'logout'])->name('admin.logout');

    Route::resource('roles', RoleControler::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('role.permissions', RolePermissionController::class);
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');
    Route::resource('users', UserController::class);
    Route::get('employee/attendanceReport/{id}', [UserController::class, 'attendanceReport'])->name('attendanceReport.index');
    Route::get('employee/searchattendanceReport/{id}', [UserController::class, 'searchattendanceReport'])->name('searchattendanceReport');
    Route::get('employee/financialReport/{id}', [UserController::class, 'financialReport'])->name('financialReport');
    Route::get('employee/financialReportSearch/{id}', [UserController::class, 'financialReportSearch'])->name('employee.financialReportSearch');

    Route::resource('profiles', UserProfileController::class);
    Route::get('/change-password', [ChangePasswordController::class, 'changePasswordView'])->name('changePassword');
    Route::post('/change-password', [ChangePasswordController::class, 'changePasswordSave'])->name('postChangePassword');


    Route::get('employess/roles/{user_id}', [UserRoleController::class, 'index'])->name('employees.roles');
    Route::DELETE('employees/roles/remove/{role_id}/{user_id}', [UserRoleController::class, 'removeRole'])->name('role.removeRole');
    Route::post('employees/roles/addRole/{userID}', [UserRoleController::class, 'addRole'])->name('role.add');

    Route::resource('trainers', TrainerController::class);
    Route::put('trainers/update', [TrainerController::class, 'update']);
    Route::get('trainer', [TrainerController::class, 'search'])->name('trainers.search');
    Route::get('trainer/attendanceReport/{id}', [TrainerController::class, 'attendanceReport'])->name('trainer.attendanceReport');
    Route::get('trainer/financialreport/{id}', [TrainerController::class, 'financialreport'])->name('trainer.financialreport');


    Route::resource('schedules', ScheduleController::class);
    Route::put('schedules/update', [ScheduleController::class, 'update']);



    Route::prefix('attendance')->group(function () {
        Route::get('/check', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendanceRequests', [AttendanceController::class, 'attendanceRequests'])->name('attendance.attendanceRequests');
        Route::post('/acceptAttendance', [AttendanceController::class, 'acceptAttendance'])->name('attendance.acceptAttendance');
        Route::post('/rejectionAttendance', [AttendanceController::class, 'rejectionAttendance'])->name('attendance.rejectionAttendance');
        Route::post('/attendances_store', [AttendanceController::class, 'attendances_store'])->name('attendance.attendances_store');
        Route::post('/departure', [AttendanceController::class, 'departure'])->name('attendance.departure');

    });

    Route::get('subscriptions/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::delete('subscriptions/destroy/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::get('/subscriptions/edit/{id}', [SubscriptionController::class, 'edit']);
    Route::put('/subscriptions/update', [SubscriptionController::class, 'update']);
    Route::get('subscriptions/search', [SubscriptionController::class, 'search'])->name('subscriptions.search');


    Route::get('subscribers/', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('subscribers/store', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::get('subscribers/edit/{id}', [SubscriberController::class, 'edit'])->name('subscribers.edit');
    Route::put('subscribers/update/{id}', [SubscriberController::class, 'update'])->name('subscribers.update');
    Route::delete('subscribers/destroy/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('subscribers/search', [SubscriberController::class, 'search'])->name('subscribers.search');
    Route::get('subscribers/expiredSubscriptions', [SubscriberController::class, 'expiredSubscriptions'])->name('expiredSubscriptions');
    Route::post('subscribers/sendAlert', [SubscriberController::class, 'sendAlert'])->name('sendAlert');

    Route::get('subscribers/financialBoost/{id}', [FinancialController::class, 'edit']);
    Route::post('subscribers/addFinancialBoost', [FinancialController::class, 'financial_boost']);


    Route::get('subscribers/subscriptionRenewal/{id}', [SubscriptionRenewalController::class, 'edit'])->name('subscribers.subscriptionRenewal');

    Route::post('subscribers/subscriptionRenewal/update/{id}', [SubscriptionRenewalController::class, 'update'])->name('subscriptionRenewal.update');



    Route::get('subscribers/changeStatusActive/{id}', [SubscriberController::class, 'changeStatusActive'])
        ->name('subscriber.changeStatusActive');
    Route::get('subscribers/statusChangeInactive/{id}', [SubscriberController::class, 'statusChangeInactive'])
        ->name('subscriber.statusChangeInactive');

    Route::prefix('subscriber')->group(function () {
        Route::get('/showfinancialReport/{id}', [SubscriberController::class, 'showfinancialReport'])
            ->name('subscriber.showfinancialReport');
        Route::get('/searchFinancialReport/{id}', [SubscriberController::class, 'searchFinancialReport'])
            ->name('subscriber.searchFinancialReport');
        Route::get('/showSubscriptionReport/{id}', [SubscriberController::class, 'showSubscriptionReport'])
            ->name('subscriber.showSubscriptionReport');
    });


    //    categories
    Route::prefix('categories')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/search', [CategoryController::class, 'search'])->name('categories.search');

        Route::get('/productReport/{id}', [CategoryController::class, 'productReport'])->name('categories.productReport');
    });

    Route::prefix('products')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');

        Route::get('/createDiscount/{id}', [ProductController::class, 'createDiscount'])->name('product.createDiscount');
        Route::post('/discount/{id}', [ProductController::class, 'discount'])->name('products.discount');
    });




    Route::prefix('complaints')->group(function () {
        Route::get('/', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/read/{id}', [ComplaintController::class, 'readComplaint'])->name('complaints.read');
        Route::get('/archives', [ComplaintController::class, 'archives'])->name('complaints.archives');
        Route::get('/trainerComplaints', [ComplaintController::class, 'trainerComplaints'])->name('trainer.complaints');
        Route::get('/readTrainerComplaint/{id}', [ComplaintController::class, 'readTrainerComplaint'])->name('readTrainerComplaint');

    });

    Route::prefix('trainerAttendance')->group(function () {
        Route::get('/index', [TrainerAttendanceController::class, 'index'])->name('trainerAttendance.index');
        Route::post('/acceptTrainerAttendance', [TrainerAttendanceController::class, 'acceptTrainerAttendance'])->name('trainerAttendance.acceptTrainerAttendance');
        Route::post('/rejectionTrainerAttendance', [TrainerAttendanceController::class, 'rejectionTrainerAttendance'])->name('trainerAttendance.rejectionTrainerAttendance');

    });
    Route::prefix('/incomings')->group(function () {
        Route::get('/', [IncomingController::class, 'index'])->name('incomings.index');
    });
    Route::prefix('/facebook')->group(function () {
        Route::get('/create-post', [FacebookController::class, 'create'])->name('create-post');
        Route::post('/post', [FacebookController::class, 'createPost'])->name('facebook_post');
    });
    Route::get('ratings-index', [RatingController::class, 'index'])->name('ratings.index');
    Route::get('create-notification', [SendNotificationr::class, 'index'])->name('create.notification');
    Route::post('sendNotification', [SendNotificationr::class, 'sendNotification'])->name('send.notification');

    Route::prefix('/offers')->group(function () {
        Route::get('/offers', [OfferController::class, 'index'])->name('offer.index');
        Route::get('/create', [OfferController::class, 'create'])->name('offer.create');
        Route::post('/store', [OfferController::class, 'store'])->name('offer.store');
        Route::delete('/destroy/{id}', [OfferController::class, 'destroy'])->name('offer.destroy');
        Route::get('edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
        Route::put('/update/{id}', [OfferController::class, 'update'])->name('offer.update');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.indx');
        Route::get('/orderAccept/{id}', [OrderController::class, 'acceptOrder'])->name('order.acceptOrder');
        Route::get('/rejectOrder/{id}', [OrderController::class, 'rejectOrder'])->name('order.rejectOrder');

    });

    Route::prefix('/expenses')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('/store', [ExpenseController::class, 'store'])->name('expenses.store');

    });

});


// Route::get('/send-passowrd', [SmsController::class, 'sms']);
// Route::get('mail', function () {
//     $data['url'] = 'lknlk';
//     $data['email'] = 'jbjl';
//     $data['title'] = 'Password Reset';
//     $data['body'] = 'من فضلك إضغط على الرابط التالي من أجل إعادة تعين كلمة المرور الخاصة بك';
//     Mail::to('nouh.work@gmail.com')->send(new ResetPasswordMail($data));
//     return redirect()->back();
// });